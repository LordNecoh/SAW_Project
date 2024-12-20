<link rel="stylesheet" href="css/ProfilePopup.css">

<?php
require 'connessioneDB.php';

session_start();

if(!isset($_SESSION['email'])) {    //In case somehow the user is not logged in, should be in order to see the button to access here.
    header('Location: login.php');
    exit;
}

//Taking user's data from the DataBase
$email = $_SESSION['email'];
$stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
$stmst->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    //To do: if() profile picture is null
    //echo '<img class="profile-picture" src="' . htmlspecialchars($user['profilepicture']) . '" alt="Profile Picture">';
    
    echo '<div class="profile-info">';
    echo '<div class="profile-field">First Name: ' . htmlspecialchars($user['firstname']) . '</div>';
    echo '<div class="profile-field">Last Name: ' . htmlspecialchars($user['lastname']) . '</div>';
    echo '<div class="profile-field">Email: ' . htmlspecialchars($user['email']) . '</div>';
    echo '</div>';
} else {
    echo '<p class="error-message">User not found.</p>';
}


?>