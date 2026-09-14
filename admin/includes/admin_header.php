<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_admin_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Blood Bank & Donor Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
</head>
<body>
<div class="d-flex" id="wrapper">
    <div class="border-end bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom bg-danger text-white fw-bold text-center py-3">
            Admin Panel
        </div>
        <div class="list-group list-group-flush">
            <a href="<?php echo $base_url; ?>/admin/dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
            <a href="<?php echo $base_url; ?>/admin/blood-groups.php" class="list-group-item list-group-item-action">Blood Groups</a>
            <a href="<?php echo $base_url; ?>/admin/donors.php" class="list-group-item list-group-item-action">Donor List</a>
            <a href="<?php echo $base_url; ?>/admin/requests.php" class="list-group-item list-group-item-action">Requests Received</a>
            <a href="<?php echo $base_url; ?>/admin/contact-queries.php" class="list-group-item list-group-item-action">Contact Queries</a>
            <a href="<?php echo $base_url; ?>/admin/pages.php" class="list-group-item list-group-item-action">Manage Pages</a>
            <a href="<?php echo $base_url; ?>/admin/settings.php" class="list-group-item list-group-item-action">Contact Info</a>
            <a href="<?php echo $base_url; ?>/admin/profile.php" class="list-group-item list-group-item-action">My Profile</a>
            <a href="<?php echo $base_url; ?>/admin/change-password.php" class="list-group-item list-group-item-action">Change Password</a>
            <a href="<?php echo $base_url; ?>/admin/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
        </div>
    </div>
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-outline-danger" id="sidebarToggle">Toggle Menu</button>
                <span class="navbar-text ms-3 fw-semibold">BloodBankPro Admin</span>
            </div>
        </nav>
        <div class="container-fluid py-4">
