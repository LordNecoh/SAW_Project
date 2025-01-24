<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit();
}
include("connessioneDB.php");

$email = $_SESSION["email"];

try {
    $query = "SELECT username, firstname, lastname, email FROM users WHERE email = :email";
    
    $stmt = $conn->prepare($query);
    
    $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
    
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        echo "No user found";
        $first = $last = $email = "";
    } else {
        $row = $stmt->fetch();
        $first = htmlspecialchars($row["firstname"], ENT_QUOTES, 'UTF-8');
        $last = htmlspecialchars($row["lastname"], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8');
        $username = htmlspecialchars( $row["username"], ENT_QUOTES, 'UTF-8');

    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    exit("Something went wrong, visit us later");
}
?>