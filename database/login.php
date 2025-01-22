<?php
require 'connessioneDB.php'; // Collegamento al database

// Verifica se il metodo della richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Controllo che tutti i campi siano compilati
    if (empty($_POST["email"]) || empty($_POST["pass"])) {
        echo "<div class='error'>Uno o più campi sono vuoti, compila tutti i campi.</div>";
        exit();
    }

    // Sanifica l'email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Controllo se l'email è valida
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='error'>L'email non è valida.</div>";
        exit();
    }

    $password = $_POST['pass'];  // La password non viene modificata, per sicurezza non è necessario sanitizzare

    try {
        // Controllo nel database i dati dell'utente
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch();

        // Verifica la correttezza della password
        if (!$user || !password_verify($password, $user['password'])) {
            echo "<div class='error'>Email o password non corretti.</div>";
            exit();
        } 
        
        // Gestione della sessione
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Salvataggio delle informazioni nell sessione
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstname'] = $user['firstname'];

        // Reindirizza alla home
        header('Location: ../index.php');
        exit();
        
    } catch (PDOException $e) {
        // Log dell'errore nel caso di problemi con il database
        error_log("Errore di connessione o query: " . $e->getMessage());
        echo "<div class='error'>Si è verificato un errore. Riprovare più tardi.</div>";
        exit();
    }
}
?>
