<?php
$dsn = "mysql:host=localhost;dbname=mecaniq;charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
  $pdo = new PDO($dsn, "root", "", $options);
} catch (\PDOException $e) {
  die("Erro temporário de ligação ao serviço de dados.");
}
?>