<?php
// Assuming $conn is your database connection object

// Fetch sales data
$querySales = "SELECT id, order_id, delivery, total_amount, date_created FROM sales WHERE 1";
$salesResult = $conn->query($querySales);

// Check if the query was successful
if (!$salesResult) {
    die("Error in query: " . $conn->error);
}

// Fetch sales data grouped by day
$query = "SELECT DATE(date_created) AS date, SUM(total_amount) AS total_sales FROM sales GROUP BY DATE(date_created)";
$result = $conn->query($query);

// Initialize arrays for line charts
$dailyLabels = $dailyData = [];
$weeklyLabels = $weeklyData = [];
$monthlyLabels = $monthlyData = [];
$quarterlyLabels = $quarterlyData = [];
$yearlyLabels = $yearlyData = [];

while ($row = $result->fetch_assoc()) {
    $date = strtotime($row['date']);
    $year = date('Y', $date);
    $month = date('m', $date);
    $week = date('W', $date);

    // Daily data
    $dailyLabels[] = date('Y-m-d', $date);
    $dailyData[] = $row['total_sales'];

    // Weekly data
    $weeklyLabels[] = "Week " . $week;
    $weeklyData[] = $row['total_sales'];

    // Monthly data
    $monthlyLabels[] = date('F', $date);
    $monthlyData[] = $row['total_sales'];

    // Quarterly data
    $quarter = ceil($month / 3);
    $quarterlyLabels[] = "Q" . $quarter . " " . date('Y', $date);
    $quarterlyData[] = $row['total_sales'];

    // Yearly data
    $yearlyLabels[] = $year;
    $yearlyData[] = $row['total_sales'];
}
?>

<!-- Table to display sales data -->
<h2>Sales Data</h2>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Order ID</th>
            <th>Delivery</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while ($salesRow = $salesResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $salesRow['date_created'] ?></td>
                <td><?php echo $salesRow['order_id'] ?></td>
                <td><?php echo $salesRow['delivery'] ?></td>
                <td><?php echo number_format($salesRow['total_amount']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Daily Sales Line Chart -->
<h2>Daily Sales</h2>
<canvas id="dailyChart" width="400" height="200"></canvas>

<!-- Weekly Sales Line Chart -->
<h2>Weekly Sales</h2>
<canvas id="weeklyChart" width="400" height="200"></canvas>

<!-- Monthly Sales Line Chart -->
<h2>Monthly Sales</h2>
<canvas id="monthlyChart" width="400" height="200"></canvas>

<!-- Quarterly Sales Line Chart -->
<h2>Quarterly Sales</h2>
<canvas id="quarterlyChart" width="400" height="200"></canvas>

<!-- Yearly Sales Line Chart -->
<h2>Yearly Sales</h2>
<canvas id="yearlyChart" width="400" height="200"></canvas>

<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Function to create a line chart
    function createLineChart(canvasId, label, labels, data) {
        var ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });
    }

    // Render daily chart
    createLineChart('dailyChart', 'Daily Sales', <?php echo json_encode($dailyLabels); ?>, <?php echo json_encode($dailyData); ?>);

    // Render weekly chart
    createLineChart('weeklyChart', 'Weekly Sales', <?php echo json_encode($weeklyLabels); ?>, <?php echo json_encode($weeklyData); ?>);

    // Render monthly chart
    createLineChart('monthlyChart', 'Monthly Sales', <?php echo json_encode($monthlyLabels); ?>, <?php echo json_encode($monthlyData); ?>);

    // Render quarterly chart
    createLineChart('quarterlyChart', 'Quarterly Sales', <?php echo json_encode($quarterlyLabels); ?>, <?php echo json_encode($quarterlyData); ?>);

    // Render yearly chart
    createLineChart('yearlyChart', 'Yearly Sales', <?php echo json_encode($yearlyLabels); ?>, <?php echo json_encode($yearlyData); ?>);
</script>
<style>
    *{
        color: #FFF;
    }
</style>