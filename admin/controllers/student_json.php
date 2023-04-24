<?php
     require '../includes/dbConnection.php';

    //get Student List
    if($_GET["data"] == "get_student"){
        $sql = "SELECT * FROM vStudent";
        $result = $conn->prepare($sql);
        $result->execute();
        $student = [];

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            if ($row['status'] == 1) {
                $status = "<span class='badge badge-pill badge-primary'>Active</span>";
            } else {
                $status = "<span class='badge badge-pill badge-danger'>Inactive</span>";
            }

            $student[] = array($row['id'], $row['startYear'],$row['endYear'], $row["studentName"], 
            $row['image'],  $row['gender'],$row['className'],
            $row["birthday"], $row["password"],$status, $row['createdAt']);

        }
        echo json_encode($student);
    }

	//Get Class
	if($_GET['data'] == "get_class"){
        $sql = "SELECT * FROM Class";
        $result = $conn->prepare($sql);
        $result->execute();
        $class = [];

        while( $row = $result->fetch(PDO::FETCH_ASSOC)){

                $class[] = array($row['id'],
                    $row['className'],$row['createdAt']);
            
        }
        echo json_encode($class);
    }
    
	//Add Student
if($_GET["data"] == "add_student"){

    $start = $_POST["txtStartYear"];
    $end = $_POST["txtEndYear"];


    $studentName = $_POST["txtStudentName"];
    $gender = $_POST["ddlGender"];
    $class = $_POST["ddlClass"];
    $birthday = $_POST["txtBirthday"];
    $password = $_POST["txtPassword"];
    $image = $_FILES['image']['name'];

    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    if (strlen($password) > 5) {
        echo json_encode("Password must be less than 5 characters long");
        return;
    }

    $encrypted_password = md5($password);

    $sql = "INSERT INTO Student (startYear, endYear,studentName, gender, classId, birthday, password, image) VALUES 
                                (:startYear, :endYear, :studentName, :gender, :classId, :birthday, :password, :image)";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':startYear', $start);
    $insert->bindParam(':endYear', $end);
    $insert->bindParam(':studentName', $studentName);
    $insert->bindParam(':gender', $gender);
    $insert->bindParam(':classId', $class);
    $insert->bindParam(':birthday', $birthday);
    $insert->bindParam(':password', $encrypted_password);
    $insert->bindParam(':image', $image);

    if($insert->execute()){
        echo json_encode("Insert Success");
    }else{
        echo json_encode("Insert Failed");
    }    
}

    
		// 4 get_byid
	if($_GET['data'] == 'get_byid'){
			$result = $conn->prepare("SELECT * FROM Student WHERE id=:id");
			$result->bindParam(':id', $_GET['id']);
			$result->execute();
			if($row = $result->fetch(PDO::FETCH_ASSOC)){
                $student[] = array($row['id'], $row['startYear'],$row['endYear'], $row["studentName"], 
                $row['image'],  $row['gender'],$row['classId'],
                $row["birthday"], $row["password"], $row['createdAt']);
			}
			echo json_encode($student);
	}

        //5 Update Book
	 if($_GET['data'] == 'update_student'){

		if(empty($_POST['txtStudentName'])){
			echo json_encode("Please check the empty fields!");
		}else{
			$id = $_GET['id'];
            $start = $_POST["txtStartYear"];
            $end = $_POST["txtEndYear"];
        
        
            $studentName = $_POST["txtStudentName"];
            $gender = $_POST["ddlGender"];
            $class = $_POST["ddlClass"];
            $birthday = $_POST["txtBirthday"];
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
				$stmt = $conn->prepare("SELECT image FROM Student WHERE id=:id");
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$image = $row['image'];
			}
	
			// Update the image file and user data in the database
			$sql = "UPDATE Student SET startYear=:startYear, endYear=:endYear, studentName=:studentName,
             gender=:gender, classId=:classId, birthday=:birthday, password=:password, image=:image where id=:id;";
			$update = $conn->prepare($sql);
			$update->bindParam(':image', $image);
            $update->bindParam(':startYear', $start);
            $update->bindParam(':endYear', $end);
            $update->bindParam(':studentName', $studentName);
            $update->bindParam(':gender', $gender);
            $update->bindParam(':classId', $class);
            $update->bindParam(':birthday', $birthday);
            $update->bindParam(':password', $password);
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

    //Delete Student
    if ($_GET['data'] == 'delete_student') {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT image FROM Student WHERE id=:id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $image = $result['image'];

        $delete = $conn->prepare("DELETE FROM Student WHERE id=:id;");
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

      //view Student
      if ($_GET['data'] == 'student_info') {
        $result = $conn->prepare("SELECT * FROM vStudent WHERE id=:id");
        $result->bindParam(':id', $_GET['id']);
        $result->execute();
        if($row = $result->fetch(PDO::FETCH_ASSOC)){
            $student[] = array($row['id'], $row['startYear'],$row['endYear'], $row["studentName"], 
            $row['image'],  $row['gender'],$row['className'],
            $row["birthday"], $row["password"],$row["status"], $row['createdAt']);
        }
        echo json_encode($student);
    }
    //disable
    if($_GET['data'] == 'disable_student'){
        
        $id = $_GET['id'];
        $status = 0;
        $sql = "UPDATE Student SET status=:status WHERE id=:id;";
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