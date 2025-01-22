<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuck the Beaver</title>
    <script src="js/gestionePopup.js"></script>
    <script src="js/gestionePopupDonazione.js"></script>

    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/donazionePopup.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }


        h1 {
            text-align: center;
            color: #007bff;
            margin: 30px 0;
            font-size: 36px;
        }

        .content-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
            padding: 15px;
        }

        .baseText {
            flex: 1 1 50%;
            line-height: 1.8;
            font-size: 18px;
            background: none;
            padding: 15px;
            border-left: 5px solid #007bff;
            border-radius: 5px;
            color: #333;
        }

        .centeredImage {
            flex: 1 1 40%;
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .donation-bar {
            text-align: center;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border: 2px solid #007bff;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .donation-bar h2 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .donation-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin: 15px 0;
        }

        .donation-progress {
            width: 50%;
            background-color: #4caf50;
            height: 25px;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .donation-details {
            font-size: 18px;
            margin: 10px 0;
        }

        .donation-bar button {
            background-color: #ffcc00;
            color: #333;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .donation-bar button:hover {
            background-color: #e6b800;
        }

        footer {
            background-color: #0056b3;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            margin-top: 5px;
            font-size: 16px;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        }

        
    </style>
</head>
<body>
    <?php require "header.php"?>
    <?php include('donazionePopup.php'); ?>

    <h1> Welcome to Chuck the Beaver's very unofficial website! </h1>

    <div class="content-container">
        <div class="baseText" id="about">
            <p>Chuck the Beaver is a very exciting tower defense game created for the GMTK GameJam 2024.</p>
            <p>The theme for this year's jam is "built to scale," and Chuck the Beaver embodies this concept perfectly.</p>
            <p>Players must strategically place and upgrade their defenses to protect their territory from waves of enemies.</p>
            <p>As the game progresses, the challenges scale up, requiring players to adapt and enhance their strategies to succeed.</p>
            <p>Join Chuck the Beaver in this thrilling adventure and see if you have what it takes to defend your Dam!</p>
        </div>

        <img src="images/gameImage.png" alt="Chuck the Beaver" class="centeredImage">
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

    <div class="donation-bar" id="support">
        <h2>Support Chuck the Beaver!</h2>
        <div class="donation-container">
            <div class="donation-progress"></div>
        </div>
        <p class="donation-details">Collected: <span id="donation-amount">$5,000</span> / Goal: <span id="donation-goal">$10,000</span></p>
        <button id="openDonationBtn">Donate Now</button>
    </div>

    <footer>
        &copy; 2024 Chuck the Beaver. All rights reserved.
    </footer>
</body>
</html>
