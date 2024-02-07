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
                <a class="get-a-quote" id="login-btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" >Login</a>
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

  <script>
  $('#search-form').submit(function(e){
    e.preventDefault()
     var sTxt = $('[name="search"]').val()
     if(sTxt != '')
      location.href = './?p=products&search='+sTxt;
  })
</script>