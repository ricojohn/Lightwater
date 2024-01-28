
          <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Orders</span>
                <span class="info-box-number text-right">
                  <?php 
                   $pending = $conn->query("SELECT COUNT(*) as total FROM orders WHERE status = '0' AND paid = '0'")->fetch_assoc()['total'];
                   echo number_format($pending);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Sales</span>
                <span class="info-box-number text-right">
                <?php
                    $querySales = "SELECT SUM(amount) AS total FROM orders WHERE status = '3'|| '5' AND paid = '1'";
                    $resultSales = $conn->query($querySales);

                    // Check if the query was successful
                    if (!$resultSales) {
                        die("Error in query: " . $conn->error);
                    }

                    // Fetch the total sales
                    $row = $resultSales->fetch_assoc();

                    // Check if any rows were returned
                    if ($row === null) {
                        die("No results returned for the query: $querySales");
                    }

                    // Display the total sales
                    echo number_format($row['total']);
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
</div>
