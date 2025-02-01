<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminPage.css">

    <title>Admin Page</title>

    <script src="js/adminActions.js" defer></script>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <libnk rel="stylesheet" href="css/footer.css">


</head>

<body>
    <?php
        require_once 'header.php';
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php');
            exit;
        }
    ?>

    <div class="admin-picture">
        <img src="images/Security_Beaver_Profile.png" alt="Security Beaver" title="Security Beaver">
    </div>

    <div class="button-area">
        <h2>Administrative area</h2>
        <hr>
        <button id="topDonorsButton" >Find top donors</button>
        <button id="userDonationsButton" >Donations list per user</button>
        <button id="refundMoneyButton" >Refund user</button>
        <button id="setGoalButton" >Set crowdfunding goal</button>
    </div>

    <div id="result-box" class="result-box"></div>

    <!-- Form per Cercare i Top N Donatori -->
    <div id="topDonorsDiv" class="form-container">
        <button class='close-button' id='closeTopDonors'>&times;</button>
        <h3>Find top donors</h3>
        <form id="topDonorsForm">
            <label for="topN">Number of donors to find:</label>
            <input type="number" id="topN" name="topN" required>
            <button type="submit" >Find</button>
        </form>
    </div>


    <!-- Form per Lista Donazioni per Utente -->
    <div id="userDonationsDiv" class="form-container">
        <button class='close-button' id='closeUserDonations'>&times;</button>
        <h3>Donations list per user</h3>
        <form id="userDonationsForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <button type="submit" >Search</button>
        </form>
    </div>


    <!-- Form per Spendere N Soldi -->
    <div id="refundMoneyDiv" class="form-container">
        <button class='close-button' id='closeRefundMoney'>&times;</button>
        <h3>Refund users</h3>
        <form id="refundMoneyForm">
            <label for="refundUsername">User to refund:</label>
            <input type="text" id="refundUsername" name="refundUsername" required>
            <button type="submit" >Confirm</button>
        </form>
    </div>


    <!-- Form per Impostare l'Obiettivo -->
    <div id="setGoalDiv" class="form-container">
        <button class='close-button' id='closeSetGoal'>&times;</button>
        <h3>Set Goal</h3>
        <form id="setGoalForm">
            <label for="goal">New Goal:</label>
            <input type="number" id="goal" name="goal" required>
            <button type="submit">Set</button>
        </form>
    </div>

    <?php require 'footer.php'; ?>
</body>
</html>