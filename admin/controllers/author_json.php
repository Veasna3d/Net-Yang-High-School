<?php

    require '../includes/dbConnection.php';
    if($_GET["data"] == "get_author"){
        $sql = "select * from author";
        $result = $conn->prepare($sql);
		$result->execute();
        $class = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $class[] = array($row["id"], $row["authorName"],$row["createdAt"]);
        }
        echo json_encode($class);
    }

    if ($_GET['data'] == 'check_author_name') {
        $name = $_POST['name'];
        $query = "SELECT COUNT(*) as count FROM author WHERE authorName = :name";
        $statement = $conn->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        echo json_encode(['exists' => $count > 0]);
        exit;
    }
    

    //1-add_class
    if($_GET["data"] == "add_author"){
            $name = $_POST["txtName"];

            $sql = "INSERT INTO author(authorName) VALUE(:authorName);";
            $insert = $conn->prepare($sql);
            $insert->bindParam(':authorName', $name);

            if($insert->execute()){
                   echo json_encode("Insert Success");}
            else{ echo json_encode("Insert Faild");}    
    }

    //2-get_byID
    if($_GET['data'] == 'get_byid'){
        $result = $conn->prepare("select * from author where id=:id");
        $result->bindParam(':id', $_GET['id']);
        $result->execute();
        if($row = $result->fetch(PDO::FETCH_ASSOC)){
            $class[] = array($row['id'], $row['authorName'],$row['createdAt']);
        }
        echo json_encode($class);
    }

    //3-update
    if($_GET['data'] == 'update_author'){
        if(empty($_POST['txtName'])){
            echo json_encode("please check the empty field!");
        }else{

            $id = $_GET['id'];
            $name = $_POST['txtName'];

            $sql = "Update author set authorName=:authorName where id=:id;";
            $update = $conn->prepare($sql);

            $update->bindParam(':authorName', $name);
            $update->bindParam(':id', $id);
            if($update->execute()){
                echo json_encode("Update Success");
            }else{
                echo json_encode("Update Faild");
            }
        }
    }

    //4-delete
    if($_GET['data'] == 'delete_author'){
        $id = $_GET['id'];
        $delete = $conn->prepare("DELETE FROM author WHERE id=:id;");
        $delete->bindParam(':id', $id);
        if($delete->execute()){
            echo json_encode("Delete Success");
        }else{
            echo json_encode("Delete Faild");
        }
    }
?>