<section class="py-5 mt-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Update Account Details</b></h4>
                    <a href="./?p=my_account" class="btn btn btn-dark btn-flat"><div class="fa fa-angle-left"></div> Back to Order List</a>
                </div>
                    <form action="" id="update_account">
                        <hr class="border-warning">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
                                <div class="form-group">
                                    <label for="firstname" class="control-label">Firstname</label>
                                    <input type="text" name="firstname" class="form-control form" value="<?php echo $_settings->userdata('firstname') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">Lastname</label>
                                    <input type="text" name="lastname" class="form-control form" value="<?php echo $_settings->userdata('lastname') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="" class="control-label">Contact</label>
                                    <input type="text" class="form-control form-control-sm form" name="contact" value="<?php echo $_settings->userdata('contact') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="" class="control-label">Gender</label>
                                    <select name="gender" id="" class="custom-select select" required>
                                        <option <?php echo $_settings->userdata('gender') == "Male" ? "selected" : '' ?>>Male</option>
                                        <option <?php echo $_settings->userdata('gender') == "Female" ? "selected" : '' ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                            <?php 
                            $add = $_settings->userdata('default_delivery_address');
                            $explode = explode(",",$add);
                            ?>
                            <div class="col-md-6 col-lg-2" >
                                <div class="form-group ">
                                    <label for="" class="control-label">Default Delivery Address</label>
                                    <input type="text" class="form-control form-control-sm form" name="province" value="<?php echo end($explode);?>" readonly style="background-color: #343a40;">
                                    <input type="hidden" class="form-control form" rows='3' name="default_delivery_address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group">
                                    <div class="form-group ">
                                        <label for="" class="control-label">City</label>
                                        <input type="hidden" name='real_city' id='real_city'>
                                        <?php 
                                        // Fetch all cities
                                        $conn = mysqli_connect("localhost", "root", "", "light_water_db");
                                        $get_city = "SELECT * FROM refcitymun WHERE provCode = '0421'";
                                        $get_city_result = $conn->query($get_city);
                                        ?>
                                        <select type="text" class="form-select form-select-sm form" id="city" name="city" required>
                                            <option value="<?php echo $explode[3];?>"><?php echo $explode[3];?></option>
                                            <?php 
                                                while($row = $get_city_result->fetch_assoc()){
                                                    $citymunCode = strtolower($row['citymunCode']);
                                                    $citymunDesc = strtolower(utf8_decode($row['citymunDesc']));
                                                    echo "<option value='".$citymunCode."' >".ucwords(utf8_encode($citymunDesc))."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3" >
                                <div class="form-group ">
                                <label for="" class="control-label">Brgy</label>
                                    <select class="form-select form-select-sm form" id="brgy" name="brgy" required style="background-color: #343a40;" >
                                        <option value="<?php echo $explode[2];?>"><?php echo $explode[2];?></option>
                                    </select>
                                    <!-- <input type="text" class="form-control form-control-sm form" id="brgy" name="brgy" placeholder="Barangay"> -->
                                    <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-2" >
                                <div class="form-group ">
                                    <label for="" class="control-label">Street</label>
                                    <input type="text" class="form-control form-control-sm form" id="street" name="street" placeholder="Street" required value='<?php echo $explode[1];?>' style="background-color: #343a40;">
                                    <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-2" >
                                <div class="form-group ">
                                    <label for="" class="control-label">House No.</label>
                                    <input type="text" class="form-control form-control-sm form" id="housenum" name="housenum" placeholder="House No." required value='<?php echo $explode[0];?>' style="background-color: #343a40;">
                                    <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="text" name="email" class="form-control form" value="<?php echo $_settings->userdata('email') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="password" class="control-label">New Password</label>
                                    <input type="password" name="password" class="form-control form" value="" placeholder="(Enter value to change password)">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="cpassword" class="control-label">Current Password</label>
                                    <input type="password" name="cpassword" class="form-control form" value="" placeholder="(Enter value to change password)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group d-flex justify-content-end">
                                    <button class="btn btn-dark btn-flat">Update</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
            </div>
        </div>
    </div>
</section>
<script>
$(function(){
        $('#update_account [name="password"],#update_account [name="cpassword"]').on('input',function(){
            if($('#update_account [name="password"]').val() != '' || $('#update_account [name="cpassword"]').val() != '')
            $('#update_account [name="password"],#update_account [name="cpassword"]').attr('required',true);
            else
            $('#update_account [name="password"],#update_account [name="cpassword"]').attr('required',false);
        })
        $('#update_account').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=update_account",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Account succesfully updated",'success');
                        $('#update_account [name="password"],#update_account [name="cpassword"]').attr('required',false);
                        $('#update_account [name="password"],#update_account [name="cpassword"]').val('');

                        window.location.href = "http://localhost/lightwater/logout.php";
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('#update_account').prepend(_err_el)
                        $('body, html').animate({scrollTop:0},'fast')
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    }
                    end_loader()
                }
            })
        })
    })
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
</script>