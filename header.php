<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="css/header.css">
<header>
<div class="menu-toggle" id="mobileMenuToggle">&#9776;</div>

    <nav class="navbar" id="navbar">
        <!-- Mobile Menu Toggle -->

        <!-- Sinistra: Titolo -->
        <div class="navbar-left">
            <h1 class="top-left-title">Chuck the Beaver</h1>
        </div>

        <!-- Centro: Blog -->
        <div class="navbar-center">
            <?php
            if (basename($_SERVER['PHP_SELF']) !== 'blog.php') {
                echo '<button type="button" id="blogBtn" class="blog-button" onclick="window.location.href=\'blog.php\'">Check our blog!</button>';
            }
            ?>
        </div>

        <!-- Destra: Login e Profilo -->
        <div class="navbar-right" id="logInfo">
            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            if ($currentPage === 'formModifica.php' || $currentPage === 'formRegistrazione.php' || $currentPage === 'adminPage.php' || $currentPage === 'blog.php') {
                echo '<button type="button" id="backToIndexBtn" class="login-button" onclick="window.location.href=\'index.php\'">Home</button>';
            } else {
                if (isset($_SESSION['username'])) {
                    echo '<div id="profilePopup" class="profilePopup">';
                    include 'profilePopup.php';
                    echo '</div>';
                    echo '<span class="welcome">Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</span>';
                    echo '<button type="button" id="openProfileBtn" class="profile-button">Profile</button>';
                    echo '<button type="button" id="logoutBtn" class="login-button">Logout</button>';
                } else {
                    echo '<div id="loginPopup" class="loginPopup">';
                    include 'loginPopup.php';
                    echo '</div>';
                    if ($currentPage !== 'formRegistrazione.php') {
                        echo '<button type="button" id="openLoginBtn" class="login-button">Login</button>';
                    }
                }
            }
            ?>
        </div>
    </nav>
</header>
<script>
    document.getElementById('mobileMenuToggle').addEventListener('click', function() {
    const navbar = document.getElementById('navbar');
    const menuToggle = document.getElementById('mobileMenuToggle');
    navbar.classList.toggle('active');
    menuToggle.classList.toggle('active');
});
</script>
