<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ./PHP/home.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tetris Home</title>
  <link rel="stylesheet" href="./CSS/tetris.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
  <link rel="icon" type="image/png" href="./images/tetris.png">
  <script src="./JS/login.js"></script>
</head>
<body>
        <div class="login-container">
          <div class="logo">
            <img id="tetris" src="./images/logotetris.png" alt="tetris">
          </div>
          
          <form action="./PHP/login.php" method="post" class="form-container" id="login-form">
          <div id="login-fields" class="input-container">
            
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="username" name="username" required autofocus>
      
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="password" name="password" required>
      
            <button type="submit" id="login-btn" class="id" name="login">LOGIN</button>
      
            <p class="not-registered">Non hai un account? <a href="#" id="register-link">Registrati</a></p>
          </div>
          </form>
          
          
          <form action="./PHP/register.php" method="post" class="form-container hidden" id="register-form">
            <div id="registration-fields" class="input-container"> 
              <label for="reg-username">Username</label>
              <input type="text" id="reg-username" placeholder="Username" name="reg-username" pattern=".{3,}" title="Lo username deve contenere almeno 3 caratteri." required>
          
              <label for="reg-password">Password</label>
              <input type="password" id="reg-password" placeholder="Password" name="reg-password" pattern="(?=.*[a-z])(?=.*[A-Z]).{7,}" title="La password deve contenere almeno una maiuscola, una minuscola e essere lunga almeno 7 caratteri." required>
              
              <label for="confirm-password">Conferma Password</label>
              <input type="password" id="confirm-password" placeholder="Conferma Password" name="confirm-password" required>
          
              <button type="submit" id="register-btn" class="id" name="register">REGISTRATI</button>
              <p class="not-registered"><a href="#" id="login-link">Torna al LOGIN</a></p>
            </div>
          </form>
          <div class="info-icon">
      <i class="fas fa-info-circle"></i>
    </div>
        </div>
        
        <?php    
            include "./PHP/footer.php";
        ?>
</body>
</html>