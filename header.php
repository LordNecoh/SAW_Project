<link rel="stylesheet" href="css/header.css">
<header>
    <h1>Chuck the Beaver</h1>
    <div id="logInfo">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Controlla se l'utente è autenticato
        if (isset($_SESSION['firstname'])) {
            // Utente autenticato: includi solo profilePopup
            echo '<div id="profilePopup" class="profilePopup">';
            include 'profilePopup.php';
            echo '</div>';
            
            // Mostra messaggio di benvenuto, pulsante profilo e logout
            echo '<span>Benvenuto, ' . htmlspecialchars($_SESSION['firstname']) . '!</span>';
            echo '<button type="button" id="openProfileBtn" class="profile-button">Profilo</button>';
            echo '<button type="button" id="logoutBtn" class="login-button">Logout</button>';
        } else {
            // Utente non autenticato: includi solo loginPopup
            echo '<div id="loginPopup" class="loginPopup">';
            include 'loginPopup.php';
            echo '</div>';
            
            if (basename($_SERVER['PHP_SELF']) !== 'formRegistrazione.php') {
                echo '<button type="button" id="openLoginBtn" class="login-button">Accedi</button>';
            }
        }
        ?>
    </div>
</header>
