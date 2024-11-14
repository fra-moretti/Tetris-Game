document.addEventListener("DOMContentLoaded", function () {
    const registerLink = document.getElementById('register-link');
    const loginLink = document.getElementById('login-link');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    registerLink.addEventListener('click', function (event) {
        event.preventDefault();
        loginForm.classList.add("hidden");
        registerForm.classList.remove("hidden");
    });

    loginLink.addEventListener('click', function (event) {
        event.preventDefault();
        loginForm.classList.remove("hidden");
        registerForm.classList.add("hidden");
    });

    const infoIcon = document.querySelector('.info-icon');
    infoIcon.addEventListener('click', () => {
        console.log('hai cliccato');
    window.location.href = './HTML/info.html';
    });
});