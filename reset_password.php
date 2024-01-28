<?php
require_once('classes/DBConnection.php');
require_once('initialize.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $reset_token = $_GET['token'];


    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    $update_query = mysqli_query($connection, "UPDATE student SET password='$new_password', reset_token=NULL WHERE reset_token='$reset_token'");
    
    if ($update_query) {
        echo "<script>alert('Successfully');</script>";
        echo "Password reset successfully. You can now <a href='index.php'>login</a> with your new password.";
    } else {
        echo "<script>alert('Failed');</script>";
        echo "Error updating password. Please try again.";
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
            font-family: Arial, sans-serif;
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
</head>
<body>  
    <div class="container">  
    <div class="table-responsive">  
    <h3 align="center">Reset password Form</h3><br/>
    <div class="box">
     <form method="post" >  
       <div class="form-group">
       <label for="password">New Password</label>
       <input type="text" name="password" id="password" placeholder="Enter password" required class="form-control"/>
      </div>
      <div class="form-group">
       <label for="confirm-password">Confirm-Password</label>
       <input type="confirm_password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm_Password" required class="form-control"/>
      </div>
      <div class="form-group">
       <input type="submit" id="reset" name="reset" value="Submit" class="btn btn-success" />
       </div>
</body>
</html>


