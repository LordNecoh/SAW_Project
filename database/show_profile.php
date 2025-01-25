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
    $query = "SELECT firstname, lastname, email, username FROM users WHERE email = :email";
    
    $stmt = $conn->prepare($query);
    
    $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
    
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        echo "No user found";
    } else {

        //Preparazione dati
        $row = $stmt->fetch();
        $first = $row["firstname"];
        $last = $row["lastname"];
        $username = $row["username"];
        $email = $row["email"];

        if(isset($_SESSION['admin'])){
            $adminBadge = "<img src='images/star.png' alt='AdminBadge' title='AdminBadge' class='admin-badge'>";
            $adminArea = "<a href='adminPage.php' class='admin-link'>Admin Area</a>";
        }else{
            $adminBadge = "";
            $adminArea = "";
        }

        $result = "
                <span class='close-button' id='closeProfilePopup'>&times;</span>
                <div class='profile-image-wrapper'>
                    <img src='images/profilePicture.png' alt='Profile Image' title='Pofile Image' class='profile-image'>
                    $adminBadge
                </div>
                <p><strong>Nome:</strong> <span>" . htmlspecialchars($first, ENT_QUOTES) . "</span></p>
                <p><strong>Cognome:</strong> <span>" . htmlspecialchars($last,ENT_QUOTES) . "</span></p>
                <p><strong>Username:</strong> <span>" . htmlspecialchars($username, ENT_QUOTES) . "</span></p>
                <p><strong>Email:</strong> <span>" . htmlspecialchars($email, ENT_QUOTES) . "</span></p>
                
                <button id='editProfileButton' class='edit-button'>Modifica Informazioni</button>
                $adminArea
                ";
        echo $result;
        
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    exit("Something went wrong, visit us later");
}
?>
