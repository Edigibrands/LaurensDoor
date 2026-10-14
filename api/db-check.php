<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    $url = getenv('DATABASE_URL');

    if (!$url) {
        throw new RuntimeException('DATABASE_URL is missing');
    }

    if (!extension_loaded('pdo_pgsql')) {
        throw new RuntimeException('PDO PostgreSQL driver unavailable');
    }

    // Parse the full Neon URL, including query parameters.
    $parts = parse_url($url);

    if (!$parts || empty($parts['host']) || empty($parts['path'])) {
        throw new RuntimeException('Invalid database URL');
    }

    $host = $parts['host'];
    $port = $parts['port'] ?? 5432;
    $dbname = rawurldecode(ltrim($parts['path'], '/'));
    $user = rawurldecode($parts['user'] ?? '');
    $password = rawurldecode($parts['pass'] ?? '');

    $query = [];
    parse_str($parts['query'] ?? '', $query);

    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

    // Preserve Neon endpoint routing parameters if present.
    if (!empty($query['options'])) {
        $options = rawurldecode($query['options']);
        $dsn .= ";options=" . $options;
    }

    $db = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10
    ]);

    $db->query('SELECT 1');

    http_response_code(200);
    echo json_encode([
        'ok' => true,
        'database' => 'connected'
    ]);

} catch (Throwable $e) {
    error_log('Neon DB test: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
