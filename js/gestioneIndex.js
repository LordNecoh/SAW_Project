document.addEventListener("DOMContentLoaded", function () {

    //    ----   Video   ----   //

    const video = document.getElementById("video");
    const playBtn = document.getElementById("playBtn");
    const pauseBtn = document.getElementById("pauseBtn");
    const muteBtn = document.getElementById("muteBtn");
    const unmuteBtn = document.getElementById("unmuteBtn");

    playBtn.addEventListener("click", function () {
        video.play();
    });

    pauseBtn.addEventListener("click", function () {
        video.pause();
    });

    muteBtn.addEventListener("click", function () {
        video.muted = true;
    });

    unmuteBtn.addEventListener("click", function () {
        video.muted = false;
    });

    //    ----   Timer   ----   //

    const deadline = new Date("2026-01-01T00:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = deadline - now;

        if (timeLeft <= 0) {
            document.getElementById("countdown-timer").innerText = "Campaign Ended!";
            return;
        }

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        document.getElementById("countdown-timer").innerText = 
            `Time left: ${days}d ${hours}h ${minutes}m ${seconds}s`;
    }

    updateCountdown(); // Mostra il timer subito
    setInterval(updateCountdown, 1000); // Aggiorna il timer ogni secondo
});
