<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function require_admin_login() {
    if (!is_admin_logged_in()) {
        redirect('../admin/login.php');
    }
}

function is_donor_logged_in() {
    return isset($_SESSION['donor_id']);
}

function require_donor_login() {
    if (!is_donor_logged_in()) {
        redirect('../donor/login.php');
    }
}

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
