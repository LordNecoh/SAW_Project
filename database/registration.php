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

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $firstname, $lastname, $hashedPassword]);

        // Successo, invia i dati di sessione
        $_SESSION["email"] = $email;
        $_SESSION['firstname'] = $firstname;

        $response['success'] = "Registrazione completata con successo!";
        echo json_encode($response);
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // Controlla errore per email duplicata
            $response['error'] = "Errore: l'email è già registrata.";
        } else {
            error_log("Errore del database: " . $e->getMessage());
            $response['error'] = "Si è verificato un errore. Riprovare più tardi.";
        }
        echo json_encode($response);
        exit();
    }
}
?>
