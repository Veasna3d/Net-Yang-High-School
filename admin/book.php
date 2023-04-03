<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>បញ្ចីសារពើភណ្ឌ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">ផ្ទះ</a></li>
                        <li class="breadcrumb-item active">បញ្ចីសារពើភណ្ឌសៀវភៅ</li>
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
                            <!-- Button trigger modal -->
                            <button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#myModal">
                                សៀវភៅថ្មី
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableId" class="table table-bordered table-striped">
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានសៀវភៅ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txtDate">ថ្ងៃខែឆ្នាំទទួល</label>
                                <input type="text" name="txtDate" class="form-control" id="txtDate">
                            </div>
                            <div class="form-group">
                                <label for="ddlAuthor">អ្នកនិពន្ធ</label>
                                <select id="ddlAuthor" name="ddlAuthor" class="form-control">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txtBook">ឈ្មោះសៀវភៅ</label>
                                <input type="text" name="txtBook" class="form-control" id="txtBook">
                            </div>
                            <div class="form-group">
                                <label for="ddlAuthor">គ្រឹះស្ថានបោះពុម្ភ</label>
                                <select id="ddlAuthor" name="ddlAuthor" class="form-control">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ddlAuthor">ទីតាំងបោះពុម្ភ</label>
                                <select id="ddlAuthor" name="ddlAuthor" class="form-control">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txtPublishYear">ឆ្នាំបោះពុម្ភ</label>
                                <input type="text" name="txtPublishYear" class="form-control" id="txtPublishYear">
                            </div>

                            <div class="form-group">
                                <label for="ddlSupplier">ម្ចាស់អំណោយ</label>
                                <select id="ddlSupplier" name="ddlSupplier" class="form-control"
                                    aria-label="Default select example">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txtPrice">តម្លៃ</label>
                                <input type="number" name="txtPrice" class="form-control" id="txtPrice">
                            </div>
                            <div class="form-group">
                                <label for="txtQty">សម្គាល់</label>
                                <input type="number" name="txtQty" class="form-control" id="txtQty">
                            </div>
                            <div class="form-group">
                                <label for="ddlCategory">លេខបញ្ជី</label>
                                <select id="ddlCategory" name="ddlCategory" class="form-control"
                                    aria-label="Default select example">
                                    <option selected>ជ្រើសរើស</option>
                                </select>
                            </div>

                        </div>
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
<script src="./js/book.js"></script>
<script>
$("#txtPublishYear").datepicker({
    dateFormat: "yy",
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "c-10:c+10" // Optional, limits the year range available to select
});
$("#txtDate").datepicker({
    dateFormat: "dd-MM-yy",
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "c-10:c+10" // Optional, limits the year range available to select
});
</script>