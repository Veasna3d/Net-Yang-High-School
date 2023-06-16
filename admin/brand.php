<?php include 'controllers/brand_json.php' ?>

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
                            <div class="container rounded bg-white">
                                <?php
                                $brandId = 1;

                                $sql = "SELECT * FROM Brand WHERE id = :id";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':id', $brandId);
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($stmt->rowCount() > 0) {
                                    foreach ($result as $row) {
                                ?>
                                        <form id="recordForm" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="brandId" value="<?php echo $brandId; ?>">
                                            <input type="hidden" name="oldImage" value="<?php echo $row['image']; ?>"> <!-- Added this line to store the old image value -->
                                            <div class="row">
                                                <div class="col-md-3 border-right">
                                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                        <img id="previewImage" class="rounded mt-5" width="150px" src="./upload/<?php echo $row['image']; ?>">
                                                        <img id="imagePreview" class="rounded mt-5" width="150px" style="display: none;">
                                                        <label for="image" class="btn btn-outline-primary mt-2">ផ្លាស់ប្ដូររូបភាព</label>
                                                        <input type="file" name="image" id="image" class="form-control-file d-none" onchange="previewImage(event)">
                                                    </div>
                                                </div>



                                                <div class="col-md-9 border-right">
                                                    <div class="p-3 py-5">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h4 class="text-right">Profile Settings</h4>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <label class="labels">ឈ្មោះ</label>
                                                                <input type="text" name="name" value="<?php echo $row['name'] ?>" id="name" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="labels">លេខទូរស័ព្ទ</label>
                                                                <input type="text" name="phone" value="<?php echo $row['phone'] ?>" id="phone" class="form-control">
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="labels">អាសយដ្ឋាន</label>
                                                                <textarea name="address" id="address" class="form-control" id="" rows="5"><?php echo $row['address'] ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label class="labels">អ៊ីមែល (Optional)</label>
                                                                <input type="text" name="email" value="<?php echo $row['email'] ?>" id="email" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="labels">ហ្វេសប៊ុក​ (Optional)</label>
                                                                <input type="text" name="facebook" value="<?php echo $row['facebook'] ?>" id="facebook" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="mt-5">
                                                            <button class="btn btn-primary" type="submit" name="updateProfile">Update Profile</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

<?php include 'includes/footer.php' ?>
<script>
    function previewImage(event) {
        var input = event.target;
        var previewImage = document.getElementById('previewImage');
        var imagePreview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Hide the old image
                previewImage.style.display = 'none';

                // Display the preview of the new image
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // If no new image is selected, show the old image
            previewImage.style.display = 'block';

            // Hide the preview of the new image
            imagePreview.style.display = 'none';
        }
    }
</script>