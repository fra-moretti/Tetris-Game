<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tetris Shop</title>
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
        $saldo = getSaldo($connection, $username);
        require "./tetrisDB.php";
        $selectedStyle = getSelected($connection, $user_id);
    } else {
        echo "Errore di connessione al database.";
    }
}else{
    header("Location: ./../index.php");
    exit();
}
?>

    <script>const saldo = <?php echo $saldo; ?>;</script>
    <script src="./../JS/shop.js"></script>
    <script src="./../JS/purchase.js"></script>

    
</head>
<body>
<div class="shop-container">
    <div class="shop-header">
        <h1>Shop</h1>
        <button id="back-to-home" class="buttons"><i class="fas fa-arrow-left"></i></button>
    </div>
    <p><i class="fas fa-user"></i> <?php echo $username; ?></p>
    <p id="saldo"><?php echo $saldo; ?>$</p>
    <div class="shop-items">
        <div class="shop-item">
            <h3>Classic</h3> <div class="style-preview">
        <div class="color-preview classic-cell"></div>
        <div class="color-preview classic-block"></div>
    <button onclick="purchaseStyle('classic')" class="shop-button buttons <?php echo isSelected('classic', $selectedStyle); ?>"></button>
        </div></div>

        <div class="shop-item">
            <h3>Spring</h3><div class="style-preview">
        <div class="color-preview spring-cell"></div>
        <div class="color-preview spring-block"></div>        
            <button onclick="purchaseStyle('spring')" class="buttons shop-button <?php echo isSelected('spring', $selectedStyle); ?>" id="springButton">
            <?php echo (!isPurchased('spring', $user_id)) ? '10$' : ''; ?></button>
        </div></div>

        <div class="shop-item">
            <h3>Midnight</h3><div class="style-preview">
        <div class="color-preview midnight-cell"></div>
        <div class="color-preview midnight-block"></div>
            <button onclick="purchaseStyle('midnight')" class="buttons shop-button <?php echo isSelected('midnight', $selectedStyle); ?>" id="midnightButton">
            <?php echo (!isPurchased('midnight', $user_id)) ? '25$' : ''; ?></button>
        </div></div>

        <div class="shop-item">
            <h3>Sunset</h3><div class="style-preview">
                <div class="color-preview sunset-cell"></div>
                <div class="color-preview sunset-block"></div>
            <button onclick="purchaseStyle('sunset')" class="buttons shop-button <?php echo isSelected('sunset', $selectedStyle); ?>" id="sunsetButton">
            <?php echo (!isPurchased('sunset', $user_id)) ? '50$' : ''; ?></button>
        </div></div>

        <div class="shop-item">
            <h3>Retro</h3><div class="style-preview">
        <div class="color-preview retro-cell"></div>
        <div class="color-preview retro-block"></div>
            <button onclick="purchaseStyle('retro')" class="buttons shop-button <?php echo isSelected('retro', $selectedStyle); ?>" id="retroButton">
            <?php echo (!isPurchased('retro', $user_id)) ? '100$' : ''; ?></button>
        </div></div>
    </div>
</div>
</body>
</html>

