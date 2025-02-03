<?php

require_once 'connessioneDB.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]) || empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"])) {
        echo json_encode(["success" => false, "message" => "One or more fields are empty. Please fill in all fields."]);
        exit();
    }
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        echo json_encode(["success" => false, "message" => "Username can only contain letters, numbers, and underscores."]);
        exit();
    }
    
    // Verify if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "The email is not valid."]);
        exit();
    }
    
    // Verify if first name and last name contain only letters and spaces
    if (!preg_match("/^[a-zA-Z\s]+$/", $firstname) || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        echo json_encode(["success" => false, "message" => "First name and last name can only contain letters and spaces."]);
        exit();
    }
    
    try {
        $stmt = $conn->prepare("UPDATE users SET username = ?, firstname = ?, lastname = ?, email = ? WHERE email = ?");
        $stmt->execute([$username, $firstname, $lastname, $email, $_SESSION["email"]]);
    
        $_SESSION["email"] = $email;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['username'] = $username;
        echo json_encode(["success" => true, "message" => "Update completed successfully!"]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "An error occurred during the update. Please try again later."]);
    }
    
}
?>
