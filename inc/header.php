<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Light Water</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="uploads/received_347587078009688.jpeg" rel="icon">
  <link href="assets_test/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets_test/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets_test/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets_test/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets_test/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets_test/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets_test/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets_test/css/main.css?v2.4" rel="stylesheet">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">
     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
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

  <!-- =======================================================
  * Template Name: Logis
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top sticked">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="uploads/received_347587078009688.jpeg" alt="">
        <h1>Light Water</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="test.php" class="active">Home</a></li>
          <!-- <li><a href="about.html">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="pricing.html">Pricing</a></li> -->
          <?php 
            $cat_qry = $conn->query("SELECT * FROM categories where status = 1  limit 3");
            $count_cats =$conn->query("SELECT * FROM categories where status = 1 ")->num_rows;
            while($crow = $cat_qry->fetch_assoc()):
              $sub_qry = $conn->query("SELECT * FROM sub_categories where status = 1 and parent_id = '{$crow['id']}'");
              if($sub_qry->num_rows <= 0):
          ?>
          <li><a href="./?p=products&c=<?php echo md5($crow['id']) ?>"><?php echo $crow['category'] ?></a></li>
          <?php else: ?>
          <li class="dropdown"><a href="#"><span><?php echo $crow['category'] ?></span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <?php while($srow = $sub_qry->fetch_assoc()): ?>
              <li><a href="./?p=products&c=<?php echo md5($crow['id']) ?>&s=<?php echo md5($srow['id']) ?>"><?php echo $srow['sub_category'] ?></a></li>
              <?php endwhile; ?>
            </ul>
          </li>
          <?php endif; ?>
          <?php endwhile; ?>
          <!-- <li class="dropdown"><a href="#"><span>Retail</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="#">Slim</a></li>
              <li><a href="#">Round</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Brand New</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="#">RGallon</a></li>
              <li><a href="#">SGallon</a></li>
            </ul>
          </li> -->
          <?php if($count_cats > 3): ?>
            <li><a href="./?p=view_categories">All Categories</a></li>
          <?php endif; ?>
          <li><a href="#about" >About</a></li>
           <li>
              <div>
                <?php if(!isset($_SESSION['userdata']['id'])): ?>
                <a class="get-a-quote" id="login-btn" type="button"  data-bs-toggle="modal" data-bs-target="#exampleModal">Login</a>
                <?php else: ?>
                <a class="text-light nav-link" href="./?p=cart">
                <i class="bi-cart-fill me-1"></i>
                Cart
                <span class="badge bg-info text-white ms-1 rounded-pill" id="cart-count">
                <?php 
                  if(isset($_SESSION['userdata']['id'])):
                    $count = $conn->query("SELECT SUM(quantity) as items from `cart` where client_id =".$_settings->userdata('id'))->fetch_assoc()['items'];
                    echo ($count > 0 ? $count : 0);
                  else:
                    echo "0";
                  endif;
                ?>
                </span>
                </a>
              </div>
            </li> 
            <li>
              <a href="./?p=my_account" class="text-light  nav-link"><b> Hi, <?php echo $_settings->userdata('firstname')?>!</b></a>
            </li>
            <li>
              <a href="logout.php" class="get-a-quote2" type="button" >Logout</a>
            </li>
            <?php endif; ?>
        </ul>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
  <!-- End Header -->
  <!-- Modal -->
  <!-- Modal -->
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
                    <a type="button" id="create_account" class="btn btn-link">Create Account</a>
                    <a href="phpmailer/forgot_password.php" class="btn btn-link">Forgot Password?</a>
                    <button type="submit" class="btn btn-primary btn-flat">Login</button>
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
                        alert("Login Successfully", 'success');
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
  
  