document.addEventListener("DOMContentLoaded", function () {

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


});
