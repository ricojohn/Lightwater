<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Jar</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" class="btn btn-flat btn-primary add_new"><span class="fas fa-plus"></span> Add New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-stripped">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="25%">
                    <col width="35%">
                </colgroup>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date Created</th>
                    <th>Jar</th>
                    <th>Description</th>
     
                </tr>
                </thead>
                <tbody>
                <?php 
                $i = 1;
                $qry = $conn->query("SELECT * FROM `products` WHERE id IN (SELECT product_id FROM `featured_Jar` WHERE is_deleted = 0) ORDER BY UNIX_TIMESTAMP(date_created) DESC ");
                while($row = $qry->fetch_assoc()):
                    foreach($row as $k=> $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                        <td><?php echo $row['title'] ?></td>
                        <td><p class="m-0 truncate"><?php echo $row['description'] ?></p></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to remove this featured Jar from the list?","delete_featured",[$(this).attr('data-id')])
        })
        $('.add_new').click(function(){
            uni_modal("Add Jar to Featured Page","featured/add_Jar.php")
        })
        $('.table').dataTable();
    })
    function delete_featured($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=soft_delete_featured",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occurred.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occurred.",'error');
                    end_loader();
                }
            }
        })
    }
</script>