<?php

require 'connessioneDB.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(["success" => false, "message" => "Entrambi i campi password sono obbligatori."]);
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(["success" => false, "message" => "Le password non coincidono."]);
        exit();
    }

    if (strlen($newPassword) < 8 || !preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        echo json_encode([
            "success" => false,
            "message" => "La password deve contenere almeno 8 caratteri, includere lettere e numeri."
        ]);
        exit();
    }

    try {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $_SESSION["email"]]);

        echo json_encode(["success" => true, "message" => "Password aggiornata con successo!"]);
    } catch (PDOException $e) {
        error_log("Errore del database: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "Si è verificato un errore durante l'aggiornamento della password. Riprovare più tardi."]);
    }
}
?>
