<?php
session_start();
include_once('DBConnection.php');
require_once('initialize.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$msg = '';

$host = "localhost";
$username = "root";
$password = "";
$database = "light_water_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];
    $select_query = mysqli_query($conn, "SELECT * FROM clients WHERE email='$email'");
    $res = mysqli_num_rows($select_query);

    if ($res > 0) {
        $data = mysqli_fetch_array($select_query);
        $reset_token = bin2hex(random_bytes(32));
        $update_query = mysqli_query($conn, "UPDATE clients SET reset_token='$reset_token' WHERE email='$email'");

        $reset_link = "http://localhost/OTP_LOGIN/phpmailer/reset_password.php?token=" . $reset_token; 

        $message = '<div>
            <p><b>Hello!</b></p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <br>
            <p>Click the following link to reset your password:</p>
            <p><a href="' . $reset_link . '">Reset Password</a></p>
            <br>
            <p>If you did not request a password reset, no further action is required.</p>
        </div>';

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'lightwater106@gmail.com';
        $mail->Password = 'avvhzfuhpachootj';
        $mail->FromName = "light Sup";
        $mail->AddAddress($email);
        $mail->Subject = "Password Reset";
        $mail->isHTML(true);
        $mail->Body = $message;
        $mail->send();

    } else {
        $msg = "Invalid Email";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <title>Password Reset</title>
    <style>
        body {
            background-color: #e7e0e0;
        }

        h2 {
            text-align: center;
            margin-top: 50px; 
        }

        form {
            width: 300px;
            margin: 0 auto;
            text-align: center;
            margin-top: 20px; 
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        p {
            text-align: center;
            color: red;
        }
    </style>
     <script>
        $(document).ready(function () {
            $('form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'your_php_file.php', // Replace with the actual filename
                    data: $('form').serialize(),
                    success: function (response) {
                        $('p').text(response);
                    },
                    error: function () {
                        $('p').text('Error sending request');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post" action="">
        <label for="email">Enter Your Email:</label>
        <input type="email" name="email" required>
        <input type="submit" name="forgot_password" value="Send Reset Link">
    </form>
    <p><?php echo $msg; ?></p>
</body>
</html>

