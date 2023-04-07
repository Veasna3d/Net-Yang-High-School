<?php
require '../includes/dbConnection.php';

//Get Import
if ($_GET["data"] == "get_import") {
    $sql = "SELECT * FROM vImport";
    $result = $conn->prepare($sql);
    $result->execute();
    $import = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $import[] = array(
            $row['id'], $row['receivedDate'], $row['bookTitle'],
            $row["supplierName"], $row['qty'], $row['createdAt']
        );
    }
    echo json_encode($import);
}

//Get Book
if ($_GET['data'] == "get_book") {
    $sql = "SELECT * FROM vBook";
    $result = $conn->prepare($sql);
    $result->execute();
    $book = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $book[] = array(
            $row["id"], $row["bookCode"],
            $row["bookTitle"], $row["authorName"], $row["publishingHouse"],
            $row["publishYear"], $row["price"], $row["categoryCode"], $row["image"],
            $row["status"], $row["createdAt"]
        );
    }
    echo json_encode($book);
}
//Get Supplier
if ($_GET['data'] == "get_supplier") {
    $sql = "SELECT * FROM Supplier";
    $result = $conn->prepare($sql);
    $result->execute();
    $supplier = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $supplier[] = array(
            $row['id'], $row['supplierName'], $row['phone'],
            $row['email'], $row['createdAt']
        );
    }
    echo json_encode($supplier);
}

//Add Student
if ($_GET["data"] == "add_import") {

    $receivedDate = $_POST["txtReceivedDate"];
    $book = $_POST["ddlBook"];
    $supplier = $_POST["ddlSupplier"];
    $qty = $_POST["txtQty"];

    $sql = "INSERT INTO Import (receivedDate, bookId,supplierId, qty) VALUES 
                                (:receivedDate, :bookId, :supplierId, :qty)";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':receivedDate', $receivedDate);
    $insert->bindParam(':bookId', $book);
    $insert->bindParam(':supplierId', $supplier);
    $insert->bindParam(':qty', $qty);


    if ($insert->execute()) {
        echo json_encode("Insert Success");
    } else {
        echo json_encode("Insert Failed");
    }
}


// 4 get_byid
if ($_GET['data'] == 'get_byid') {
    $result = $conn->prepare("SELECT * FROM Import WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $import[] = array(
            $row['id'], $row['receivedDate'], $row['bookId'],
            $row["supplierId"], $row['qty'], $row['createdAt']
        );
    }
    echo json_encode($import);
}

//5 Update Book
if ($_GET['data'] == 'update_import') {

    if (empty($_POST['txtReceivedDate'])) {
        echo json_encode("Please check the empty fields!");
    } else {
        $id = $_GET['id'];
        $receivedDate = $_POST["txtReceivedDate"];
        $book = $_POST["ddlBook"];
        $supplier = $_POST["ddlSupplier"];
        $qty = $_POST["txtQty"];


        $sql = "UPDATE Import SET receivedDate=:receivedDate, bookId=:bookId,
         supplierId=:supplierId, qty=:qty where id=:id;";
        $update = $conn->prepare($sql);
        $update->bindParam(':receivedDate', $receivedDate);
        $update->bindParam(':bookId', $book);
        $update->bindParam(':supplierId', $supplier);
        $update->bindParam(':qty', $qty);
        $update->bindParam(':id', $id);

        if ($update->execute()) {
            echo json_encode("Update Success");
        } else {
            echo json_encode("Update Failed");
        }
    }
}

//Delete Import    
if ($_GET['data'] == 'delete_import') {
    $id = $_GET['id'];
    $delete = $conn->prepare("DELETE FROM Import WHERE id=:id;");
    $delete->bindParam(':id', $id);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Faild");
    }
}
