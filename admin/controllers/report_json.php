<?php

    require '../includes/dbConnection.php';
    //1get_sale 
//   if ($_GET["data"] =="get_supp") {
//     $sql = "SELECT * FROM vsupplier";
//     $result = $conn->prepare($sql);
//     $result->execute();
//     $import = [];
//     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//       $import[] = array($row["id"],$row["bookTitle"],$row["supName"],$row["categoryName"],$row["qty"],$row["impDate"]);
//     }
//     echo json_encode($import);
//   }
//    //4 get_suppbydate
//    if ($_GET["data"] == "get_suppbydate") {
//     $date1 = $_GET["date1"];
//     $date2 = $_GET["date2"];
//     $result = $conn->prepare("SELECT * FROM  vsupplier where impDate between :date1 and :date2");
//     $result->bindParam(':date1',$date1);
//     $result->bindParam(':date2',$date2);
//     $result->execute();
//     $import = [];
//     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//       $import[] = array($row["id"],$row["bookTitle"],$row["supName"],$row["categoryName"],$row["qty"],$row["impDate"]);
//     }
//     echo json_encode($import);
// }

//   if ($_GET["data"] =="get_totalBook") {
//     $sql = "SELECT * FROM totalbook";
//     $result = $conn->prepare($sql);
//     $result->execute();
//     $tatalBook = [];
//     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//       $tatalBook[] = array($row["id"],$row["bookTitle"],$row["categoryName"],$row["create_date"]);
//     }
//     echo json_encode($tatalBook);
//   }

  //get borrow
  if ($_GET["data"] =="get_vborrow") {
    $sql = "SELECT * FROM  rBorrow";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $borrow[] = array($row["id"],$row["bookTitle"],$row["studentName"],$row["borrowDate"],
            $row["returnDate"],$row["create_date"]);
    }
    echo json_encode($borrow);
  }

  //4 get_borrowbydate
  if ($_GET["data"] == "get_borrowbydate") {
        $date1 = $_GET["date1"];
        $date2 = $_GET["date2"];
        $result = $conn->prepare("SELECT * FROM  rBorrow where borrowDate between :date1 and :date2");
        $result->bindParam(':date1',$date1);
        $result->bindParam(':date2',$date2);
        $result->execute();
        $borrow = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $borrow[] = array($row["id"],$row["bookTitle"],$row["studentName"],$row["borrowDate"],
            $row["returnDate"],$row["create_date"]);
        }
        echo json_encode($borrow);
    }


?>