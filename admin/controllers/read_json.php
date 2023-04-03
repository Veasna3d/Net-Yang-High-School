<?php

    require '../includes/dbConnection.php';
    if($_GET["data"] == "get_read"){
        $sql = "select * from vReader";
        $result = $conn->prepare($sql);
		$result->execute();
        $read = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $read[] = array($row["id"], $row["studentName"], $row["gender"],$row["date"],$row["bookTitle"],$row["createdAt"]);
        }
        echo json_encode($read);
    }

    if ($_GET['data'] == 'check_class_name') {
        $name = $_POST['name'];
        $query = "SELECT COUNT(*) as count FROM Class WHERE className = :name";
        $statement = $conn->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        echo json_encode(['exists' => $count > 0]);
        exit;
    }
    
    	//Get Student
	if($_GET['data'] == "get_student"){
        $sql = "SELECT * FROM Student";
        $result = $conn->prepare($sql);
        $result->execute();
        $student = [];

        while( $row = $result->fetch(PDO::FETCH_ASSOC)){

            $student[] = array($row['id'], $row['startYear'],$row['endYear'], $row["studentName"], 
            $row['image'],  $row['gender'],$row['classId'],
            $row["birthday"], $row["password"], $row['createdAt']);
            
        }
        echo json_encode($student);
    }

     	//Get Book
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


    //1-add_class
    if($_GET["data"] == "add_class"){
            $name = $_POST["txtName"];

            $sql = "INSERT INTO Class (className) VALUES (:className);";
            $insert = $conn->prepare($sql);
            $insert->bindParam(':className', $name);

            if($insert->execute()){
                   echo json_encode("Insert Success");}
            else{ echo json_encode("Insert Faild");}    
    }

    //2-get_byID
    if($_GET['data'] == 'get_byid'){
        $result = $conn->prepare("select * from Reader where id=:id");
        $result->bindParam(':id', $_GET['id']);
        $result->execute();
        if($row = $result->fetch(PDO::FETCH_ASSOC)){
            $class[] = array($row['id'], $row['studentId'],$row['date'],$row['bookId'],$row['createdAt']);
        }
        echo json_encode($class);
    }

    //3-update
    if($_GET['data'] == 'update_class'){
        if(empty($_POST['txtName'])){
            echo json_encode("please check the empty field!");
        }else{

            $id = $_GET['id'];
            $name = $_POST['txtName'];

            $sql = "Update Class set className=:className where id=:id;";
            $update = $conn->prepare($sql);

            $update->bindParam(':className', $name);
            $update->bindParam(':id', $id);
            if($update->execute()){
                echo json_encode("Update Success");
            }else{
                echo json_encode("Update Faild");
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