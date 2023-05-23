<?php
session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../404.php');
}

include 'includes/timezone.php';
?>


<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-5 pt-2">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">ទំព័រដើម</li>
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
                            <?php
                            $sql = "SELECT SUM(qty) as total FROM Import";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            $total = $result['total'];
                            echo "<h3>" . $total . " <sup style='font-size: 20px'>ក្បាល</sup></h3>";
                            ?>

                            <p>ចំនួនសៀវភៅសរុប</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <a href="import.php" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $sql = "SELECT * FROM Category";
                            $query = $conn->query($sql);
                            $total_rows = $query->rowCount();

                            echo "<h3>" . $total_rows . "</h3>";
                            ?>
                            <p>ប្រភេទនៃសៀវភៅ</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-server"></i>
                        </div>
                        <a href="category.php" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                           $sql = "SELECT COUNT(bookId) AS time_student_borrow FROM borrow WHERE studentId IS NOT NULL;";
                           $query = $conn->query($sql);
                           $row = $query->fetch(PDO::FETCH_ASSOC);
                           $total_rows = $row['time_student_borrow'];
                           
                           echo "<h3>" . $total_rows . "</h3>";                           
                            ?>

                            <p>ចំនួនសិស្សដែលបានខ្ចីសរុប</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="student.php" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                              $sql = "SELECT COUNT(bookId) AS time_teacher_borrow FROM borrow WHERE teacherId IS NOT NULL;";
                              $query = $conn->query($sql);
                              $row = $query->fetch(PDO::FETCH_ASSOC);
                              $total_rows = $row['time_teacher_borrow'];
                              
                              echo "<h3>" . $total_rows . "</h3>";  
                            ?>

                            <p>ចំនួនគ្រូដែលបានខ្ចីសរុប</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="teacher.php" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Monthly Transaction Report</h3>
                    <div class="card-tools pull-right">
                        <form class="form-inline">
                            <div class="form-group me-2">
                                <label for="select_year">Select Year:</label>
                                <select class="form-control" id="select_year">
                                    <?php for ($i = 2023; $i <= 2026; $i++) { ?>
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
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
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
        $sql = "SELECT id, bookId, studentId FROM borrow WHERE MONTH(createdAt) = :month AND YEAR(createdAt) = :year AND status=1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['month' => $month, 'year' => $year]);
        array_push($return, $stmt->rowCount());

        $sql = "SELECT id, bookId, studentId FROM borrow WHERE MONTH(createdAt) = :month AND YEAR(createdAt) = :year AND status=0";
        $stmt = $conn->prepare($sql);
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
    $(document).ready(function() {
        var areaChartData = {
            labels: <?php echo $months; ?>,
            datasets: [{
                    label: 'បានសង',
                    backgroundColor: 'rgba(53, 240, 195, 0.8)',
                    borderColor: 'rgba(255, 161, 0, 1)',
                    data: [10, 20, 30, 40, 50, 60, 70],
                    data: <?php echo $borrow; ?>
                },
                {
                    label: 'បានខ្ចី',
                    backgroundColor: 'rgba(3, 189, 66, 0.8)',
                    borderColor: 'rgba(255, 161, 0, 1)',
                    data: [30, 50, 20, 60, 40, 80, 10],
                    data: <?php echo $return; ?>
                }
            ]
        };

        var barChartCanvas = document.getElementById('barChart').getContext('2d');
        var barChartData = JSON.parse(JSON.stringify(areaChartData));
        var temp0 = areaChartData.datasets[0];
        var temp1 = areaChartData.datasets[1];
        barChartData.datasets[0] = temp1;
        barChartData.datasets[1] = temp0;

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });



    $(function() {
        $('#select_year').change(function() {
            window.location.href = 'index.php?year=' + $(this).val();
        });
    });
</script>