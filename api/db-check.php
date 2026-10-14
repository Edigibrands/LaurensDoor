<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond($status, $data) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
    exit;
}

try {
    $url = getenv('DATABASE_URL');

    if (!$url) {
        throw new RuntimeException('DATABASE_URL is missing');
    }

    if (!extension_loaded('pdo_pgsql')) {
        throw new RuntimeException('PDO PostgreSQL driver unavailable');
    }

    $parts = parse_url($url);

    if (
        !$parts ||
        empty($parts['host']) ||
        empty($parts['path']) ||
        empty($parts['user']) ||
        !isset($parts['pass'])
    ) {
        throw new RuntimeException('Invalid DATABASE_URL format');
    }

    $host = $parts['host'];
    $port = $parts['port'] ?? 5432;
    $dbname = rawurldecode(ltrim($parts['path'], '/'));
    $user = rawurldecode($parts['user']);
    $originalPassword = rawurldecode($parts['pass']);

    // Extract Neon endpoint ID from the hostname.
    $endpointId = explode('.', $host)[0];
    $endpointId = preg_replace('/-pooler$/', '', $endpointId);

    if (!preg_match('/^ep-[a-z0-9-]+$/', $endpointId)) {
        throw new RuntimeException('Could not identify Neon endpoint');
    }

    // Workaround for older libpq clients without SNI support.
    $password = 'endpoint=' . $endpointId . ';' . $originalPassword;

    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

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
    error_log('Neon database test failed: ' . $e->getMessage());

    respond(500, [
        'ok' => false,
        'error' => 'Database connection failed',
        'detail' => $e->getMessage()
    ]);
}
