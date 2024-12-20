document.addEventListener("DOMContentLoaded", () => {
    const openLoginPopup = document.getElementById("openLoginBtn");
    const closeLoginPopup = document.getElementById("closeLoginPopup");
    const loginPopup = document.getElementById("loginPopup");
    const logoutBtn = document.getElementById("logoutBtn");
    const openProfileBtn = document.getElementById("openProfileBtn");
    const closeProfilePopup = document.getElementById("closeProfilePopup");

    const profilePopup = document.getElementById("show_profile");
     
    if (openLoginPopup) {
        openLoginPopup.addEventListener("click", () => {
            loginPopup.style.display = "flex";
        });
    } else {
        console.error("Element 'openLoginBtn' not found.");
    }

    if (closeLoginPopup) {
        closeLoginPopup.addEventListener("click", () => {
            loginPopup.style.display = "none";
        });
    } else {
        console.error("Element 'closeLoginPopup' not found.");
    }

    window.addEventListener("click", (e) => {
        if (e.target === loginPopup) {
            loginPopup.style.display = "none";
        }
    });
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
        
            fetch('logout.php', {
                method: 'POST'
            })
                .then(() => {
                    window.location.href="index.php";
                })
                .catch(error => {
                    console.error('Error during logout:', error);
                });
        });
    }

    if(openProfileBtn){
        openProfileBtn.addEventListener("click", () => {
            profileBtn.style.display = "flex";
        });
    }

    if(closeProfilePopup){
        closeProfilePopup.addEventListener("click", () => {
            profilePopup.style.display = "none";
        });
    }
});