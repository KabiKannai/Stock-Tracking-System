<?php

// Include database connection
$mysqli = require __DIR__ . "/database.php";

// Get email from POST request
$email = $_POST["email"];

// Generate a secure token
$token = bin2hex(random_bytes(16));

// Hash the token for secure storage
$token_hash = hash("sha256", $token);

// Set an expiry time for the token (30 minutes from now)
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Prepare the SQL statement to update the user's reset token and expiry time
$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

// Check if the email exists in the database
if ($stmt->affected_rows) {
    // Load the mailer configuration
    $mail = require __DIR__ . "/mailer.php";

    // Set the sender and recipient email addresses
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";

    // Set the email body with the reset link
    $mail->Body = <<<END
    Click <a href="http://localhost/SmallCodings/reset-password.php?token=$token">here</a> 
    to reset your password.
    END;

    // Send the email and handle potential errors
    try {
        $mail->send();
        echo "Message sent, please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
} else {
    echo "Email address not found.";
}
