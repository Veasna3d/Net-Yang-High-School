<?php

require '../includes/dbConnection.php';
if($_GET["data"] == "get_category"){
    $sql = "SELECT * FROM category";
    $result = $conn->prepare($sql);
  $result->execute();
  $category = [];
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $category[]  = array($row["id"],$row["categoryCode"],$row["categoryName"],$row["createdAt"]);
  }
    echo json_encode($category);
}

if ($_GET['data'] == 'check_category_name') {
    $categoryCode = $_POST['categoryCode'];
    $categoryName = $_POST['categoryName'];

    $query = "SELECT COUNT(*) as count FROM category WHERE categoryCode = :categoryCode AND categoryName = :categoryName";
    $statement = $conn->prepare($query);
    $statement->bindParam(':categoryCode',$categoryCode);
    $statement->bindParam(':categoryName',$categoryName);
    $statement->execute(); // add this line
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    echo json_encode(['exists' => $count > 0]);
    exit;
    
}


//1-add_class
if($_GET["data"] == "add_category"){
    $categoryCode = $_POST['categoryCode'];
    $categoryName = $_POST['categoryName'];

        $sql = "INSERT INTO category(categoryCode,categoryName) VALUE(:categoryCode,:categoryName);";
        $insert = $conn->prepare($sql);
        $insert->bindParam(':categoryCode',$categoryCode);
        $insert->bindParam(':categoryName',$categoryName);
        if($insert->execute()){
               echo json_encode("Insert Success");}
        else{ echo json_encode("Insert Faild");}    
}

//2-get_byID
if($_GET['data'] == 'get_byid'){
    $result = $conn->prepare("select * from category where id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if($row = $result->fetch(PDO::FETCH_ASSOC)){
        $category[]  = array($row["id"],$row["categoryCode"],$row["categoryName"],$row["createdAt"]);
    }
    echo json_encode($category);
}

//3-update
if($_GET['data'] == 'update_category'){
    if(empty($_POST['categoryCode']) || empty($_POST['categoryName'])){
        echo json_encode("please check the empty field!");
    }else{

        $id = $_GET['id'];
        $categoryCode = $_POST['categoryCode'];
        $categoryName = $_POST['categoryName'];

        $sql = "Update category set categoryCode=:categoryCode,categoryName=:categoryName where id=:id;";
        $update = $conn->prepare($sql);

        $update->bindParam(':categoryCode',$categoryCode);
        $update->bindParam(':categoryName',$categoryName);
        $update->bindParam(':id', $id);
        if($update->execute()){
            echo json_encode("Update Success");
        }else{
            echo json_encode("Update Faild");
        }
    }
}

//4-delete
if($_GET['data'] == 'delete_category'){
    $id = $_GET['id'];
    $delete = $conn->prepare("DELETE FROM category WHERE id=:id;");
    $delete->bindParam(':id', $id);
    if($delete->execute()){
        echo json_encode("Delete Success");
    }else{
        echo json_encode("Delete Faild");
    }
}
?>