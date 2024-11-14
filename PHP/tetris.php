
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tetris Game</title>
  <link rel="icon" type="image/png" href="./../images/tetris.png">
  <link rel="stylesheet" href="./../CSS/tetris.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">

  <?php
    include "./DBfunctions.php";
    include "./tetrisDB.php";
    include "./updateDB.php";   
    include "./footer.php";


    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
        
        if (isset($connection)) {
            $highscore = getHighscore($connection, $username);
        } else {
            echo "Errore di connessione al database.";
            $highscore = 0;
        }
    }else{
      header("Location: ./../index.php");
        exit();
    }
    
?>

  <script src="./../JS/tetris.js"></script>
  <script src="./../JS/pause.js"></script>
  <script src="./../JS/updateDB.js"></script>
  <style>
    <?php
        $colors = getColors($user_id);
        echo ".cell {
          /* Altri stili */
          background-color: " . $colors['cell_color'] . ";
      }";

      echo ".cell.block {
          /* Altri stili per i blocchi */
          background-color: " . $colors['block_color'] . ";
      }";
    ?>
</style>
</head>

<body>

  <div class="game-container">
    <div class="game-grid-column">
      <div class="grid" id="grid"></div>
    </div>

    <div class="right-column">
      <img src="./../images/logotetris.png" alt="Tetris Logo" class="tetris-logo">
      <button id="pause-button" class="buttons"><i class="fas fa-pause"></i></button>
      
      <div class="highscorez">Highscore: <span id="highscorez"><?php echo $highscore; ?></span></div>
      <div class="score">Punteggio: <span id="score">0</span></div>
      <div class="lines">Linee: <span id="lines">0</span></div>
      <div class="level">Livello: <span id="level">1</span></div>
      <div class="next-piece">
        <div class="title">Prossimo Pezzo</div>
        <div id="next-piece-grid" class="next-piece-grid"></div>
      </div>
    </div>
  </div>
  <div id="pause-screen">
    <div class="pause-content">
      <button id="resume-button" class="buttons"><i class="fas fa-play"></i></button><button id="how-to-play-button" class="buttons"><i
          class="fas fa-question"></i></button><button id="home-button" class="buttons"><i class="fas fa-home"></i></button>
    </div>
    <div id="confirmation-modal" class="modal">
      <div class="modal-content">
        <h2>Termina partita?</h2>
        <p>La partita non sarà salvata.</p>
        <div class="modal-buttons">
          <button id="confirm-button">Accetta</button>
          <button id="cancel-button">Annulla</button>
        </div>
      </div>
    </div>
  </div> 
  <div id="game-over-screen">
    <div class="game-over-content">
    <h2>Game Over</h2>
    <p id="game-over-score">Punteggio: <span id="score-value"></span></p>
    <p id="game-over-lines">Linee: <span id="lines-value"></span></p>
    <button id="restart-button" class="buttons">
      <i class="fas fa-redo"></i></button><button id="home-button-2" class="buttons">
      <i class="fas fa-home"></i></button>
  </div>
  </div>
  <?php include "./howtoplay.php" ?>

</body>

</html>