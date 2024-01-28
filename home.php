
 <header class="" id="main-header">
</header>

<section class="py-3">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="mt-3 row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
                $products = $conn->query("SELECT * FROM `products` where status = 1 and id in (SELECT product_id FROM `featured_Jar`) order by Rand() ");
                while($row = $products->fetch_assoc()):
                    $upload_path = base_app.'/uploads/product_'.$row['id'];
                    $img = "";
                    if(is_dir($upload_path)){
                        $fileO = scandir($upload_path);
                        unset($fileO[0]);
                        unset($fileO[1]);
                        asort($fileO);
                        if(isset($fileO[2]))
                            $img = "uploads/product_".$row['id']."/".$fileO[2];
                        // var_dump($fileO);
                    }
                    foreach($row as $k=> $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    $stat = $conn->query("SELECT * FROM `products` WHERE id = ".$row['id']);
                    $inv = array();
                    while($ir = $stat->fetch_assoc()){
                        $inv[] = number_format($ir['price']);
                    }
                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                    ?>
            <div class="col mb-5">
                <div class="card product-item">
                    <!-- Product image-->
                    <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-2">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $row['title'] ?></h5>
                            <!-- Product price-->
                            <?php foreach($inv as $k=> $v): ?>
                                <span><b>Price: </b><?php echo $v ?></span>
                            <?php endforeach; ?>
                            <small class="truncate border-top"><?php echo $row['description'] ?></small>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-2 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary "   href=".?p=view_product&id=<?php echo md5($row['id']) ?>">View</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

