<?php
require 'connessioneDB.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"]) || empty($_POST["pass"])) {
        echo "<div class='error'>Uno o più campi sono vuoti, compila tutti i campi.</div>";
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='error'>L'email non è valida.</div>";
        exit();
    }

    $password = $_POST['pass'];  

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            echo "<div class='error'>Email o password non corretti.</div>";
            exit();
        } 
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstname'] = $user['firstname'];

        header('Location: ../index.php');
        exit();
        
    } catch (PDOException $e) {
        error_log("Errore di connessione o query: " . $e->getMessage());
        echo "<div class='error'>Si è verificato un errore. Riprovare più tardi.</div>";
        exit();
    }
}
?>
