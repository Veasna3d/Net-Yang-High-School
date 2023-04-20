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
                        <li class="breadcrumb-item active">អ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ</li>
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
                            <button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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

<!-- Modal -->


<?php include 'includes/footer.php' ?>
<script src="./js/user.js"></script>