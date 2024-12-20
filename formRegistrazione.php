
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrazione </title>
        <link rel="stylesheet" href="css/formRegistrazione.css">
        <link rel="stylesheet" href="css/body.css">

        <script src="gestionePopup.js" ></script>
        
        
    </head>
    <body>

        <?php include 'header.php'; ?>
        
        <div id="registrationForm">
        <form action="registration.php" method="post" id="registrationForm" class="registrationForm">
            <h2>Registration Form</h2>
            <label for="firstname">Nome:</label>
            <input type="text" name="firstname" id="firstname" required>
            <label for="lastname">Cognome:</label>
            <input type="text" name="lastname" id="lastname" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" required >
            <label for="confirm">Confirm:</label>
            <input type="password" name="confirm" id="confirm" required >

            <input type="submit" name="register" value="Register">
</form>
            <a href="index.php">Torna alla home</a>
        </div>
    </body>
</html>