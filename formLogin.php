
<link rel="stylesheet" href="css/formLoginPopup.css">

<div class="popup-content">
    <span class="close-button" id="closeLoginPopup">&times;</span>
    <form action="database/login.php" method="POST">
        <h2> Login Form</h2>
        <label for="email">Email</label> 
        <input type="email" name="email">
        <label for="password">Password</label>
        <input type="password" name="pass">
        <input type="submit" name="submit" value="login">
    </form>
    <span> Non hai un account? <a href="formRegistrazione.php">Registrati!</a></span>
</div>