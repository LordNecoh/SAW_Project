<link rel="stylesheet" href="css/loginPopup.css">

<div class="loginPopup-content">
    <span class="close-button" id="closeLoginPopup">&times;</span>
    <form action="database/login.php" method="POST">
        <h2> Login Form</h2>
        <label for="email">Email</label> 
        <input type="email" id="email" name="email">
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass">
        <input type="submit" name="submit" value="login">
    </form>
    <span> Non hai un account? <a href="formRegistrazione.php">Registrati!</a></span>
</div>