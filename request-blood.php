<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$donor_id = intval($_GET['donor_id'] ?? 0);
$donor = null;
if ($donor_id) {
    $stmt = $mysqli->prepare("SELECT d.id, d.full_name, d.email AS donor_email, bg.name AS blood_group, d.city FROM donors d JOIN blood_groups bg ON d.blood_group_id = bg.id WHERE d.id = ? AND d.is_hidden = 0");
    if ($stmt) {
        $stmt->bind_param('i', $donor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $donor = $result->fetch_assoc();
        $stmt->close();
    }
}
if (!$donor) {
    echo "<div class='alert alert-danger'>Invalid donor selection.</div>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = trim($_POST['patient_name'] ?? '');
    $patient_email = trim($_POST['patient_email'] ?? '');
    $patient_phone = trim($_POST['patient_phone'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($patient_name && $patient_email && $city) {
        $stmt = $mysqli->prepare("INSERT INTO blood_requests (donor_id, patient_name, patient_email, patient_phone, city, message) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('isssss', $donor_id, $patient_name, $patient_email, $patient_phone, $city, $message);
            if ($stmt->execute()) {
                $success = "Your request has been sent to the donor.";
                
                // Send email to donor
                require_once __DIR__ . '/includes/PHPMailer/src/Exception.php';
                require_once __DIR__ . '/includes/PHPMailer/src/PHPMailer.php';
                require_once __DIR__ . '/includes/PHPMailer/src/SMTP.php';
                
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = SMTP_HOST;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = SMTP_USER;
                    $mail->Password   = SMTP_PASS;
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = SMTP_PORT;

                    $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
                    $mail->addAddress($donor['donor_email'], $donor['full_name']);

                    $mail->isHTML(true);
                    $mail->Subject = "Urgent: Your Blood Type {$donor['blood_group']} is Requested!";
                    
                    $email_body = "<h3>Urgent Blood Request</h3>";
                    $email_body .= "<p>Dear {$donor['full_name']},</p>";
                    $email_body .= "<p>There is an urgent requirement for your blood group (<strong>{$donor['blood_group']}</strong>) in <strong>{$city}</strong>.</p>";
                    $email_body .= "<p><strong>Patient Details:</strong><br>";
                    $email_body .= "Name: {$patient_name}<br>";
                    $email_body .= "Email: {$patient_email}<br>";
                    if ($patient_phone) {
                        $email_body .= "Phone: {$patient_phone}<br>";
                    }
                    $email_body .= "</p>";
                    if ($message) {
                        $email_body .= "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";
                    }
                    $email_body .= "<p>Please contact the patient if you are available to donate.</p>";
                    $email_body .= "<p>Thank you,<br>" . SMTP_FROM_NAME . "</p>";

                    $mail->Body    = $email_body;
                    $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\r\n", "\r\n\r\n"], $email_body));

                    $mail->send();
                } catch (Exception $e) {
                    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
            } else {
                $error = "Failed to send request. Please try again.";
            }
            $stmt->close();
        } else {
            $error = "Unexpected error. Please try again.";
        }
    } else {
        $error = "Patient Name, Email and City are required.";
    }
}
?>
<h1 class="mb-4">Request Blood from <?php echo e($donor['full_name']); ?></h1>
<div class="card shadow-sm">
    <div class="card-body">
        <p><strong>Donor Name:</strong> <?php echo e($donor['full_name']); ?></p>
        <p><strong>Blood Group:</strong> <span class="badge bg-danger"><?php echo e($donor['blood_group']); ?></span></p>
        <p><strong>City:</strong> <?php echo e($donor['city']); ?></p>
        <hr>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo e($success); ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Patient Name *</label>
                <input type="text" name="patient_name" class="form-control" required value="<?php echo isset($_POST['patient_name']) ? e($_POST['patient_name']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Patient Email *</label>
                <input type="email" name="patient_email" class="form-control" required value="<?php echo isset($_POST['patient_email']) ? e($_POST['patient_email']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Patient Phone</label>
                <input type="text" name="patient_phone" class="form-control" value="<?php echo isset($_POST['patient_phone']) ? e($_POST['patient_phone']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" required value="<?php echo isset($_POST['city']) ? e($_POST['city']) : e($donor['city']); ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="4"><?php echo isset($_POST['message']) ? e($_POST['message']) : ''; ?></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Send Request</button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
