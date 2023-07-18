<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ../404.php');
}
?>
<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mt-5 pt-2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>សៀវភៅ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">សៀវភៅ</li>
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានសៀវភៅ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="col-12 form-group">
                                <label for="txtBookNumber">សារពើភណ្ឌ</label>
                                <input type="number" name="txtBookNumber" class="form-control" id="txtBookNumber">
                            </div>

                            <div class="form-group d-flex">
                                <div class="col-10">
                                    <label for="ddlPrint">គ្រឹះស្ថាន នឹង​ ទីតាំងបោះពុម្ភ</label>
                                    <select id="ddlPrint" name="ddlPrint" class="form-control">
                                        <option selected>ជ្រើសរើស</option>
                                    </select>
                                </div>
                                <div class="col-2 pt-3 mt-3">
                                    <a href="./print.php" class="btn btn-sm btn-info">បន្ថែម</a>
                                </div>
                            </div>

                            <div class="col-12 form-group">
                                <label for="txtPublishYear">ឆ្នាំបោះពុម្ភ</label>
                                <select name="txtPublishYear" class="form-control" id="txtPublishYear">
                                    <!-- Generate options for years from 1900 to 2023 -->
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = 1900; $year <= $currentYear; $year++) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label for="txtPrice">តម្លៃ</label>
                                <input type="number" name="txtPrice" class="form-control" id="txtPrice">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="col-12 form-group">
                                <label for="txtBookTitle">ឈ្មោះសៀវភៅ</label>
                                <input type="text" name="txtBookTitle" class="form-control" id="txtBookTitle">
                            </div>
                            <div class="form-group d-flex">
                                <div class="col-10">
                                    <label for="ddlCategory">លេខបញ្ជី</label>
                                    <select id="ddlCategory" name="ddlCategory" class="form-control" aria-label="Default select example">
                                        <option selected>ជ្រើសរើស</option>
                                    </select>
                                </div>
                                <div class="col-2 pt-3 mt-3">
                                    <a href="./category.php" class="btn btn-sm btn-info">បន្ថែម</a>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <label for="txtAuthor">អ្នកនិពន្ធ</label>
                                <input type="text" name="txtAuthor" class="form-control" id="txtAuthor">
                            </div>


                            <div class="col-12 form-group pt-4 mt-4">
                                <label for="image" class="btn btn-outline-primary">រូបភាព</label>
                                <input type="file" name="image" id="image" class="form-control-file d-none" onchange="previewImage(event)">
                            </div>
                            <img style="height: 200px; width:150px;" id="image-preview" class="d-none">

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
                <form method="POST" action="importBook.php" enctype="multipart/form-data" id="upload_csv_form">
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
<script src="./js/book.js"></script>

<script>
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