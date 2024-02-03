<style>
    table td,table th{
        padding: 3px !important;
    }
</style>
<?php 
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] :  date("Y-m-d",strtotime(date("Y-m-d")." -7 days")) ;
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] :  date("Y-m-d",strtotime(date("Y-m-d")." +1 days")) ;
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Sales Report</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Date Start</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d",strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start">Date End</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d",strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <!-- <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-warning btn-sm" type="button" ><i class="fa fa-print"></i> Sales Invoice</button>
                </div> -->
            </div>
        </form>
        <hr>
        <div id="printable">
            <div>
                <h4 class="text-center m-0"><?php echo $_settings->info('name') ?></h4>
                <h3 class="text-center m-0"><b>Sales Report</b></h3>
                <p class="text-center m-0">Date Between <?php echo $date_start ?> and <?php echo $date_end ?></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="5">
                    <col width="5">
                    <col width="10">
                    <col width="10">
                    <col width="10">
                    <col width="10">
                    <col width="10">
                </colgroup>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>#</th>
                        <th>Date Time</th>
                        <th>Client</th>
                        <th>Order</th>
                        <th>QTY</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 0;
                    $totalQuantity = 0;
                    $totalAmount = 0;
                    $query = "SELECT *
                    FROM orders
                    INNER JOIN order_list ON orders.id = order_list.order_id
                    INNER JOIN sales ON orders.id = sales.order_id 
                    INNER JOIN clients ON orders.client_id = clients.id
                    INNER JOIN products ON order_list.product_id = products.id
                    WHERE orders.paid = '1' AND orders.date_created BETWEEN '$date_start' AND '$date_end'";
                    $run = $conn->query($query);
                    while ($row = $run->fetch_assoc()){
                        $totalQuantity += $row['quantity'];
                        $totalAmount += $row['quantity'] * $row['price'];
                ?>
                    <tr>
                        <td class="text-center">
                            <div>
                                <a href='http://localhost/Lightwater/admin/sales/print.php?orderid=<?php echo $row['order_id'] ?>' class="btn btn-warning btn-sm mt-2" type="button" ><i class="fa fa-print"></i> Sales Invoice</a>
                            </div>
                        </td>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td><?php echo $row['date_created'] ?></td>
                        <td>
                            <p class="m-0"><?php echo $row['firstname'].' '.$row['lastname'] ?></p>
                            <p class="m-0"><small>Email: <?php echo $row['email'] ?></small></p>
                        </td>
                        <td>
                            <p class="m-0"><?php echo $row['title'] ?></p>
                        </td>
                        <td class="text-center"><?php echo $row['quantity'] ?></td>
                        <td class="text-right"><?php echo number_format($row['quantity'] * $row['price']) ?></td>
                    </tr>
                <?php
                    }
                
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total:</th>
                        <th class="text-center"><?php echo $totalQuantity ?></th>
                        <th class="text-right"><?php echo number_format($totalAmount) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<noscript>
    <style>
        .m-0{
            margin:0;
        }
        .text-center{
            text-align:center;
        }
        .text-right{
            text-align:right;
        }
        .table{
            border-collapse:collapse;
            width: 100%
        }
        .table tr,.table td,.table th{
            border:1px solid gray;
        }
    </style>
</noscript>
<script>
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=sales&date_start="+$('[name="date_start"]').val()+"&date_end="+$('[name="date_end"]').val()
        })

        $('#printBTN').click(function(){
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            rep.prepend(ns)
            var nw = window.document.open('','_blank','width=900,height=600')
                nw.document.write(rep.html())
                nw.document.close()
                nw.print()
                setTimeout(function(){
                    nw.close()
                    end_loader()
                },500)
        })
    })
</script>