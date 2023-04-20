<?php
     require '../includes/dbConnection.php';
    //Get Slide
    if($_GET["data"] == "get_slide"){
        $sql = "SELECT * FROM slide";
        $result = $conn->prepare($sql);
        $result->execute();
        $slide = [];

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $slide[] = array($row['id'], $row['title'], $row["subTitle"], 
            $row['image'], $row['createdAt']);
        }
        echo json_encode($slide);
    }

    
	//Add Slide
	if($_GET["data"] == "add_slide"){
		$title = $_POST["txtTitle"];
		$subTitle = $_POST["txtSubTitle"];
		$image = $_FILES['image']['name'];
			  
		$target_dir = "../upload/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
	
	
		$sql = "INSERT INTO Slide (title, subTitle, image) VALUES 
                                (:title, :subTitle, :image)";
		$insert = $conn->prepare($sql);
		$insert->bindParam(':title', $title);
		$insert->bindParam(':subTitle', $subTitle);
		$insert->bindParam(':image', $image);
	
		if($insert->execute()){
			echo json_encode("Insert Success");
		}else{
			echo json_encode("Insert Failed");
		}    
	}

    
		// 4 get_byid
		if($_GET['data'] == 'get_byid'){
			$result = $conn->prepare("SELECT * FROM Slide WHERE id=:id");
			$result->bindParam(':id', $_GET['id']);
			$result->execute();
			if($row = $result->fetch(PDO::FETCH_ASSOC)){
				$slide[] = array($row['id'], $row['title'], $row["subTitle"],$row['image']);
			}
			echo json_encode($slide);
		}

        //5 Update Slide
	 if($_GET['data'] == 'update_slide'){

		if(empty($_POST['txtTitle']) || empty($_POST['txtSubTitle'])){
			echo json_encode("Please check the empty fields!");
		}else{
			$id = $_GET['id'];

			$title = $_POST["txtTitle"];
		    $subTitle = $_POST["txtSubTitle"];

	
			// Check if a new image file was uploaded
			if(!empty($_FILES['image']['name'])) {
				// Get the image file and move it to the uploads directory
				$image = $_FILES['image']['name'];
				$target_dir = "../upload/";
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
			} else {
				// Get the old image file name from the database
				$stmt = $conn->prepare("SELECT image FROM Slide WHERE id=:id");
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$image = $row['image'];
			}
	
			// Update the image file and user data in the database
			$sql = "UPDATE Slide SET title=:title, subTitle=:subTitle, image=:image where id=:id;";
			$update = $conn->prepare($sql);
			$update->bindParam(':image', $image);
            $update->bindParam(':title', $title);
            $update->bindParam(':subTitle', $subTitle);
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

    //Delete Book
    if ($_GET['data'] == 'delete_slide') {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT image FROM Slide WHERE id=:id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $image = $result['image'];

        $delete = $conn->prepare("DELETE FROM Slide WHERE id=:id;");
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

?>