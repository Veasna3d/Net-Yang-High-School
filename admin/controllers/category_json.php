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




//1-add_category
if ($_GET["data"] == "add_category") {
    $categoryCode = $_POST["categoryCode"];
    $categoryName = $_POST["categoryName"];


    $sql_check = "SELECT COUNT(*) FROM Category WHERE categoryCode = :categoryCode";
    $check = $conn->prepare($sql_check);
    $check->bindParam(':categoryCode', $categoryCode);
    $check->execute();
    $count = $check->fetchColumn();

    if ($count > 0) {
        echo json_encode("Category code already exists");
        return;
    }

    $sql_insert = "INSERT INTO Category (categoryCode, categoryName) VALUES (:categoryCode, :categoryName)";
    $insert = $conn->prepare($sql_insert);
    $insert->bindParam(':categoryCode', $categoryCode);
    $insert->bindParam(':categoryName', $categoryName);

    if ($insert->execute()) {
        echo json_encode("Insert Success");
    } else {
        echo json_encode("Insert Failed");
    }
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

    if(empty($_POST['categoryCode'])){
        echo json_encode("Please check the empty fields!");
    }else{
        $id = $_GET['id'];
        $categoryCode = $_POST["categoryCode"];
        $categoryName = $_POST["categoryName"];


        // Check if the new username already exists in the database
        $stmt = $conn->prepare("SELECT * FROM Category WHERE categoryCode=:categoryCode AND id!=:id");
        $stmt->bindParam(':categoryCode', $categoryCode);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo json_encode("Category code already exists");
        } else {

            // Update the image file and user data in the database
            $sql = "UPDATE Category SET categoryCode=:categoryCode, categoryName=:categoryName where id=:id;";
            $update = $conn->prepare($sql);
            $update->bindParam(':categoryCode', $categoryCode);
            $update->bindParam(':categoryName', $categoryName);
            $update->bindParam(':id', $id);

            if($update->execute()){
                echo json_encode("Update Success");
            }else{
                echo json_encode("Update Failed");
            }
        }
    }
}

//4-delete
if ($_GET['data'] == 'delete_category') {
    $id = $_GET['id'];

    // Check if the category exists in the "Book" table
    $checkCategory = $conn->prepare("SELECT COUNT(*) FROM Book WHERE categoryId=:id");
    $checkCategory->bindParam(':id', $id);
    $checkCategory->execute();
    $categoryExists = $checkCategory->fetchColumn();

    if ($categoryExists) {
        echo json_encode("Cannot delete it exists in the Book table");
    } else {
        $delete = $conn->prepare("DELETE FROM Category WHERE id=:id;");
        $delete->bindParam(':id', $id);
        if ($delete->execute()) {
            echo json_encode("Delete Success");
        } else {
            echo json_encode("Delete Failed");
        }
    }
}

?>