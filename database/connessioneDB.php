<?php
$configFile = __DIR__ . '/config.php';

if (!file_exists($configFile)) {
    die("Errore: il file di configurazione non è presente.");
}

require_once $configFile;
try {
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $conn = new PDO($dsn, DB_USER, DB_PASSWORD);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 

} catch (PDOException $e) {
    error_log("Errore di connessione al database: " . $e->getMessage());
    die("Impossibile connettersi al database. Riprova più tardi.");
}
?>

