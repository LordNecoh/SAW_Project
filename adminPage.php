<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminPage.css">

    <title>Admin Page</title>

    <script>
        function toggleForm(formId) {
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(formId).classList.add('active');
        }

        function sendFormData(formId, action) {
            const form = document.getElementById(formId); 
            if (!form) {
                console.error(`Form with ID "${formId}" not found.`);
                return;
            }
            const formData = new FormData(form);
            formData.append('action', action);

            fetch('database/adminActions.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    const resultBox = document.getElementById('result-box');
                    if (data.success) {
                        resultBox.innerHTML = renderResults(data);
                        resultBox.classList.add('active');
                    } else {
                        resultBox.innerHTML = `<p style="color: red;">Error: ${data.error}</p>`;
                        resultBox.classList.add('active');
                    }
                })
                .catch(error => {
                    const resultBox = document.getElementById('result-box');
                    resultBox.innerHTML = `<p style="color: red;">Unexpected error: ${error.message}</p>`;
                    resultBox.classList.add('active');
                });
        }

        function renderResults(data) {
            let html = '<h3>Query Results:</h3>';
            if (data.donors) {
                html += '<ul>';
                data.donors.forEach(donor => {
                    html += `<li>${donor.username}: ${donor.total_donated}</li>`;
                });
                html += '</ul>';
            } else if (data.donations) {
                html += '<ul>';
                data.donations.forEach(donation => {
                    html += `<li>${donation.amount}€ - ${donation.date}</li>`;
                });
                html += '</ul>';
            } else {
                html += '<p>No data available.</p>';
            }
            return html;
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
        <button onclick="toggleForm('topDonorsDiv')">Find top donors</button>
        <button onclick="toggleForm('userDonationsDiv')">Donations list per user</button>
        <button onclick="toggleForm('spendMoneyDiv')">Invest Money</button>
        <button onclick="toggleForm('setGoalDiv')">Set crowdfunding goal</button>
    </div>

    <div id="result-box" class="result-box"></div>

    <!-- Form per Cercare i Top N Donatori -->
    <div id="topDonorsDiv" class="form-container">
        <h3>Find top donors</h3>
        <form id="topDonorsForm">
            <label for="topN">Number of donors to find:</label>
            <input type="number" id="topN" name="topN" required>
            <button type="button" onclick="sendFormData('topDonorsForm', 'topDonors')">Find</button>
        </form>
    </div>


    <!-- Form per Lista Donazioni per Utente -->
    <div id="userDonationsDiv" class="form-container">
        <h3>Donations list per user</h3>
        <form id="userDonationsForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <button type="button" onclick="sendFormData('userDonationsForm', 'userDonations')">Search</button>
        </form>
    </div>


    <!-- Form per Spendere N Soldi -->
    <div id="spendMoneyDiv" class="form-container">
        <h3>Invest Money!</h3>
        <form id="spendMoneyForm">
            <label for="amount">Amount to Spend:</label>
            <input type="number" id="amount" name="amount" required>
            <button type="button" onclick="sendFormData('spendMoneyForm', 'spendMoney')">Confirm</button>
        </form>
    </div>


    <!-- Form per Impostare l'Obiettivo -->
    <div id="setGoalDiv" class="form-container">
        <h3>Set Goal</h3>
        <form id="setGoalForm">
            <label for="goal">New Goal:</label>
            <input type="number" id="goal" name="goal" required>
            <button type="button" onclick="sendFormData('setGoalForm', 'setGoal')">Set</button>
        </form>
    </div>


</body>
</html>