<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formModifica.css">
    <link rel="stylesheet" href="css/body.css">
    <title>User Profile</title>
    <script src="js/gestioneFormModifica.js" defer></script>
</head>

<body>
    <?php 
        require 'header.php';
        require 'database/get_user_info.php';
    ?>

    <div class="container">
        <div class="profile-picture">
            <img src="images/profilePicture.png" alt="User Icon" id="profileImage">
        </div>

        <div class="user-info">
            <h2>User Information</h2>
            <form id="userForm">
                <div class="form-group">
                    <input type="text" id="firstname" name="firstname" placeholder="Name" 
                        value="<?php echo htmlspecialchars($first, ENT_QUOTES); ?>" disabled required>
                    <input type="text" id="lastname" name="lastname" placeholder="Surname" 
                        value="<?php echo htmlspecialchars($last, ENT_QUOTES); ?>" disabled required>
                </div>
                <div class="form-group">
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
</body>

</html>
