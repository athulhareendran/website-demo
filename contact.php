<?php
// Set the owner's email address
$owner_email = 'athulhareendran@gmail.com';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $offer = isset($_POST['offer']) && $_POST['offer'] !== '' ? trim($_POST['offer']) : null;

    $errors = [];
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }
    if (empty($mobile) || !preg_match('/^\+\d{7,16}$/', $mobile)) {
        $errors[] = 'A valid mobile number with country code is required.';
    }
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    if (empty($errors)) {
        $subject = "BahrainFort.com Price Request";
        $body = "Name: $name\nEmail: $email\nMobile: $mobile\n";
        $body .= "Offer: " . ($offer ? ("$offer USD") : "No offer specified") . "\n";
        $body .= "Message: $message";
        $headers = "From: $email\r\nReply-To: $email";

        if (mail($owner_email, $subject, $body, $headers)) {
            $success = true;
        } else {
            $errors[] = 'Failed to send your request. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BahrainFort.com - Request Sent</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f6fa; margin: 0; padding: 0; }
        .container { max-width: 420px; margin: 6vh auto 0 auto; background: #fff; padding: 2.5rem 2rem 2rem 2rem; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        h1 { color: #1a2238; }
        .success { color: #27ae60; margin-bottom: 1.5rem; }
        .error { color: #e43f5a; margin-bottom: 1.5rem; }
        .footer { text-align: center; color: #aaa; font-size: 0.95rem; margin-top: 2rem; }
        a { color: #1a2238; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>BahrainFort.com</h1>
        <?php if (!empty($success)): ?>
            <div class="success">Thank you for your interest! Your request has been sent. We will contact you soon.</div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error) echo htmlspecialchars($error) . '<br>'; ?>
                </div>
            <?php endif; ?>
            <a href="index.html">&larr; Go back to the landing page</a>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; 2024 BahrainFort.com &mdash; Domain for sale. Not affiliated with any official entity.
    </div>
</body>
</html> 