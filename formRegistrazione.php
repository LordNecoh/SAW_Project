<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="css/formRegistrazione.css">
    <link rel="stylesheet" href="css/body.css">
    <script src="js/gestioneFormRegistrazione.js"></script>

</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container">
        <form id="registrationForm" method="post" class="registration-form">
            <h2>Registrati</h2>
            <div id="errorMessage" class="error-message"></div> 

            <label for="firstname">Nome:</label>
            <input type="text" name="firstname" class="input-text" id="firstname" required>
            
            <label for="lastname">Cognome:</label>
            <input type="text" name="lastname" class="input-text" id="lastname" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" class="input-email" id="email" required>
            
            <label for="pass">Password:</label>
            <input type="password" name="pass" class="input-password" id="pass" required>
            
            <label for="confirm">Conferma password:</label>
            <input type="password" name="confirm" class="input-password" id="confirm" required>
            
            <input type="submit" name="register" value="Conferma" class="submit-button">
        </form>
        <div id="loadingSpinner" class="loading-spinner"></div>

        <a href="index.php">Torna alla home</a>
    </div>


</body>
</html>
