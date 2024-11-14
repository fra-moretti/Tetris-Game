<?php
session_start();
include "./DBfunctions.php";
include "./tetrisDB.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["username"])) {
        $user_id = $_SESSION["user_id"];
        $username = $_SESSION["username"];
        $style = $_POST["style"];
        
        function getPrice($style) {
            $stylePrices = [
                'classic' => 0,
                'spring' => 10,
                'midnight' => 25,
                'sunset' => 50,
                'retro' => 100
            ];

            return isset($stylePrices[$style]) ? $stylePrices[$style] : -1;
        }

        $stylePrice = getPrice($style);

        if ($stylePrice >= 0) {
            $saldo = getSaldo($connection, $username);

            $connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

            if (mysqli_connect_errno()) {
                die(mysqli_connect_error());
            }

            $sqlCheckPurchase = "SELECT COUNT(*) AS count FROM purchases WHERE user_id = ? AND style_name = ?";
            $statementCheckPurchase = mysqli_prepare($connection, $sqlCheckPurchase);
            mysqli_stmt_bind_param($statementCheckPurchase, 'is', $user_id, $style);
            mysqli_stmt_execute($statementCheckPurchase);
            mysqli_stmt_bind_result($statementCheckPurchase, $count);
            mysqli_stmt_store_result($statementCheckPurchase);
            mysqli_stmt_fetch($statementCheckPurchase);
    
            if ($count > 0) {
                http_response_code(400);
                echo json_encode(["message" => "Hai già acquistato questo stile in precedenza"]);
                $sqlSelectStyle = "UPDATE selected SET style_name = ? where user_id = ?";
                $statementSelectStyle = mysqli_prepare($connection, $sqlSelectStyle);
                mysqli_stmt_bind_param($statementSelectStyle, 'si', $style, $user_id);
                mysqli_stmt_execute($statementSelectStyle);
            } elseif ($saldo >= $stylePrice) {
                $newSaldo = $saldo - $stylePrice;

                $sqlUpdateSaldo = "UPDATE cash SET saldo = ? WHERE username = ?";
                $statementUpdateSaldo = mysqli_prepare($connection, $sqlUpdateSaldo);
                mysqli_stmt_bind_param($statementUpdateSaldo, 'is', $newSaldo, $username);
                mysqli_stmt_execute($statementUpdateSaldo);

                if (mysqli_affected_rows($connection) > 0) {
                    $sqlAddPurchase = "INSERT INTO purchases (user_id, style_name) VALUES (?, ?)";
                    $statementAddPurchase = mysqli_prepare($connection, $sqlAddPurchase);
                    mysqli_stmt_bind_param($statementAddPurchase, 'is', $user_id, $style);
                    mysqli_stmt_execute($statementAddPurchase);

                    $sqlSelectStyle = "UPDATE selected SET style_name = ? where user_id = ?";
                    $statementSelectStyle = mysqli_prepare($connection, $sqlSelectStyle);
                    mysqli_stmt_bind_param($statementSelectStyle, 'si', $style, $user_id);
                    mysqli_stmt_execute($statementSelectStyle);

                    http_response_code(200);
                    echo json_encode(["message" => "Acquisto effettuato con successo"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Errore durante l'acquisto"]);
                }

                mysqli_close($connection);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Saldo insufficiente"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Stile non trovato"]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Utente non autenticato"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Metodo non consentito"]);
}
?>
