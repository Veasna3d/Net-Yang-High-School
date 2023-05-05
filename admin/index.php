<?php
$dsn = 'mysql:host=localhost;dbname=netyangdb';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

include 'includes/timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}


?>

<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Monthly Transaction Report</h3>
                    <div class="card-tools pull-right">
                        <form class="form-inline">
                            <div class="form-group me-2">
                                <label for="select_year">Select Year:</label>
                                <select class="form-select form-select-sm" id="select_year">
                                    <?php for ($i = 2022; $i <= 2025; $i++) { ?>
                                    <?php $selected = ($i == $year) ? 'selected' : ''; ?>
                                    <option value="<?php echo $i ?>" <?php echo $selected ?>><?php echo $i ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>


            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'includes/footer.php' ?>
<?php
    $and = 'AND YEAR(date) = :year';
    $months = array();
    $return = array();
    $borrow = array();
    for ($m = 1; $m <= 12; $m++) {
        $month = str_pad($m, 2, 0, STR_PAD_LEFT);
        $sql = "SELECT id, bookId, studentId FROM borrow WHERE MONTH(STR_TO_DATE(returnDate, '%Y-%m-%d')) = :month 
        AND YEAR(STR_TO_DATE(returnDate, '%Y-%m-%d')) = :year AND status=1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['month' => $month, 'year' => $year]);
        array_push($return, $stmt->rowCount());

        $sql = "SELECT id, bookId, studentId FROM borrow WHERE MONTH(STR_TO_DATE(borrowDate, '%Y-%m-%d')) = :month 
        AND YEAR(STR_TO_DATE(borrowDate, '%Y-%m-%d')) = :year  AND status=0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['month' => $month, 'year' => $year]);
        array_push($borrow, $stmt->rowCount());

        $month_name = date('M', mktime(0, 0, 0, $m, 1));
        array_push($months, $month_name);
    }

    $months = json_encode($months);
    $return = json_encode($return);
    $borrow = json_encode($borrow);

    ?>


<!-- End Chart Data -->

<script>
$(function() {
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: {
            labels: <?php echo $months; ?>,
            datasets: [{
                    label: 'Borrow',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    borderWidth: 1,
                    data: <?php echo $borrow; ?>
                },
                {
                    label: 'Return',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    borderWidth: 1,
                    data: <?php echo $return; ?>
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        color: 'rgba(0,0,0,.05)',
                        lineWidth: 1
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
    document.getElementById('legend').innerHTML = barChart.generateLegend();
});


$(function() {
    $('#select_year').change(function() {
        window.location.href = 'index.php?year=' + $(this).val();
    });
});
</script>