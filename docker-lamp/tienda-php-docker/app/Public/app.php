<?php
$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$name = getenv('DB_NAME') ?: 'tienda';
$user = getenv('DB_USER') ?: 'tienda_user';
$pass = getenv('DB_PASS') ?: '1234';
$dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
$pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
http_response_code(500);
die("Error de conexión: " . $e->getMessage());
}
