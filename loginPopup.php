<link rel="stylesheet" href="css/loginPopup.css">

<div class="loginPopup-content">
    <span class="close-button" id="closeLoginPopup">&times;</span>
    <form action="database/login.php" method="POST">
        <h2>Login Form</h2>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass" required>
        <div id="erroreLogin" class="error-message"></div>
        <input type="submit" name="submit" value="Login">
        <span>Don't have an account? <a href="formRegistrazione.php">Register!</a></span>
    </form>
</div>