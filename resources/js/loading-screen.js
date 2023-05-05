window.addEventListener("DOMContentLoaded", () => {
    document.getElementById("loading-screen").style.display = "none";
});
window.addEventListener("beforeunload", () => {
    document.getElementById("loading-screen").style.display = null;
});
