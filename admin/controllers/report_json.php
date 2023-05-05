<?php

    require '../includes/dbConnection.php';

    //get ​teacher borrow
   if ($_GET["data"] =="get_vReader") {
    $sql = "SELECT * FROM rReader";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $borrow[] = array($row["id"],$row["studentName"],$row["gender"],$row["className"],$row["bookTitle"],$row["date"]);
    }
    echo json_encode($borrow);
  }

  //4 get_borrowbydate teacher
  if ($_GET["data"] == "get_Readerbydate") {
        $date1 = $_GET["date1"];
        $date2 = $_GET["date2"];
        $result = $conn->prepare("SELECT * FROM  rReader  where date between :date1 and :date2");
        $result->bindParam(':date1',$date1);
        $result->bindParam(':date2',$date2);
        $result->execute();
        $borrow = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $borrow[] = array($row["id"],$row["studentName"],$row["gender"],$row["className"],$row["bookTitle"],$row["date"]);
        }
        echo json_encode($borrow);
    }

   //get ​teacher borrow
   if ($_GET["data"] =="get_vTeacherBorrow") {
    $sql = "SELECT * FROM  rTeacherBorrow ";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $borrow[] = array($row["id"],$row["bookTitle"],$row["teacherName"],$row["borrowDate"],
            $row["returnDate"],$row["createdAt"]);
    }
    echo json_encode($borrow);
  }

  //4 get_borrowbydate teacher
  if ($_GET["data"] == "get_Teacherborrowbydate") {
        $date1 = $_GET["date1"];
        $date2 = $_GET["date2"];
        $result = $conn->prepare("SELECT * FROM  rTeacherBorrow  where createdAt between :date1 and :date2");
        $result->bindParam(':date1',$date1);
        $result->bindParam(':date2',$date2);
        $result->execute();
        $borrow = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $borrow[] = array($row["id"],$row["bookTitle"],$row["teacherName"],$row["borrowDate"],
            $row["returnDate"],$row["createdAt"]);
        }
        echo json_encode($borrow);
    }


  //get rborrow
  if ($_GET["data"] =="get_vborrow") {
    $sql = "SELECT * FROM  rBorrow";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $borrow[] = array($row["id"],$row["bookTitle"],$row["studentName"],$row["className"],$row["borrowDate"],
            $row["returnDate"],$row["createdAt"]);
    }
    echo json_encode($borrow);
  }

  //4 get_borrowbydate
  if ($_GET["data"] == "get_borrowbydate") {
        $date1 = $_GET["date1"];
        $date2 = $_GET["date2"];
        $result = $conn->prepare("SELECT * FROM  rBorrow where createdAt between :date1 and :date2");
        $result->bindParam(':date1',$date1);
        $result->bindParam(':date2',$date2);
        $result->execute();
        $borrow = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $borrow[] = array($row["id"],$row["bookTitle"],$row["studentName"],$row["className"],$row["borrowDate"],
            $row["returnDate"],$row["createdAt"]);
        }
        echo json_encode($borrow);
    }


?>