const loadingTime = 2000;   // Tempo di caricamento in millisecondi

document.addEventListener("DOMContentLoaded", () => {
    const errorMessage = document.getElementById('errorMessage');

    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);

        if (/^\s|\s$/.test(formData.get('password'))) { //È improbabile che l'utente abbia intenzionalmente inserito spazi bianchi all'inizio o alla fine della password
            if(!confirm("Password contains balnk spaces. Is it intentional?")) {
                formData.set('password', formData.get('password').trim());
            }
        }

        fetch('database/registration.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                errorMessage.textContent = data.error;
                errorMessage.className = "error-message error";
            } else if (data.success) {
                errorMessage.textContent = data.success;
                errorMessage.className = "error-message success";

                //Fake loading
                const loader = document.getElementById('loaderWheel');
                loader.style.display = 'block';
                const submitButton = registrationForm.querySelector("input[type='submit']");
                submitButton.disabled = true;
                setTimeout(() => window.location.href = 'index.php', loadingTime); 
                
            }
        })
        .catch(error => {
            console.error('Errore durante la registrazione:', error);
        });

    });
});