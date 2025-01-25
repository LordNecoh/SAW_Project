<!DOCTYPE html>
<html lang="it">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuck the Beaver</title>

    <!--    Scripts     -->
    <script src="js/caricaDonazioni.js"></script>
    <script src="js/gestionePopup.js"></script>
    <script src="js/gestionePopupDonazione.js"></script>

    <!--    Stylesheets     -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/donazionePopup.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

</head>
<body>
    <?php require_once "database/connessioneDB.php"?>
    <?php include "header.php"?>
    <?php include "donazionePopup.php" ?>

    <!--    Introduzione    -->

    <h1> Welcome to Chuck the Beaver's very unofficial website! </h1>

    <div class="content-container">
        <div class="baseText" id="about">
            <p>Chuck the Beaver is a very exciting tower defense game created for the GMTK GameJam 2024.</p>
            <p>The theme for this year's jam is "built to scale," and Chuck the Beaver embodies this concept perfectly.</p>
            <p>Players must strategically place and upgrade their defenses to protect their territory from waves of enemies.</p>
            <p>As the game progresses, the challenges scale up, requiring players to adapt and enhance their strategies to succeed.</p>
            <p>Join Chuck the Beaver in this thrilling adventure and see if you have what it takes to defend your Dam!</p>
        </div>

        <img src="images/gameImage.png" alt="Image of the game's protagonist" title="Image of the game's protagonist" class="centeredImage">
    </div>

    <div class="content-container">
        <div class="baseText" id="game">
            <p>In the world of Chuck the Beaver, our protagonist is an industrious beaver who is obsessed with upgrading his dam.</p>
            <p>His relentless pursuit of perfection and efficiency has led him to block an important river, disrupting the natural balance of the forest.</p>
            <p>As a result, the forest creatures, angered by the changes and the threat to their habitat, have revolted against Chuck.</p>
            <p>They are determined to destroy his dam and restore the river to its former glory.</p>
            <p>Players must help Chuck defend his dam from the onslaught of forest creatures, using strategy and upgrades to withstand the relentless attacks.</p>
        </div>

    </div>

    <!--    Donazioni    -->
    

    <div class="donation-bar" id="support">
        <h2>Support Chuck the Beaver!</h2>
        <div class="donation-container">
            <div class="donation-progress" id="donationProgress"></div>
        </div>
        <p class="donation-details">
            Collected: <span id="donation-amount">€0.00</span> / Goal: <span id="donation-goal">Loading...</span>
        </p>
        <?php 
            if(isset($_SESSION['username'])){
                echo '<button id="openDonationBtn">Donate Now</button>';
            }else{
                echo '<button id="logToReg">Login to Donate</button>';
            }
        ?>
    </div>

    <!--    Top Donors   -->

<div id="donors-section" class="top-donors-table">
    <h2>Our Donors</h2>
    <hr>
    <table id="donor-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Amount (€)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Donors will be loaded here -->
        </tbody>
    </table>
    <hr>
    <p id="anonDonations"></p>
</div>
    
    <footer>
        &copy; 2025 Chuck the Beaver. All rights reserved.
    </footer>
</body>
</html>
