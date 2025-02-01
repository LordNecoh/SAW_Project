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
    if (!is_array($data)) {
        echo json_encode(['success' => false, 'error' => 'Dati JSON non validi.']);
        exit();
    }
    $email = $_SESSION["email"];
    $amount = filter_var($data["amount"] ?? null, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $public = $data["public"] ?? false;
    $public = filter_var($public, FILTER_VALIDATE_BOOL);

    //Senza questo su localhost va ma su server no
    if($public === null) {
        echo json_encode(['success' => false, 'error' => 'Valore pubblico non valido.']);
        exit();
    }else if($public === true){
        $public = 1;
    }else{
        $public = 0;
    }

    
    if ( $amount === false || $amount <= 0) {
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
        echo json_encode(['success' => false, 'error' => 'Errore durante la registrazione della donazione : ' . $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Metodo non consentito.']);
    exit();
}
