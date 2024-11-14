document.addEventListener('DOMContentLoaded', () => {

    function updateScoreboard(isHighscore) {
        const mode = isHighscore ? 'highscore' : 'lines';
        fetchScoreboard(mode);
    }

    function fetchScoreboard(mode) {
        fetch(`./../PHP/home.php?mode=${mode}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.scoreboard').innerHTML = data;
        })
        .catch(error => {
            console.error('Errore durante il recupero della classifica:', error);
        });
    }

    updateScoreboard(isHighscoreMode); 
});