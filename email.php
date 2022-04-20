<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once 'vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

function sendEmail($email, $message, $messageType) {

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);



// $email = $_POST["email"];

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = 'team18library@gmail.com'; // YOUR gmail email
    $mail->Password = 'Library#18'; // YOUR gmail password
    $mail->AddAddress($email, "recipient-name");
    // Sender and recipient settings
    // $mail->setFrom('example@gmail.com', 'Sender Name');
    // $mail->addAddress('phppot@example.com', 'Receiver Name');
    $mail->From = "team18library@gmail.com";
    $mail->FromName = "Team 18 Library";
    // $mail->addReplyTo('team18library@gmail.com', 'Team 18'); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = $message;
    // $mail->Body = 'Hello, <br>
    //                 You have a fine added on your account. <br>
    //                 Please pay it before the due date. <br>
    //                 Thank you! <br>
    //                 Team 18 Library';
    $mail->Body = $message;
    $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

    $mail->send();
    if($messageType = 'b') {
        echo '<script>alert("Alert Email has been sent!, Please Check Your Inbox");</script>';
    }
    elseif($messageType = 'f') {
        echo '<script>alert("Fine added to your account. Email has been sent!, Please Check Your Inbox");</script>';
    }
    //echo '<script>alert("Reminder Email has been Sent, Please Check Your Inbox!");</script>';
    //echo "Email message sent.";
} catch (Exception $e) {
    echo'<script>alert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");</script>';
    //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}
}

?>
