<?php
function getHighscore($connection, $username) {
    $sql = "SELECT highscore
    FROM highscores
    WHERE username = ?";

    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, 's', $username);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    $row = mysqli_fetch_assoc($result);

    mysqli_close($connection);
    return $row["highscore"];
}

function getSaldo($connection, $username){
    $sql = "SELECT saldo
    FROM cash
    WHERE username = ?";

$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($statement, 's', $username);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

mysqli_close($connection);
$row = mysqli_fetch_assoc($result);
return $row["saldo"];
}

function getSelected($connection, $user_id){
    $sql = "SELECT style_name
    FROM selected
    WHERE user_id = ?";

$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($statement, 'i', $user_id);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

mysqli_close($connection);
$row = mysqli_fetch_assoc($result);
return $row["style_name"];
}

function isSelected($style, $selectedStyle) {
    return ($style === $selectedStyle) ? 'selected' : '';
}

function isPurchased($style, $user_id) {
    require "tetrisDB.php";
    if ($style === 'classic') {
        return true;
    } else {
        $sqlCheckPurchase = "SELECT COUNT(*) AS count FROM purchases WHERE user_id = ? AND style_name = ?";
        $statementCheckPurchase = mysqli_prepare($connection, $sqlCheckPurchase);
        mysqli_stmt_bind_param($statementCheckPurchase, 'is', $user_id, $style);
        mysqli_stmt_execute($statementCheckPurchase);
        mysqli_stmt_bind_result($statementCheckPurchase, $count);
        mysqli_stmt_store_result($statementCheckPurchase);
        mysqli_stmt_fetch($statementCheckPurchase);

        return $count > 0;
    }
}

function getColors($user_id) {
    require "tetrisDB.php";
    $sql = "SELECT s.cell_color, s.block_color 
            FROM selected AS sl
            JOIN styles AS s ON sl.style_name = s.style_name
            WHERE sl.user_id = ?";

    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    mysqli_close($connection);

    $row = mysqli_fetch_assoc($result);
    return array(
        "cell_color" => $row["cell_color"],
        "block_color" => $row["block_color"]
    );
}