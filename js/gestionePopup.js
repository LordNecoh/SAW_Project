document.addEventListener("DOMContentLoaded", () => {
    const openLoginPopup = document.getElementById("openLoginBtn");
    const closeLoginPopup = document.getElementById("closeLoginPopup");
    const loginPopup = document.getElementById("loginPopup");

    const logoutBtn = document.getElementById("logoutBtn");

    const openProfileBtn = document.getElementById("openProfileBtn"); 
    const closeProfilePopup = document.getElementById("closeProfilePopup");
    const profilePopup = document.getElementById("profilePopup");

    // Login popup
    if (openLoginPopup) {
        openLoginPopup.addEventListener("click", () => {
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

    // Logout
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

    // Profile popup
    if (openProfileBtn) {
        openProfileBtn.addEventListener("click", () => {
            profilePopup.style.display = "flex"; // Mostra il popup
        });
    }

    if (closeProfilePopup) {
        closeProfilePopup.addEventListener("click", () => {
            profilePopup.style.display = "none"; // Chiudi il popup
        });
    }

    // Chiudi il popup cliccando fuori dal contenuto
    window.addEventListener("click", (e) => {
        if (e.target === profilePopup) {
            profilePopup.style.display = "none";
        }
    });

    if(document.getElementById('editProfileButton')){
        document.getElementById('editProfileButton').addEventListener('click', function() {
            window.location.href = 'formModifica.php';
        });
    }
        
    
   
});