<?php
// Costing Builder API - updated for Square Feet costing and Proposal % quotation fields.
// New quotation/costing fields are stored inside the existing JSON data store.
// Costing Builder API. Upload next to index.html. Needs PHP 7.4+ with PDO SQLite.
// 1) Set MAIL_FROM to an address on your own domain (needed so the OTP email is delivered).
const MAIL_FROM = 'no-reply@yourdomain.com';
const APP_NAME  = 'Costing Builder';
// 2) Keep false in production. Set true only to test when the server cannot send email.
const DEV_SHOW_OTP = true;

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => !empty($_SERVER['HTTPS']),
    'path' => '/'
]);
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
function out($a, $c = 200) { http_response_code($c); echo json_encode($a); exit; }
function err($m, $c = 400) { out(['error' => $m], $c); }

$dir = __DIR__ . '/data';
if (!is_dir($dir)) {
    @mkdir($dir, 0700, true);
    @file_put_contents("$dir/.htaccess", "<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nDeny from all\n</IfModule>\n");
}
try {
    $db = new PDO('sqlite:' . $dir . '/app-' . substr(md5(__DIR__), 0, 12) . '.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, name TEXT, email TEXT UNIQUE, pw TEXT, role TEXT, active INTEGER DEFAULT 1, master INTEGER DEFAULT 0, last TEXT);
      CREATE TABLE IF NOT EXISTS logins(id INTEGER PRIMARY KEY, ts TEXT, email TEXT, result TEXT, ip TEXT);
      CREATE TABLE IF NOT EXISTS pending(email TEXT PRIMARY KEY, name TEXT, pw TEXT, otp TEXT, exp INTEGER, tries INTEGER DEFAULT 0);
      CREATE TABLE IF NOT EXISTS kv(k TEXT PRIMARY KEY, v TEXT);
      CREATE TABLE IF NOT EXISTS audit(id INTEGER PRIMARY KEY, ts TEXT, user_id INTEGER, email TEXT, action TEXT, entity TEXT, entity_id TEXT, ip TEXT)");
} catch (Throwable $e) {
    err('Server storage unavailable. Check that PHP SQLite is enabled and the data folder is writable.', 500);
}

$in = json_decode(file_get_contents('php://input'), true) ?: [];
$a = $_GET['a'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$roles = ['admin', 'manager', 'estimator', 'viewer'];

function q($sql, $p = []) { global $db; $s = $db->prepare($sql); $s->execute($p); return $s; }
function pub($u) { return ['id' => (int)$u['id'], 'name' => $u['name'], 'email' => $u['email'], 'role' => $u['role'], 'active' => (int)$u['active'], 'master' => (int)$u['master'], 'last' => $u['last']]; }
function me() {
    if (empty($_SESSION['uid'])) return null;
    $u = q('SELECT * FROM users WHERE id=? AND active=1', [$_SESSION['uid']])->fetch(PDO::FETCH_ASSOC);
    return $u ?: null;
}
function need($admin = false) {
    $u = me();
    if (!$u) err('Please sign in', 401);
    if ($admin && $u['role'] != 'admin') err('Admin only', 403);
    return $u;
}
function logL($e, $r) { global $ip; q('INSERT INTO logins(ts,email,result,ip) VALUES(?,?,?,?)', [date('Y-m-d H:i:s'), $e, $r, $ip]); }
function audit($u, $action, $entity='', $entityId='') {
    global $ip;
    q('INSERT INTO audit(ts,user_id,email,action,entity,entity_id,ip) VALUES(?,?,?,?,?,?,?)', [
        date('Y-m-d H:i:s'), (int)$u['id'], $u['email'], $action, $entity, (string)$entityId, $ip
    ]);
}
function csrf() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function checkCsrf() {
    $safe = ['me','setup_start','setup_verify','login'];
    global $a;
    if (in_array($a, $safe, true)) return;
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($GLOBALS['in']['csrf'] ?? ''))) {
        err('Security token expired. Refresh the page and try again.', 419);
    }
}
function okpw($p) { return is_string($p) && strlen($p) >= 8; }
$count = (int)q('SELECT COUNT(*) FROM users')->fetchColumn();
checkCsrf();

