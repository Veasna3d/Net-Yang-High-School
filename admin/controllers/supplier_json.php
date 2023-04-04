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

if ($_GET['data'] == 'check_supplier_name') {
  $supplierName = $_POST['supplierName'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

   $query = "SELECT COUNT(*) as count FROM supplier WHERE supplierName = :supplierName AND phone = :phone AND email = :email";
    $statement = $conn->prepare($query);
    $statement->bindValue(':supplierName', $supplierName);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    echo json_encode(['exists' => $count > 0]);
    exit;
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
    if(empty($_POST['supplierName']) || empty($_POST['phone']) || empty($_POST['email'])){
        echo json_encode("please check the empty field!");
    }else{

        $id = $_GET['id'];
        $supplierName = $_POST['supplierName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $sql = "Update supplier set supplierName=:supplierName,phone=:phone,email=:email where id=:id;";
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
if($_GET['data'] == 'delete_supplier'){
    $id = $_GET['id'];
    $delete = $conn->prepare("DELETE FROM supplier WHERE id=:id;");
    $delete->bindParam(':id', $id);
    if($delete->execute()){
        echo json_encode("Delete Success");
    }else{
        echo json_encode("Delete Faild");
    }
}
?>