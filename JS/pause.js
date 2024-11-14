document.addEventListener('DOMContentLoaded', function() {
    const homeButton = document.getElementById('home-button');
    const homeButton2 = document.getElementById('home-button-2');
    const confirmationModal = document.getElementById('confirmation-modal');
    const confirmButton = document.getElementById('confirm-button');
    const cancelButton = document.getElementById('cancel-button');

    homeButton.addEventListener('click', () => {
        confirmationModal.classList.add('show-modal'); 
    });

    homeButton2.addEventListener('click', () => {
        window.location.href = './home.php';
    });

    confirmButton.addEventListener('click', () => {
        window.location.href = './home.php';
    });

    cancelButton.addEventListener('click', () => {
        confirmationModal.classList.remove('show-modal');
    });

});
