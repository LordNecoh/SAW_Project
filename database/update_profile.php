<?php

require 'connessioneDB.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    echo json_encode(["success" => false, "message" => "Errore: utente non autenticato."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"])) {
        echo json_encode(["success" => false, "message" => "Uno o più campi sono vuoti. Compilare tutti i campi."]);
        exit();
    }

    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "L'email non è valida."]);
        exit();
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        echo json_encode(["success" => false, "message" => "Nome e cognome possono contenere solo lettere e spazi."]);
        exit();
    }

    try {
        $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE email = ?");
        $stmt->execute([$firstname, $lastname, $email, $_SESSION["email"]]);

        $_SESSION["email"] = $email;
        $_SESSION['firstname'] = $firstname;
        echo json_encode(["success" => true, "message" => "Modifica completata con successo!"]);
    } catch (PDOException $e) {
        error_log("Errore del database: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "Si è verificato un errore durante l'aggiornamento. Riprovare più tardi."]);
    }
}
?>
