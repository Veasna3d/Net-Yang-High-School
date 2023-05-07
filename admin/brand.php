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

                    <div class="form-group">
                        <label class="form-label">ឈ្មោះ</label>
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">ហ្វេបុក</label>
                        <input type="" name="facebook" id="facebook" class="form-control" />
                    </div>


                    <div class="form-group">
                        <label class="form-label">លេខទូរស័ព្ទ</label>
                        <input type="" name="phone" id="phone" class="form-control" />
                    </div>


                    <div class="form-group">
                        <label class="form-label">អ៊ីម៊ែល</label>
                        <input type="Email" name="email" id="email" class="form-control" />
                    </div>

                    <div class="form-floating">
                        <label class="form-label">អាសយដ្ឋាន</label>
                        <textarea class="form-control" placeholder="កំណត់សម្គាល់" name="address" id="address"
                            style="height: 100px"></textarea>
                        <!-- <label for="floatingTextarea2">Comments</label> -->
                    </div>

                    <div class="form-group pt-2">
                        <label for="image" class="btn btn-primary">រូបភាព</label>
                        <input type="file" name="image" id="image" class="form-control-file" hidden>
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