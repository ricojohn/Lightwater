<?php 
 $products = $conn->query("SELECT * FROM `products`  where md5(id) = '{$_GET['id']}' ");
 if($products->num_rows > 0){
     foreach($products->fetch_assoc() as $k => $v){
         $$k= stripslashes($v);
     }
    $upload_path = base_app.'/uploads/product_'.$id;
    $img = "";
    if(is_dir($upload_path)){
        $fileO = scandir($upload_path);
        if(isset($fileO[2]))
            $img = "uploads/product_".$id."/".$fileO[2];
        // var_dump($fileO);
    }
    $stat = $conn->query("SELECT * FROM products where id = ".$id);
    $inv = array();
    while($ir = $stat->fetch_assoc()){
        $inv[] = $ir;
    }
 }
?>
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="mb-5 mb-md-0 bg-black border-1 img-prev rounded border" loading="lazy" id="display-img" height="500" width="600" src="<?php echo validate_image($img) ?>" alt="..." />
                <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                    <?php 
                        foreach($fileO as $k => $img):
                            if(in_array($img,array('.','..')))
                                continue;
                    ?>
                    <div class="col">
                        <a href="javascript:void(0)" class="view-image <?php echo $k == 2 ? "active":'' ?>"><img src="<?php echo validate_image('uploads/product_'.$id.'/'.$img) ?>" loading="lazy"  class="img-thumbnail" alt=""></a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6">
                <!-- <div class="small mb-1">SKU: BST-498</div> -->
                <h1 class="display-5 fw-bolder border-bottom border-primary pb-1"><?php echo $title ?></h1>
                <div class="fs-5 mb-5">
                    <?php if (!empty($inv) && isset($inv[0]['price'])): ?>
                        &#8369; <span id="price"><?php echo number_format($inv[0]['price']) ?></span>
                    <?php else: ?>
                        <span>No price available</span>
                    <?php endif; ?>
                </div>
                <form action="" id="add-cart">
                <div class="d-flex">
                    <input type="hidden" id="price_product" name="price" value="<?php echo $inv[0]['price'] ?>">
                    <input type="hidden" id="stat_id" name="stat_id" value="<?php echo $inv[0]['id'] ?>">
                    <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" name="quantity" />
                    <?php
                    if(isset($_SESSION['userdata']['id'])){
                        $count = $conn->query("SELECT SUM(quantity) as items from `cart` where client_id =".$_settings->userdata('id'))->fetch_assoc()['items'];
                    }else{
                        $count = '0';
                    }
                    ?>
                    <input type="hidden" id="count_cart" value="<?php echo $count; ?>">
                    <input type="button" class="btn btn-outline-dark flex-shrink-0" id="checkout" value="Checkout" >
                    <!-- <div class="d-flex w-100 justify-content-center"> -->
                        <!-- <a href="./?p=checkout?product_id=<?php echo $inv[0]['id'] ?>&price=<?php echo $inv[0]['price'] ?>" class="btn btn-sm btn-flat btn">Checkout</a> -->
                    <!-- </div> -->
                    
                    <button class="btn btn-outline-dark flex-shrink-0 ml-3" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Add to cart
                    </button>
                </div>
                </form>
                <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
                
            </div>
        </div>
    </div>
</section>
<!-- Related items section-->
<section class="py-5 bg-secondary">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center border-top pt-2">
        <?php 
            $products = $conn->query("SELECT * FROM `products` where status = 1 and (category_id = '{$category_id}' or sub_category_id = '{$sub_category_id}') and id !='{$id}' order by rand() limit 4 ");
            while($row = $products->fetch_assoc()):
                $upload_path = base_app.'/uploads/product_'.$row['id'];
                $img = "";
                if(is_dir($upload_path)){
                    $fileO = scandir($upload_path);
                    if(isset($fileO[2]))
                        $img = "uploads/product_".$row['id']."/".$fileO[2];
                    // var_dump($fileO);
                }
                $stat = $conn->query("SELECT * FROM products where id = ".$row['id']);
                $_inv = array();
                foreach($row as $k=> $v){
                    $row[$k] = trim(stripslashes($v));
                }
                while($ir = $stat->fetch_assoc()){
                    $_inv[] = number_format($ir['price']);
                }
                $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                ?>
            <div class="col mb-5">
                <div class="card h-100 product-item">
                    <!-- Product image-->
                    <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $row['title'] ?></h5>
                            <!-- Product price-->
                            <?php foreach($_inv as $k=> $v): ?>
                                <span><b>Price: </b><?php echo $v ?></span>
                            <?php endforeach; ?>
                            <small class="truncate border-top"><?php echo $row['description'] ?></small>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
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
<script>
    var inv = $.parseJSON('<?php echo json_encode($inv) ?>');
    
    $(function(){
        $('.view-image').click(function(){
            var _img = $(this).find('img').attr('src');
            $('#display-img').attr('src',_img);
            $('.view-image').removeClass("active")
            $(this).addClass("active")
        })

        $('.p-size').click(function(){
            var k = $(this).attr('data-id');
            $('.p-size').removeClass("active")
            $(this).addClass("active")
            $('#price').text(inv[k].price)
            $('[name="price"]').val(inv[k].price)
            $('#avail').text(inv[k].quantity)
            $('[name="stat_id"]').val(inv[k].id)
        })

        $('#checkout').click(function(){
            var price = $('#price_product').val();
            var id = $('#stat_id').val();
            var qty = $('#inputQuantity').val();
            var count_cart = $('#count_cart').val();
            location.href = "./?p=checkout&id=" + id + "&price=" + price + "&qty=" + qty + "&count_cart=" + count_cart;
             window.location.href = checkoutUrl;
             uni_modal("","login.php");
                return false;
        })

        $('#add-cart').submit(function(e){
            e.preventDefault();
            if('<?php echo $_settings->userdata('id') ?>' <= 0){
                uni_modal("","login.php");
                return false;
            }
            start_loader();
            $.ajax({
                url:'classes/Master.php?f=add_to_cart',
                data:$(this).serialize(),
                method:'POST',
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status=='success'){
                        alert_toast("Product added to cart.",'success')
                        $('#cart-count').text(resp.cart_count)
                        $('#count_cart').val(resp.cart_count)
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    }
                    end_loader();
                }
            })
        })
    })
</script>