<?php

    require '../includes/dbConnection.php';
    if($_GET["data"] == "get_print"){
        $sql = "select * from print";
        $result = $conn->prepare($sql);
		$result->execute();
        $print = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $print[] = array($row["id"], $row["publishingHouse"],$row["printingHouse"],$row["createdAt"]);
        }
        echo json_encode($print);
    }

    if ($_GET['data'] == 'check_print_name') {
        $publishingHouse = $_POST['publishingHouse'];
        $printingHouse = $_POST['printingHouse'];

       $query = "SELECT COUNT(*) as count FROM print WHERE publishingHouse = :publishingHouse AND printingHouse = :printingHouse";
        $statement = $conn->prepare($query);
        $statement->bindValue(':publishingHouse', $publishingHouse);
        $statement->bindValue(':printingHouse', $printingHouse);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        echo json_encode(['exists' => $count > 0]);
        exit;
    }
    

    //1-add_class
    if($_GET["data"] == "add_print"){
        $publishingHouse = $_POST['publishingHouse'];
        $printingHouse = $_POST['printingHouse'];

            $sql = "INSERT INTO print(publishingHouse,printingHouse) VALUE(:publishingHouse,:printingHouse);";
            $insert = $conn->prepare($sql);
            $insert->bindParam(':publishingHouse', $publishingHouse);
            $insert->bindParam(':printingHouse', $printingHouse);
            if($insert->execute()){
                   echo json_encode("Insert Success");}
            else{ echo json_encode("Insert Faild");}    
    }

    //2-get_byID
    if($_GET['data'] == 'get_byid'){
        $result = $conn->prepare("select * from print where id=:id");
        $result->bindParam(':id', $_GET['id']);
        $result->execute();
        if($row = $result->fetch(PDO::FETCH_ASSOC)){
            $print[] = array($row["id"], $row["publishingHouse"],$row["printingHouse"],$row["createdAt"]);
        }
        echo json_encode($print);
    }

    //3-update
    if($_GET['data'] == 'update_print'){
        if(empty($_POST['publishingHouse'] || empty($_POST['printingHouse']))){
            echo json_encode("please check the empty field!");
        }else{

            $id = $_GET['id'];
            $publishingHouse = $_POST['publishingHouse'];
            $printingHouse = $_POST['printingHouse'];

            $sql = "Update print set publishingHouse=:publishingHouse,printingHouse=:printingHouse where id=:id;";
            $update = $conn->prepare($sql);

            $update->bindParam(':publishingHouse', $printingHouse);
            $update->bindParam(':printingHouse', $printingHouse);
            $update->bindParam(':id', $id);
            if($update->execute()){
                echo json_encode("Update Success");
            }else{
                echo json_encode("Update Faild");
            }
        }
    }

    //4-delete
    if($_GET['data'] == 'delete_print'){
        $id = $_GET['id'];
        $delete = $conn->prepare("DELETE FROM print WHERE id=:id;");
        $delete->bindParam(':id', $id);
        if($delete->execute()){
            echo json_encode("Delete Success");
        }else{
            echo json_encode("Delete Faild");
        }
    }
?>