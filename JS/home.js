document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.getElementById('logout-button');
    logoutButton.addEventListener('click', () => {
        fetch('./../PHP/logout.php', {
            method: 'POST',
        })
            .then(response => response.json())
            .then(data => {
                if (data.logged_out) {
                    window.location.href = './../index.php';
                }
            })
            .catch(error => console.error('Errore durante il logout:', error));
    });

    const newGameButton = document.getElementById('play-button');
    newGameButton.addEventListener('click', () => {
        window.location.href = './tetris.php';
    });

    const scoreboardButton = document.getElementById('scoreboard-button');
    scoreboardButton.addEventListener('click', () => {
        toggleScoreboardMode();
        toggleButtonText();
    });

    let isHighscoreMode = true;

    loadInitialScoreboard();

    function loadInitialScoreboard() {
        updateScoreboard(isHighscoreMode);
    }


    function toggleScoreboardMode() {
        isHighscoreMode = !isHighscoreMode;
        updateScoreboard(isHighscoreMode);
    }

    function toggleButtonText() {
        const buttonText = scoreboardButton.textContent.trim();
        scoreboardButton.textContent = buttonText === 'Punteggio' ? 'Linee' : 'Punteggio';
    }

    function updateScoreboard(isHighscore) {
        const mode = isHighscore ? 'highscore' : 'lines';
        fetch('./../PHP/scoreboard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `mode=${mode}`,
        })
            .then(response => response.text())
            .then(data => {
                document.querySelector('.scoreboard').innerHTML = data;
            })
            .catch(error => {
                console.error('Errore durante il recupero della classifica:', error);
            });
    }

    const shopButton = document.getElementById("shop-button");
    if (shopButton) {
        shopButton.addEventListener("click", function () {
            window.location.href = "shop.php";
        });
    }
    const helpButton = document.getElementById('help-button');
    const howToPlayScreen = document.getElementById('how-to-play-screen');

    helpButton.addEventListener('click', () => {
        howToPlayScreen.style.display = 'block';
    });
    const backButton = document.getElementById("back-button");
    backButton.addEventListener('click', () => {
        howToPlayScreen.style.display = 'none';
    });
});

