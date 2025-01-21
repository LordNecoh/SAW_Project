<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formModifica.css">
    <title>User Profile</title>
    <script src="js/gestioneFormModifica.js"></script>
    </head>
<body>
    <?php require 'header.php';
    require 'database/get_info.php';
    ?>

    <div class="container">
        <div class="user-icon">
            <img src="images/profilePicture.png" alt="User Icon" id="userIcon">
        </div>
        <div class="form-container">
            <h2>User Information</h2>
            <form id="userForm">
                <div class="form-row">
                    <input type="text" id="firstname" name="firstname" class="form-control half-width"
                        placeholder="Name" required value="<?php echo htmlspecialchars($first, ENT_QUOTES); ?>">
                    <input type="text" id="lastname" name="lastname" class="form-control half-width"
                        placeholder="Surname" required value="<?php echo htmlspecialchars($last, ENT_QUOTES); ?>">
                </div>
                <div class="form-row">
                    <input type="email" id="email" name="email" class="form-control large-width" placeholder="Email"
                        required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                </div>
                <button type="submit" class="form-button" style="display: none;">Submit</button>
            </form>
            <button id="editProfileButton" class="form-button">Modifica Informazioni</button>
            <button id="cancelButton" class="form-button cancel-button hidden">Annulla</button>
            <button id="confirmInfoButton" class="form-button confirm-button hidden">Conferma</button>
        </div>

        <div class="password-form-container">
            <button id="editPasswordButton" class="form-button">Modifica Password</button>
            <div id="passwordForm" class="hidden">
                <form id="passwordUpdateForm">
                    <div class="form-row">
                        <input type="password" id="password" name="password"
                            class="password-form-control half-width" placeholder="Nuova Password" required>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="password-form-control half-width" placeholder="Conferma Password" required>
                    </div>
                </form>
                <button id="cancelPasswordButton" class="form-button cancel-button">Annulla</button>
                <button id="confirmPasswordButton" class="form-button confirm-button">Conferma</button>
            </div>
        </div>
    </div>


</body>

</html>