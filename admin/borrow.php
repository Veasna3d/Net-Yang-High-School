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
<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <div class="form-group d-flex">
                                <div class="col-10">
                                    <label for="ddlStudent">សិស្ស</label>
                                    <select id="ddlStudent" name="ddlStudent" class="">
                                        <option selected>ជ្រើសរើស</option>
                                    </select>
                                </div>
                                <div class="col-2 pt-3 mt-3">
                                    <a href="./student.php" class="btn btn-sm btn-info">បន្ថែម</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group d-flex">
                                <div class="col-10">
                                    <label for="ddlTeacher">គ្រូ</label>
                                    <select id="ddlTeacher" name="ddlTeacher" class="">
                                        <option selected>ជ្រើសរើស</option>
                                    </select>
                                </div>
                                <div class="col-2 pt-3 mt-3">
                                    <a href="./teacher.php" class="btn btn-sm btn-info">បន្ថែម</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group d-flex">
                            <div class="col-11">
                                <label for="ddlBook">សៀវភៅ</label>
                                <select id="ddlBook" name="ddlBook" class="">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>
                            <div class="col-1 pt-3 mt-3">
                                <a href="./book.php" class="btn btn-sm btn-info">បន្ថែម</a>
                            </div>
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtBorrowDate">ថ្ងៃខែឆ្នាំខ្ចី</label>
                            <input type="text" name="txtBorrowDate" class="form-control" id="txtBorrowDate">
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtReturnDate">ថ្ងៃខែឆ្នាំសង</label>
                            <input type="text" name="txtReturnDate" class="form-control" id="txtReturnDate">
                        </div>
                        <div class="col-12 form-floating">
                            <textarea class="form-control" placeholder="កំណត់សម្គាល់" name="txtRemark" id="txtRemark" style="height: 100px"></textarea>
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
    var currentDate = new Date();

    $("#txtBorrowDate").datepicker({
            dateFormat: "dd-MM-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2023:2030",
            // minDate: currentDate,
            // maxDate: currentDate
        }).datepicker("setDate", currentDate) // Auto-select the current date
        // .on("change", function() {
        //     $(this).datepicker("option", "dateFormat", "dd-MM-yy").datepicker("setDate", $(this).datepicker("getDate"));
        //     $(this).attr("readonly", true);
        // });



    var returnDate = new Date(currentDate);
    returnDate.setDate(returnDate.getDate() + 7);

    $("#txtReturnDate").datepicker({
            dateFormat: "dd-MM-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "2023:2030",
            // minDate: currentDate
        }).datepicker("setDate", returnDate) // Auto-select the date that is 7 days after the current date
        // .on("change", function() {
        //     $(this).datepicker("option", "dateFormat", "dd-MM-yy").datepicker("setDate", $(this).datepicker("getDate"));
        //     $(this).attr("readonly", true);
        // });

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