<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Your form data

try {
    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth   = true; // Enable SMTP authentication
    $mail->Username   = 'lightwater106@gmail.com'; // SMTP username
    $mail->Password   = 'avvhzfuhpachootj'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable implicit TLS encryption
    $mail->Port       = 587; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $email = $_GET["email"];
    // Recipients
    $mail->setFrom('lightwater106@gmail.com', '');
    $mail->addAddress($email, ''); // Name is optional

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $mail->Subject = 'Resend Email Verification';
    $mail->Body    = "Your Verification code is: <strong>$verification_code</strong></p>

    Click <a href='http://localhost/Lightwater/email_verification.php?email=".$email ."'>Here</a> to Verify <br>
    
    <table>
<tr>
    <td colspan='2'>Resend Email Verification</td>
</tr>
<tr>
    <td><strong>Email: </strong>$email</td>
</tr>
<tr>
    <td>To access your account and start managing your water services, please visit our online portal at <a href='http://localhost/Lightwater/'>http://localhost/Lightwater/</a> and log in using the credentials provided above.</td>
</tr>
<tr>
    <td>If you have any questions, concerns, or require assistance with your account, our dedicated customer support team is here to help. You can reach us at <a href='mailto:lightwater.Inc@gmail.com'>lightwater.Inc@gmail.com</a>.</td>
</tr>
<tr>
    <td>Thank you for choosing Light Water Services. We are committed to providing you with high-quality water services and a seamless customer experience.</td>
</tr>
<tr>
    <td>Sincerely,<br>
        Ann Manuel Galapon-(COE)<br>
        Light Water Services<br>
        0999-187-8967 (Smart) & 0956-884-8224 (Globe)
    </td>
</tr>
</table>";

    $mail->send();
    
    $conn = mysqli_connect("localhost", "root", "", "light_water_db");



    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");
    $stamp = date('Y-m-d H:i:s',strtotime('+3 minutes',strtotime($date)));

    $otp_record = "INSERT INTO `otp_check`(`otp`, `email`, `status`, `create_at`) 
    VALUES ('$verification_code','$email','Sent', '$stamp')";
    mysqli_query($conn, $otp_record);

    $otp_resend = "UPDATE `clients` SET `verification_code`='$verification_code' WHERE email = '$email'";
    mysqli_query($conn, $otp_resend);

    echo"<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://localhost/lightwater/email_verification.php?email=". $email."'>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
