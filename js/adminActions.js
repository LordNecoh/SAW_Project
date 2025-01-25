document.addEventListener("DOMContentLoaded", () => {
    //    ----    Variabili    ----    //

    //Show Forms
    const topDonorsButton = document.getElementById('topDonorsButton');
    const userDonationsButton = document.getElementById('userDonationsButton');
    const setGoalButton = document.getElementById('setGoalButton');

    //Submit forms
    const topDonorsForm = document.getElementById('topDonorsForm');
    const userDonationsForm = document.getElementById('userDonationsForm');
    const setGoalForm = document.getElementById('setGoalForm');


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
        if (data.donors) {
            // Top Donors Results
            let table = '<table class="styled-table">';
            table += '<thead><tr><th>Username</th><th>Email</th><th>Total Donated</th></tr></thead>';
            table += '<tbody>';
            data.donors.forEach(donor => {
                table += `<tr><td>${donor.username}</td><td>${donor.email}</td><td>${donor.total_donated}</td></tr>`;
            });
            table += '</tbody></table>';
            return table;
        } else if (data.donations) {
            // User Donations Results
            let table = '<table class="styled-table">';
            table += '<thead><tr><th>Donation ID</th><th>Amount</th><th>Date</th><th>Public</th></tr></thead>';
            table += '<tbody>';
            data.donations.forEach(donation => {
                table += `<tr><td>${donation.id}</td><td>${donation.amount}</td><td>${donation.donation_date}</td><td>${donation.public ? 'Yes' : 'No'}</td></tr>`;
            });
            table += '</tbody></table>';
            return table;
        } else if(data.newGoal){
            return `<p>New goal set: <strong>€${data.newGoal}</strong></p>`;
        } else {
            return '<p>No results found.</p>';
        }
    }

        //    ----    Event Listeners    ----    //
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
});