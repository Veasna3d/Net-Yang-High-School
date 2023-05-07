<?php

    require '../includes/dbConnection.php';
    if($_GET["data"] == "get_class"){
        $sql = "select * from Class";
        $result = $conn->prepare($sql);
		$result->execute();
        $class = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $class[] = array($row["id"], $row["className"],$row["createdAt"]);
        }
        echo json_encode($class);
    }

    //1-add_class
    if ($_GET["data"] == "add_class") {
        $className = $_POST["txtName"];
    
    
        $sql_check = "SELECT COUNT(*) FROM Class WHERE className = :className";
        $check = $conn->prepare($sql_check);
        $check->bindParam(':className', $className);
        $check->execute();
        $count = $check->fetchColumn();
    
        if ($count > 0) {
            echo json_encode("Class already exists");
            return;
        }
    
        $sql_insert = "INSERT INTO Class (className) VALUES (:className)";
        $insert = $conn->prepare($sql_insert);
        $insert->bindParam(':className', $className);
    
        if ($insert->execute()) {
            echo json_encode("Insert Success");
        } else {
            echo json_encode("Insert Failed");
        }
    }

    //2-get_byID
    if($_GET['data'] == 'get_byid'){
        $result = $conn->prepare("select * from Class where id=:id");
        $result->bindParam(':id', $_GET['id']);
        $result->execute();
        if($row = $result->fetch(PDO::FETCH_ASSOC)){
            $class[] = array($row['id'], $row['className'],$row['createdAt']);
        }
        echo json_encode($class);
    }

    //3-update
    if($_GET['data'] == 'update_class'){

        if(empty($_POST['txtName'])){
            echo json_encode("Please check the empty fields!");
        }else{
            $id = $_GET['id'];
            $className = $_POST["txtName"];
    
    
            // Check if the new username already exists in the database
            $stmt = $conn->prepare("SELECT * FROM Class WHERE className=:className AND id!=:id");
            $stmt->bindParam(':className', $className);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                echo json_encode("Class already exists");
            } else {
    
                // Update the image file and user data in the database
                $sql = "UPDATE Class SET className=:className where id=:id;";
                $update = $conn->prepare($sql);
                $update->bindParam(':className', $className);
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
    if($_GET['data'] == 'delete_class'){
        $id = $_GET['id'];
        $delete = $conn->prepare("DELETE FROM Class WHERE id=:id;");
        $delete->bindParam(':id', $id);
        if($delete->execute()){
            echo json_encode("Delete Success");
        }else{
            echo json_encode("Delete Faild");
        }
    }
?>