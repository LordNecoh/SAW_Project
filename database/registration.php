<?php
require 'connessioneDB.php'; 

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = [];

    if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || 
        empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["confirm"])) {
        $response['error'] = "Uno o più campi sono vuoti. Compila tutti i campi.";
        echo json_encode($response);
        exit();
    }

    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['pass'];
    $confirm = $_POST['confirm'];
    $username = !empty($_POST["username"]) ? $_POST["username"] : null; // Campo opzionale per passare i test

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = "L'email non è valida.";
        echo json_encode($response);
        exit();
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        $response['error'] = "Nome e cognome possono contenere solo lettere e spazi.";
        echo json_encode($response);
        exit();
    }

    if ($password !== $confirm) {
        $response['error'] = "Le password non corrispondono.";
        echo json_encode($response);
        exit();
    }

    if (strlen($password) < 8) {
        $response['error'] = "La password deve essere lunga almeno 8 caratteri.";
        echo json_encode($response);
        exit();
    }

    if ($username !== null && (!preg_match("/^[a-zA-Z0-9_]+$/", $username) || strlen($username) < 4 || strlen($username) > 50)) {
        $response['error'] = "L'username può contenere solo lettere, numeri e underscore ed essere lungo tra 4 e 50 caratteri.";
        echo json_encode($response);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, password, username) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $firstname, $lastname, $hashedPassword, $username]);

        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;

        $response['success'] = "Registrazione completata con successo!";
        echo json_encode($response);
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // Controllo per duplicati (email o username)
            if (strpos($e->errorInfo[2], 'username') !== false) {
                $response['error'] = "Errore: l'username è già in uso.";
            } else {
                $response['error'] = "Errore: l'email è già registrata.";
            }
        } else {
            error_log("Errore del database: " . $e->getMessage());
            $response['error'] = "Si è verificato un errore. Riprovare più tardi.";
        }
        echo json_encode($response);
        exit();
    }
}
?>
