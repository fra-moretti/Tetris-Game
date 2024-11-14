<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./tetrisDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $regUsername = $_POST['reg-username'];
    $regPassword = $_POST['reg-password'];
    $confirmPassword = $_POST['confirm-password'];


    if (strlen($regUsername) < 3) {
        echo '<script>alert("Lo username deve contenere almeno 3 caratteri."); history.back();</script>';
        exit();
    }

    if (strlen($regPassword) < 7){
    echo '<script>alert("La password deve contenere almeno 7 caratteri."); history.back();</script>';
    exit();
}
if ($regPassword !== $confirmPassword) {
    echo '<script>alert("La password e la conferma della password non coincidono."); history.back();</script>';
    exit(); 
}

    if (!preg_match("/[A-Z]/", $regPassword) || !preg_match("/[0-9]/", $regPassword)) {
        echo '<script>alert("La password deve contenere almeno una maiuscola e un numero."); history.back();</script>';
        exit();
    }

    $checkUsernameQuery = "SELECT username FROM users WHERE username = ?";
    $stmtCheck = mysqli_prepare($connection, $checkUsernameQuery);
    mysqli_stmt_bind_param($stmtCheck, 's', $regUsername);
    mysqli_stmt_execute($stmtCheck);
    mysqli_stmt_store_result($stmtCheck);

    if (mysqli_stmt_num_rows($stmtCheck) > 0) {
        echo '<script>alert("Questo nome utente esiste già. Scegline un altro."); history.back();</script>';
    } else {
        $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmtInsert = mysqli_prepare($connection, $insertQuery);

        $hashedPassword = password_hash($regPassword, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmtInsert, 'ss', $regUsername, $hashedPassword);

        if (mysqli_stmt_execute($stmtInsert)) {
            session_start();

            $userID = mysqli_insert_id($connection);

            $_SESSION['user_id'] = $userID;
            $_SESSION['username'] = $regUsername;

            $insertHighscoreQuery = "INSERT INTO highscores (username, highscore, linee, livello) VALUES (?, 0, 0, 0)";
            $stmtHighscore = mysqli_prepare($connection, $insertHighscoreQuery);
            mysqli_stmt_bind_param($stmtHighscore, 's', $regUsername);
            mysqli_stmt_execute($stmtHighscore);
            mysqli_stmt_close($stmtHighscore);

            $insertMoneyQuery = "INSERT INTO cash (username, saldo) VALUES (?, 0)";
            $stmtMoney = mysqli_prepare($connection, $insertMoneyQuery);
            mysqli_stmt_bind_param($stmtMoney, 's', $regUsername);
            mysqli_stmt_execute($stmtMoney);
            mysqli_stmt_close($stmtMoney);

            $insertLinesCompletedQuery = "INSERT INTO lines_completed (username, max_lines) VALUES (?, 0)";
            $stmtLinesCompleted = mysqli_prepare($connection, $insertLinesCompletedQuery);
            mysqli_stmt_bind_param($stmtLinesCompleted, 's', $regUsername);
            mysqli_stmt_execute($stmtLinesCompleted);
            mysqli_stmt_close($stmtLinesCompleted);

            $insertSelectedQuery = "INSERT INTO selected (user_id, style_name) VALUES (?, 'classic')";
            $stmtSelected = mysqli_prepare($connection, $insertSelectedQuery);
            mysqli_stmt_bind_param($stmtSelected, 'i', $userID);
            mysqli_stmt_execute($stmtSelected);
            mysqli_stmt_close($stmtSelected);

            $insertPurchaseQuery = "INSERT INTO purchases (user_id, style_name) VALUES (?, 'classic')";
            $stmtPurchase = mysqli_prepare($connection, $insertPurchaseQuery);
            mysqli_stmt_bind_param($stmtPurchase, 'i', $userID);
            mysqli_stmt_execute($stmtPurchase);
            mysqli_stmt_close($stmtPurchase);
            
            header("Location: ./../PHP/home.php");
            exit();
        } else {
            echo "Errore durante la registrazione: " . mysqli_error($connection);
        }
        mysqli_stmt_close($stmtInsert);
    }
    mysqli_stmt_close($stmtCheck);
}
?>