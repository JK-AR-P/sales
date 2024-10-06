const preloaderCover = document.querySelector(".preloader-cover");

function showPreloader() {
    preloaderCover.style.display = "flex";
}

function hidePreloader() {
    preloaderCover.style.opacity = 0;
    setTimeout(() => {
        preloaderCover.style.display = "none";
    }, 1000);
}

window.addEventListener("load", () => {
    setTimeout(() => {
        hidePreloader();
    }, 100); // Replace 2000 with your desired loading time
});
