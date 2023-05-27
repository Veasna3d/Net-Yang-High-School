<?php
require '../includes/dbConnection.php';

//get Student List
if ($_GET["data"] == "get_teacher") {
    $sql = "SELECT * FROM Teacher";
    $result = $conn->prepare($sql);
    $result->execute();
    $teacher = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-primary'>Active</span>";
        } else {
            $status = "<span class='badge badge-pill badge-danger'>Disabled</span>";
        }

        $teacher[] = array(
            $row['id'], $row["teacherName"], $row["image"],
            $row['gender'], $row['phone'], $status, $row['createdAt']
        );
    }
    echo json_encode($teacher);
}

//Add Teacher
if ($_GET["data"] == "add_teacher") {


    $teacherName = $_POST["txtTeacherName"];
    $gender = $_POST["ddlGender"];
    $phone = $_POST["txtPhone"];
    $image = $_FILES['image']['name'];

    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);



    $sql = "INSERT INTO Teacher (teacherName, gender, phone, image) VALUES 
                                ( :teacherName, :gender, :phone, :image)";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':teacherName', $teacherName);
    $insert->bindParam(':gender', $gender);
    $insert->bindParam(':phone', $phone);
    $insert->bindParam(':image', $image);

    if ($insert->execute()) {
        echo json_encode("Insert Success");
    } else {
        echo json_encode("Insert Failed");
    }
}


// 4 get_byid
if ($_GET['data'] == 'get_byid') {
    $result = $conn->prepare("SELECT * FROM Teacher WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $teacher[] = array(
            $row['id'], $row["teacherName"], $row["image"],
            $row['gender'], $row['phone'], $row["status"], $row['createdAt']
        );
    }
    echo json_encode($teacher);
}

//5 Update Teacher
if ($_GET['data'] == 'update_teacher') {

    if (empty($_POST['txtTeacherName'])) {
        echo json_encode("Please check the empty fields!");
    } else {
        $id = $_GET['id'];
        $teacherName = $_POST["txtTeacherName"];
        $gender = $_POST["ddlGender"];
        $phone = $_POST["txtPhone"];

        // Check if a new image file was uploaded
        if (!empty($_FILES['image']['name'])) {
            // Get the image file and move it to the uploads directory
            $image = $_FILES['image']['name'];
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            // Get the old image file name from the database
            $stmt = $conn->prepare("SELECT image FROM Teacher WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $image = $row['image'];
        }

        // Update the image file and user data in the database
        $sql = "UPDATE Teacher SET teacherName=:teacherName,
                gender=:gender, phone=:phone,
                image=:image where id=:id;";
        $update = $conn->prepare($sql);
        $update->bindParam(':image', $image);
        $update->bindParam(':teacherName', $teacherName);
        $update->bindParam(':gender', $gender);
        $update->bindParam(':phone', $phone);
        $update->bindParam(':id', $id);

        if ($update->execute()) {
            // If the update was successful, delete the old image file if it exists
            if (!empty($_FILES['image']['name'])) {
                if (isset($_POST['oldImage']) && !empty($_POST['oldImage'])) {
                    $old_image = $_POST['oldImage'];
                    if (file_exists('../upload/' . $old_image)) {
                        unlink('../upload/' . $old_image);
                    }
                }
            }
            echo json_encode("Update Success");
        } else {
            echo json_encode("Update Failed");
        }
    }
}

//Delete Teacher
if ($_GET['data'] == 'delete_teacher') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT image FROM Teacher WHERE id=:id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $result['image'];

    $delete = $conn->prepare("DELETE FROM Teacher WHERE id=:id;");
    $delete->bindParam(':id', $id);

    if ($delete->execute()) {
        // delete image from folder
        $target_file = "../upload/" . $image;
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}

//disable
if($_GET['data'] == 'disable_teacher'){
        
    $id = $_GET['id'];
    $status = 0;
    $sql = "UPDATE Teacher SET status=:status WHERE id=:id;";
    $update = $conn->prepare($sql);

    $update->bindParam(':status', $status);
    $update->bindParam(':id', $id);

    if($update->execute()){
        echo json_encode("Return Success");
    }else{
        echo json_encode("Return Faild");
    }
}

//active
if($_GET['data'] == 'active_teacher'){
        
    $id = $_GET['id'];
    $status = 1;
    $sql = "UPDATE Teacher SET status=:status WHERE id=:id;";
    $update = $conn->prepare($sql);

    $update->bindParam(':status', $status);
    $update->bindParam(':id', $id);

    if($update->execute()){
        echo json_encode("Return Success");
    }else{
        echo json_encode("Return Faild");
    }
}
?>


