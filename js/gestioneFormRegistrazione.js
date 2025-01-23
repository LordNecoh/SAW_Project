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
                setTimeout(() => window.location.href = 'index.php', 2000); 
            }
        })
        .catch(error => {
            console.error('Errore durante la registrazione:', error);
        });
        document.addEventListener("DOMContentLoaded", () => {
            const registrationForm = document.getElementById("registrationForm");
            const loadingSpinner = document.getElementById("loadingSpinner");
        
            registrationForm.addEventListener("submit", function(event) {
                loadingSpinner.style.display = "block";
        
                const submitButton = registrationForm.querySelector("input[type='submit']");
                submitButton.disabled = true;
        
                setTimeout(() => {
                    loadingSpinner.style.display = "none";
                    submitButton.disabled = false;
                }, 2000); 
            });
        });

    });
});