switch ($a) {
case 'me': {
    $u = me();
    out(['user' => $u ? pub($u) : null, 'setup' => $count == 0, 'csrf' => csrf()]);
}
case 'setup_start': {
    if ($count > 0) err('Master admin already exists', 403);
    $n = trim($in['name'] ?? ''); $e = strtolower(trim($in['email'] ?? '')); $p = $in['password'] ?? '';
    if (!$n || !filter_var($e, FILTER_VALIDATE_EMAIL) || !okpw($p)) err('Enter your name, a valid email and a password of 8+ characters');
    $o = (string)random_int(100000, 999999);
    q('DELETE FROM pending');
    q('INSERT INTO pending(email,name,pw,otp,exp,tries) VALUES(?,?,?,?,?,0)', [$e, $n, password_hash($p, PASSWORD_DEFAULT), password_hash($o, PASSWORD_DEFAULT), time() + 600]);
    $sent = @mail($e, APP_NAME . ' verification code', "Your verification code is $o. It expires in 10 minutes.\n", "From: " . MAIL_FROM . "\r\nContent-Type: text/plain; charset=utf-8");
    if (!$sent && !DEV_SHOW_OTP) err('Could not send the email. Check MAIL_FROM in api.php and your server mail settings.', 500);
    out(['ok' => 1] + (DEV_SHOW_OTP ? ['dev_otp' => $o] : []));
}
case 'setup_verify': {
    if ($count > 0) err('Master admin already exists', 403);
    $e = strtolower(trim($in['email'] ?? '')); $o = trim($in['otp'] ?? '');
    $r = q('SELECT * FROM pending WHERE email=?', [$e])->fetch(PDO::FETCH_ASSOC);
    if (!$r || $r['exp'] < time()) err('Code expired. Request a new one.');
    if ($r['tries'] >= 5) err('Too many wrong codes. Request a new one.');
    if (!password_verify($o, $r['otp'])) { q('UPDATE pending SET tries=tries+1 WHERE email=?', [$e]); err('Wrong code'); }
    q('INSERT INTO users(name,email,pw,role,active,master,last) VALUES(?,?,?,?,1,1,?)', [$r['name'], $e, $r['pw'], 'admin', date('Y-m-d H:i:s')]);
    $id = (int)$db->lastInsertId();
    q('DELETE FROM pending');
    session_regenerate_id(true); $_SESSION['uid'] = $id;
    logL($e, 'Master admin verified'); logL($e, 'Success');
    $newUser = q('SELECT * FROM users WHERE id=?', [$id])->fetch(PDO::FETCH_ASSOC);
    audit($newUser, 'created', 'user', $id);
    out(['user' => pub($newUser), 'csrf' => csrf()]);
}
case 'login': {
    $e = strtolower(trim($in['email'] ?? '')); $p = $in['password'] ?? '';
    $f = (int)q("SELECT COUNT(*) FROM logins WHERE email=? AND result='Failed' AND ts>?", [$e, date('Y-m-d H:i:s', time() - 900)])->fetchColumn();
    if ($f >= 5) err('Too many attempts. Try again in 15 minutes.', 429);
    $u = q('SELECT * FROM users WHERE email=?', [$e])->fetch(PDO::FETCH_ASSOC);
    if (!$u || !is_string($p) || !password_verify($p, $u['pw'])) { logL($e ?: '(blank)', 'Failed'); err('Wrong email or password', 401); }
    if (!$u['active']) { logL($e, 'Disabled account'); err('This account is disabled', 403); }
    session_regenerate_id(true); $_SESSION['uid'] = (int)$u['id'];
    q('UPDATE users SET last=? WHERE id=?', [date('Y-m-d H:i:s'), $u['id']]);
    logL($e, 'Success');
    audit($u, 'login', 'user', $u['id']);
    out(['user' => pub($u), 'csrf' => csrf()]);
}
case 'logout': {
    $u = me(); if ($u) { logL($u['email'], 'Logout'); audit($u, 'logout', 'user', $u['id']); }
    $_SESSION = []; session_destroy();
    out(['ok' => 1]);
}
case 'change_password': {
    $u = need(); $n = $in['new'] ?? '';
    if (!password_verify($in['old'] ?? '', $u['pw'])) err('Current password is wrong');
    if (!okpw($n)) err('Use 8+ characters');
    q('UPDATE users SET pw=? WHERE id=?', [password_hash($n, PASSWORD_DEFAULT), $u['id']]);
    audit($u, 'changed password', 'user', $u['id']);
    out(['ok' => 1]);
}
case 'users': {
    need(true);
    out(['users' => array_map('pub', q('SELECT * FROM users ORDER BY id')->fetchAll(PDO::FETCH_ASSOC)),
         'logins' => q('SELECT ts,email,result,ip FROM logins ORDER BY id DESC LIMIT 100')->fetchAll(PDO::FETCH_ASSOC)]);
}
case 'add_user': {
    need(true);
    $n = trim($in['name'] ?? ''); $e = strtolower(trim($in['email'] ?? '')); $p = $in['password'] ?? ''; $r = $in['role'] ?? '';
    if (!$n || !filter_var($e, FILTER_VALIDATE_EMAIL) || !okpw($p) || !in_array($r, $roles, true)) err('Enter a name, valid email, 8+ character password and a role');
    if (q('SELECT 1 FROM users WHERE email=?', [$e])->fetch()) err('That email already exists');
    q('INSERT INTO users(name,email,pw,role,active,master) VALUES(?,?,?,?,1,0)', [$n, $e, password_hash($p, PASSWORD_DEFAULT), $r]);
    out(['ok' => 1]);
}
case 'set_user': {
    $me = need(true);
    $t = q('SELECT * FROM users WHERE id=?', [(int)($in['id'] ?? 0)])->fetch(PDO::FETCH_ASSOC);
    if (!$t) err('User not found');
    if ($t['master'] || $t['id'] == $me['id']) err('This account cannot be changed here');
    $f = $in['field'] ?? ''; $v = $in['value'] ?? null;
    if ($f == 'role' && in_array($v, $roles, true)) q('UPDATE users SET role=? WHERE id=?', [$v, $t['id']]);
    elseif ($f == 'active') q('UPDATE users SET active=? WHERE id=?', [$v ? 1 : 0, $t['id']]);
    else err('Bad request');
    audit($me, 'edited', 'user', $t['id']);
    out(['ok' => 1]);
}
case 'reset_password': {
    need(true); $n = $in['new'] ?? '';
    if (!okpw($n)) err('Use 8+ characters');
    q('UPDATE users SET pw=? WHERE id=?', [password_hash($n, PASSWORD_DEFAULT), (int)($in['id'] ?? 0)]);
    out(['ok' => 1]);
}
case 'del_user': {
    $me = need(true);
    $t = q('SELECT * FROM users WHERE id=?', [(int)($in['id'] ?? 0)])->fetch(PDO::FETCH_ASSOC);
    if (!$t || $t['master'] || $t['id'] == $me['id']) err('This account cannot be deleted');
    q('DELETE FROM users WHERE id=?', [$t['id']]);
    out(['ok' => 1]);
}
case 'load': {
    $u = need();
    $r = q("SELECT v FROM kv WHERE k='data'")->fetchColumn();
    $d = $r ? (json_decode($r, true) ?: []) : [];
    // Estimators only receive their own saved costing and quotation history.
    if ($u['role'] === 'estimator') {
        $uid = (int)$u['id']; $name = $u['name'];
        $d['history'] = array_values(array_filter($d['history'] ?? [], function($h) use ($uid, $name) {
            return (isset($h['userId']) && (int)$h['userId'] === $uid) || (!isset($h['userId']) && ($h['user'] ?? '') === $name);
        }));
        $d['quotations'] = array_values(array_filter($d['quotations'] ?? [], function($q) use ($uid, $name) {
            return (isset($q['userId']) && (int)$q['userId'] === $uid) || (!isset($q['userId']) && ($q['user'] ?? '') === $name);
        }));
        $d['taxInvoices'] = array_values(array_filter($d['taxInvoices'] ?? [], function($iv) use ($uid, $name) {
            return (isset($iv['userId']) && (int)$iv['userId'] === $uid) || (!isset($iv['userId']) && ($iv['user'] ?? '') === $name);
        }));
    }
    out(['data' => $d]);
}
case 'backups': {
    $u = need(true);
    $bdir = $dir . '/backups';
    if (!is_dir($bdir)) @mkdir($bdir, 0700, true);
    $files = glob($bdir . '/backup-*.json') ?: [];
    rsort($files, SORT_STRING);
    $out = [];
    foreach (array_slice($files, 0, 30) as $f) $out[] = ['name' => basename($f), 'size' => filesize($f), 'modified' => date('Y-m-d H:i:s', filemtime($f))];
    out(['backups' => $out]);
}
case 'backup_download': {
    $u = need(true);
    $name = basename((string)($in['name'] ?? ''));
    if (!preg_match('/^backup-\\d{4}-\\d{2}-\\d{2}(-\\d{6})?\\.json$/', $name)) err('Invalid backup name');
    $file = $dir . '/backups/' . $name;
    if (!is_file($file)) err('Backup not found', 404);
    $data = json_decode(file_get_contents($file), true);
    audit($u, 'downloaded', 'backup', $name);
    out(['name' => $name, 'data' => $data]);
}
case 'backup_restore': {
    $u = need(true);
    $name = basename((string)($in['name'] ?? ''));
    if (!preg_match('/^backup-\\d{4}-\\d{2}-\\d{2}(-\\d{6})?\\.json$/', $name)) err('Invalid backup name');
    $file = $dir . '/backups/' . $name;
    if (!is_file($file)) err('Backup not found', 404);
    $data = json_decode(file_get_contents($file), true);
    if (!is_array($data)) err('Backup is invalid');
    q("REPLACE INTO kv(k,v) VALUES('data',?)", [json_encode($data)]);
    audit($u, 'restored', 'backup', $name);
    out(['ok' => 1]);
}
case 'save': {
    $u = need();
    $allow = ['admin' => null,
              'manager' => ['history', 'quotations', 'taxInvoices', 'templates', 'seq', 'qseq', 'invseq', 'tid', 'audit', 'pdfT'],
              'estimator' => ['history', 'quotations', 'taxInvoices', 'seq', 'qseq', 'invseq', 'audit', 'pdfT'],
              'viewer' => []][$u['role']];
    $d = $in['data'] ?? null;
    if (!is_array($d)) err('Bad data');
    $cur = json_decode((string)q("SELECT v FROM kv WHERE k='data'")->fetchColumn(), true) ?: [];
    foreach ($d as $k => $v) {
        if ($allow !== null && !in_array($k, $allow, true)) continue;

        if ($k == 'history' && is_array($v)) {
            $m = [];
            foreach (($cur['history'] ?? []) as $h) $m[$h['id']] = $h;
            if ($u['role'] === 'estimator') {
                foreach ($v as $h) {
                    $owner = isset($h['userId']) ? (int)$h['userId'] : 0;
                    $old = $m[$h['id']] ?? null;
                    $oldOwner = $old && isset($old['userId']) ? (int)$old['userId'] : 0;
                    if (($owner && $owner === (int)$u['id']) || (!$owner && ($h['user'] ?? '') === $u['name']) || ($old && $oldOwner === (int)$u['id'])) {
                        $h['userId'] = (int)$u['id']; $h['user'] = $u['name']; $m[$h['id']] = $h;
                    }
                }
            } else {
                foreach ($v as $h) $m[$h['id']] = $h;
            }
            $v = array_values($m);
            usort($v, function ($x, $y) { return strcmp($y['id'], $x['id']); });
        }

        if ($k == 'quotations' && is_array($v)) {
            $m = [];
            foreach (($cur['quotations'] ?? []) as $qv) $m[$qv['id']] = $qv;
            if ($u['role'] === 'estimator') {
                foreach ($v as $qv) {
                    $old = $m[$qv['id']] ?? null;
                    $owner = isset($qv['userId']) ? (int)$qv['userId'] : 0;
                    $oldOwner = $old && isset($old['userId']) ? (int)$old['userId'] : 0;
                    if (($owner && $owner === (int)$u['id']) || (!$owner && ($qv['user'] ?? '') === $u['name']) || ($old && $oldOwner === (int)$u['id'])) {
                        $qv['userId'] = (int)$u['id']; $qv['user'] = $u['name']; $m[$qv['id']] = $qv;
                    }
                }
            } else {
                foreach ($v as $qv) $m[$qv['id']] = $qv;
            }
            $v = array_values($m);
            usort($v, function ($x, $y) { return strcmp($y['id'], $x['id']); });
        }

        if ($k == 'taxInvoices' && is_array($v)) {
            $m = [];
            foreach (($cur['taxInvoices'] ?? []) as $iv) $m[$iv['id']] = $iv;
            if ($u['role'] === 'estimator') {
                foreach ($v as $iv) {
                    $old = $m[$iv['id']] ?? null;
                    $owner = isset($iv['userId']) ? (int)$iv['userId'] : 0;
                    $oldOwner = $old && isset($old['userId']) ? (int)$old['userId'] : 0;
                    if (($owner && $owner === (int)$u['id']) || (!$owner && ($iv['user'] ?? '') === $u['name']) || ($old && $oldOwner === (int)$u['id'])) {
                        $iv['userId'] = (int)$u['id']; $iv['user'] = $u['name']; $m[$iv['id']] = $iv;
                    }
                }
            } else {
                foreach ($v as $iv) $m[$iv['id']] = $iv;
            }
            $v = array_values($m);
            usort($v, function ($x, $y) { return strcmp($y['id'], $x['id']); });
        }

        $cur[$k] = $v;
    }
    $json = json_encode($cur);
    $bdir = $dir . '/backups';
    if (!is_dir($bdir)) @mkdir($bdir, 0700, true);
    $todayKey = date('Y-m-d');
    $lastBackup = (string)q("SELECT v FROM kv WHERE k='backup_day'")->fetchColumn();
    if ($lastBackup !== $todayKey) {
        $old = q("SELECT v FROM kv WHERE k='data'")->fetchColumn();
        if ($old) @file_put_contents($bdir . '/backup-' . $todayKey . '-' . date('His') . '.json', $old, LOCK_EX);
        q("REPLACE INTO kv(k,v) VALUES('backup_day',?)", [$todayKey]);
    }
    q("REPLACE INTO kv(k,v) VALUES('data',?)", [$json]);
    audit($u, 'saved', 'data', 'data');
    out(['ok' => 1]);
}
default:
    err('Unknown action', 404);
}
