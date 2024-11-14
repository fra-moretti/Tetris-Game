<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tetris Home</title>
  <link rel="stylesheet" href="./../CSS/tetris.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
  <link rel="icon" type="image/png" href="./../images/tetris.png">
  <script src="./../JS/home.js"></script>
</head>
<body>
    <div class="header">
        <div class="user-info">
            <div class="user-box">
                <i class="fas fa-user"></i>
                <span class="username">
                    <?php 
                    session_start();
                    if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    } else {
                      header("Location: ./../index.php");
                      exit();
                    }
                ?>
            </span>
            </div>
        </div>
    </div>
  <div class="home-container">
    <div class="logo">
        <img id="tetris" src="./../images/logotetris.png" alt="tetris">
    </div>

    <button id="play-button" class="buttons">Nuova Partita</button>
    <button id="scoreboard-button" class="buttons">Punteggio</button>

   <div class="scoreboard">
   
</div>

    <!-- Pulsanti ? Shop Logout -->
    <div class="actions">
      <button id="help-button" class="buttons"><i class="fas fa-question"></i></button>
      <button id="shop-button" class="buttons"><i class="fas fa-shopping-cart"></i></button>
      <button id="logout-button" class="buttons"><i class="fas fa-sign-out-alt"></i></button>
    </div>
    <?php include "./howtoplay.php" ?>
    
  </div>
  <?php    
            include "./footer.php";
        ?>
</body>
</html>