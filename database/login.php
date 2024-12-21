<?php
require 'connessioneDB.php'; // Collegamento al database

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Checking all fields are completed
    if(empty($_POST["email"]) || empty($_POST["pass"])){
        echo "<div class='error'>One or more fields are empty, please be sure to fill out all fields</div>";
        //Output errore da rivedere!!
        exit();
    }

    //Taking values from the fields
    $email = $_POST['email'];
    $password = $_POST['pass'];

    try {
        //Checking the database for user's data
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            echo "<div class='failure'>Username or password are incorrect</div>";
            //Output errore da rivedere
            exit();    
        } 
        
        //Session management
        session_start();
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstname'] = $user['firstname'];
        header('Location: ../index.php');
        
    } catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
        //Output errore da rivedere
    }

}
?>
