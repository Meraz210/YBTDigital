<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';

// Ensure session is started (config.php handles it)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Create CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Invalid form submission.';
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors[] = 'Please enter your name.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($message === '') {
        $errors[] = 'Please enter a message.';
    }

    if (empty($errors)) {
        // Insert into database
        $stmt = $connection->prepare("INSERT INTO contact_messages (name, email, subject, message, status) VALUES (?, ?, ?, ?, ?)");
        $status = 'new';
        $stmt->bind_param('sssss', $name, $email, $subject, $message, $status);
        if ($stmt->execute()) {
            // Try to send email notification
            $to = SITE_EMAIL;
            $mail_subject = "[Contact] " . ($subject ?: 'New message');
            $mail_body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
            $headers = "From: $name <$email>\r\nReply-To: $email\r\n";
            @mail($to, $mail_subject, $mail_body, $headers);

            $success = 'Thank you! Your message has been received. We will get back to you soon.';

            // Reset fields
            $name = $email = $subject = $message = '';

            // Regenerate CSRF token
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $csrf_token = $_SESSION['csrf_token'];
        } else {
            $errors[] = 'Failed to save your message. Please try again later.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - YBT Digital</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="assets/css/theme.css" rel="stylesheet">
</head>
<body>
    <?php if (file_exists(__DIR__ . '/partials/header.php')) { include __DIR__ . '/partials/header.php'; } ?>

    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Contact Us</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-7">
                    <form method="post" action="contact.php" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" value="<?php echo htmlspecialchars($subject ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="6" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>

                <div class="col-md-5">
                    <div class="card p-3">
                        <h5>Contact Information</h5>
                        <p class="mb-1"><i class="fas fa-envelope me-2"></i> <?php echo htmlspecialchars(SITE_EMAIL); ?></p>
                        <p class="mb-1"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                        <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> 123 Business St, City, Country</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light py-5">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> YBT Digital. All rights reserved.</p>
        </div>
    </footer>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>