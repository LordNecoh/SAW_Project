<?php
require 'connessioneDB.php'; 

header('Content-Type: application/json'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (!isset($_SESSION["email"])) {
        echo json_encode(['success' => false, 'error' => 'Utente non autenticato.']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $email = $_SESSION["email"];
    $amount = $data["amount"] ?? null;
    $public = $data["public"] ?? false;
    $public = filter_var($public, FILTER_VALIDATE_BOOLEAN);
    
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        echo json_encode(['success' => false, 'error' => 'Importo non valido.']);
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO donations (email, amount, public) VALUES (?, ?, ?)");
        $stmt->execute([$email, $amount, $public]);

        echo json_encode(['success' => true, 'message' => 'Donazione registrata con successo.']);
        exit();
    } catch (PDOException $e) {
        error_log("Errore del database: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Errore durante la registrazione della donazione.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Metodo non consentito.']);
    exit();
}
