<?php

    require '../includes/dbConnection.php';
    if($_GET["data"] == "get_read"){
        $sql = "select * from vRead";
        $result = $conn->prepare($sql);
		$result->execute();
        $read = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $read[] = array($row["id"], $row["studentName"], $row["date"],
            $row["bookTitle"],$row["createdAt"]);
        }
        echo json_encode($read);
    }

    // if ($_GET['data'] == 'check_class_name') {
    //     $name = $_POST['name'];
    //     $query = "SELECT COUNT(*) as count FROM Class WHERE className = :name";
    //     $statement = $conn->prepare($query);
    //     $statement->bindValue(':name', $name);
    //     $statement->execute();
    //     $row = $statement->fetch(PDO::FETCH_ASSOC);
    //     $count = $row['count'];
    //     echo json_encode(['exists' => $count > 0]);
    //     exit;
    // }
    
    	//Get Student
	if($_GET['data'] == "get_student"){
        $sql = "SELECT * FROM vStudent";
        $result = $conn->prepare($sql);
        $result->execute();
        $student = [];

        while( $row = $result->fetch(PDO::FETCH_ASSOC)){

            $student[] = array($row['id'], $row['startYear'],$row['endYear'], $row["studentName"], 
            $row['image'],  $row['gender'],$row['className'],
            $row["birthday"], $row["password"], $row['createdAt']);
            
        }
        echo json_encode($student);
    }

     	//Get Book
	if($_GET['data'] == "get_book"){
        $sql = "SELECT * FROM vBook";
        $result = $conn->prepare($sql);
        $result->execute();
        $book = [];

        while( $row = $result->fetch(PDO::FETCH_ASSOC)){
            $book[] = array($row["id"], $row["bookCode"],
            $row["bookTitle"],$row["authorName"],$row["publishingHouse"],
            $row["publishYear"],$row["price"],$row["categoryCode"],$row["image"],
            $row["status"],$row["createdAt"]);
            
        }
        echo json_encode($book);
    }


    //1-add_reader
    if($_GET["data"] == "add_read"){
            $student = $_POST["ddlStudent"];
            $date = $_POST["txtDate"];
            $book = $_POST["ddlBook"];

            $sql = "INSERT INTO Reader (studentId,date,bookId) VALUES (:studentId,:date,:bookId);";
            $insert = $conn->prepare($sql);
            $insert->bindParam(':studentId', $student);
            $insert->bindParam(':date', $date);
            $insert->bindParam(':bookId', $book);

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
    if($_GET['data'] == 'update_read'){
        if(empty($_POST['ddlStudent'])){
            echo json_encode("please check the empty field!");
        }else{

            $id = $_GET['id'];
            $student = $_POST["ddlStudent"];
            $date = $_POST["txtDate"];
            $book = $_POST["ddlBook"];

            $sql = "UPDATE Reader SET studentId=:studentId,date=:date, bookId=:bookId WHERE id=:id;";
            $update = $conn->prepare($sql);

            $update->bindParam(':studentId', $student);
            $update->bindParam(':date', $date);
            $update->bindParam(':bookId', $book);
            $update->bindParam(':id', $id);
            if($update->execute()){
                echo json_encode("Update Success");
            }else{
                echo json_encode("Update Faild");
            }
        }
    }

    //4-delete
    if($_GET['data'] == 'delete_read'){
        $id = $_GET['id'];
        $delete = $conn->prepare("DELETE FROM Reader WHERE id=:id;");
        $delete->bindParam(':id', $id);
        if($delete->execute()){
            echo json_encode("Delete Success");
        }else{
            echo json_encode("Delete Faild");
        }
    }
?>