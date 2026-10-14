<?php
/**
 * Costing Builder API - Neon PostgreSQL version.
 *
 * Replace: api/api.php
 * Requires: PHP 8+ with PDO_PGSQL and DATABASE_URL configured in Vercel.
 *
 * IMPORTANT:
 * - This version creates PostgreSQL tables automatically.
 * - It does NOT import old SQLite data.
 * - Configure a real email provider/mail transport before production setup.
 */

const MAIL_FROM = 'no-reply@yourdomain.com';
const APP_NAME = 'Costing Builder';
const DEV_SHOW_OTP = false; // Must remain false in production.

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

function out($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function err($message, $status = 400) {
    out(['error' => $message], $status);
}

function envDatabaseUrl() {
    $url = getenv('DATABASE_URL');
    if (!$url) {
        throw new RuntimeException('DATABASE_URL is not configured');
    }
    return $url;
}

/**
 * Uses the complete Neon URL and retains its query parameters.
 * The endpoint= password prefix is used for older libpq clients that do not
 * support Neon SNI. If the client supports SNI, the prefix is generally not
 * needed; the test endpoint confirmed this approach works in this deployment.
 */
function connectPostgres() {
    $url = envDatabaseUrl();

    if (!extension_loaded('pdo_pgsql')) {
        throw new RuntimeException('PDO PostgreSQL driver is unavailable');
    }

    $parts = parse_url($url);
    if (
        !$parts ||
        empty($parts['host']) ||
        empty($parts['path']) ||
        empty($parts['user']) ||
        !isset($parts['pass'])
    ) {
        throw new RuntimeException('DATABASE_URL format is invalid');
    }

    $host = $parts['host'];
    $port = $parts['port'] ?? 5432;
    $database = rawurldecode(ltrim($parts['path'], '/'));
    $username = rawurldecode($parts['user']);
    $originalPassword = rawurldecode($parts['pass']);

    $query = [];
    parse_str($parts['query'] ?? '', $query);

    // Neon endpoint ID is the hostname's first label, without "-pooler".
    $endpointId = explode('.', $host)[0];
    $endpointId = preg_replace('/-pooler$/', '', $endpointId);

    $password = $originalPassword;
    if (preg_match('/^ep-[a-z0-9-]+$/', $endpointId)) {
        $password = 'endpoint=' . $endpointId . ';' . $originalPassword;
    }

    $dsn = "pgsql:host={$host};port={$port};dbname={$database};sslmode=require";

    // Do not pass Neon URL's options query parameter into the PDO DSN here.
    // This deployment's successful connectivity test uses the endpoint= password prefix.

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true,
        PDO::ATTR_TIMEOUT => 10,
    ]);

    return $pdo;
}

/**
 * PostgreSQL-backed PHP sessions are used because local files are not reliable
 * persistent storage across serverless function instances.
 */
class PostgresSessionHandler implements SessionHandlerInterface {
    private $db;
    private $ttl;

    public function __construct(PDO $db, $ttl = 1440) {
        $this->db = $db;
        $this->ttl = (int)$ttl;
    }

    public function open(string $path, string $name): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }

    public function read(string $id): string|false {
        $stmt = $this->db->prepare(
            'SELECT data FROM app_sessions WHERE id = ? AND last_activity >= ?'
        );
        $stmt->execute([$id, time() - $this->ttl]);
        $value = $stmt->fetchColumn();
        return $value === false ? '' : (string)$value;
    }

    public function write(string $id, string $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO app_sessions(id, data, last_activity)
             VALUES(?, ?, ?)
             ON CONFLICT(id) DO UPDATE
             SET data = EXCLUDED.data, last_activity = EXCLUDED.last_activity'
        );
        return $stmt->execute([$id, $data, time()]);
    }

    public function destroy(string $id): bool {
        $stmt = $this->db->prepare('DELETE FROM app_sessions WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function gc(int $max_lifetime): int|false {
        $stmt = $this->db->prepare('DELETE FROM app_sessions WHERE last_activity < ?');
        $stmt->execute([time() - $max_lifetime]);
        return $stmt->rowCount();
    }
}

