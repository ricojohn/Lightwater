<?php
  // require_once('sess_auth.php');
  
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bootstrap 4 -->
      <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <!-- <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css"> -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url ?>assets/css/styles.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">
     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Vendor CSS Files -->
 <!-- Vendor CSS Files -->
  <link href="assets_test/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets_test/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets_test/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets_test/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets_test/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets_test/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets_test/css/main.css?v2.4" rel="stylesheet">
    <style type="text/css">/* Chart.js */
      @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
    </style>

     <!-- jQuery -->
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>
    <script src="<?php echo base_url ?>assets/js/scripts.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>

    <style>
    #main-header{
        position:relative;
        /* background: radial-gradient(circle, rgba(0,0,0,0.48503151260504207) 22%, rgba(0,0,0,0.39539565826330536) 49%, rgba(0,212,255,0) 100%)!important; */
        display: flex;
        justify-content: center;
        height:40vh;
    }
    #main-header:before{
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: black;
      background-image: url(http://localhost/Lightwater/uploads/received_1368209897422487.jpeg);
      background-size: 100vw 46vh;
      background-position: top center;
      background-repeat: no-repeat;
      filter: drop-shadow(0px 7px 6px #3c8dbc);
      z-index: -1;
    }
    img.img-banner {
        height: 20.5vw;
        width: calc(100%);
    }
    .text-default{
      color:#45bbff !important;
    }

 </style>
  </head>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="login-form">
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control form" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form" name="password" id="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text password-toggle" aria-hidden="true" aria-label="Toggle Password Visibility">
                                <i class="fa fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group d-flex justify-content-between mt-3">
                    <a type="button"  data-bs-toggle="modal" data-bs-target="#register" id="create_account" class="btn btn-link">Create Account</a>
                    <a href="phpmailer/forgot_password.php" class="btn btn-link">Forgot Password?</a>
                    <button type="submit" class="btn btn-primary btn-flat">Login</button>
                </div>
          </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Create New Account</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" id="registration">
					<div class="row  align-items-center h-100">
						<div class="col-lg-5 border-right">
							<div class="form-group">
								<label for="" class="control-label">Firstname</label>
								<input type="text" class="form-control form" name="firstname" required placeholder="Firstname"> </div>
							<div class="form-group">
								<label for="" class="control-label">Lastname</label>
								<input type="text" class="form-control form" name="lastname" required placeholder="Lastname"> </div>
							<div class="form-group">
								<label for="" class="control-label">Contact</label>
								<input type="text" class="form-control form" name="contact" required placeholder="+63"> </div>
							<div class="form-group">
								<label for="" class="control-label">Gender</label>
								<select name="gender" id="" class="form-select " required>
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
						</div>
						<div class="col-lg-7">
							<label for="" class="control-label">Default Delivery Address</label>
							<div class="row">
								<div class="col-lg-4 col-sm-12">
									<div class="form-group ">
										<input type="text" class="form-control form" name="province" value="Cavite" readonly >
										<!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
									</div>
								</div>
								<div class="col-lg-4 col-sm-12">
									<div class="form-group ">
										<input type="hidden" name='real_city' id='real_city'>
										<?php 
                            // Fetch all cities
                            $conn = mysqli_connect("localhost", "root", "", "light_water_db");
                            $get_city = "SELECT * FROM refcitymun WHERE provCode = '0421'";
                            $get_city_result = $conn->query($get_city);
                            ?>
											<select type="text" class="form-select form-select-sm form" id="city" name="city" required>
												<option value="0">- Select City -</option>
												<?php 
                                    while($row = $get_city_result->fetch_assoc()){
                                        $citymunCode = strtolower($row['citymunCode']);
                                        $citymunDesc = strtolower(utf8_decode($row['citymunDesc']));
                                        echo "<option value='".$citymunCode."' >".ucwords(utf8_encode($citymunDesc))."</option>";
                                    }
                                ?>
											</select>
											<!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
									</div>
								</div>
								<div class="col-lg-4 col-sm-12">
									<div class="form-group ">
										<select class="form-select form-select-sm form" id="brgy" name="brgy" required>
											<option value="">- Select Brgy -</option>
										</select>
										<!-- <input type="text" class="form-control form-control-sm form" id="brgy" name="brgy" placeholder="Barangay"> -->
										<!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
									</div>
								</div>
								<div class="col-lg-4 col-sm-12">
									<div class="form-group ">
										<input type="text" class="form-control  form" id="street" name="street" placeholder="Street" required>
										<!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
									</div>
								</div>
								<div class="col-lg-4 col-sm-12">
									<div class="form-group ">
										<input type="text" class="form-control  form" id="housenum" name="housenum" placeholder="House No." required>
										<!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Email</label>
								<input type="email" class="form-control  form" name="email" required placeholder="Email"> </div>
							<div class="form-group">
								<label for="" class="control-label">Password</label>
								<div class="input-group error_pass">
									<input type="password" class="form-control form" name="password" required placeholder="Password">
									<div class="input-group-append"> <span class="input-group-text password-toggle"><i class="fa fa-eye-slash"></i></span> </div>
								</div>
							</div>
              <div class="form-group">
                <label for="" class="control-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control form-control-sm form" name="confirm_password" required placeholder="Confirm Password">
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle"><i class="fa fa-eye-slash"></i></span>
                    </div>
                </div>
                </div>
                <div class="form-group">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="consentCheckbox" required>
                      <label class="form-check-label" for="consentCheckbox">
                          I agree to the <span id="readMoreLink" style="cursor: pointer; color: blue; text-decoration: underline;">data privacy policy</span>.
                      </label>
                  </div>
                </div>
              </div>
						</div>
            <div class="form-group d-flex justify-content-between mt-3">
              <a href="javascript:void()"  data-bs-toggle="modal" data-bs-target="#exampleModal">Already have an Account</a>
              <button class="btn btn-primary btn-flat">Register</button>
            </div>
          </div>
				</form>
				</div>
			</div>
		</div>
	</div>
  <script>
  $('#login-form').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "classes/Login.php?f=login_user",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                      var _err_el = $('<div>').addClass("alert alert-success err-msg").text("Incorrect Credentials.");
                        alert_toast("Login Successfully", 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else if (resp.status === 'incorrect') {
                        var _err_el = $('<div>').addClass("alert alert-danger err-msg").text("Incorrect Credentials.");
                        $('#login-form').prepend(_err_el);
                        end_loader();
                    } else if (resp.status === 'pending') {
                        var _err_el = $('<div>').addClass("alert alert-danger err-msg").text("Not Yet Verified, Please Check email");
                        $('#login-form').prepend(_err_el);
                        end_loader();
                    }else {
                        console.log(resp);
                        alert("An error occurred", 'error');
                        end_loader();
                    }
                },
                error: function (err) {
                    console.log(err);
                    alert("An error occurred", 'error');
                    end_loader();
                }
            });
        });
