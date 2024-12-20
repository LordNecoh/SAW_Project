<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<p>Accesso negato. Sarai reindirizzato alla pagina di login.</p>";
    header("Refresh: 3; url=index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pagina Riservata</title>
    </head>
    <body>
        <h1>Benvenuto nella pagina riservata, <?php echo $_SESSION['username']; ?>!</h1>
        <a href="index.php">Torna alla home</a>
    </body>
</html>
