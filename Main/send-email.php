<?php
$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$msg = '';

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.example.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "my@example.com";
$mail->Password = "************";

$mail->setFrom('my@example.com', 'Tomas');
$mail->addAddress('another@example.com');

if ($mail->addReplyTo($email, $name)) {
    $mail->Subject = 'Contact form';
    //Keep it simple - don't use HTML
    $mail->isHTML(false);
    //Build a simple message body
    $mail->Body = <<<EOT
Email: {$email}
Name: {$name}
Message: {$message}
EOT;
    //Send the message, check for errors
    if (!$mail->send()) {
        //The reason for failing to send will be in $mail->ErrorInfo
        //but it's unsafe to display errors directly to users - process the error, log it on your server.
        $msg = 'Sorry, something went wrong. Please try again later.';
    } else {
        header("Location: sent.html");
    }
} 
else {
    $msg = 'Invalid email address, message ignored.';
}
if (!empty($msg)) {
    echo "<h2>$msg</h2>";
}