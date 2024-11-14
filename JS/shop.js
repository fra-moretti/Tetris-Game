document.addEventListener("DOMContentLoaded", function () {
    const backButton = document.getElementById("back-to-home");
    if (backButton) {
        backButton.addEventListener("click", function () {
            window.location.href = "home.php";
        });
    }    
});