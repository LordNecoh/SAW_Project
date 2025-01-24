const loadingTime = 2000;   // Tempo di caricamento in millisecondi

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);

        fetch('database/registration.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const errorMessage = document.getElementById('errorMessage');
            if (data.error) {
                errorMessage.textContent = data.error;
                errorMessage.style.color = 'red';
            } else if (data.success) {
                errorMessage.textContent = data.success;
                errorMessage.style.color = 'green';

                //Fake loading
                const submitButton = registrationForm.querySelector("input[type='submit']");
                submitButton.disabled = true;
                setTimeout(() => window.location.href = 'index.php', loadingTime); 
                const loader = document.getElementById('loaderWheel');
                loader.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Errore durante la registrazione:', error);
        });

    });
});