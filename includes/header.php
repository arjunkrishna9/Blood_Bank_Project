<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Bank & Donor Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo $base_url; ?>/index.php">BloodBankPro</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/donor-list.php">Donor List</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/search-donor.php">Search Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
        <?php if (isset($_SESSION['donor_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/donor/dashboard.php">My Account</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/donor/logout.php">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/donor/register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>/donor/login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="py-4">
<div class="container">
