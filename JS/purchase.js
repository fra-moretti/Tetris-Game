function purchaseStyle(style) {
        fetch('purchase.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `style=${style}`
        })
        .then(response => {
            return response.text();
        })
        .then(data => {
            console.log('Risposta dal server:', data);

            if (data.includes("Acquisto effettuato")) {
                const buttonElement = document.getElementById(`${style}Button`);
                console.log(buttonElement);
            }

            window.location.reload();
            
            
        })
        .catch(error => {
            console.error('Si è verificato un errore:', error);
            alert('Si è verificato un errore durante la richiesta.');
        });
    }
