<?php

require '../includes/dbConnection.php';
if($_GET["data"] == "get_supplier"){
    $sql = "SELECT * FROM supplier";
    $result = $conn->prepare($sql);
  $result->execute();
  $supplier = [];
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $supplier[]  = array($row["id"],$row["supplierName"],$row["phone"],$row["email"],$row["createdAt"]);
  }
    echo json_encode($supplier);
}



//1-add_class
if($_GET["data"] == "add_supplier"){
  $supplierName = $_POST['supplierName'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

        $sql = "INSERT INTO supplier(supplierName,phone,email) VALUE(:supplierName,:phone,:email);";
        $insert = $conn->prepare($sql);
        $insert->bindParam(':supplierName',$supplierName);
        $insert->bindParam(':phone',$phone);
        $insert->bindParam(':email',$email);
        if($insert->execute()){
               echo json_encode("Insert Success");}
        else{ echo json_encode("Insert Faild");}    
}

//2-get_byID
if($_GET['data'] == 'get_byid'){
    $result = $conn->prepare("select * from supplier where id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if($row = $result->fetch(PDO::FETCH_ASSOC)){
      $supplier[]  = array($row["id"],$row["supplierName"],$row["phone"],$row["email"],$row["createdAt"]);
    }
    echo json_encode($supplier);
}

//3-update
if($_GET['data'] == 'update_supplier'){
    if(empty($_POST['supplierName']) || empty($_POST['phone'])){
        echo json_encode("please check the empty field!");
    }else{

        $id = $_GET['id'];
        $supplierName = $_POST['supplierName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $sql = "UPDATE supplier SET supplierName=:supplierName,phone=:phone,email=:email WHERE id=:id;";
        $update = $conn->prepare($sql);

        $update->bindParam(':supplierName',$supplierName);
        $update->bindParam(':phone',$phone);
        $update->bindParam(':email',$email);
        $update->bindParam(':id', $id);
        if($update->execute()){
            echo json_encode("Update Success");
        }else{
            echo json_encode("Update Faild");
        }
    }
}

//4-delete
if ($_GET['data'] == 'delete_supplier') {
    $id = $_GET['id'];

    // Check if the class exists in the "Student" table
    $checkSup = $conn->prepare("SELECT COUNT(*) FROM Import WHERE supplierId=:id");
    $checkSup->bindParam(':id', $id);
    $checkSup->execute();
    $supExists = $checkSup->fetchColumn();

    if ($supExists) {
        echo json_encode("Cannot delete it exists in the Import table");
    } else {
        $delete = $conn->prepare("DELETE FROM Supplier WHERE id=:id;");
        $delete->bindParam(':id', $id);
        if ($delete->execute()) {
            echo json_encode("Delete Success");
        } else {
            echo json_encode("Delete Failed");
        }
    }
}

?>