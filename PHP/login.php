<?php
    $dbHost = "localhost";
    $dbName = "moretti_603552";
    $dbUsername = "root";
    $dbPassword  = "";

    $connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['login'])) {
            $loginUsername = $_POST['username'];
            $loginPassword = $_POST['password'];

            $selectQuery = "SELECT password FROM users WHERE username = ?";
            $stmt = mysqli_prepare($connection, $selectQuery);
            mysqli_stmt_bind_param($stmt, 's', $loginUsername);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $storedPassword);

            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($loginPassword, $storedPassword)) {
                    
                    session_start();
        
                    mysqli_stmt_close($stmt);
            
                    $getIDQuery = "SELECT id FROM users WHERE username = ?";
                    $stmtID = mysqli_prepare($connection, $getIDQuery);
                    mysqli_stmt_bind_param($stmtID, 's', $loginUsername);
                    mysqli_stmt_execute($stmtID);
                    mysqli_stmt_bind_result($stmtID, $userID);
            
                    if (mysqli_stmt_fetch($stmtID)) {
                        $_SESSION['user_id'] = $userID;
                        $_SESSION['username'] = $loginUsername;
            
                        header("Location: ./../PHP/home.php");
                        exit();
                    }
                } else {
                    echo '<script>alert("Password non corretta."); history.back();</script>';
                }
            } else {
                echo '<script>alert("Utente non trovato."); history.back();</script>';
            }

            mysqli_stmt_close($stmt);
        }
    }
?>