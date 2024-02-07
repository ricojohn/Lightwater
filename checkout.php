<?php
if(isset($_GET['price'])){
    $price = $_GET['price'];
    $product_id = $_GET['id'];
    $qty = $_GET['qty'];
    $count_cart = $_GET['count_cart'];

    $total = $price * $qty;

} else {
    $total = '0';
    $qry = $conn->query("SELECT c.quantity, i.price FROM `cart` c INNER JOIN `products` i ON i.id=c.stat_id WHERE c.client_id = ".$_settings->userdata('id'));
    while($row = $qry->fetch_assoc()){
        $total += $row['price'] * $row['quantity'];
    }
}
?>
   
<section class="py-5 mt-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body"></div>
            <h3 class="text-center"><b>Checkout</b></h3>
            <hr class="border-dark">
            <form action="" id="place_order">
                <?php
                if(isset($_GET['price'])){
                ?>
                <input type="hidden" name="amount" value="<?php echo $total ?>">
                <input type="hidden" name="payment_method" value="cod">
                <input type="hidden" name="count_cart" value="<?php echo $count_cart ?>">
                <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                <input type="hidden" name="price" value="<?php echo $price ?>">
                <input type="hidden" name="quantity" value="<?php echo $qty ?>">
                <input type="hidden" name="paid" value="0">
                <?php
                }else{
                ?>
                <input type="hidden" name="amount" value="<?php echo $total ?>">
                <input type="hidden" name="payment_method" value="cod">
                <input type="hidden" name="paid" value="0">
                <input type="hidden" name="count_cart" value="0">
                <?php
                }
                ?>
                
                <div class="row row-col-1 justify-content-center">
                    <div class="col-6">
                    <div class="form-group col mb-0">
                    <label for="" class="control-label">Order Type</label>
                    </div>
                    <div class="form-group d-flex pl-2">
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input custom-control-input-primary" type="radio" id="customRadio4" name="order_type" value="2" checked="">
                          <label for="customRadio4" class="custom-control-label">For Delivery</label>
                        </div>
                        <div class="custom-control custom-radio ml-3">
                          <input class="custom-control-input custom-control-input-primary custom-control-input-outline" type="radio" id="customRadio5" name="order_type" value="1">
                          <label for="customRadio5" class="custom-control-label">For Pick up</label>
                        </div>
                      </div>
                        <div class="form-group col address-holder">
                            <label for="" class="control-label">Delivery Address</label>
                            <textarea id="" cols="30" rows="3" name="delivery_address" class="form-control" style="resize:none"><?php echo $_settings->userdata('default_delivery_address') ?></textarea>
                        </div>
                        <div class="col">
                            <span><h4><b>Total:</b> <?php echo number_format($total) ?></h4></span>
                        </div>
                        <hr>
                        <div class="col my-3">
                        <h4 class="text-muted">Payment Method</h4>
                            <div class="d-flex w-100 justify-content-between">
                                <button class="btn btn-flat btn-primary">Cash on Delivery</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>

$(function(){
    $('[name="order_type"]').change(function(){
        if($(this).val() ==1){
            $('.address-holder').hide('slow')
        }else{
            $('.address-holder').show('slow')
        }
    })
    $('#place_order').submit(function(e){
        e.preventDefault()
        start_loader();
        $.ajax({
            url:'classes/Master.php?f=place_order',
            method:'POST',
            data:$(this).serialize(),
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("an error occured 2","error")
                end_loader();
            },
            success:function(resp){
                console.log(resp)
                if(!!resp.status && resp.status == 'success'){
                    alert_toast("Order Successfully placed.","success")
                    alert("Order Successfully placed.","success")
                    setTimeout(function(){
                        location.replace('./')
                    },2000)
                }else{
                    console.log(resp)
                    alert_toast("an error occured","error")
                    end_loader();
                }
            }
        })
    })
})
</script>