</script>
  <script>
// address Codes
$(function() {
    $('#street').attr('disabled', true);
    $('#housenum').attr('disabled', true);
    $("#city").change(function(){
        // Selected city id
        var city_id = $(this).val();
        var city_name = $('#city :selected').text();

        $('#brgy').find('option').not(':first').remove();
        $('#real_city').val(city_name);
        $('#street').val('');
        $('#housenum').val('');
        // Fetch brgy
        $.ajax({
            url: 'search.php',
            type: 'POST',
            data: {request:'getCityBrgy',city_id:city_id},
            // dataType: 'json',
            success:function(response){
                var data = JSON.parse(response);
                var len = data.length;
                // Add data to state dropdown
                for( var i = 0; i<len; i++){
                    var brgyCode = data[i]['brgyCode'];
                    var brgyDesc = data[i]['brgyDesc'];
                    $("#brgy").append("<option value='"+ brgyDesc +"' >"+ brgyDesc +"</option>");

                }
            }
        });
    });
    $("#brgy").change(function(){
        var brgy_id = $(this).val();
        if(brgy_id == ''){
            $('#street').val('');
            $('#housenum').val('');
            $('#street').attr('disabled', true);
            $('#housenum').attr('disabled', true);
        }else{
            $('#street').attr('disabled', false);
            $('#housenum').attr('disabled', false);
        }
        
    });
});
  $(function(){
    $('#login-show').click(function(){
        uni_modal("","login.php")
    })
    $('#readMoreLink').click(function () {
        $('#readMoreModal').modal('show');
    });

    $('#registration').submit(function(e){
        e.preventDefault();

        // Validate contact number
        var contactNumber = $('[name="contact"]').val();

        // Remove any non-numeric characters
        var numericContact = contactNumber.replace(/\D/g, '');

        // Check for the correct format
        if (!numericContact.startsWith('63') || numericContact.length !== 12) {
            var _err_el = $('<div>')
            _err_el.addClass("alert alert-danger err-msg").text('Invalid contact number format. Please use +63 followed by 10 numeric digits.');
            $('[name="contact"]').after(_err_el);
            end_loader();

            // Delay the form submission for 2 seconds
            setTimeout(function() {
                $('.err-msg').remove();
            }, 2000);

            return false; // Stop form submission
        }

        // Continue with form submission
        if($('.err-msg').length > 0)
            $('.err-msg').remove();
        $.ajax({
            url: "classes/Master.php?f=register",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("Account successfully registered", 'success');
                setTimeout(function () {
                    location.reload();
                }, 5000);
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert_toast("Account successfully registered", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 5000);
                } else if (resp.status == 'failed' && !!resp.msg) {
                    var _err_el = $('<div>')
                    _err_el.addClass("alert alert-danger err-msg").text(resp.msg);
                    // $('[class="error_pass"]').after(_err_el);
                    $('.error_pass').after(_err_el);
                    end_loader();
                    setTimeout(function() {
                        $('.err-msg').remove();
                    }, 5000);
                } else if (resp.status == 'failed_email' && !!resp.msg) {
                    var _err_el = $('<div>')
                    _err_el.addClass("alert alert-danger err-msg").text(resp.msg);
                    $('[name="email"]').after(_err_el);
                    end_loader();
                    setTimeout(function() {
                        $('.err-msg').remove();
                    }, 5000);
                } else {
                    console.log(resp);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            }
        });
    });

    // Custom validation for contact number
    function isValidContactNumber(contactNumber) {
        return /^\+63/.test(contactNumber);
    }
    $(document).on('click', '.password-toggle', function () {
        var passwordField = $(this).closest('.input-group').find('input');
        var fieldType = passwordField.attr('type');
        var newType = (fieldType === 'password') ? 'text' : 'password';
        passwordField.attr('type', newType);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
});

</script>