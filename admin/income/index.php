<style>
    table td, table th {
        padding: 3px !important;
    }
</style>

<?php
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get date range for the report
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d", strtotime(date("Y-m-d") . " -7 days"));
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");

// Calculate total sales
$totalSales = 0;
$querySales = "SELECT COALESCE(SUM(total_amount), 0) AS total FROM `sales` s JOIN orders o ON s.order_id = o.id WHERE date(s.date_created) BETWEEN '{$date_start}' AND '{$date_end}' AND o.paid = 1";
$resultSales = $conn->query($querySales);
if ($rowSales = $resultSales->fetch_assoc()) {
    $totalSales = $rowSales['total'];
}

// Calculate total expenses
$totalExpenses = 0;
$queryExpenses = "SELECT COALESCE(SUM(amount), 0) AS total FROM expenses WHERE date BETWEEN '{$date_start}' AND '{$date_end}'";
$resultExpenses = $conn->query($queryExpenses);
if ($rowExpenses = $resultExpenses->fetch_assoc()) {
    $totalExpenses = $rowExpenses['total'];
}

// Calculate total income
$totalIncome = $totalSales - $totalExpenses;
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Income Report</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Date Start</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d", strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start">Date End</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d", strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </form>
        <hr>
        <div id="printable">
            <div>
                <h4 class="text-center m-0"><?php echo $_settings->info('name') ?></h4>
                <h3 class="text-center m-0"><b>Income Report</b></h3>
                <p class="text-center m-0">Date Between <?php echo $date_start ?> and <?php echo $date_end ?></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="50%">
                    <col width="50%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Total Sales</th>
                        <th>Total Expenses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-right"><?php echo number_format($totalSales) ?></td>
                        <td class="text-right"><?php echo number_format($totalExpenses) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Income</th>
                        <th class="text-right"><?php echo number_format($totalIncome) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<noscript>
    <style>
        .m-0 {
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .table {
            border-collapse: collapse;
            width: 100%
        }

        .table tr,
        .table td,
        .table th {
            border: 1px solid gray;
        }
    </style>
</noscript>
<script>
    $(function () {
        $('#filter-form').submit(function (e) {
            e.preventDefault()
            location.href = "./?page=income&date_start=" + $('[name="date_start"]').val() + "&date_end=" + $('[name="date_end"]').val()
        })

        $('#printBTN').click(function () {
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            rep.prepend(ns)
        })
    })
</script>
        