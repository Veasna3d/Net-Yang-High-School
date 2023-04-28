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
                    <h1>ខ្ចីសៀវភៅ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">ខ្ចីសៀវភៅ</li>
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
                <h5 class="modal-title" id="myModalLabel">ខ្ចីសៀវភៅ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ddlStudent">សិស្ស</label>
                                <select id="ddlStudent" name="ddlStudent" class="form-control">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ddlTeacher">គ្រូ</label>
                                <select id="ddlTeacher" name="ddlTeacher" class="form-control">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="ddlBook">សៀវភៅ</label>
                            <select id="ddlBook" name="ddlBook" class="form-control"
                                aria-label="Default select example">
                                <option selected>ជ្រើសរើស</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtBorrowDate">ថ្ងៃខែឆ្នាំខ្ចី</label>
                            <input type="text" name="txtBorrowDate" class="form-control" id="txtBorrowDate">
                        </div>
                        <div class="form-group">
                            <label for="txtReturnDate">ថ្ងៃខែឆ្នាំសង</label>
                            <input type="text" name="txtReturnDate" class="form-control" id="txtReturnDate">
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="កំណត់សម្គាល់" name="txtRemark" id="txtRemark"
                                style="height: 100px"></textarea>
                            <!-- <label for="floatingTextarea2">Comments</label> -->
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
<script src="./js/borrow.js"></script>
<script>
$("#txtBorrowDate").datepicker({
    dateFormat: "dd-MM-yy",
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "2023:2030",
    defaultDate: new Date() // Set the default date to today's date
});
$("#txtReturnDate").datepicker({
    dateFormat: "dd-MM-yy",
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "2023:2030",
    defaultDate: new Date() // Set the default date to today's date
});

$(document).ready(function() {
    // get references to the select elements
    const ddlStudent = $("#ddlStudent");
    const ddlTeacher = $("#ddlTeacher");

    // listen for changes on ddlStudent
    ddlStudent.change(function() {
        if (ddlStudent.val()) {
            ddlTeacher.prop("disabled", true);
        } else {
            ddlTeacher.prop("disabled", false);
        }
    });

    // listen for changes on ddlTeacher
    ddlTeacher.change(function() {
        if (ddlTeacher.val()) {
            ddlStudent.prop("disabled", true);
        } else {
            ddlStudent.prop("disabled", false);
        }
    });
});
</script>