<?php
require 'connessioneDB.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //    ----  Validazione  ----  //

    if (empty($_POST["email"]) || empty($_POST["pass"])) {
        $response['message'] = "Uno o più campi sono vuoti, compila tutti i campi.";
        echo json_encode($response);
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "L'email non è valida.";
        echo json_encode($response);
        exit();
    }

    $password = $_POST['pass'];

    //    ----  Query  ----  //

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $response['message'] = "Email o password non corretti.";
            echo json_encode($response);
            exit();
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username'];
        $isAdmin = $user['admin'];
        if($isAdmin == 1){
            $_SESSION['admin'] = $user['admin'];
        }


        $response['success'] = true;
        echo json_encode($response);
        exit();
    } catch (PDOException $e) {
        error_log("Errore di connessione o query: " . $e->getMessage());
        $response['message'] = "Si è verificato un errore. Riprovare più tardi.";
        echo json_encode($response);
        exit();
    }
}
?>
