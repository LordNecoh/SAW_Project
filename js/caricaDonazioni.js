function fetchDonations(donationAmountElement) {
    
    //   ---    Variaili  ---    //

    //Obbiettivo
    const goal = 1000; // Obiettivo totale delle donazioni (€)
    const donationProgress = document.getElementById("donationProgress");
    const donationGoalElement = document.getElementById("donation-goal");

    //Donatori
    const donorTable = document.getElementById("donor-table");
    const donorsSection = document.getElementById("donors-section");
    const anonParagraph = document.getElementById("anonDonations");

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
                donorTable.innerHTML = "";

                let publicDonations = 0;


                //Aggiunta Donazioni Pubbliche
                data.donors.forEach((donor) => {

                    //Calcolo donazioni non anonime
                    publicDonations += parseFloat(donor.amount);

                    //Aggiunta riga
                    const row = document.createElement("tr");

                    const usernameCell = document.createElement("td");
                    usernameCell.textContent = donor.username;

                    const amountCell = document.createElement("td");
                    amountCell.textContent = `€${donor.amount}`;

                    row.appendChild(usernameCell);
                    row.appendChild(amountCell);

                    donorTable.appendChild(row);
                });

                //Aggiunta Donazioni Anonime
                anonAmount = data.total - publicDonations;

                if (anonAmount > 0) {
                    anonParagraph.innerHTML = 
                    `Also thanks to all the anonymous donors who helped us collect 
                    <span class="amount">€${anonAmount}</span>!`;
                }


                //Vecchio sistema: elenco puntato
                // data.donors.forEach((donor) => {
                //     const donorElement = document.createElement("li");
                //     donorElement.textContent = `${donor.username} - €${donor.amount}`;
                //     donorTable.appendChild(donorElement);
                // });
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

    fetchDonations(donationAmountElement);
});
