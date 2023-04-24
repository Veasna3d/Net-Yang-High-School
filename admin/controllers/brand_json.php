<?php
     require '../includes/dbConnection.php';

    //get Student List
    if($_GET["data"] == "get_brand"){
        $sql = "SELECT * FROM brand";
        $result = $conn->prepare($sql);
        $result->execute();
        $brand = [];

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            
          $brand[]  = array($row["id"],$row["name"],$row["image"],$row["address"],$row["facebook"],$row["telegram"],$row["youtube"],$row["description"],$row["phone"],$row["email"]);

        }
        echo json_encode($brand);
    }
    
	//Add Student
if($_GET["data"] == "add_brand"){

  $name = $_POST['name'];
  $image = $_FILES['image']['name'];
  $address = $_POST['address'];
  $facebook = $_POST['facebook'];
  $telegram = $_POST['telegram'];
  $youtube = $_POST['youtube'];
  $description = $_POST['description'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    
    $sql="insert into brand(name,image,address,facebook,telegram,youtube,description,phone,email) 
    values(:name,:image,:address,:facebook,:telegram,:youtube,:description,:phone,:email);";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':name',$name);
    $insert->bindParam(':image', $image);
    $insert->bindParam(':address',$address);
    $insert->bindParam(':facebook',$facebook);
    $insert->bindParam(':telegram',$telegram);
    $insert->bindParam(':youtube',$youtube);
    $insert->bindParam(':description',$description);
    $insert->bindParam(':phone',$phone);
    $insert->bindParam(':email',$email);

    if($insert->execute()){
        echo json_encode("Insert Success");
    }else{
        echo json_encode("Insert Failed");
    }    
}

    
if($_GET['data'] == 'get_byid'){
    $result = $conn->prepare("SELECT * FROM brand WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if($row = $result->fetch(PDO::FETCH_ASSOC)){
        $brand[] = array(
            $row["id"],
            $row["name"],
            $row["image"],
            $row["facebook"],
            $row["telegram"],
            $row["youtube"],
            $row["description"],
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
    } else {
        $id = $_GET['id'];
        $address = $_POST['address'];
        $facebook = $_POST['facebook'];
        $telegram = $_POST['telegram'];
        $youtube = $_POST['youtube'];
        $description = $_POST['description'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        // Check if a new image file was uploaded
        if(!empty($_FILES['image']['name'])) {
            // Get the image file and move it to the uploads directory
            $image = $_FILES['image']['name'];
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            // Get the old image file name from the database
            $stmt = $conn->prepare("SELECT image FROM brand WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $image = $row['image'];
        }

        // Update the image file and user data in the database
        $sql ="UPDATE brand SET name=:name, image=:image, address=:address, facebook=:facebook, telegram=:telegram, youtube=:youtube, description=:description, phone=:phone, email=:email WHERE id=:id";
        $update = $conn->prepare($sql);
        $update->bindParam(':name', $_POST['name']);
        $update->bindParam(':image', $image);
        $update->bindParam(':address', $address);
        $update->bindParam(':facebook', $facebook);
        $update->bindParam(':telegram', $telegram);
        $update->bindParam(':youtube', $youtube);
        $update->bindParam(':description', $description);
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
        } else {
            echo json_encode("Update Failed");
        }
    }
}


    //Delete Student
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

	


?>