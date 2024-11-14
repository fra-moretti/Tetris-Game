<?php

session_start();

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    if (isset($_POST["ricompensa"])) {
        $ricompensa = $_POST["ricompensa"];
    
        require_once "./tetrisDB.php";
        aggiornaSaldo($connection, $username, $ricompensa);
        return;
    }

    if (isset($_POST["highscore"]) && isset($_POST["linee"]) && isset($_POST["livello"])) {
        $highscore = $_POST["highscore"];
        $linee = $_POST["linee"];
        $livello = $_POST["livello"];
    
        require_once "./tetrisDB.php";
        aggiornaHighscore($connection, $username, $highscore, $linee, $livello);
        aggiornaLinee($connection, $username, $linee);
        return;
    }

    
}

function aggiornaHighscore($connection, $username, $highscore, $linee, $livello) {
    $sql = "UPDATE highscores
            SET highscore = ?, linee = ?, livello = ?
            WHERE username = ?
            AND highscore <= ?";
    
    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, 'iiisi', $highscore, $linee, $livello, $username, $highscore);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) > 0) {
        echo "Highscore aggiornato con successo per l'utente: $username";
    } else {
        echo "Nessun highscore aggiornato per l'utente: $username";
    }

    mysqli_stmt_close($statement);
}

function aggiornaLinee($connection, $username, $completedRows) {
    $sql = "UPDATE lines_completed
            SET max_lines = ?
            WHERE username = ? AND ? > max_lines";

    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, 'isi', $completedRows, $username, $completedRows);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) > 0) {
        echo "Righe completate aggiornate con successo per l'utente: $username";
    } else {
        echo "Nessuna riga completata aggiornata per l'utente: $username";
    }

    mysqli_stmt_close($statement);
    mysqli_close($connection);
}

function aggiornaSaldo($connection, $username, $ricompensa) {
    $sql = "UPDATE cash
            SET saldo = saldo + ?
            WHERE username = ?";
    
    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, 'is', $ricompensa, $username);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) > 0) {
        echo "Saldo aggiornato con successo per l'utente: $username";
    } else {
        echo "Nessun saldo aggiornato per l'utente: $username";
    }

    mysqli_stmt_close($statement);
    mysqli_close($connection);
}

