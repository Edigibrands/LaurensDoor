
<?php
header('Content-Type: application/json');
header('Cache-Control: no-store');

$url = getenv('DATABASE_URL');

if (!$url || !extension_loaded('pdo_pgsql')) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Database URL or PostgreSQL extension unavailable'
    ]);
    exit;
}

try {
    $parts = parse_url($url);

    if (!$parts || empty($parts['host']) ||
        empty($parts['path']) || empty($parts['user'])) {
        throw new RuntimeException('Invalid database URL');
    }

    $host = $parts['host'];
    $port = $parts['port'] ?? 5432;
    $dbname = rawurldecode(ltrim($parts['path'], '/'));
    $user = rawurldecode($parts['user']);
    $password = rawurldecode($parts['pass'] ?? '');

    $dsn = "pgsql:host=$host;port=$port;" .
           "dbname=$dbname;sslmode=require";

    $db = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);

    $db->query('SELECT 1');

    echo json_encode([
        'ok' => true,
        'database' => 'connected'
    ]);
} catch (Throwable $e) {
    error_log('Database connectivity test failed: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Database connection failed'
    ]);
}
