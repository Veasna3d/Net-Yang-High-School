<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>របាយការណ៍</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">របាយការណ៍</a></li>
                        <li class="breadcrumb-item active">ការខ្ចីរបស់សិស្ស​​​​​​​​​​​​​​​​</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p>
                                ថ្ងៃ : <input type="date" id="date1"> ដល់ <input type="date" id="date2">
                                <button type="button" class="btn btn-primary" id="btnsearch">ស្វែងរក</button>
                            </p>
                            <h2 style="text-align: center;">របាយការណ៍ខ្ចីរបស់សិស្ស</h2>
                            <table id="tableId" class="table table-bordered">
                            </table>
                            <div id="div_print">
                                <p id="showdate">...</p>
                                <div id="display">content.........</div>
                                <h1>&nbsp;</h1>
                            </div>
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
<script src="./js/r_borrow.js"></script>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>