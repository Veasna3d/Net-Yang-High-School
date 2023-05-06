<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header('Location: ../404.php');
    }
?>
<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

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
                        <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">ការខ្ចីសៀវភៅ</li>
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
                    <div class="card-header">
                        <div class="row well input-daterange">
                            <div class="col-sm-4">
                                <label class="control-label">Gender</label>
                                <select class="form-control" name="gender" id="gender" style="height: 40px;">
                                    <option value="">- Please select -</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label" for="initial_date">Start date</label>
                                <input class="form-control datepicker" type="text" name="initial_date" id="initial_date"
                                    placeholder="yyyy-mm-dd" style="height: 40px;" />
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label" for="final_date">End date</label>
                                <input class="form-control datepicker" type="text" name="final_date" id="final_date"
                                    placeholder="yyyy-mm-dd" style="height: 40px;" />
                            </div>

                            <div class="col-sm-2">
                                <button class="btn btn-success btn-block" type="submit" name="filter" id="filter"
                                    style="margin-top: 30px">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                            </div>

                            <div class="col-sm-12 text-danger" id="error_log"></div>
                        </div>
                    </div>
                    <div class="card">
                        <!-- /.card-header -->
                        <table id="fetch_users" class="table table-hover table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Date of birth</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                        </table>
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