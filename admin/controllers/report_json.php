<?php

    require '../includes/dbConnection.php';


//date Reader
if ($_GET["data"] == "get_reader") {
  $date1 = $_GET["date1"];
  $date2 = $_GET["date2"];
  $new_date1 = date('Y-m-d', strtotime($date1)); // convert string to date format
  $new_date2 = date('Y-m-d', strtotime($date2)); 
  $result = $conn->prepare("SELECT * FROM  vReadDetail  where createdAt between STR_TO_DATE(:date1, '%Y-%m-%d') and STR_TO_DATE(:date2, '%Y-%m-%d')");
  $result->bindParam(':date1', $new_date1);
  $result->bindParam(':date2', $new_date2);

  $result->execute();
  $read = [];
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

      $date = new DateTime($row["date"]);
      $formattedDate = $date->format('d-M-Y, h:i A');

      $read[] = array($row["id"],$row["studentName"],$row["gender"],$row["className"],
      $formattedDate,$row["bookTitle"],$row["createdAt"]);
  }
  echo json_encode($read);
}

    //4 Get Teacher Borrow
    if ($_GET["data"] == "get_seacherBorrow") {
      $date1 = $_GET["date1"];
      $date2 = $_GET["date2"];
      $new_date1 = date('Y-m-d', strtotime($date1)); // convert string to date format
      $new_date2 = date('Y-m-d', strtotime($date2)); 
      $result = $conn->prepare("SELECT * FROM  vTeacherBorrow  where createdAt between STR_TO_DATE(:date1, '%Y-%m-%d') and STR_TO_DATE(:date2, '%Y-%m-%d')");
      $result->bindParam(':date1', $new_date1);
      $result->bindParam(':date2', $new_date2);

      $result->execute();
      $borrow = [];
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
          $status = "<span class='badge badge-pill badge-success'>បានខ្ចី</span>";
      } else {
          $status = "<span class='badge badge-pill badge-info'>បានសង</span>";
      }
          $borrow[] = array($row["id"],$row["bookTitle"],$row["teacherName"],$row["borrowDate"],
          $row["returnDate"],$status,$row["createdAt"]);
      }
      echo json_encode($borrow);
  }

    //Get Student Borrow
    if ($_GET["data"] == "get_studentBorrow") {
      $date1 = $_GET["date1"];
      $date2 = $_GET["date2"];
      $new_date1 = date('Y-m-d', strtotime($date1)); // convert string to date format
      $new_date2 = date('Y-m-d', strtotime($date2)); 
      $result = $conn->prepare("SELECT * FROM  vStudentBorrow  where createdAt between STR_TO_DATE(:date1, '%Y-%m-%d') and STR_TO_DATE(:date2, '%Y-%m-%d')");
      $result->bindParam(':date1', $new_date1);
      $result->bindParam(':date2', $new_date2);

      $result->execute();
      $borrow = [];
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
          $status = "<span class='badge badge-pill badge-success'>បានខ្ចី</span>";
      } else {
          $status = "<span class='badge badge-pill badge-info'>បានសង</span>";
      }
          $borrow[] = array($row["id"],$row["bookTitle"],$row["studentName"],$row["className"],
          $row["borrowDate"],$row["returnDate"],$status,$row["createdAt"]);
      }
      echo json_encode($borrow);
  }

    //Get Collection of Book
    if ($_GET["data"] == "get_book") {
      $date1 = $_GET["date1"];
      $date2 = $_GET["date2"];
      $new_date1 = date('Y-m-d', strtotime($date1)); // convert string to date format
      $new_date2 = date('Y-m-d', strtotime($date2)); 
      $result = $conn->prepare("SELECT * FROM  vBindBook  where createdAt between STR_TO_DATE(:date1, '%Y-%m-%d') and STR_TO_DATE(:date2, '%Y-%m-%d')");
      $result->bindParam(':date1', $new_date1);
      $result->bindParam(':date2', $new_date2);

      $result->execute();
      $book = [];
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $book[] = array($row["bookCode"],$row["receivedDate"],$row["authorName"],$row["bookTitle"],
          $row["publishingHouse"],$row["printingHouse"],$row["publishYear"],$row["supplierName"],
          $row["price"],$row["qty"],$row["categoryCode"],$row["createdAt"]);
      }
      echo json_encode($book);
  }

?>