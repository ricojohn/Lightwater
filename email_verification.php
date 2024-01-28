<?php
 $conn = mysqli_connect("localhost", "root", "", "light_water_db");

$email2 = $_GET["email"];
$email_count = "SELECT * FROM otp_check WHERE email = '$email2' ORDER BY id DESC LIMIT 1";
$email_count_result  = mysqli_query($conn, $email_count);
$total_count = mysqli_num_rows($email_count_result);
$email_count_row  = mysqli_fetch_assoc($email_count_result);
$Date = date_create($email_count_row['create_at']);

if ($total_count > 3){
    echo "<script>alert('Email Not Recognized')</script>";
    header("Refresh:1; url=http://localhost/lightwater/");
}

if (isset($_POST["verify_email"]))
    {
        $email = $_POST["email"];
        $verification_code = $_POST["num1"].$_POST["num2"].$_POST["num3"].$_POST["num4"].$_POST["num5"].$_POST["num6"];
        // connect with database
       
 
        // mark email as verified
        $sql = "UPDATE `clients` SET email_verified_at = NOW(), verification_status = 'Verified'  WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "' ";
        $result  = mysqli_query($conn, $sql);
 
        if (mysqli_affected_rows($conn) == 0)
        {
            die("Verification code failed.");
        }
        echo "<script>alert('Account verified!')</script>";
        
        header("Refresh:1; url=http://localhost/lightwater/");
        exit();
}

if(isset($_GET['email'])){
    $sql_check = "SELECT * FROM clients WHERE email = '$email2' AND verification_status = 'Pending' ";
    $result  = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result) <= 0)
    {
        echo "<script>alert('Email Not Recognized')</script>";
        header("Refresh:1; url=http://localhost/lightwater/");
    }
}else{
    header("Refresh:1; url=http://localhost/lightwater/");
    exit();
}

if(isset($_GET['resend'])){
    if($_GET['resend'] != 'true'){
        echo "<script>alert('Email Not Recognized')</script>";
        header("Refresh:1; url=http://localhost/lightwater/");
        exit();
    }
    include('phpmailer/resend.php');
}else{
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <title>Document</title>
    <style>
body {
	background-color: #e7e0e0;
}

.height-100 {
	height: 100vh;
}

.card {
	width: 400px;
	border: none;
	height: 300px;
	box-shadow: 0px 5px 20px 0px #d2dae3;
	z-index: 1;
	display: flex;
	justify-content: center;
	align-items: center;
}

.card h6 {
	color: red;
	font-size: 20px;
}

.inputs input {
	width: 40px;
	height: 40px;
}

input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	margin: 0;
}

.card-2 {
    background-color: #fff;
    padding: 10px;
    width: 350px;
    height: 115px;
    bottom: -70px;
    left: 20px;
    position: absolute;
    border-radius: 5px;
}



.card-2 .content {
	margin-top: 50px;
}


.form-control:focus {
	box-shadow: none;
	border: 2px solid red;
}

.validate {
	border-radius: 20px;
	height: 40px;
	background-color: red;
	border: 1px solid red;
	width: 140px;
}
    </style>
</head>
<body>
<div class="container height-100 d-flex justify-content-center align-items-center">
  <div class="position-relative">
    <form method="post">
        <div class="card p-2 text-center">
            <p id='demo' style='color: #2905a0;' ></p>
            <h6>Please enter the one time password <br> to verify your account </h6>
            <div>
                <span>A code has been sent to</span><br>
                <small><?php echo $_GET['email']; ?></small>
            </div>
                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                    <input type="hidden" value="<?php echo $_GET['email']; ?>" name="email">
                    <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" name='num1' autofocus/>
                    <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" name='num2'/>
                    <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" name='num3'/>
                    <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" name='num4'/>
                    <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" name='num5'/>
                    <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" name='num6'/>
                </div>
            <div class="mt-4">
                <button type="submit" id="submit_btn" class="btn btn-danger px-4 validate" name="verify_email">Validate</button>
            </div>
        </div>
    </form>
    <div class="card-2 " id='resend' hidden>
      <div class="content d-flex justify-content-center align-items-center">
        <a href="http://localhost/Lightwater/email_verification.php?email=rjjuanitas16@gmail.com&resend=true" class="text-decoration-none ms-3  btn btn-info" >Resend</a>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
  
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    inputs[i].value = '';
                    if (i !== 0) inputs[i - 1].focus();
                } else {
                    if (i === inputs.length - 1 && inputs[i].value !== '') {
                        return true;
                    } else if (event.keyCode > 47 && event.keyCode < 58) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    } else if (event.keyCode > 64 && event.keyCode < 91) {
                        inputs[i].value = String.fromCharCode(event.keyCode);
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    }
                }
            });
        }
    }
OTPInput();
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<?php
echo "<script>
    // Set the date we're counting down to
    let countDownDate = new Date('".date_format($Date, 'M d, Y H:i:s')."').getTime();

    // Update the count down every 1 second
    let x = setInterval(function() {

    // Get today's date and time
    let now = new Date().getTime();
        
    // Find the distance between now and the count down date
    let distance = countDownDate - now;
        
    // Time calculations for days, hours, minutes and seconds
    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
    // Output the result in an element with id='demo'
    document.getElementById('demo').innerHTML = minutes + 'm ' + seconds + 's ';
        
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById('demo').innerHTML = 'Verification code Expired';
        $('#resend').removeAttr('hidden');
        $('input').attr('disabled','disabled');
        $('#submit_btn').attr('disabled','disabled');
    }
    }, 1000);
    </script>"; 
?> 
</body>
</html>


