<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminPage.css">

    <title>Admin Page</title>

    <script>
        function toggleForm(formId) {
            // Nascondi tutti i form
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });
            // Mostra il form selezionato
            document.getElementById(formId).classList.add('active');
        }
    </script>
</head>

<body>
    <?php
        require_once 'header.php';
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php');
            exit;
        }
    ?>

    <div class="button-area">
        <h2>Administrative area</h2>
        <hr>
        <button onclick="toggleForm('topDonorsForm')">Find top donors</button>
        <button onclick="toggleForm('userDonationsForm')">Donations list per user</button>
        <button onclick="toggleForm('spendMoneyForm')">Invest Money</button>
        <button onclick="toggleForm('setGoalForm')">Set crowdfunding goal</button>
    </div>

    <!-- Form per Cercare i Top N Donatori -->
    <div id="topDonorsForm" class="form-container">
        <h3>Find top donors</h3>
        <form action="adminActions.php" method="POST">
            <label for="topN">Number of donors to find:</label>
            <input type="number" id="topN" name="topN" required>
            <button type="submit" name="action" value="topDonors">Find</button>
        </form>
    </div>

    <!-- Form per Lista Donazioni per Utente -->
    <div id="userDonationsForm" class="form-container">
        <h3>Donations list per user</h3>
        <form action="adminActions.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <button type="submit" name="action" value="userDonations">Search</button>
        </form>
    </div>

    <!-- Form per Spendere N Soldi -->
    <div id="spendMoneyForm" class="form-container">
        <h3>Spend N Money</h3>
        <form action="adminActions.php" method="POST">
            <label for="amount">Amount to Spend:</label>
            <input type="number" id="amount" name="amount" required>
            <button type="submit" name="action" value="spendMoney">Confirm</button>
        </form>
    </div>

    <!-- Form per Impostare l'Obiettivo -->
    <div id="setGoalForm" class="form-container">
        <h3>Set Goal</h3>
        <form action="adminActions.php" method="POST">
            <label for="goal">New Goal:</label>
            <input type="number" id="goal" name="goal" required>
            <button type="submit" name="action" value="setGoal">Set</button>
        </form>
    </div>

</body>
</html>