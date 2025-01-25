<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formModifica.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <title>User Profile</title>
    <script src="js/gestioneFormModifica.js" defer></script>
</head>

<body>
    <?php 
        require_once 'header.php';
        require_once 'database/get_user_info.php';
    ?>
    

    <div class="container">
        <div class="profile-image-wrapper">
            <img src="images/profilePicture.png" alt="User Icon" title="User Icon" id="profileImage" class="mainImage">

            <?php 
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if(isset($_SESSION['admin'])) echo "<img src='images/star.png' class='admin-badge' alt='AdminBadge' title='AdminBadge'>"; 
            ?>
        </div>

        <div class="user-info">
            <h2>User Information</h2>
            <form id="userForm">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" 
                    value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" disabled required>
            </div>
            <div class="form-group">
                <label for="firstname">Name:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Name" 
                    value="<?php echo htmlspecialchars($first, ENT_QUOTES); ?>" disabled required>
            </div>
            <div class="form-group">
                <label for="lastname">Surname:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Surname" 
                    value="<?php echo htmlspecialchars($last, ENT_QUOTES); ?>" disabled required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" 
                    value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" disabled required>
            </div>

                <div class="buttons">
                    <button id="editProfile" type="button">Edit</button>
                    <button id="cancelEdit" type="button" class="hidden">Cancel</button>
                    <button id="saveProfile" type="button" class="hidden">Save</button>
                </div>
            </form>
        </div>

        <div class="password-section">
            <button id="editPassword">Change Password</button>
                <form id="passwordForm" class="hidden">
                    <div class="form-group">
                        <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                    </div>
                    <div class="buttons">
                        <button id="cancelPassword" type="button">Cancel</button>
                        <button id="savePassword" type="button">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <footer>
            &copy; 2025 Chuck the Beaver. All rights reserved.
        </footer>   
    </body>

</html>
