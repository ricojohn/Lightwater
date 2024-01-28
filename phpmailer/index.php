<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Your form data
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

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

    // Recipients
    $mail->setFrom('lightwater106@gmail.com', '');
    $mail->addAddress($email, ''); // Name is optional

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $mail->Subject = 'Email Verification';
    $mail->Body    = "Your Verification code is: <strong>$verification_code</strong></p>

    Click <a href='http://localhost/Lightwater/email_verification.php?email=".$email ."'>Here</a> to Verify <br>
    
    <table>
<tr>
    <td colspan='2'></td>
</tr>
<tr>
    <td><strong>Dear: $firstname</strong></td>
</tr>
<tr>
    <td>I hope this message finds you well. We are delighted to inform you that your account registration for Light Water Services has been successfully completed. You are now a valued member of our water service community.</td>
</tr>
<tr>
    <td><strong>Your account details:</strong></td>
</tr>
<tr>
    <td><strong>Account Name: </strong>$firstname $lastname</td>
 
</tr>
<tr>
    <td><strong>Contact: </strong>$contact</td>
    
</tr>
<tr>
    <td><strong>Email: </strong>$email</td>
   
</tr>
<tr>
    <td><strong>Address: </strong>$default_delivery_address</td>
  
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
    
    // Verification code sent successfully, now store it in the database
    $encrypted_password = md5($password);
    $default_delivery_address = $housenum.','.$street.','.$brgy.','.$real_city.','.$province;
    $conn = mysqli_connect("localhost", "root", "", "light_water_db");

    // Assuming the following columns exist in your 'clients' table
    $email_verified_at = NULL; // You may need to adjust this based on your database schema
    $date_created = date("Y-m-d H:i:s");

    $sql ="INSERT INTO `clients`(`verification_status`, `id`, `firstname`, `lastname`, `gender`, `contact`, `email`, `password`, `verification_code`, `email_verified_at`, `default_delivery_address`, `date_created`) 
            VALUES ('Pending', NULL, '$firstname','$lastname','$gender','$contact','$email','$encrypted_password','$verification_code','$email_verified_at','$default_delivery_address','$date_created')";
    mysqli_query($conn, $sql);

    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");
    $stamp = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($date)));

    $otp_record = "INSERT INTO `otp_check`(`otp`, `email`, `status`, `create_at`) 
    VALUES ('$verification_code','$email','Sent', '$stamp')";
    mysqli_query($conn, $otp_record);


    header("Location: email_verification.php?email=" . $email);
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
