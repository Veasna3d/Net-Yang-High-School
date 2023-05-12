<?php
require '../includes/dbConnection.php';
//  $db = new Db;

//get_user 
if ($_GET["data"] == "get_user") {
	$sql = "SELECT * FROM user";
	$result = $conn->prepare($sql);
	$result->execute();
	$user = [];
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		$user[]  = array(
			$row["id"], $row["username"], $row["password"], $row["image"],
			$row["email"], $row["createdAt"]
		);
	}
	echo json_encode($user);
}


//add_user
if ($_GET["data"] == "add_user") {
	$username = $_POST["txtUsername"];
	$password = $_POST["txtPassword"];
	$email = $_POST["txtEmail"];
	$image = $_FILES['image']['name'];

	$target_dir = "../upload/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

	if (strlen($password) < 5) {
		echo json_encode("Password must be at least 5 characters long");
		return;
	}

	$encrypted_password = md5($password);

	$sql_check = "SELECT COUNT(*) FROM user WHERE username = :username";
	$check = $conn->prepare($sql_check);
	$check->bindParam(':username', $username);
	$check->execute();
	$count = $check->fetchColumn();

	if ($count > 0) {
		echo json_encode("User already exists");
		return;
	}

	$sql_insert = "INSERT INTO user (username, password, image, email) VALUES (:username, :password, :image, :email)";
	$insert = $conn->prepare($sql_insert);
	$insert->bindParam(':username', $username);
	$insert->bindParam(':password', $encrypted_password);
	$insert->bindParam(':image', $image);
	$insert->bindParam(':email', $email);

	if ($insert->execute()) {
		echo json_encode("Insert Success");
	} else {
		echo json_encode("Insert Failed");
	}
}



// 4 get_byid
if ($_GET['data'] == 'get_byid') {
	$result = $conn->prepare("SELECT * FROM User WHERE id=:id");
	$result->bindParam(':id', $_GET['id']);
	$result->execute();
	if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$user[]  = array($row["id"], $row["username"], $row["password"], $row["email"], $row["image"], $row["createdAt"]);
	}
	echo json_encode($user);
}

//5 update_user

if($_GET['data'] == 'update_user'){

    if(empty($_POST['txtUsername'])){
        echo json_encode("Please check the empty fields!");
    }else{
        $id = $_GET['id'];
        $username = $_POST["txtUsername"];
        $email = $_POST["txtEmail"];
        $password = $_POST["txtPassword"];

        // Check if a new image file was uploaded
        if(!empty($_FILES['image']['name'])) {
            // Get the image file and move it to the uploads directory
            $image = $_FILES['image']['name'];
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            // Get the old image file name from the database
            $stmt = $conn->prepare("SELECT image FROM User WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $image = $row['image'];
        }

        // Check if a new password was entered and encrypt it
        if(!empty($password)) {
            $encrypted_password = md5($password);
        } else {
            // If no new password was entered, use the existing one
            $stmt = $conn->prepare("SELECT password FROM User WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $encrypted_password = $row['password'];
        }

        // Check if the new username already exists in the database
        $stmt = $conn->prepare("SELECT * FROM User WHERE username=:username AND id!=:id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo json_encode("Username already exists");
        } else {

            // Update the image file and user data in the database
            $sql = "UPDATE User SET username=:username, email=:email, password=:password, image=:image where id=:id;";
            $update = $conn->prepare($sql);
            $update->bindParam(':image', $image);
            $update->bindParam(':username', $username);
            $update->bindParam(':email', $email);
            $update->bindParam(':password', $encrypted_password);
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


//5 delete_user
if ($_GET['data'] == 'delete_user') {
	$id = $_GET['id'];
	$stmt = $conn->prepare("SELECT image FROM User WHERE id=:id;");
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$image = $result['image'];

	$delete = $conn->prepare("DELETE FROM User WHERE id=:id;");
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
