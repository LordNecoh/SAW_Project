function fetchDonations(donationAmountElement) {
    // Variabili
    const donationProgress = document.getElementById("donationProgress");
    const donationGoalElement = document.getElementById("donation-goal");
    const donorTable = document.getElementById("donor-table");
    const anonParagraph = document.getElementById("anonDonations");

    let goal = 0;

    function loadGoal() {
        return fetch("database/getGoal.php", {
            method: "POST"
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    goal = parseFloat(data.goal); 
                    donationGoalElement.textContent = `€${goal}`; 
                } else {
                    console.error("Errore nel recuperare il goal:", data.error);
                    donationGoalElement.textContent = "Error loading goal";
                }
            })
            .catch((error) => {
                console.error("Errore nel caricamento del goal:", error);
                donationGoalElement.textContent = "Error loading goal";
            });
    }

    function loadDonations() {
        fetch("database/getDonations.php", {
            method: "POST"
        }
        )
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    donationAmountElement.textContent = `€${data.total}`;

                    const percentage = goal > 0 ? Math.min((data.total / goal) * 100, 100) : 0;
                    donationProgress.style.width = `${percentage}%`;

                    donorTable.innerHTML = "";
                    let publicDonations = 0;

                    //Donazioni Pubbliche
                    data.donors.forEach((donor) => {
                        publicDonations += parseFloat(donor.total_donated);

                        const row = document.createElement("tr");
                        const usernameCell = document.createElement("td");
                        usernameCell.textContent = donor.username;

                        const amountCell = document.createElement("td");
                        amountCell.textContent = `€${donor.total_donated}`;

                        row.appendChild(usernameCell);
                        row.appendChild(amountCell);
                        donorTable.appendChild(row);
                    });

                    //Donazioni Anonime
                    const anonAmount = data.total - publicDonations;
                    if (anonAmount > 0) {
                        anonParagraph.innerHTML =
                            `Also thanks to all the anonymous donors who helped us collect 
                            <span class="amount">€${anonAmount}</span>!`;
                    }
                } else {
                    console.error("Errore nel recuperare i dati delle donazioni:", data.error);
                }
            })
            .catch((error) => {
                console.error("Errore nel caricamento delle donazioni:", error);
            });
    }
    loadGoal().then(loadDonations);
}

// Inizializza dopo il caricamento del DOM
document.addEventListener("DOMContentLoaded", () => {
    const donationAmountElement = document.getElementById("donation-amount");
    fetchDonations(donationAmountElement);
});
