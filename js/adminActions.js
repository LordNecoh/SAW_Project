document.addEventListener("DOMContentLoaded", () => {
    //    ----    Variabili    ----    //

    //Show Forms
    const topDonorsButton = document.getElementById('topDonorsButton');
    const userDonationsButton = document.getElementById('userDonationsButton');
    const setGoalButton = document.getElementById('setGoalButton');
    const refundMoneyButton = document.getElementById('refundMoneyButton');

    //Close Forms
    const closeTopDonors = document.getElementById('closeTopDonors');
    const closeUserDonations = document.getElementById('closeUserDonations');
    const closeSetGoal = document.getElementById('closeSetGoal');
    const closeRefundMoney = document.getElementById('closeRefundMoney');
    const resultBox = document.getElementById('result-box');
    let closeResultBox;

    //Submit Forms
    const topDonorsForm = document.getElementById('topDonorsForm');
    const userDonationsForm = document.getElementById('userDonationsForm');
    const setGoalForm = document.getElementById('setGoalForm');
    const refundMoneyForm = document.getElementById('refundMoneyForm');


    //    ----    Funzioni    ----    //

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
                if (data.success) {
                    renderResults(data);
                    resultBox.classList.add('active');
                } else {
                    resultBox.innerHTML = `<p style="color: red;">Error: ${data.error}</p>`;
                    resultBox.classList.add('active');
                }
            })
            .catch(error => {
                resultBox.innerHTML = `<p style="color: red;">Unexpected error: ${error.message}</p>`;
                resultBox.classList.add('active');
            });
    }

    function processRefund(donationID) {
        const formData = new FormData();
        formData.append('action', 'singleRefund');
        formData.append('donationID', donationID);

        fetch('database/adminActions.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    //Reload the table
                    renderResults(data);
                } else {
                    resultBox.innerHTML = `<p style="color: red;">Error: ${data.error}</p>`;
                    resultBox.classList.add('active');
                }
            })
            .catch(error => {
                resultBox.innerHTML = `<p style="color: red;">Unexpected error: ${error.message}</p>`;
                resultBox.classList.add('active');
            });
    }

    function renderResults(data) {
        resultBox.innerHTML = '<button id="closeResultBox" class="close-button">&times;</button>';
        
        if (data.donors) {
            // Top Donors Results
            let table = '<table class="styled-table">';
            table += '<thead><tr><th>Username</th><th>Email</th><th>Total Donated</th></tr></thead>';
            table += '<tbody>';
            data.donors.forEach(donor => {
                table += `<tr><td>${donor.username}</td><td>${donor.email}</td><td>${donor.total_donated}</td></tr>`;
            });
            table += '</tbody></table>';
            resultBox.innerHTML += table;

        } else if (data.donations) { // User Donations Results
            if(data.username){
                resultBox.innerHTML += `<h3>Donations for user: ${data.username}</h3>`;
            }
            
            let table = '<table class="styled-table">';
            table += '<thead><tr><th>Donation ID</th><th>Amount</th><th>Date</th><th>Public</th><th>Refund</th></tr></thead>';
            table += '<tbody>';
            data.donations.forEach(donation => {
                table += `<tr>
                            <td>${donation.id}</td>
                            <td>${donation.amount}</td>
                            <td>${donation.donation_date}</td>
                            <td>${donation.public ? 'Yes' : 'No'}</td>
                            <td><button class="refund-button" data-id="${donation.id}">Refund</button></td>
                          </tr>`;
            });
            table += '</tbody></table>';
            resultBox.innerHTML += table;
    
            // Aggiungi il listener ai bottoni "Refund"
            const refundButtons = document.querySelectorAll('.refund-button');
            refundButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const donationId = e.target.getAttribute('data-id');
                    const confirmation = confirm(`Are you sure you want to refund donation ID ${donationId}?`);
                    if (confirmation) {
                        processRefund(donationId);
                    }
                });
            });
        } else if(data.newGoal){
            resultBox.innerHTML += `<p>New goal set: <strong>€${data.newGoal}</strong></p>`;
        }else if(data.totalRefunded){
            resultBox.innerHTML += `<p>Refunded <strong>${data.totalRefunded}€</strong></p>`;
        } else if(data.amountRefunded){
            resultBox.innerHTML += `<p>Refunded <strong>${data.amountRefunded}€</strong></p>`; 
        } else {
            resultBox.innerHTML += '<p>No results found.</p>';
        }

        resultBox.classList.add('active');

        const closeResultBox = document.getElementById('closeResultBox');
        if (closeResultBox) {
            closeResultBox.addEventListener('click', () => {
                resultBox.classList.remove('active');
            });
        }
    }

        //    ----    Event Listeners    ----    //


        // Show Forms

        if (topDonorsButton) {
            topDonorsButton.addEventListener('click', () => {
                toggleForm('topDonorsDiv');
            });
        }
    
        if (userDonationsButton) {
            userDonationsButton.addEventListener('click', () => {
                toggleForm('userDonationsDiv');
            });
        }
    
        if (setGoalButton) {
            setGoalButton.addEventListener('click', () => {
                toggleForm('setGoalDiv');
            });
        }

        if (refundMoneyButton) {
            refundMoneyButton.addEventListener('click', () => {
                toggleForm('refundMoneyDiv');
            });
        }

        // Close Forms

        if (closeTopDonors) {
            closeTopDonors.addEventListener('click', () => {
                document.getElementById('topDonorsDiv').classList.remove('active');
            });
        }

        if (closeUserDonations) {
            closeUserDonations.addEventListener('click', () => {
                document.getElementById('userDonationsDiv').classList.remove('active');
            });
        }

        if (closeSetGoal) {
            closeSetGoal.addEventListener('click', () => {
                document.getElementById('setGoalDiv').classList.remove('active');
            });
        }

        if (closeRefundMoney) {
            closeRefundMoney.addEventListener('click', () => {
                document.getElementById('refundMoneyDiv').classList.remove('active');
            });
        }

        if(closeResultBox){
            closeResultBox.addEventListener('click', () => {
                resultBox.classList.remove('active');
            });
        }
        

        // Submit Forms
    
        if (topDonorsForm) {
            topDonorsForm.addEventListener('submit', (e) => {
                e.preventDefault();
                sendFormData('topDonorsForm', 'getTopDonors');
            });
        }
    
        if (userDonationsForm) {
            userDonationsForm.addEventListener('submit', (e) => {
                e.preventDefault();
                sendFormData('userDonationsForm', 'getUserDonations');
            });
        }
    
        if (setGoalForm) {
            setGoalForm.addEventListener('submit', (e) => {
                e.preventDefault();
                sendFormData('setGoalForm', 'setGoal');
            });
        }

        if (refundMoneyForm) {
            refundMoneyForm.addEventListener('submit', (e) => {
                e.preventDefault();
                var username = document.getElementById('username').value;
                var confirmation = confirm('Are you sure you want to refund ' + username + '?');
                if(confirmation) sendFormData('refundMoneyForm', 'refundMoney');
            });
        }
});