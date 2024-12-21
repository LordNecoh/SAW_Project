<?php

require 'connessioneDB.php'; // Connessione al database


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Cheking all fields are filled
    if((empty($_POST["firstname"])) ||(empty($_POST["lastname"]))|| 
    empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["confirm"])){
        echo "<div class='error'>One or more fields are empty, please be sure to fill out all fields </div>";
        //Output errore da rivedere!!
        exit();
    }

    //Taking values from the fields
    $email = htmlspecialchars($_POST['email']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); //Password with hash

    try {
        //Inserting fields data
        $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $firstname, $lastname, $password]);
        /* echo "Registrazione completata con successo!"; */
        header('Location: ../index.php');

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { //1062 means mail already existing
            echo "Errore: l'email è già registrata.";   //Error output da rivedere!
        } else {
            echo "Errore: " . $e->getMessage(); //Error output da rivedere!
        }
    }

    //Session management
    session_start();
    $_SESSION["email"] = $email;
    $_SESSION['firstname'] = $firstname;
}
?>