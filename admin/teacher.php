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
                    <h1>ចំនួនគ្រូ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">គ្រូ</li>
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានគ្រូ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="form-group">
                        <label for="txtTeacherName">ឈ្មោះ</label>
                        <input type="text" name="txtTeacherName" class="form-control" id="txtTeacherName">
                    </div>
                    <div class="form-group">
                        <label for="ddlGender">ភេទ</label>
                        <select id="ddlGender" name="ddlGender" class="form-control"
                            aria-label="Default select example">
                            <option selected>ជ្រើសរើសភេទ</option>
                            <option value="ស្រី">ស្រី</option>
                            <option value="ប្រុស">ប្រុស</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtPhone">លេខទូរស័ព្ទ</label>
                        <input type="text" name="txtPhone" class="form-control" id="txtPhone">
                    </div>
                    <div class="form-group">
                        <label for="image" class="btn btn-outline-primary">រូបភាព</label>
                        <input type="file" name="image" id="image" class="form-control-file d-none">
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
<script src="./js/teacher.js"></script>
<!-- <script src="./js/jquery.daterange.js"></script> -->