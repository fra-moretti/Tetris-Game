<?php
session_start();

if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();

    header('Content-Type: application/json');
    echo json_encode(['logged_out' => true]);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['logged_out' => false]);
    exit;
}
?>