<?php
require 'connessioneDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (!isset($_SESSION['email'])) {
        echo json_encode(['success' => false, 'message' => 'Utente non autenticato.']);
        exit();
    }

    $newPassword = $_POST['newPassword'];

    if (empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'La password non può essere vuota.']);
        exit();
    }

    try {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $_SESSION['email']]);

        echo json_encode(['success' => true, 'message' => 'Password aggiornata con successo!']);
    } catch (PDOException $e) {
        error_log("Errore del database: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Errore del database. Riprova più tardi.']);
    }
}
?>
