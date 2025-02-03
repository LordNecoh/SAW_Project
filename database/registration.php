<?php
require_once 'connessioneDB.php'; 

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // ---- Validazione ---- //

    $response = [];

    if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || 
        empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["confirm"])) {
        $response['error'] = "One or more fields are empty. Please fill in all fields.";
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
        $response['error'] = "Email is not valid.";
        echo json_encode($response);
        exit();
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        $response['error'] = "First name and last name can only contain letters and spaces.";
        echo json_encode($response);
        exit();
    }

    if ($password !== $confirm) {
        $response['error'] = "Passwords do not match.";
        echo json_encode($response);
        exit();
    }

    if (strlen($password) < 8) {
        $response['error'] = "Password must be at least 8 characters long.";
        echo json_encode($response);
        exit();
    }
    
    // Controllo: la password deve contenere solo lettere o numeri.
    if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
        $response['error'] = "Password must contain only letters and numbers.";
        echo json_encode($response);
        exit();
    }

    if ($username !== null) {
        // Controllo per spazi nell'username e solo lettere, numeri e underscore.
        if (preg_match("/\s/", $username)) {
            $response['error'] = "Username cannot contain spaces.";
            echo json_encode($response);
            exit();
        }
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username) || strlen($username) < 4 || strlen($username) > 50) {
            $response['error'] = "Username can only contain letters, numbers, and underscores and must be between 4 and 50 characters long.";
            echo json_encode($response);
            exit();
        }
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ---- Query ---- //

    try {
        $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, password, username) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $firstname, $lastname, $hashedPassword, $username]);

        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;

        $response['success'] = "Registration completed successfully!";
        echo json_encode($response);
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { 
            if (strpos($e->errorInfo[2], 'username') !== false) {
                $response['error'] = "Error: username is already in use.";
            } else {
                $response['error'] = "Error: email is already registered.";
            }
        } else {
            error_log("Database error: " . $e->getMessage());
            $response['error'] = "An error occurred. Please try again later.";
        }
        echo json_encode($response);
        exit();
    
    }
}
?>
