<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header('Location: ../404.php');
    }
?>
<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-5 pt-2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>អានសៀវភៅ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">អានសៀវភៅ</li>
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
                            <table id="tableId" class="table table-bordered table-hover">
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

<!-- Modal Insert & Update -->
<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានសិស្ស</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="form-group d-flex">
                        <div class="col-11">
                        <label for="ddlStudent">សិស្ស</label>
                        <select id="ddlStudent" name="ddlStudent" class="form-control">
                            <option selected>ជ្រើសរើសសិស្ស</option>
                        </select>
                        </div>
                        <div class="col-1 pt-3 mt-3">
                            <a href="./student.php" class="btn btn-sm btn-info">បន្ថែម</a>
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <label for="txtDate">កាលបរិច្ឆេទ</label>
                        <input type="text" name="txtDate" class="form-control" id="txtDate">
                    </div>
                    <div class="form-group d-flex">
                        <div class="col-11">
                            <label for="ddlBook">ឈ្មោះសៀវភៅ</label>
                            <select id="ddlBook" name="ddlBook" class="form-control">
                                <option selected>ជ្រើសរើស</option>
                            </select>
                        </div>
                        <div class="col-1 pt-3 mt-3">
                            <a href="./book.php" class="btn btn-sm btn-info">បន្ថែម</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">បិទ</button>
                        <button type="button" class="btn btn-primary" id="btnSave">រក្សាទុក</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<?php include 'includes/footer.php' ?>
<script src="./js/read.js"></script>
<script>
 jQuery(document).ready(function() {
            'use strict';

            // Get the current date and time
            var currentDate = new Date();

            // Format the date and time as needed for the datetimepicker
            var formattedDate = currentDate.getFullYear() + "-" + 
                               ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + 
                               ("0" + currentDate.getDate()).slice(-2) + " " + 
                               ("0" + currentDate.getHours()).slice(-2) + ":" + 
                               ("0" + currentDate.getMinutes()).slice(-2) + " " + 
                               (currentDate.getHours() >= 12 ? "PM" : "AM");

            // Set the initial value of the "txtDate" input field to the current date and time
            jQuery('#txtDate').val(formattedDate);

            // Initialize the datetimepicker on the "txtDate" input field
            jQuery('#txtDate').datetimepicker();
        });
</script>