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
                    <h1>ការនាំចូល</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">ការនាំចូល</li>
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
                <h5 class="modal-title" id="myModalLabel">ការនាំចូល</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="form-group">
                        <label for="txtReceivedDate">ថ្ងៃខែឆ្នាំទទួល</label>
                        <input type="text" name="txtReceivedDate" class="form-control" id="txtReceivedDate">
                    </div>
                    <div class="form-group">
                        <label for="ddlBook">ឈ្មោះសៀវភៅ</label>
                        <select id="ddlBook" name="ddlBook" class="form-control">
                            <option selected>ជ្រើសរើស</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ddlSupplier">ម្ចាស់អំណោយ</label>
                        <select id="ddlSupplier" name="ddlSupplier" class="form-control"
                            aria-label="Default select example">
                            <option selected>ជ្រើសរើស</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtQty">ចំនួនសៀវភៅ</label>
                        <input type="number" name="txtQty" class="form-control" id="txtQty">
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
<script src="./js/import.js"></script>
<script>
$("#txtReceivedDate").datepicker({
  dateFormat: "dd-MM-yy",
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
  yearRange: "2020:2030",
  defaultDate: new Date() // Set the default date to today's date
});

// Set the datepicker to today's date
$("#txtReceivedDate").datepicker("setDate", new Date());

</script>