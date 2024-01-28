<style>
    #uni_modal .modal-content>.modal-footer, #uni_modal .modal-content>.modal-header {
        display: none;
    }

    #readMoreModal .modal-content {
        margin-top: 20px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <h3 class="float-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h3>
        <div class="col-lg-12">
            <h3 class="text-center">Login</h3>
            <hr>
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
                    <a href="forgot_password.php">Forgot Password?</a>
                    <button type="submit" class="btn btn-primary btn-flat">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    
    $(function () {
        $('#create_account').click(function () {
            uni_modal("", "registration.php", "mid-large");
        });

        $(document).on('click', '.password-toggle', function () {
            var passwordField = $(this).closest('.input-group').find('input');
            var fieldType = passwordField.attr('type');
            var newType = (fieldType === 'password') ? 'text' : 'password';
            passwordField.attr('type', newType);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
        $(document).ready(function () {
            $('form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'forgot_password.php',
                    data: $('form').serialize(),
                    success: function (response) {
                        $('p').text(response);
                    },
                    error: function () {
                        $('p').text('Error sending request');
                    }
                });
            });
        });

        $('#login-form').submit(function (e) {
            e.preventDefault();
            start_loader();

            var formData = $(this).serialize();
            $.ajax({
                url: _base_url_ + "classes/Login.php?f=login_user",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
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
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    }
                },
                error: function (err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            });
        });
    });
</script>
