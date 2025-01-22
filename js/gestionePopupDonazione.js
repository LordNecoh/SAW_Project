document.addEventListener("DOMContentLoaded", () => {

    //    ----    Variabili    ----    //

    const openDonationPopup = document.getElementById("openDonationBtn");
    const closeDonationPopup = document.getElementById("closeDonationPopup");
    const donationPopup = document.getElementById("donationPopup");

    //   ----    Popup Donazione    ----    //
    if (openDonationPopup) {
        openDonationPopup.addEventListener("click", () => {
            donationPopup.style.display = "flex"; // Mostra il popup
        });
    }

    if (closeDonationPopup) {
        closeDonationPopup.addEventListener("click", () => {
            donationPopup.style.display = "none"; // Nascondi il popup
        });
    }

    //Chiusura Popup Donazione quando si clicca all'esterno
    window.addEventListener("click", (e) => {
        if (e.target === donationPopup) {
            donationPopup.style.display = "none"; // Nascondi il popup se cliccato fuori
        }
    });

    //    ----    Donazione    ----    //

    const donateBtn = document.getElementById("donateBtn");
    if (donateBtn) {
        donateBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const donationAmount = document.getElementById("donationAmount").value;

            if (donationAmount <= 0) {
                alert("Per favore, inserisci un importo valido.");
                return;
            }

            //Logica donazione
            fetch("database/donate.php", {
                method: "POST",
                body: JSON.stringify({ amount: donationAmount }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Donazione effettuata con successo!");
                    donationPopup.style.display = "none";
                } else {
                    alert("Errore durante la donazione.");
                }
            })
            .catch((error) => {
                console.error("Errore durante la donazione:", error);
            });
        });
    }

});