try {
    $db = connectPostgres();

    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id BIGSERIAL PRIMARY KEY,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            pw TEXT NOT NULL,
            role TEXT NOT NULL,
            active INTEGER NOT NULL DEFAULT 1,
            master INTEGER NOT NULL DEFAULT 0,
            last TEXT
        );

        CREATE TABLE IF NOT EXISTS logins (
            id BIGSERIAL PRIMARY KEY,
            ts TEXT,
            email TEXT,
            result TEXT,
            ip TEXT
        );

        CREATE TABLE IF NOT EXISTS pending (
            email TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            pw TEXT NOT NULL,
            otp TEXT NOT NULL,
            exp BIGINT NOT NULL,
            tries INTEGER NOT NULL DEFAULT 0
        );

        CREATE TABLE IF NOT EXISTS kv (
            k TEXT PRIMARY KEY,
            v TEXT
        );

        CREATE TABLE IF NOT EXISTS audit (
            id BIGSERIAL PRIMARY KEY,
            ts TEXT,
            user_id BIGINT,
            email TEXT,
            action TEXT,
            entity TEXT,
            entity_id TEXT,
            ip TEXT
        );

        CREATE TABLE IF NOT EXISTS app_sessions (
            id TEXT PRIMARY KEY,
            data TEXT NOT NULL,
            last_activity BIGINT NOT NULL
        );

        CREATE INDEX IF NOT EXISTS app_sessions_last_activity_idx
            ON app_sessions(last_activity);

        CREATE TABLE IF NOT EXISTS app_backups (
            name TEXT PRIMARY KEY,
            data TEXT NOT NULL,
            created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
        );

        CREATE INDEX IF NOT EXISTS app_backups_created_at_idx
            ON app_backups(created_at DESC);
    ");

    // Ensure the shared JSON data row exists before any saves.
    $db->prepare("INSERT INTO kv(k, v) VALUES('data', '{}') ON CONFLICT(k) DO NOTHING")
       ->execute();

    session_set_save_handler(new PostgresSessionHandler($db), true);
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'),
        'path' => '/',
    ]);
    session_start();
} catch (Throwable $e) {
    error_log('Costing Builder database/session initialization failed: ' . $e->getMessage());
    err('Database unavailable. Check the Vercel DATABASE_URL and Neon database.', 500);
}

