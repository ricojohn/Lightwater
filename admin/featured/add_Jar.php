<?php require_once('../../config.php'); ?>
<div class="container-fluid">
<form action="" id="featured-form">
    <div class="form-group">
        <label for="product_id" class="control-label">Jar</label>
        <select name="product_id" id="product_id" class="custom-select select2">
            <option value=""></option>
            <?php 
            $qry = $conn->query("SELECT * FROM `products` where id not in (SELECT product_id from `featured_Jar`) order by title desc ");
            while($row = $qry->fetch_assoc()):
            ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
</form>
</div>
<script>
	$(document).ready(function(){
       $('.select2').select2({
           'placeholder':"Select Jar to Feature Here"
       })
       
        $('#category_id').change(function(){
            var cid = $(this).val()
            var opt = "<option></option>";
            Object.keys(sub_categories).map(k=>{
                if(k == cid){
                    Object.keys(sub_categories[k]).map(i=>{
                        if('<?php echo isset($sub_category_id) ? $sub_category_id : 0 ?>' == sub_categories[k][i].id){
                            opt += "<option value='"+sub_categories[k][i].id+"' selected>"+sub_categories[k][i].sub_category+"</option>";
                        }else{
                            opt += "<option value='"+sub_categories[k][i].id+"'>"+sub_categories[k][i].sub_category+"</option>";
                        }
                    })
                }
            })
            $('#sub_category_id').html(opt)
            $('#sub_category_id').select2({placeholder:"Please Select here",width:"relative"})
        })
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
        if(parseInt("<?php echo isset($category_id) ? $category_id : 0 ?>") > 0){
            console.log('test')
            start_loader()
            setTimeout(() => {
                $('#category_id').trigger("change");
                end_loader()
            }, 750);
        }
		$('#featured-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_featured",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>