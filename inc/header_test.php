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
  <header id="header" class="header d-flex align-items-center fixed-top">
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
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                
                <div class="form-group d-flex justify-content-between">
                    <button type="button" id="create_account" class="btn btn-link">Create Account</button>
                    <a href="phpmailer/forgot_password.php">Forgot Password?</a>
                    <button type="submit" class="btn btn-primary btn-flat">Login</button>
                </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  
  