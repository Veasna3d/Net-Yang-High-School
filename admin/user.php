<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>អ្នកប្រើប្រាស់</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">ផ្ទះ</a></li>
                        <li class="breadcrumb-item active">អ្នកប្រើប្រាស់</li>
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
                                បង្កើត
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានអ្នកប្រើប្រាស់</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="name">ឈ្មោះអ្នកប្រើប្រាស់</label>
                        <input type="text" name="txtUsername" id="txtUsername" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="name">លេខសម្ងាត់</label>
                        <input type="password" name="txtPassword" id="txtPassword" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="role">ច្បាប់</label>
                        <select class="form-control" id="txtRole" name="txtRole">
                            <option value="1">Admin</option>
                            <option value="2">Editor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">អ៊ីមែល</label>
                        <input type="email" name="txtEmail" id="txtEmail" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="image">រូបភាព</label>
                        <input type="file" name="image" id="image" class="form-control-file">
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
<!-- Modal View Card-->
<div class="modal fade" id="viewData" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="viewDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDataLabel">ព័ត៌មានសិស្ស</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>


<?php include 'includes/footer.php' ?>
<script src="./js/user.js"></script>
<!-- <script src="./js/jquery.daterange.js"></script> -->

<script>
$(function() {
    $("#txtStartYear").datepicker({
        dateFormat: "yy",
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "c-10:c+10" // Optional, limits the year range available to select
    });
    $("#txtEndYear").datepicker({
        dateFormat: "yy",
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "c-10:c+10" // Optional, limits the year range available to select
    });
    $("#txtBirthday").datepicker({
        dateFormat: "dd-MM-yy",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "c-10:c+10" // Optional, limits the year range available to select
    });
});
</script>