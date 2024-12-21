<?php
require 'connessioneDB.php'; // Collegamento al database

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Controllo che tutti i campi siano compilati
    if (empty($_POST["email"]) || empty($_POST["pass"])) {
        echo "<div class='error'>Uno o più campi sono vuoti, compila tutti i campi.</div>";
        exit();
    }

    // Prendi i valori dai campi
    $email = $_POST['email'];
    $password = $_POST['pass'];

    try {
        // Controllo nel database i dati dell'utente
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            echo "<div class='failure'>Email o password non validi.</div>";
            exit();    
        } 
        
        // Gestione della sessione
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstname'] = $user['firstname'];
        
        // Reindirizza alla home
        header('Location: ../index.php');
        exit();
        
    } catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
        exit();
    }
}
?>