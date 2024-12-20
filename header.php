
<link rel="stylesheet" href="css/header.css">
<header>
  <h1>Chuck the beaver</h1>
    <div id="logInfo">
        <?php
        session_start();

        if (isset($_SESSION['firstname'])) {
            
            echo '<span>Benvenuto, ' . htmlspecialchars($_SESSION['firstname']) . '! </span>';
            echo '<button type="button" id="openProfileBtn" class="login-button">Profile</button>';
            echo '<button type="button" id="logoutBtn" class="login-button">Logout</button>';


        } else if (basename($_SERVER['PHP_SELF']) !== 'formRegistrazione.php') { 
             echo '<button type="button" id="openLoginBtn" class="login-button">Accedi</button>';
                }

                
        ?>
                
    </div>
</header>