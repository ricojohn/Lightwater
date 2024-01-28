<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `expenses` WHERE id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Expense</h3>
    </div>
    <div class="card-body">
        <form action="" id="expense-form">
            <input type="hidden" id="expense_id" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <label for="datetime" class="control-label">Expense Date and Time</label>
                <input type="datetime-local" class="form-control" id="datetime" name="date" value="<?php echo isset($date) ? date('Y-m-d\TH:i', strtotime($date)) : date('Y-m-d\TH:i'); ?>" required>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="2" class="form-control form no-resize" required><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="amount" class="control-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>" required>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="expense-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=expenses">Cancel</a>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#expense-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_expenses",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=expenses";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>
