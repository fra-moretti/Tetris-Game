
function aggiornaHighscore(highscore, linee, livello) {
    const parametriURL = `highscore=${highscore}&linee=${linee}&livello=${livello}`;

    fetch('./../PHP/updateDB.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: parametriURL
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore nell\'aggiornamento dell\'highscore');
        }
        return response.text();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.warn('Errore nell\'aggiornamento dell\'highscore:', error);
    });
}

function aggiornaSaldo(ricompensa) {
    const parametriURL = `ricompensa=${ricompensa}`;

    fetch('./../PHP/updateDB.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: parametriURL
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore nell\'aggiornamento del saldo');
        }
        return response.text();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.warn('Errore nell\'aggiornamento del saldo:', error);
    });
}
