<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>

    <link rel="stylesheet" href="css/formRegistrazione.css">
    <link rel="stylesheet" href="css/loader.css">
    <link rel="stylesheet" href="css/footer.css">


    <script src="js/gestioneFormRegistrazione.js"></script>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">


</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container">
        <form id="registrationForm" method="post" class="registration-form">
            <h2>Register</h2>
            <div id="loaderWheel" class="loader"></div>
            <div id="errorMessage" class="error-message"></div> 

            <label for="username">Username:</label>
            <input type="text" name="username" class="input-text" id="username" required>
            
            <label for="firstname">Name:</label>
            <input type="text" name="firstname" class="input-text" id="firstname" required>
            
            <label for="lastname">Surname:</label>
            <input type="text" name="lastname" class="input-text" id="lastname" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" class="input-email" id="email" required>
            
            <label for="pass">Password:</label>
            <input type="password" name="pass" class="input-password" id="pass" required>
            
            <label for="confirm">Confirm password:</label>
            <input type="password" name="confirm" class="input-password" id="confirm" required>
            
            <input type="submit" name="register" value="Confirm" class="submit-button">
        </form>
        <div id="loadingSpinner" class="loading-spinner"></div>

        <a href="index.php">Back to the homepage</a>
    </div>

    <?php require 'footer.php'; ?>
</body>
</html>
