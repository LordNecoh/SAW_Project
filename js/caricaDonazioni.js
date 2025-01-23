//uso parametri cosi non devo caricare prima il dom di definire la funzione
function fetchDonations(donationAmountElement, donorListContainer) {
    fetch("database/getDonations.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                donationAmountElement.textContent = `€${data.total}`;

                donorListContainer.innerHTML = ""; 
                data.donors.forEach((donor) => {
                    const donorElement = document.createElement("li");
                    donorElement.textContent = `${donor.email} - €${donor.amount}`;
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

document.addEventListener("DOMContentLoaded", () => {
    const donationAmountElement = document.getElementById("donation-amount");
    const donorListContainer = document.getElementById("donor-list");

    fetchDonations(donationAmountElement, donorListContainer);
});
