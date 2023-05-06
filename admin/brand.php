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
                    <h1>ឈ្មោះសាលា</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">ទំព័រដើម</a></li>
                        <li class="breadcrumb-item active">ឈ្មោះសាលា</li>
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
                <h5 class="modal-title" id="myModalLabel">ឈ្មោះសាលា</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form">
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">ឈ្មោះ</label>
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="image">រូបភាព</label>
                                <input type="file" name="image" id="image" class="form-control-file">
                            </div>

                            <div class="form-group">
                                <label class="form-label">ទីតាំង</label>
                                <input type="text" name="address" id="address" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">ហ្វេបុក</label>
                                <input type="" name="facebook" id="facebook" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">តេលេក្រាម</label>
                                <input type="" name="telegram" id="telegram" class="form-control" />
                            </div>

                        </div>
                        <div class="col-6">
                        <div class="form-group">
                                <label class="form-label">យូធូ</label>
                                <input type="text" name="youtube" id="youtube" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">ការពិពណ៌នា</label>
                                <input type="" name="description" id="description" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">លេខទូរស័ព្ទ</label>
                                <input type="" name="phone" id="phone" class="form-control" />
                            </div>


                            <div class="form-group">
                                <label class="form-label">អ៊ីម៊ែល</label>
                                <input type="Email" name="email" id="email" class="form-control" />
                            </div>
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


    <?php include 'includes/footer.php' ?>
    <script src="./js/brand.js"></script>

  