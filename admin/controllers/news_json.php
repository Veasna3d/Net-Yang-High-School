<?php
require '../includes/dbConnection.php';
//Get News
if($_GET["data"] == "get_news"){
    $sql = "SELECT * FROM news";
    $result = $conn->prepare($sql);
    $result->execute();
    $news = [];

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $createdAt = date("d-M-Y h:i:s A", strtotime($row['createdAt'])); // format createdAt with AM/PM
        $news[] = array($row['id'], $row['subTitle'], $row["detail"], 
        $row['image'], $createdAt);
    }
    echo json_encode($news);
}


// Add News
if ($_GET["data"] == "add_news") {
    $subTitle = $_POST["txtSubTitle"];
    $detail = $_POST["txtDetail"];
    $images = '';

    if (!empty($_FILES['images']['name'][0])) {
        $target_dir = "../upload/";
        $num_files = count($_FILES['images']['name']);

        for ($i = 0; $i < $num_files; $i++) {
            $target_file = $target_dir . basename($_FILES['images']['name'][$i]);
            move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_file);
            $images .= $_FILES['images']['name'][$i] . ',';
        }

        $images = rtrim($images, ','); // remove last comma
    }

    $sql = "INSERT INTO news (subTitle, detail, image) VALUES (:subTitle, :detail, :image)";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':subTitle', $subTitle);
    $insert->bindParam(':detail', $detail);
    $insert->bindParam(':image', $images);

    if ($insert->execute()) {
        echo json_encode("Insert Success");
    } else {
        echo json_encode("Insert Failed");
    }
}



// 4 get_byid
if ($_GET['data'] == 'get_byid') {
    $result = $conn->prepare("SELECT * FROM news WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $news[] = array($row['id'], $row['subTitle'], $row["detail"], $row['image']);
    }
    echo json_encode($news);
}

//5 Update News
//5 Update News
if ($_GET['data'] == 'update_news') {
    if (empty($_POST['txtSubTitle']) || empty($_POST['txtDetail'])) {
        echo json_encode("Please check the empty fields!");
    } else {
        $id = $_GET['id'];
        $subTitle = $_POST["txtSubTitle"];
        $detail = $_POST["txtDetail"];

        // Get the old image file names from the database
        $stmt = $conn->prepare("SELECT image FROM news WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $old_images = array_column($rows, 'image');

        // Check if new image files were uploaded
        if (!empty(array_filter($_FILES['images']['name']))) {
            // Get the image files and move them to the uploads directory
            $images = array();
            $target_dir = "../upload/";
            foreach ($_FILES['images']['name'] as $key => $value) {
                if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                    $image = $_FILES['images']['name'][$key];
                    $target_file = $target_dir . basename($_FILES["images"]["name"][$key]);
                    move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file);
                    $images[] = $image;
                }
            }
        } else {
            // No new images were uploaded
            $images = $old_images;
        }

        // Update the image files and user data in the database
        $sql = "UPDATE news SET subTitle=:subTitle, detail=:detail, image=:image WHERE id=:id";
        $update = $conn->prepare($sql);
        foreach ($images as $key => $value) {
            $update->bindParam(':subTitle', $subTitle);
            $update->bindParam(':detail', $detail);
            $update->bindParam(':id', $id);
            $update->bindParam(':image', $images[$key]); // bind the corresponding image filename
            $update->execute();
        }

        // If the update was successful, delete the old image files if they exist
        foreach ($old_images as $key => $value) {
            if (!in_array($value, $images)) {
                if (file_exists('../upload/' . $value)) {
                    unlink('../upload/' . $value);
                }
            }
        }

        echo json_encode("Update Success");
    }
}





//Delete News
if ($_GET['data'] == 'delete_news') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT image FROM News WHERE id=:id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $result['image'];

    $delete = $conn->prepare("DELETE FROM News WHERE id=:id;");
    $delete->bindParam(':id', $id);

    if ($delete->execute()) {
        // delete image from folder
        $target_file = "upload/" . $image;
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}
