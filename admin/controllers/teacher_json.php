
<?php
// error_reporting(0);
require '../includes/dbConnection.php';

if($_GET["data"] == "get_teacher"){
  $sql = "SELECT * FROM teacher";
  $result = $conn->prepare($sql);
$result->execute();
$teacher = [];
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $teacher[]  = array($row["id"],$row["teacherName"],$row["password"],
    $row["image"],$row["gender"],$row["phone"],$row["createdAt"]);
  }
    echo json_encode($teacher);
}

if ($_GET['data'] == 'check_teacher_name') {
    $teacherName = $_POST['teacherName'];

    $query = "SELECT COUNT(*) as count FROM teacher WHERE teacherName = :teacherName";
    $statement = $conn->prepare($query);
    $statement->bindParam(':teacherName', $teacherName);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    echo json_encode(['exists' => $count > 0]);
    exit;
}

//Add teacher
// if($_GET["data"] == "add_teacher"){
//   $teacherName = $_POST["teacherName"];
// $password = $_POST["password"];
// $image = $_FILES['image']['name'];
// $gender = $_POST["ddlGender"];
// $phone = $_POST["phone"];

// $target_dir = "../upload/";
// $target_file = $target_dir . basename($_FILES["image"]["name"]);
// move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// if (strlen($password) > 5) {
//     echo json_encode("Password must be less than 5 characters long");
//     return;
// }

// $encrypted_password = md5($password);

// $sql = "INSERT INTO teacher (teacherName,password,image,gender,phone) VALUES(:teacherName,:password, :image,:gender,:phone)";
// $insert = $conn->prepare($sql);
// $insert->bindParam(':teacherName', $teacherName);
// $insert->bindParam(':password', $encrypted_password);
// $insert->bindParam(':image', $image);
// $insert->bindParam(':gender', $gender);
// $insert->bindParam(':phone', $phone);

// if($insert->execute()){
//     echo json_encode("Insert Success");
// }else{
//     echo json_encode("Insert Failed");
// }

// }


// Add teacher
if ($_GET["data"] == "add_teacher") {
  $teacherName = $_POST['teacherName'];
  $password = $_POST["password"];
  $gender = $_POST['ddlGender'];
  $phone = $_POST['phone'];

  if (!isset($_FILES['image']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
      echo json_encode("Image file not uploaded");
      return;
  }

  $image = $_FILES['image']['name'];
  $target_dir = "../upload/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

  if (strlen($password) > 5) {
      echo json_encode("Password must be less than 5 characters long");
      return;
  }
  
  $encrypted_password = md5($password);

  $sql = "INSERT INTO teacher(teacherName, password, image, gender, phone) VALUES (:teacherName, :password, :image, :gender, :phone)";
  $insert = $conn->prepare($sql);
  $insert->bindParam(':teacherName', $teacherName);
  $insert->bindParam(':password', $encrypted_password);
  $insert->bindParam(':image', $image);
  $insert->bindParam(':gender', $gender);
  $insert->bindParam(':phone', $phone);

  if ($insert->execute()) {
      echo json_encode("Insert Success");
  } else {
      echo json_encode("Insert Failed");
  }
}



//2-get_byID
if($_GET['data'] == 'get_byid'){
    $result = $conn->prepare("select * from teacher where id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if($row = $result->fetch(PDO::FETCH_ASSOC)){
        $teacher[]  = array($row["id"],$row["teacherName"],$row["password"],$row["image"],$row["gender"],$row["phone"],$row["createdAt"]);
    }
    echo json_encode($teacher);
}

//5 Update Student
if($_GET['data'] == 'update_teacher'){

    if(empty($_POST['teacherName'])){
      echo json_encode("Please check the empty fields!");
    }else{
        $id = $_GET['id'];
        $teacherName = $_POST['teacherName'];
        $gender = $_POST["ddlGender"];
        $phone = $_POST['phone'];

  
      // Check if a new image file was uploaded
      if(!empty($_FILES['image']['name'])) {
        // Get the image file and move it to the uploads directory
        $image = $_FILES['image']['name'];
        $target_dir = "../upload/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
      } else {
        // Get the old image file name from the database
        $stmt = $conn->prepare("SELECT image FROM teacher WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $image = $row['image'];
      }
  
      // Update the image file and user data in the database
      $sql = "UPDATE teacher SET teacherName = :teacherName,password = :password,image = :image, gender = :gender, phone = :phone  where id=:id";
      $update = $conn->prepare($sql);
      $update->bindParam(':teacherName', $teacherName);
      $update->bindParam(':password', $password);
      $update->bindParam(':image', $image);
      $update->bindParam(':gender', $gender);
      $update->bindParam(':phone', $phone);
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

   
//4-delete
if($_GET['data'] == 'delete_teacher'){
    $id = $_GET['id'];
    $delete = $conn->prepare("DELETE FROM teacher WHERE id=:id;");
    $delete->bindParam(':id', $id);
    if($delete->execute()){
        echo json_encode("Delete Success");
    }else{
        echo json_encode("Delete Faild");
    }
}
?>