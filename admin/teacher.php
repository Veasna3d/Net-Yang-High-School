<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>គ្រូ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">ផ្ទះ</a></li>
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
                        <div class="card-header">
                            <!-- Button trigger modal -->
                            <button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#myModal">
                                គ្រូថ្មី
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានគ្រូ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="name">ឈ្នោះគ្រូ</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="password">លេខសម្ងាត់</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <!-- <div class="form-group">
                        <label for="image" class="btn btn-outline-primary">រូបភាព</label>
                        <input type="file" name="image" id="image" class="form-control-file d-none">
                    </div> -->
                    <div class="form-group">
                        <label for="image">រូបភាព</label>
                        <input type="file" name="image" id="image" class="form-control-file">
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
                        <label for="phone">លេខទូរស័ព្ទ</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                        <!-- <span id="user_uploaded_image"></span> -->
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
<!-- <div class="modal fade" id="viewData" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
</div> -->


<?php include 'includes/footer.php' ?>
<script src="./js/teacher.js"></script>

<!-- <script src="./js/jquery.daterange.js"></script> -->