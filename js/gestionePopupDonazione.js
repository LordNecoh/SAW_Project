document.addEventListener("DOMContentLoaded", () => {

    //    ----    Variabili    ----    //

    //Popup
    const openDonationPopup = document.getElementById("openDonationBtn");
    const closeDonationPopup = document.getElementById("closeDonationPopup"); 
    const donationPopup = document.getElementById("donationPopup"); 

    //Form
    const donationForm = document.getElementById("donationForm"); 
    const donationAmountInput = document.getElementById("donationAmount"); 
    const anonymousToggle = document.getElementById("anonymousToggle"); 
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
            const anonymous = anonymousToggle.checked;

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
                    alert("Donazione registrata con successo!");
                    donationForm.reset(); 
                    donationPopup.style.display = "none"; 
                    
                    const donationAmountElement = document.getElementById("donation-amount");

                    fetchDonations(donationAmountElement);
                } else {
                    alert("Errore: " + data.error);
                }
            })
            .catch((error) => {
                console.error("Errore durante la donazione:", error);
                alert("Si è verificato un errore. Riprova più tardi.");
            });
        });
    }
});
