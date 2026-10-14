<?php
// IMPORTANT: This must be the very first content in the file.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond($status, $data) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
    exit;
}

$url = getenv('DATABASE_URL');

if (!$url) {
    respond(500, [
        'ok' => false,
        'step' => 'environment',
        'error' => 'DATABASE_URL is missing'
    ]);
}

if (!extension_loaded('pdo_pgsql')) {
    respond(500, [
        'ok' => false,
        'step' => 'extension',
        'error' => 'PDO PostgreSQL extension is unavailable'
    ]);
}

try {
    $parts = parse_url($url);

    if (
        !$parts ||
        empty($parts['host']) ||
        empty($parts['path']) ||
        !isset($parts['user']) ||
        !isset($parts['pass'])
    ) {
        respond(500, [
            'ok' => false,
            'step' => 'url',
            'error' => 'DATABASE_URL format is invalid'
        ]);
    }

    $host = $parts['host'];
    $port = $parts['port'] ?? 5432;
    $dbname = rawurldecode(ltrim($parts['path'], '/'));
    $user = rawurldecode($parts['user']);
    $password = rawurldecode($parts['pass']);

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

    $db = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10
    ]);

    $db->query('SELECT 1');

    respond(200, [
        'ok' => true,
        'database' => 'connected'
    ]);

} catch (Throwable $e) {
    error_log('Database test failed: ' . $e->getMessage());

    respond(500, [
        'ok' => false,
        'step' => 'connection',
        'error' => 'Database connection failed',
        'detail' => $e->getMessage()
    ]);
}
