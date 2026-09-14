<?php
// Database configuration - update these credentials as per your local setup.
define('DB_HOST', 'localhost');
define('DB_NAME', 'blood_bank_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site base URL (no trailing slash). Adjust if project is not in webroot.
$base_url = 'http://localhost/blood_bank_donor_system';

// SMTP Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'your-email@gmail.com');      // Replace with your email
define('SMTP_PASS', 'your-app-password');         // Replace with your Gmail App Password
define('SMTP_PORT', 587);                         // 587 for TLS, 465 for SSL
define('SMTP_FROM', 'your-email@gmail.com');      // Email address you send from
define('SMTP_FROM_NAME', 'Rakt-Sarthi Blood Bank System');
?>