$in = json_decode(file_get_contents('php://input'), true) ?: [];
$a = $_GET['a'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$roles = ['admin', 'manager', 'estimator', 'viewer'];

function q($sql, $params = []) {
    global $db;
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function upsertKv($key, $value) {
    q(
        'INSERT INTO kv(k, v) VALUES(?, ?)
         ON CONFLICT(k) DO UPDATE SET v = EXCLUDED.v',
        [$key, $value]
    );
}

function pub($u) {
    return [
        'id' => (int)$u['id'],
        'name' => $u['name'],
        'email' => $u['email'],
        'role' => $u['role'],
        'active' => (int)$u['active'],
        'master' => (int)$u['master'],
        'last' => $u['last'],
    ];
}

function me() {
    if (empty($_SESSION['uid'])) return null;
    $u = q('SELECT * FROM users WHERE id = ? AND active = 1', [$_SESSION['uid']])
        ->fetch(PDO::FETCH_ASSOC);
    return $u ?: null;
}

function need($admin = false) {
    $u = me();
    if (!$u) err('Please sign in', 401);
    if ($admin && $u['role'] !== 'admin') err('Admin only', 403);
    return $u;
}

function logL($email, $result) {
    global $ip;
    q(
        'INSERT INTO logins(ts, email, result, ip) VALUES(?, ?, ?, ?)',
        [date('Y-m-d H:i:s'), $email, $result, $ip]
    );
}

function audit($user, $action, $entity = '', $entityId = '') {
    global $ip;
    q(
        'INSERT INTO audit(ts, user_id, email, action, entity, entity_id, ip)
         VALUES(?, ?, ?, ?, ?, ?, ?)',
        [
            date('Y-m-d H:i:s'),
            (int)$user['id'],
            $user['email'],
            $action,
            $entity,
            (string)$entityId,
            $ip,
        ]
    );
}

function csrf() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function checkCsrf() {
    $safe = ['me', 'setup_start', 'setup_verify', 'login'];
    global $a, $in;
    if (in_array($a, $safe, true)) return;

    if (!hash_equals(
        (string)($_SESSION['csrf'] ?? ''),
        (string)($in['csrf'] ?? '')
    )) {
        err('Security token expired. Refresh the page and try again.', 419);
    }
}

function okpw($password) {
    return is_string($password) && strlen($password) >= 8;
}

$count = (int)q('SELECT COUNT(*) FROM users')->fetchColumn();
checkCsrf();

switch ($a) {
    case 'me': {
        $user = me();
        out([
            'user' => $user ? pub($user) : null,
            'setup' => $count === 0,
            'csrf' => csrf(),
        ]);
    }

    case 'setup_start': {
        if ($count > 0) err('Master admin already exists', 403);

        $name = trim($in['name'] ?? '');
        $email = strtolower(trim($in['email'] ?? ''));
        $password = $in['password'] ?? '';

        if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !okpw($password)) {
            err('Enter your name, a valid email and a password of 8+ characters');
        }

        $otp = (string)random_int(100000, 999999);
        q('DELETE FROM pending');
        q(
            'INSERT INTO pending(email, name, pw, otp, exp, tries) VALUES(?, ?, ?, ?, ?, 0)',
            [
                $email,
                $name,
                password_hash($password, PASSWORD_DEFAULT),
                password_hash($otp, PASSWORD_DEFAULT),
                time() + 600,
            ]
        );

        $sent = @mail(
            $email,
            APP_NAME . ' verification code',
            "Your verification code is {$otp}. It expires in 10 minutes.\n",
            'From: ' . MAIL_FROM . "\r\nContent-Type: text/plain; charset=utf-8"
        );

        if (!$sent && !DEV_SHOW_OTP) {
            err('Could not send the email. Configure a supported email provider before setup.', 500);
        }

        out(['ok' => 1] + (DEV_SHOW_OTP ? ['dev_otp' => $otp] : []));
    }

    case 'setup_verify': {
        if ($count > 0) err('Master admin already exists', 403);

        $email = strtolower(trim($in['email'] ?? ''));
        $otp = trim($in['otp'] ?? '');
        $pending = q('SELECT * FROM pending WHERE email = ?', [$email])->fetch(PDO::FETCH_ASSOC);

        if (!$pending || (int)$pending['exp'] < time()) {
            err('Code expired. Request a new one.');
        }
        if ((int)$pending['tries'] >= 5) {
            err('Too many wrong codes. Request a new one.');
        }
        if (!password_verify($otp, $pending['otp'])) {
            q('UPDATE pending SET tries = tries + 1 WHERE email = ?', [$email]);
            err('Wrong code');
        }

        $newUserId = q(
            'INSERT INTO users(name, email, pw, role, active, master, last)
             VALUES(?, ?, ?, ?, 1, 1, ?) RETURNING id',
            [
                $pending['name'],
                $email,
                $pending['pw'],
                'admin',
                date('Y-m-d H:i:s'),
            ]
        )->fetchColumn();

        $newUserId = (int)$newUserId;
        q('DELETE FROM pending');
        session_regenerate_id(true);
        $_SESSION['uid'] = $newUserId;

        logL($email, 'Master admin verified');
        logL($email, 'Success');

        $newUser = q('SELECT * FROM users WHERE id = ?', [$newUserId])->fetch(PDO::FETCH_ASSOC);
        audit($newUser, 'created', 'user', $newUserId);

        out(['user' => pub($newUser), 'csrf' => csrf()]);
    }

    case 'login': {
        $email = strtolower(trim($in['email'] ?? ''));
        $password = $in['password'] ?? '';

        $failed = (int)q(
            "SELECT COUNT(*) FROM logins WHERE email = ? AND result = 'Failed' AND ts > ?",
            [$email, date('Y-m-d H:i:s', time() - 900)]
        )->fetchColumn();

        if ($failed >= 5) err('Too many attempts. Try again in 15 minutes.', 429);

        $user = q('SELECT * FROM users WHERE email = ?', [$email])->fetch(PDO::FETCH_ASSOC);

        if (!$user || !is_string($password) || !password_verify($password, $user['pw'])) {
            logL($email ?: '(blank)', 'Failed');
            err('Wrong email or password', 401);
        }

        if (!(int)$user['active']) {
            logL($email, 'Disabled account');
            err('This account is disabled', 403);
        }

        session_regenerate_id(true);
        $_SESSION['uid'] = (int)$user['id'];

        q('UPDATE users SET last = ? WHERE id = ?', [date('Y-m-d H:i:s'), $user['id']]);
        logL($email, 'Success');
        audit($user, 'login', 'user', $user['id']);

        out(['user' => pub($user), 'csrf' => csrf()]);
    }

    case 'logout': {
        $user = me();
        if ($user) {
            logL($user['email'], 'Logout');
            audit($user, 'logout', 'user', $user['id']);
        }
        $_SESSION = [];
        session_destroy();
        out(['ok' => 1]);
    }

    case 'change_password': {
        $user = need();
        $newPassword = $in['new'] ?? '';

        if (!password_verify($in['old'] ?? '', $user['pw'])) {
            err('Current password is wrong');
        }
        if (!okpw($newPassword)) err('Use 8+ characters');

        q('UPDATE users SET pw = ? WHERE id = ?', [
            password_hash($newPassword, PASSWORD_DEFAULT),
            $user['id'],
        ]);
        audit($user, 'changed password', 'user', $user['id']);
        out(['ok' => 1]);
    }

    case 'users': {
        need(true);
        out([
            'users' => array_map('pub', q('SELECT * FROM users ORDER BY id')->fetchAll()),
            'logins' => q('SELECT ts, email, result, ip FROM logins ORDER BY id DESC LIMIT 100')->fetchAll(),
        ]);
    }

    case 'add_user': {
        need(true);
        $name = trim($in['name'] ?? '');
        $email = strtolower(trim($in['email'] ?? ''));
        $password = $in['password'] ?? '';
        $role = $in['role'] ?? '';

        if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !okpw($password) || !in_array($role, $roles, true)) {
            err('Enter a name, valid email, 8+ character password and a role');
        }
        if (q('SELECT 1 FROM users WHERE email = ?', [$email])->fetch()) {
            err('That email already exists');
        }

        q(
            'INSERT INTO users(name, email, pw, role, active, master) VALUES(?, ?, ?, ?, 1, 0)',
            [$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]
        );
        out(['ok' => 1]);
    }

    case 'set_user': {
        $currentUser = need(true);
        $target = q('SELECT * FROM users WHERE id = ?', [(int)($in['id'] ?? 0)])->fetch(PDO::FETCH_ASSOC);

        if (!$target) err('User not found');
        if ((int)$target['master'] === 1 || (int)$target['id'] === (int)$currentUser['id']) {
            err('This account cannot be changed here');
        }

        $field = $in['field'] ?? '';
        $value = $in['value'] ?? null;

        if ($field === 'role' && in_array($value, $roles, true)) {
            q('UPDATE users SET role = ? WHERE id = ?', [$value, $target['id']]);
        } elseif ($field === 'active') {
            q('UPDATE users SET active = ? WHERE id = ?', [$value ? 1 : 0, $target['id']]);
        } else {
            err('Bad request');
        }

        audit($currentUser, 'edited', 'user', $target['id']);
        out(['ok' => 1]);
    }

    case 'reset_password': {
        need(true);
        $newPassword = $in['new'] ?? '';
        if (!okpw($newPassword)) err('Use 8+ characters');

        q('UPDATE users SET pw = ? WHERE id = ?', [
            password_hash($newPassword, PASSWORD_DEFAULT),
            (int)($in['id'] ?? 0),
        ]);
        out(['ok' => 1]);
    }

    case 'del_user': {
        $currentUser = need(true);
        $target = q('SELECT * FROM users WHERE id = ?', [(int)($in['id'] ?? 0)])->fetch(PDO::FETCH_ASSOC);

        if (!$target || (int)$target['master'] === 1 || (int)$target['id'] === (int)$currentUser['id']) {
            err('This account cannot be deleted');
        }

        q('DELETE FROM users WHERE id = ?', [$target['id']]);
        out(['ok' => 1]);
    }

    case 'load': {
        $user = need();
        $raw = q("SELECT v FROM kv WHERE k = 'data'")->fetchColumn();
        $data = $raw ? (json_decode($raw, true) ?: []) : [];

        if ($user['role'] === 'estimator') {
            $userId = (int)$user['id'];
            $userName = $user['name'];

            $data['history'] = array_values(array_filter($data['history'] ?? [], function ($item) use ($userId, $userName) {
                return (isset($item['userId']) && (int)$item['userId'] === $userId)
                    || (!isset($item['userId']) && ($item['user'] ?? '') === $userName);
            }));

            $data['quotations'] = array_values(array_filter($data['quotations'] ?? [], function ($item) use ($userId, $userName) {
                return (isset($item['userId']) && (int)$item['userId'] === $userId)
                    || (!isset($item['userId']) && ($item['user'] ?? '') === $userName);
            }));

            $data['taxInvoices'] = array_values(array_filter($data['taxInvoices'] ?? [], function ($item) use ($userId, $userName) {
                return (isset($item['userId']) && (int)$item['userId'] === $userId)
                    || (!isset($item['userId']) && ($item['user'] ?? '') === $userName);
            }));
        }

        out(['data' => $data]);
    }

    case 'backups': {
        $user = need(true);
        $rows = q(
            'SELECT name, OCTET_LENGTH(data) AS size,
                    TO_CHAR(created_at AT TIME ZONE \'UTC\', \'YYYY-MM-DD HH24:MI:SS\') AS modified
             FROM app_backups ORDER BY created_at DESC LIMIT 30'
        )->fetchAll();

        out(['backups' => array_map(function ($row) {
            return [
                'name' => $row['name'],
                'size' => (int)$row['size'],
                'modified' => $row['modified'],
            ];
        }, $rows)]);
    }

    case 'backup_download': {
        $user = need(true);
        $name = basename((string)($in['name'] ?? ''));

        if (!preg_match('/^backup-\d{4}-\d{2}-\d{2}(-\d{6})?\.json$/', $name)) {
            err('Invalid backup name');
        }

        $raw = q('SELECT data FROM app_backups WHERE name = ?', [$name])->fetchColumn();
        if ($raw === false) err('Backup not found', 404);

        $data = json_decode($raw, true);
        audit($user, 'downloaded', 'backup', $name);
        out(['name' => $name, 'data' => $data]);
    }

    case 'backup_restore': {
        $user = need(true);
        $name = basename((string)($in['name'] ?? ''));

        if (!preg_match('/^backup-\d{4}-\d{2}-\d{2}(-\d{6})?\.json$/', $name)) {
            err('Invalid backup name');
        }

        $raw = q('SELECT data FROM app_backups WHERE name = ?', [$name])->fetchColumn();
        if ($raw === false) err('Backup not found', 404);

        $data = json_decode($raw, true);
        if (!is_array($data)) err('Backup is invalid');

        upsertKv('data', json_encode($data, JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE));
        audit($user, 'restored', 'backup', $name);
        out(['ok' => 1]);
    }

    case 'save': {
        $user = need();

        $allow = [
            'admin' => null,
            'manager' => ['history', 'quotations', 'taxInvoices', 'templates', 'seq', 'qseq', 'invseq', 'tid', 'audit', 'pdfT'],
            'estimator' => ['history', 'quotations', 'taxInvoices', 'seq', 'qseq', 'invseq', 'audit', 'pdfT'],
            'viewer' => [],
        ][$user['role']];

        $incoming = $in['data'] ?? null;
        if (!is_array($incoming)) err('Bad data');

        // Lock the data row to reduce simultaneous-save overwrites.
        $db->beginTransaction();
        try {
            $currentRaw = q("SELECT v FROM kv WHERE k = 'data' FOR UPDATE")->fetchColumn();
            $current = json_decode((string)$currentRaw, true) ?: [];

            foreach ($incoming as $key => $value) {
                if ($allow !== null && !in_array($key, $allow, true)) continue;

                if ($key === 'history' && is_array($value)) {
                    $merged = [];
                    foreach (($current['history'] ?? []) as $item) {
                        if (isset($item['id'])) $merged[$item['id']] = $item;
                    }

                    if ($user['role'] === 'estimator') {
                        foreach ($value as $item) {
                            if (!isset($item['id'])) continue;
                            $owner = isset($item['userId']) ? (int)$item['userId'] : 0;
                            $old = $merged[$item['id']] ?? null;
                            $oldOwner = ($old && isset($old['userId'])) ? (int)$old['userId'] : 0;

                            if (
                                ($owner && $owner === (int)$user['id'])
                                || (!$owner && ($item['user'] ?? '') === $user['name'])
                                || ($old && $oldOwner === (int)$user['id'])
                            ) {
                                $item['userId'] = (int)$user['id'];
                                $item['user'] = $user['name'];
                                $merged[$item['id']] = $item;
                            }
                        }
                    } else {
                        foreach ($value as $item) {
                            if (isset($item['id'])) $merged[$item['id']] = $item;
                        }
                    }

                    $value = array_values($merged);
                    usort($value, function ($x, $y) {
                        return strcmp((string)($y['id'] ?? ''), (string)($x['id'] ?? ''));
                    });
                }

                if (in_array($key, ['quotations', 'taxInvoices'], true) && is_array($value)) {
                    $merged = [];
                    foreach (($current[$key] ?? []) as $item) {
                        if (isset($item['id'])) $merged[$item['id']] = $item;
                    }

                    if ($user['role'] === 'estimator') {
                        foreach ($value as $item) {
                            if (!isset($item['id'])) continue;
                            $old = $merged[$item['id']] ?? null;
                            $owner = isset($item['userId']) ? (int)$item['userId'] : 0;
                            $oldOwner = ($old && isset($old['userId'])) ? (int)$old['userId'] : 0;

                            if (
                                ($owner && $owner === (int)$user['id'])
                                || (!$owner && ($item['user'] ?? '') === $user['name'])
                                || ($old && $oldOwner === (int)$user['id'])
                            ) {
                                $item['userId'] = (int)$user['id'];
                                $item['user'] = $user['name'];
                                $merged[$item['id']] = $item;
                            }
                        }
                    } else {
                        foreach ($value as $item) {
                            if (isset($item['id'])) $merged[$item['id']] = $item;
                        }
                    }

                    $value = array_values($merged);
                    usort($value, function ($x, $y) {
                        return strcmp((string)($y['id'] ?? ''), (string)($x['id'] ?? ''));
                    });
                }

                $current[$key] = $value;
            }

            $json = json_encode($current, JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
            if ($json === false) {
                throw new RuntimeException('Could not encode data');
            }

            $todayKey = date('Y-m-d');
            $lastBackup = (string)q("SELECT v FROM kv WHERE k = 'backup_day'")->fetchColumn();

            if ($lastBackup !== $todayKey) {
                $oldData = (string)q("SELECT v FROM kv WHERE k = 'data'")->fetchColumn();
                if ($oldData !== '' && $oldData !== '{}') {
                    $backupName = 'backup-' . $todayKey . '-' . date('His') . '.json';
                    q(
                        'INSERT INTO app_backups(name, data) VALUES(?, ?)
                         ON CONFLICT(name) DO NOTHING',
                        [$backupName, $oldData]
                    );
                }
                upsertKv('backup_day', $todayKey);
            }

            upsertKv('data', $json);
            audit($user, 'saved', 'data', 'data');
            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) $db->rollBack();
            throw $e;
        }

        out(['ok' => 1]);
    }

    default:
        err('Unknown action', 404);
}
