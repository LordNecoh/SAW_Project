<?php
//Constants for the connection, need to be changed when the code is ported
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_NAME", "saw");
define("DB_PASSWORD", "");



try {
    //Creating connection with PDO
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    // Abilita la gestione degli errori PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}
?>