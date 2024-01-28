<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
    .password-toggle {
        cursor: pointer;
    }
</style>
<!-- <style>
  .ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
  .ui-front {
    z-index: 5000!important;
  }
  </style> -->

<div class="container-fluid">
    <form action="" id="registration">
        <div class="row">
        
        <h3 class="text-center">Create New Account
            <span class="float-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </h3>
            <hr>
        </div>
        <div class="row  align-items-center h-100">
            
            <div class="col-lg-5 border-right">
                
                <div class="form-group">
                    <label for="" class="control-label">Firstname</label>
                    <input type="text" class="form-control form-control-sm form" name="firstname" required placeholder="Firstname">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Lastname</label>
                    <input type="text" class="form-control form-control-sm form" name="lastname" required placeholder="Lastname">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Contact</label>
                    <input type="text" class="form-control form-control-sm form" name="contact" required placeholder="+63">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Gender</label>
                    <select name="gender" id="" class="custom-select select" required>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-7">
                <label for="" class="control-label">Default Delivery Address</label>
                <div class="row">
                    <div class="col-lg-4 col-sm-12" >
                        <div class="form-group ">
                            <input type="text" class="form-control form-control-sm form" name="province" value="Cavite" readonly style="background-color: #343a40;">
                            <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12" >
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
                    <div class="col-lg-4 col-sm-12" >
                        <div class="form-group ">
                            <select class="form-select form-select-sm form" id="brgy" name="brgy" required>
                                <option value="">- Select Brgy -</option>
                            </select>
                            <!-- <input type="text" class="form-control form-control-sm form" id="brgy" name="brgy" placeholder="Barangay"> -->
                            <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12" >
                        <div class="form-group ">
                            <input type="text" class="form-control form-control-sm form" id="street" name="street" placeholder="Street" required>
                            <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12" >
                        <div class="form-group ">
                            <input type="text" class="form-control form-control-sm form" id="housenum" name="housenum" placeholder="House No." required>
                            <!-- <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea> -->
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form-control-sm form" name="email" required placeholder="Email">
                </div>
                <div class="form-group">
                <label for="" class="control-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control form-control-sm form" name="password" required placeholder="Password">
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle"><i class="fa fa-eye-slash"></i></span>
                    </div>
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

        <div class="form-group d-flex justify-content-between">
            <a href="javascript:void()" id="login-show">Already have an Account</a>
            <button class="btn btn-primary btn-flat">Register</button>
        </div>
    </form>
</div>
<div class="modal fade" id="readMoreModal" tabindex="-1" role="dialog" aria-labelledby="readMoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="readMoreModalLabel">Data Privacy Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>We respect and value your privacy at LightWater. This Data Privacy Policy outlines how we collect, use, share, and protect your personal information. By using our services, you agree to the terms of this policy.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
        start_loader();

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
            url: _base_url_ + "classes/Master.php?f=register",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("Account successfully registered", 'success');
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert_toast("Account successfully registered", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else if (resp.status == 'failed' && !!resp.msg) {
                    var _err_el = $('<div>')
                    _err_el.addClass("alert alert-danger err-msg").text(resp.msg);
                    $('[name="email"]').after(_err_el);
                    end_loader();
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