<?php
// Database connection - Supabase PostgreSQL

$envFile = __DIR__ . '/../.env';
if (is_readable($envFile)) {
  foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
      continue;
    }
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value, " \t\"'");
    if (getenv($key) === false) {
      putenv("$key=$value");
    }
  }
}

define('DB_HOST', getenv('DB_HOST') ?: 'aws-1-us-west-2.pooler.supabase.com');
define('DB_USER', getenv('DB_USER') ?: 'postgres.vffcogryczymyudiavyt');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'postgres');
define('DB_PORT', getenv('DB_PORT') ?: 5432);

if (!extension_loaded('pdo_pgsql')) {
  $drivers = implode(', ', PDO::getAvailableDrivers());
  die(json_encode([
    'error' => 'Error conectando a la base de datos: pdo_pgsql no esta instalado',
    'available_drivers' => $drivers,
  ]));
}

// Create PostgreSQL connection using PDO
try {
  $databaseUrl = getenv('DATABASE_URL');

  if ($databaseUrl) {
    $parsed = parse_url($databaseUrl);
    $host = $parsed['host'] ?? DB_HOST;
    $port = $parsed['port'] ?? DB_PORT;
    $dbName = isset($parsed['path']) ? ltrim($parsed['path'], '/') : DB_NAME;
    $user = $parsed['user'] ?? DB_USER;
    $password = $parsed['pass'] ?? DB_PASSWORD;
    $dsn = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbName . ';sslmode=require';
  } else {
    $user = DB_USER;
    $password = DB_PASSWORD;
    $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';sslmode=require';
  }

  if ($password === '') {
    die(json_encode(['error' => 'Configura DB_PASSWORD o DATABASE_URL para conectar con Supabase']));
  }

  $conn = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  
} catch (PDOException $e) {
  die(json_encode(['error' => 'Error conectando a la base de datos: ' . $e->getMessage()]));
}

// Connection established
// echo "Conectado a la base de datos\n";

/*$conn = null;*/
?>
