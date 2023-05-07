<?php
require '../includes/dbConnection.php';

//get Brand List
if ($_GET["data"] == "get_brand") {
    $sql = "SELECT * FROM brand";
    $result = $conn->prepare($sql);
    $result->execute();
    $brand = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $brand[]  = array(
            $row["id"], $row["name"], $row["image"],
            $row["address"], $row["facebook"], $row["phone"], $row["email"]
        );
    }
    echo json_encode($brand);
}

//Add Brand
if ($_GET["data"] == "add_brand") {
	$name = $_POST["name"];
	$facebook = $_POST["facebook"];
	$phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
	$image = $_FILES['image']['name'];

	$target_dir = "../upload/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);



	$sql_check = "SELECT COUNT(*) FROM Brand WHERE name = :name";
	$check = $conn->prepare($sql_check);
	$check->bindParam(':name', $name);
	$check->execute();
	$count = $check->fetchColumn();

	if ($count > 0) {
		echo json_encode("Brand already exists");
		return;
	}

	$sql_insert = "INSERT INTO Brand (name, image, address, facebook, phone, email) VALUES (:name, :image, :address, :facebook, :phone, :email)";
	$insert = $conn->prepare($sql_insert);
	$insert->bindParam(':name', $name);
    $insert->bindParam(':image', $image);
	$insert->bindParam(':address', $address);
	$insert->bindParam(':facebook', $facebook);
    $insert->bindParam(':phone', $phone);
	$insert->bindParam(':email', $email);

	if ($insert->execute()) {
		echo json_encode("Insert Success");
	} else {
		echo json_encode("Insert Failed");
	}
}



if ($_GET['data'] == 'get_byid') {
    $result = $conn->prepare("SELECT * FROM brand WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $brand[] = array(
            $row["id"],
            $row["name"],
            $row["image"],
            $row["facebook"],
            $row["phone"],
            $row["email"],
            $row["createdAt"]
        );
    }
    echo json_encode($brand);
}

if($_GET['data'] == 'update_brand'){

    if(empty($_POST['name'])){
        echo json_encode("Please check the empty fields!");
    }else{
        $id = $_GET['id'];
        $name = $_POST["name"];
        $facebook = $_POST["facebook"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        // Check if a new image file was uploaded
        if(!empty($_FILES['image']['name'])) {
            // Get the image file and move it to the uploads directory
            $image = $_FILES['image']['name'];
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            // Get the old image file name from the database
            $stmt = $conn->prepare("SELECT image FROM Brand WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $image = $row['image'];
        }

        // Check if the new username already exists in the database
        $stmt = $conn->prepare("SELECT * FROM Brand WHERE name=:name AND id!=:id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo json_encode("Brand already exists");
        } else {

            // Update the image file and user data in the database
            $sql = "UPDATE Brand SET name=:name, image=:image, address=:address, facebook=:facebook, phone=:phone, email=:email  where id=:id;";
            $update = $conn->prepare($sql);
            $update->bindParam(':name', $name);
            $update->bindParam(':image', $image);
            $update->bindParam(':address', $address);
            $update->bindParam(':facebook', $facebook);
            $update->bindParam(':phone', $phone);
            $update->bindParam(':email', $email);
            $update->bindParam(':id', $id);

            if($update->execute()){
                // If the update was successful, delete the old image file if it exists
                if(!empty($_FILES['image']['name'])) {
                    if(isset($_POST['oldImage']) && !empty($_POST['oldImage'])) {
                        $old_image = $_POST['oldImage'];
                        if(file_exists('../upload/' . $old_image)) {
                            unlink('../upload/' . $old_image);
                        }
                    }
                }
                echo json_encode("Update Success");
            }else{
                echo json_encode("Update Failed");
            }
        }
    }
}


//Delete Brand
if ($_GET['data'] == 'delete_brand') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT image FROM brand WHERE id=:id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $result['image'];

    $delete = $conn->prepare("DELETE FROM brand WHERE id=:id;");
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
