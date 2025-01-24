document.addEventListener("DOMContentLoaded", () => {
    
    //    ----    Variabili    ----    //
    const openLoginPopup = document.getElementById("openLoginBtn");
    const logToReg = document.getElementById("logToReg");
    const closeLoginPopup = document.getElementById("closeLoginPopup");
    const loginPopup = document.getElementById("loginPopup");
    const loginForm = loginPopup ? loginPopup.querySelector("form") : null; // Form di login
    const errorElement = loginPopup ? document.createElement("div") : null;


    //    ----    Apertura/Chiusura Popup    ----    //
    if (openLoginPopup) {
        openLoginPopup.addEventListener("click", () => {
            loginPopup.style.display = "flex";
        });
    }

    if (logToReg) {
        logToReg.addEventListener("click", () => {
            loginPopup.style.display = "flex";
        });
    }


    if (closeLoginPopup) {
        closeLoginPopup.addEventListener("click", () => {
            loginPopup.style.display = "none";
        });
    }

    window.addEventListener("click", (e) => {
        if (e.target === loginPopup) {
            loginPopup.style.display = "none";
        }
    });

    if (errorElement) {
        errorElement.id = "erroreLogin";
        errorElement.className = "error-message";
        if (loginForm) loginForm.appendChild(errorElement);
    }
    
    //    ----    Login    ----    //
    if (loginForm) {
        const registrationLink = loginForm.querySelector("span"); 
        if (registrationLink && errorElement) {
            errorElement.className = "error-message"; 
            loginForm.insertBefore(errorElement, registrationLink); 
        }
    
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
    
            const formData = new FormData(loginForm);
            errorElement.innerText = ""; 
    
            try {
                const response = await fetch(loginForm.action, {
                    method: "POST",
                    body: formData,
                });
    
                const result = await response.json();
    
                if (!result.success) {
                    errorElement.innerText = result.message; 
                } else {
                    window.location.href = "index.php"; 
                }
            } catch (error) {
                console.error("Errore durante il login:", error);
                errorElement.innerText = "Si è verificato un errore. Riprova più tardi.";
            }
        });
    }
    

    //    ----    Logout    ----    //
    const logoutBtn = document.getElementById("logoutBtn");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", (e) => {
            e.preventDefault();
            fetch("database/logout.php", {
                method: "POST",
            })
                .then(() => {
                    window.location.href = "index.php";
                })
                .catch((error) => {
                    console.error("Error during logout:", error);
                });
        });
    }

    //    ----    Profilo    ----    //
    const openProfileBtn = document.getElementById("openProfileBtn");
    const closeProfilePopup = document.getElementById("closeProfilePopup");
    const profilePopup = document.getElementById("profilePopup");

    if (openProfileBtn) {
        openProfileBtn.addEventListener("click", () => {
            profilePopup.style.display = "flex";
        });
    }

    if (closeProfilePopup) {
        closeProfilePopup.addEventListener("click", () => {
            profilePopup.style.display = "none";
        });
    }

    window.addEventListener("click", (e) => {
        if (e.target === profilePopup) {
            profilePopup.style.display = "none";
        }
    });

    //    ----    Modifica Profilo    ----    //
    const editProfileButton = document.getElementById("editProfileButton");

    if (editProfileButton) {
        editProfileButton.addEventListener("click", () => {
            window.location.href = "formModifica.php";
        });
    }
});
