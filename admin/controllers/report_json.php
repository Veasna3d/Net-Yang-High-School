<?php

require '../includes/dbConnection.php';


//date Reader
if ($_GET["data"] == "get_reader") {
  $date1 = $_GET["date1"];
  $date2 = $_GET["date2"];
  $new_date1 = date('Y-m-d H:i:s', strtotime($date1 . ' 00:00:00')); 
  $new_date2 = date('Y-m-d H:i:s', strtotime($date2 . ' 23:59:59')); 

  try {
      $result = $conn->prepare("SELECT * FROM vReadDetail WHERE date BETWEEN :date1 AND :date2");
      $result->bindParam(':date1', $new_date1);
      $result->bindParam(':date2', $new_date2);
      $result->execute();

      $read = [];
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $date = new DateTime($row["date"]);
          $formattedDate = $date->format('d-M-Y, h:i A');

          $read[] = array(
              $row["id"],
              $row["studentName"],
              $row["gender"],
              $row["className"],
              $formattedDate,
              $row["bookTitle"],
              $row["createdAt"]
          );
      }

      echo json_encode($read);
  } catch (PDOException $e) {
      // Handle database connection errors
      echo "Error: " . $e->getMessage();
  }
}



//4 Get Teacher Borrow
if ($_GET["data"] == "get_teacherBorrow") {
  $date1 = $_GET["date1"];
  $date2 = $_GET["date2"];
  $new_date1 = date('d-F-Y', strtotime($date1));
  $new_date2 = date('d-F-Y', strtotime($date2));
  $result = $conn->prepare("SELECT * FROM vTeacherBorrow WHERE STR_TO_DATE(borrowDate, '%d-%M-%Y') BETWEEN STR_TO_DATE(:date1, '%d-%M-%Y') AND STR_TO_DATE(:date2, '%d-%M-%Y')");
  // $result = $conn->prepare("SELECT * FROM  vTeacherBorrow  where createdAt between STR_TO_DATE(:date1, '%Y-%m-%d') and STR_TO_DATE(:date2, '%Y-%m-%d')");
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
    $borrow[] = array(
      $row["id"], $row["bookTitle"], $row["teacherName"], $row["borrowDate"],
      $row["returnDate"], $status, $row["createdAt"]
    );
  }
  echo json_encode($borrow);
}

//Get Student Borrow
if ($_GET["data"] == "get_studentBorrow") {
  $date1 = $_GET["date1"];
  $date2 = $_GET["date2"];
  $new_date1 = date('d-F-Y', strtotime($date1));
  $new_date2 = date('d-F-Y', strtotime($date2));
  $result = $conn->prepare("SELECT * FROM vStudentBorrow WHERE STR_TO_DATE(borrowDate, '%d-%M-%Y') BETWEEN STR_TO_DATE(:date1, '%d-%M-%Y') AND STR_TO_DATE(:date2, '%d-%M-%Y')");
  // $result = $conn->prepare("SELECT * FROM  vStudentBorrow  where createdAt between STR_TO_DATE(:date1, '%Y-%m-%d') and STR_TO_DATE(:date2, '%Y-%m-%d')");
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
    $borrow[] = array(
      $row["id"], $row["bookTitle"], $row["studentName"], $row["className"],
      $row["borrowDate"], $row["returnDate"], $status, $row["createdAt"]
    );
  }
  echo json_encode($borrow);
}

//Get Collection of Book
if ($_GET["data"] == "get_book") {
  $date1 = $_GET["date1"];
  $date2 = $_GET["date2"];
  $new_date1 = date('d-F-Y', strtotime($date1));
  $new_date2 = date('d-F-Y', strtotime($date2));

  try {
    $result = $conn->prepare("SELECT * FROM vBindBook WHERE STR_TO_DATE(receivedDate, '%d-%M-%Y') BETWEEN STR_TO_DATE(:date1, '%d-%M-%Y') AND STR_TO_DATE(:date2, '%d-%M-%Y')");
    $result->bindParam(':date1', $new_date1);
    $result->bindParam(':date2', $new_date2);
    $result->execute();

    $book = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $book[] = array(
        $row["bookCode"],
        $row["receivedDate"],
        $row["authorName"],
        $row["bookTitle"],
        $row["publishingHouse"],
        $row["printingHouse"],
        $row["publishYear"],
        $row["supplierName"],
        $row["price"],
        $row["qty"],
        $row["categoryCode"],
        $row["createdAt"]
      );
    }

    echo json_encode($book);
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
