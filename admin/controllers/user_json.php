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

			$user[]  = array($row["id"],$row["username"],$row["password"],$row["image"],$row["email"],$row["createdAt"]);
		}
		echo json_encode($user);
	}

	if ($_GET['data'] == 'check_username') {
        $name = $_POST['name'];
        $query = "SELECT COUNT(*) as count FROM user WHERE username = :name";
        $statement = $conn->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        echo json_encode(['exists' => $count > 0]);
        exit;
    }

	//add_user
	if($_GET["data"] == "add_user"){
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
	
		$sql = "INSERT INTO user (username, password,image,email) VALUES (:username, :password,:image ,:email)";
		$insert = $conn->prepare($sql);
		$insert->bindParam(':username', $username);
		$insert->bindParam(':password', $encrypted_password);
		$insert->bindParam(':image', $image);
		$insert->bindParam(':email', $email);
		
		if($insert->execute()){
			echo json_encode("Insert Success");
		}else{
			echo json_encode("Insert Failed");
		}    
	}
	

		// 4 get_byid
		if($_GET['data'] == 'get_byid'){
			$result = $conn->prepare("SELECT * FROM User WHERE id=:id");
			$result->bindParam(':id', $_GET['id']);
			$result->execute();
			if($row = $result->fetch(PDO::FETCH_ASSOC)){
				$user[]  = array($row["id"],$row["username"],$row["password"],$row["email"],$row["image"],$row["createdAt"]);
			}
			echo json_encode($user);
		}

 	//5 update_user
	 if($_GET['data'] == 'update_user'){
		
		if(empty($_POST['txtUsername']) || empty($_POST['txtEmail'])){
			echo json_encode("Please check the empty fields!");
		}else{
			$id = $_GET['id'];
			$username = $_POST["txtUsername"];
			$email = $_POST["txtEmail"];
	
			// Check if a new image file was uploaded
			if(!empty($_FILES['image']['name'])) {
				// Get the image file and move it to the uploads directory
				$image = $_FILES['image']['name'];
				$target_dir = "../upload/";
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
			} else {
				// Get the old image file name from the database
				$stmt = $conn->prepare("SELECT image FROM user WHERE id=:id");
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$image = $row['image'];
			}
	
			// Check if a new password was provided
			if(!empty($_POST['txtPassword'])) {
				// If a new password was provided, encrypt it using MD5 hash
				$password = md5($_POST["txtPassword"]);
			} else {
				// If no new password was provided, retain the old password
				$stmt = $conn->prepare("SELECT password FROM user WHERE id=:id");
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$password = $row['password'];
			}
	
			// Update the image file and user data in the database
			$sql = "UPDATE user SET username=:username, password=:password,image=:image,email=:email  where id=:id;";
			$update = $conn->prepare($sql);
			$update->bindParam(':username', $username);
			$update->bindParam(':password', $password);
			$update->bindParam(':image', $image);
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
?>