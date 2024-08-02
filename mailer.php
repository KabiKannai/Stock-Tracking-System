<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

// Uncomment the line below to enable SMTP debugging
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.gmail.com"; // Update to your SMTP server
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587; // Update to the appropriate port
$mail->Username = "itachiuchiha71415@gmail.com"; // Update to your email address
$mail->Password = "jlaz yzol rsdl vogo"; // Update to your email password

$mail->isHtml(true);

return $mail;


