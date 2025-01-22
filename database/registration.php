<?php

require 'connessioneDB.php'; // Collegamento al database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controllo che tutti i campi siano compilati
    if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || 
        empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["confirm"])) {
        $_SESSION['error_message'] = "Uno o più campi sono vuoti. Compilare tutti i campi.";
        header(header: "Location: ../formRegistrazione.php");
        exit();
    }

    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['pass'];
    $confirm = $_POST['confirm'];

    // Validazione email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "L'email non è valida.";
        header("Location: registration.php");
        exit();
    }

    // Validazione nome e cognome (permette solo lettere e spazi)
    if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        $_SESSION['error_message'] = "Nome e cognome possono contenere solo lettere e spazi.";
        header(header: "Location: ../formRegistrazione.php");
        exit();
    }

    // Verifica che la password e la conferma siano uguali
    if ($password !== $confirm) {
        $_SESSION['error_message'] = "Le password non corrispondono.";
        header(header: "Location: ../formRegistrazione.php");
        exit();
    }

    // Validazione password (minimo 8 caratteri)
    if (strlen($password) < 8) {
        $_SESSION['error_message'] = "La password deve essere lunga almeno 8 caratteri.";
        header(header: "Location: ../formRegistrazione.php");
        exit();
    }

    // Hash della password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Inserimento nel database
        $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $firstname, $lastname, $hashedPassword]);

        // Gestione della sessione
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION['firstname'] = $firstname;

        // Reindirizzamento alla home dopo il successo
        header('Location: ../index.php');
        exit();

    } catch (PDOException $e) {
        // Se l'errore è per un'email già registrata, gestiscilo separatamente
        if ($e->errorInfo[1] == 1062) {
            $_SESSION['error_message'] = "Errore: l'email è già registrata.";
        } else {
            // Log dell'errore per eventuali altri problemi del database
            error_log("Errore del database: " . $e->getMessage());
            $_SESSION['error_message'] = "Si è verificato un errore. Riprovare più tardi.";
        }
        header(header: "Location: ../formRegistrazione.php");
        exit();
    }
}
?>
