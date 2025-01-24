function fetchDonations(donationAmountElement, donorListContainer) {
    const goal = 1000; // Obiettivo totale delle donazioni (€)
    const donationProgress = document.getElementById("donationProgress");
    const donationGoalElement = document.getElementById("donation-goal");

    // Imposta l'obiettivo nel DOM
    donationGoalElement.textContent = `€${goal}`;

    fetch("database/getDonations.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Aggiorna il totale delle donazioni
                donationAmountElement.textContent = `€${data.total}`;

                // Calcola la percentuale di completamento
                const percentage = Math.min((data.total / goal) * 100, 100);
                donationProgress.style.width = `${percentage}%`;

                // Aggiorna la lista dei donatori
                donorListContainer.innerHTML = "";
                data.donors.forEach((donor) => {
                    const donorElement = document.createElement("li");
                    donorElement.textContent = `${donor.username} - €${donor.amount}`;
                    donorListContainer.appendChild(donorElement);
                });
            } else {
                console.error("Errore nel recuperare i dati delle donazioni:", data.error);
            }
        })
        .catch((error) => {
            console.error("Errore:", error);
        });
}

// Inizializza dopo il caricamento del DOM
document.addEventListener("DOMContentLoaded", () => {
    const donationAmountElement = document.getElementById("donation-amount");
    const donorListContainer = document.getElementById("donor-list");

    fetchDonations(donationAmountElement, donorListContainer);
});
