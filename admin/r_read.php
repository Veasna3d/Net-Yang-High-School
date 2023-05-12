<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ../404.php');
}
?>

<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-5 pt-2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1>របាយការណ៍អានសៀវភៅ</h1> -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">របាយការណ៍អានសៀវភៅ</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                <h2>របាយការណ៍អានសៀវភៅ</h2>
                            </div>
                            <div class="d-flex justify-content-around pt-3">
                                <div class="col-9">
                                    <div class="d-flex">
                                        <input type="text" class="form-control text-center" id="date1" placeholder="dd-MM-yy"> _ <input type="text"
                                            class="form-control text-center" id="date2" placeholder="dd-MM-yy">
                                        <div>
                                            <button type="button" class="btn btn-primary" id="btnsearch">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableId" class="table table-hover">
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php include 'includes/footer.php' ?>
<script src="./js/r_read.js"></script>
<script>
    $("#date1").datepicker({
        dateFormat: "dd-MM-yy",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "2023:2030",
        defaultDate: new Date(),
        gotoCurrent: true
    });
    $("#date2").datepicker({
        dateFormat: "dd-MM-yy",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "2023:2030",
        defaultDate: new Date(),
        gotoCurrent: true
    });
</script>
