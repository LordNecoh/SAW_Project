document.addEventListener("DOMContentLoaded", () => {

    //    ----    Variabili    ----    //

    //Popup
    const openDonationPopup = document.getElementById("openDonationBtn");
    const closeDonationPopup = document.getElementById("closeDonationPopup"); 
    const donationPopup = document.getElementById("donationPopup"); 
    const loadingTime = 3000;   // Tempo di caricamento in millisecondi
    const donationSubmit = document.getElementById("donationSubmit");
    const donationMessage = document.getElementById("donationMessage");

    //Form
    const donationForm = document.getElementById("donationForm"); 
    const donationAmountInput = document.getElementById("donationAmount");
    const presetButtons = document.querySelectorAll(".donation-popup-preset"); 

    //   ----    Apertura e chiusura Popup Donazione    ----    //
    if (openDonationPopup) {
        openDonationPopup.addEventListener("click", () => {
            donationPopup.style.display = "flex"; 
        });
    }

    if (closeDonationPopup) {
        closeDonationPopup.addEventListener("click", () => {
            donationPopup.style.display = "none"; 
        });
    }

    //Chiusura Popup Donazione quando si clicca all'esterno
    
    window.addEventListener("click", (e) => {
        if (e.target === donationPopup) {
            donationPopup.style.display = "none"; 
        }
    });

    if (presetButtons) {
        presetButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const value = button.dataset.value; 
                donationAmountInput.value = value; 
            });
        });
    }

    //    ----    Invio Donazione    ----    //

    if (donationForm) {
        donationForm.addEventListener("submit", (e) => {
            e.preventDefault(); 

            const donationAmount = parseFloat(donationAmountInput.value);
            const anonymous = document.getElementById("anonymousToggle").checked;


            if (!donationAmount || donationAmount <= 0) {
                alert("Per favore, inserisci un importo valido.");
                return;
            }

            fetch("database/donation.php", {
                method: "POST",
                body: JSON.stringify({
                    amount: donationAmount,
                    public: !anonymous, 
                }),
                headers: {
                    "Content-Type": "application/json",
                },
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    donationMessage.textContent = "Donazione avvenuta con successo!";
                    donationMessage.className = "message-container success";

                    //Fake loading
                    donationSubmit.disabled = true;
                    setTimeout(() => window.location.href = 'index.php', loadingTime);
                    const loader = document.getElementById('loaderWheel');
                    loader.style.display = 'block';

                    donationForm.reset(); 
                    
                    const donationAmountElement = document.getElementById("donation-amount");

                    fetchDonations(donationAmountElement);
                } else {
                    donationMessage.textContent = `Errore verificatosi nella donazione: ${data.error}`;
                    donationMessage.className = "message-container error";
                }
            })
            .catch((error) => {
                console.error("Errore durante la donazione:", error);
            });
        });
    }
});
