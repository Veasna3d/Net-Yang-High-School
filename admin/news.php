<?php include 'includes/topbar.php' ?>
<?php include 'includes/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ព័ត៌មានអំពីសាលា</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">ផ្ទះ</a></li>
                        <li class="breadcrumb-item active">ព័ត៌មានអំពីសាលា</li>
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
                                ព័ត៌មានអំពីសាលា
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
                <h5 class="modal-title" id="myModalLabel">ព័ត៌មានសិស្ស</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="name">Sub Title</label>
                        <input type="text" name="txtSubTitle" id="txtSubTitle" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="txtDetail">Detail</label>
                        <textarea class="form-control" id="txtDetail" name="txtDetail" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Multi Image</label>
                        <input type="file" name="images[]" id="images" class="form-control-file" multiple>
                    </div>
                    <div id="preview"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSave">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<?php include 'includes/footer.php' ?>
<script src="./js/news.js"></script>
<script>
jQuery(document).ready(function() {
    'use strict';
    jQuery('#txtDate').datetimepicker();
});

function previewImages() {
  var preview = document.querySelector('#preview');
  
  // Clear all previous preview images (if any)
  preview.innerHTML = '';
  
  if (this.files) {
    // If only one image is selected, replace the previous preview image (if any)
    if (this.files.length === 1) {
      readAndPreview(this.files[0]);
    }
    // If multiple images are selected, preview them all in the container
    else {
      [].forEach.call(this.files, readAndPreview);
    }
  }
  
  function readAndPreview(file) {
    // Make sure `file.type` matches the desired image file types
    if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
      var reader = new FileReader();
      reader.addEventListener("load", function() {
        var image = new Image();
        image.height = 100;
        image.title  = file.name;
        image.src    = this.result;
        preview.appendChild(image);
      }, false);
      
      reader.readAsDataURL(file);
    }
  }
}

document.querySelector('#images').addEventListener("change", previewImages);
</script>
