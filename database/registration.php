<?php

require 'connessioneDB.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || 
        empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["confirm"])) {
        echo "<div class='error'>Uno o più campi sono vuoti. Compilare tutti i campi.</div>";
        exit();
    }

    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['pass'];
    $confirm = $_POST['confirm'];

    // Validazione email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'email non è valida.";
        exit();
    }

    // Validazione nome e cognome
    if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        echo "Nome e cognome possono contenere solo lettere e spazi.";
        exit();
    }

    // Verifica password
    if ($password !== $confirm) {
        echo "Le password non corrispondono.";
        exit();
    }

    // Hash della password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Inserimento nel database
        $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $firstname, $lastname, $hashedPassword]);
        
        // Reindirizzamento in caso di successo
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION['firstname'] = $firstname;
        header('Location: ../index.php');
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // Email già registrata
            echo "Errore: l'email è già registrata.";
        } else {
            error_log("Errore del database: " . $e->getMessage());
            echo "Si è verificato un errore. Riprovare più tardi.";
        }
    }
}
?>
