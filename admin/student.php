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
                    <h1>ចំនួនសិស្សសរុប</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">សិស្សទាំងអស់</li>
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានសិស្ស</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">

                    <div class="d-flex">
                        <div class="col-6">
                            <div class="col-12 form-group">
                                <label for="">ពីឆ្នាំ</label>
                                <select name="txtStartYear" class="form-control" id="txtStartYear">
                                    <!-- Generate options for years from 1900 to 2023 -->
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = 2000; $year <= $currentYear; $year++) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="col-12 form-group">
                                <label for="">ដល់ឆ្នាំ</label>
                                <select name="txtEndYear" class="form-control" id="txtEndYear">
                                    <!-- Generate options for years from 1900 to 2023 -->
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = 2000; $year <= $currentYear; $year++) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">


                        <div class="col-12 form-group">
                            <label for="txtStudentName">ឈ្មោះ</label>
                            <input type="text" name="txtStudentName" class="form-control" id="txtStudentName">
                        </div>
                        <div class="col-12 form-group">
                            <label for="ddlGender">ភេទ</label>
                            <select id="ddlGender" name="ddlGender" class="form-control" aria-label="Default select example">
                                <option selected>ជ្រើសរើសភេទ</option>
                                <option value="ស្រី">ស្រី</option>
                                <option value="ប្រុស">ប្រុស</option>
                            </select>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-11">
                                <label for="ddlClass">ថ្នាក់</label>
                                <select id="ddlClass" name="ddlClass" class="form-control" aria-label="Default select example">
                                    <option selected>ជ្រើសរើសថ្នាក់</option>
                                </select>
                            </div>
                            <div class="col-1 pt-3 mt-3">
                                <a href="./class.php" class="btn btn-sm btn-info">បន្ថែម</a>
                            </div>
                        </div>
                        <div class="col-12 form-group">
                            <label for="txtBirthday">ថ្ងៃខែឆ្នាំកំណើត</label>
                            <input type="text" name="txtBirthday" class="form-control" id="txtBirthday">
                        </div>
                        <div class="col-12 form-group">
                            <label for="image" class="btn btn-outline-primary">រូបភាព</label>
                            <input type="file" name="image" id="image" class="form-control-file d-none" onchange="previewImage(event)">
                        </div>
                        <img style="height: 200px; width:150px;" id="image-preview" class="d-none">
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

<!-- Modal Import -->
<div class="modal fade" id="myImport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="importStudent.php" enctype="multipart/form-data" id="upload_csv_form">
                    <div class="form-group">
                        <label for="file" class="form-control btn btn-info">Upload File (CSV)</label>
                        <input type="file" name="file" id="file" class="form-control" hidden>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<?php include 'includes/footer.php' ?>
<script src="./js/student.js"></script>
<!-- <script src="./js/jquery.daterange.js"></script> -->

<script>
    $(function() {
        $("#txtBirthday").datepicker({
            dateFormat: "dd-MM-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1990:2023"
        });
    });

    //Preview Image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.getElementById('image-preview');
            img.src = reader.result;
            img.classList.remove('d-none');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>