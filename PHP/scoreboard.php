<?php
require_once "./tetrisDB.php";

$mode = isset($_POST['mode']) ? $_POST['mode'] : 'highscore';

if ($mode === 'lines') {
    $query = "SELECT username, max_lines FROM lines_completed ORDER BY max_lines DESC LIMIT 5";
    $modeLabel = 'Linee';
} else {
    $query = "SELECT username, highscore FROM highscores ORDER BY highscore DESC LIMIT 5";
    $modeLabel = 'Punteggio';
}

$result = mysqli_query($connection, $query);

if ($result) {
    echo '<h2>Classifica</h2>';
    echo '<table>';
    echo '<thead><tr><th>Giocatore</th><th>' . $modeLabel . '</th></tr></thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_row($result)) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>'; 
        echo '<td>' . $row[1] . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo 'Errore nel recupero dei dati dalla classifica.';
}

mysqli_close($connection);
?>