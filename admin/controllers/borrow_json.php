<?php

require '../includes/dbConnection.php';
//Get Borrow
if ($_GET["data"] == "get_borrow") {
    $sql = "SELECT * FROM vBorrow WHERE status = 1";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-success'>បានខ្ចី</span>";
        } else {
            $status = "<span class='badge badge-pill badge-info'>បានសង</span>";
        }
        $borrow[] = array(
            $row["id"], $row["studentName"], $row["teacherName"],
            $row["bookTitle"], $row["borrowDate"], $row["returnDate"], $row["remark"],
            $status, $row["createdAt"]
        );
    }
    echo json_encode($borrow);
}

//Get Return
if ($_GET["data"] == "get_return") {
    $sql = "SELECT * FROM vBorrow WHERE status = 0";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-success'>បានខ្ចី</span>";
        } else {
            $status = "<span class='badge badge-pill badge-info'>បានសង</span>";
        }
        $borrow[] = array(
            $row["id"], $row["studentName"], $row["teacherName"],
            $row["bookTitle"], $row["borrowDate"], $row["returnDate"], $row["remark"],
            $status, $row["createdAt"]
        );
    }
    echo json_encode($borrow);
}

//Get Student
if ($_GET['data'] == "get_student") {
    $sql = "SELECT * FROM vStudent WHERE status = 1";
    $result = $conn->prepare($sql);
    $result->execute();
    $student = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $student[] = array(
            $row['id'], $row['startYear'], $row['endYear'], $row["studentName"],
            $row['image'],  $row['gender'], $row['className'],
            $row["birthday"],$row['createdAt']
        );
    }
    echo json_encode($student);
}


//Get Teacher
if ($_GET['data'] == "get_teacher") {
    $sql = "SELECT * FROM Teacher WHERE status = 1";
    $result = $conn->prepare($sql);
    $result->execute();
    $teacher = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $teacher[] = array(
            $row['id'], $row['teacherName'], $row['image'], $row["gender"],
            $row['phone'], $row['createdAt']
        );
    }
    echo json_encode($teacher);
}

//Get Book
if ($_GET['data'] == "get_book") {
    $sql = "SELECT * FROM vbookavailable";
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

//Add Borrow
// if ($_GET["data"] == "add_borrow") {
//     $student = !empty($_POST["ddlStudent"]) ? $_POST["ddlStudent"] : null;
//     $teacher = !empty($_POST["ddlTeacher"]) ? $_POST["ddlTeacher"] : null;
//     $book = !empty($_POST["ddlBook"]) ? $_POST["ddlBook"] : null;
//     $borrowDate = !empty($_POST["txtBorrowDate"]) ? $_POST["txtBorrowDate"] : null;
//     $returnDate = !empty($_POST["txtReturnDate"]) ? $_POST["txtReturnDate"] : null;
//     $remark = !empty($_POST["txtRemark"]) ? $_POST["txtRemark"] : null;

//     $sql = "INSERT INTO Borrow (studentId, teacherId, bookId, borrowDate, returnDate, remark) 
//             VALUES (:studentId, :teacherId, :bookId, :borrowDate, :returnDate, :remark)";
//     $insert = $conn->prepare($sql);
//     $insert->bindParam(':studentId', $student, PDO::PARAM_INT);
//     $insert->bindParam(':teacherId', $teacher, PDO::PARAM_INT);
//     $insert->bindParam(':bookId', $book, PDO::PARAM_INT);
//     $insert->bindParam(':borrowDate', $borrowDate, PDO::PARAM_STR);
//     $insert->bindParam(':returnDate', $returnDate, PDO::PARAM_STR);
//     $insert->bindParam(':remark', $remark, PDO::PARAM_STR);

//     if ($insert->execute()) {
//         echo json_encode("Insert Success");
//     } else {
//         echo json_encode("Insert Failed");
//     }
// }

// Add Borrow
if ($_GET["data"] == "add_borrow") {
    $student = !empty($_POST["ddlStudent"]) ? $_POST["ddlStudent"] : null;
    $teacher = !empty($_POST["ddlTeacher"]) ? $_POST["ddlTeacher"] : null;
    $book = !empty($_POST["ddlBook"]) ? $_POST["ddlBook"] : null;
    $borrowDate = !empty($_POST["txtBorrowDate"]) ? $_POST["txtBorrowDate"] : null;
    $returnDate = !empty($_POST["txtReturnDate"]) ? $_POST["txtReturnDate"] : null;
    $remark = !empty($_POST["txtRemark"]) ? $_POST["txtRemark"] : null;

    // Check book quantity from the "Import" table before inserting
    $bookQuantityQuery = "SELECT qty FROM Import WHERE bookId = :bookId";
    $bookQuantityStmt = $conn->prepare($bookQuantityQuery);
    $bookQuantityStmt->bindParam(':bookId', $book, PDO::PARAM_INT);
    $bookQuantityStmt->execute();
    $bookQuantity = $bookQuantityStmt->fetchColumn();

    if ($bookQuantity === false) {
        echo json_encode("Book not found");
    } else {
        if ($bookQuantity > 0) {
            // Book quantity is greater than 0, proceed with adding the borrow record
            $sql = "INSERT INTO Borrow (studentId, teacherId, bookId, borrowDate, returnDate, remark) 
                    VALUES (:studentId, :teacherId, :bookId, :borrowDate, :returnDate, :remark)";
            $insert = $conn->prepare($sql);
            $insert->bindParam(':studentId', $student, PDO::PARAM_INT);
            $insert->bindParam(':teacherId', $teacher, PDO::PARAM_INT);
            $insert->bindParam(':bookId', $book, PDO::PARAM_INT);
            $insert->bindParam(':borrowDate', $borrowDate, PDO::PARAM_STR);
            $insert->bindParam(':returnDate', $returnDate, PDO::PARAM_STR);
            $insert->bindParam(':remark', $remark, PDO::PARAM_STR);

            if ($insert->execute()) {
                // Reduce the book quantity in the "Import" table after successful borrow
                $updateQuantityQuery = "UPDATE Import SET qty = qty - 1 WHERE bookId = :bookId";
                $updateQuantityStmt = $conn->prepare($updateQuantityQuery);
                $updateQuantityStmt->bindParam(':bookId', $book, PDO::PARAM_INT);
                $updateQuantityStmt->execute();

                echo json_encode("Insert Success");
            } else {
                echo json_encode("Insert Failed");
            }
        } else {
            echo json_encode("Book quantity is 0");
        }
    }
}



//2-get_byID
if ($_GET['data'] == 'get_byid') {
    $result = $conn->prepare("SELECT * FROM Borrow WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $borrow[] = array(
            $row["id"], $row["studentId"], $row["teacherId"],
            $row["bookId"], $row["borrowDate"],
            $row["returnDate"], $row["remark"], $row["status"], $row["createdAt"]
        );
    }
    echo json_encode($borrow);
}

//3-update
if ($_GET['data'] == 'update_borrow') {
    if (empty($_POST['ddlStudent'])) {
        echo json_encode("please check the empty field!");
    } else {

        $id = $_GET['id'];
        $student = !empty($_POST["ddlStudent"]) ? $_POST["ddlStudent"] : null;
        $teacher = !empty($_POST["ddlTeacher"]) ? $_POST["ddlTeacher"] : null;
        $book = !empty($_POST["ddlBook"]) ? $_POST["ddlBook"] : null;
        $borrowDate = !empty($_POST["txtBorrowDate"]) ? $_POST["txtBorrowDate"] : null;
        $returnDate = !empty($_POST["txtReturnDate"]) ? $_POST["txtReturnDate"] : null;
        $remark = !empty($_POST["txtRemark"]) ? $_POST["txtRemark"] : null;

        $sql = "UPDATE Borrow SET studentId=:studentId, teacherId=:teacherId,
        bookId=:bookId,borrowDate=:borrowDate,returnDate=:returnDate, remark=:remark WHERE id=:id;";
        $update = $conn->prepare($sql);
        $update->bindParam(':studentId', $student, PDO::PARAM_INT);
        $update->bindParam(':teacherId', $teacher, PDO::PARAM_INT);
        $update->bindParam(':bookId', $book, PDO::PARAM_INT);
        $update->bindParam(':borrowDate', $borrowDate, PDO::PARAM_STR);
        $update->bindParam(':returnDate', $returnDate, PDO::PARAM_STR);
        $update->bindParam(':remark', $remark, PDO::PARAM_STR);
        $update->bindParam(':id', $id);
        if ($update->execute()) {
            echo json_encode("Update Success");
        } else {
            echo json_encode("Update Faild");
        }
    }
}

//4-delete
if ($_GET['data'] == 'delete_borrow') {
    $id = $_GET['id'];

    // Fetch the bookId from the Borrow table before deletion
    $fetchBookIdSql = "SELECT bookId FROM Borrow WHERE id=:id";
    $fetchBookIdStmt = $conn->prepare($fetchBookIdSql);
    $fetchBookIdStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $fetchBookIdStmt->execute();
    $bookId = $fetchBookIdStmt->fetchColumn();

    $delete = $conn->prepare("DELETE FROM Borrow WHERE id=:id;");
    $delete->bindParam(':id', $id);
    if ($delete->execute()) {
        if ($bookId !== false) {
            // Increase the book quantity in the Import table after deletion
            $increaseQtySql = "UPDATE Import SET qty = qty + 1 WHERE bookId = :bookId";
            $increaseQtyStmt = $conn->prepare($increaseQtySql);
            $increaseQtyStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $increaseQtyStmt->execute();
        }

        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}


//return 
if ($_GET['data'] == 'return_borrow') {
    $id = $_GET['id'];
    $status = 0;
    $sql = "UPDATE Borrow SET status=:status WHERE id=:id;";
    $update = $conn->prepare($sql);

    $update->bindParam(':status', $status);
    $update->bindParam(':id', $id);

    $increaseQty = false; // A flag to indicate whether the book quantity should be increased

    // Fetch the bookId from the Borrow table before updating the status
    $fetchBookIdSql = "SELECT bookId FROM Borrow WHERE id=:id";
    $fetchBookIdStmt = $conn->prepare($fetchBookIdSql);
    $fetchBookIdStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $fetchBookIdStmt->execute();
    $bookId = $fetchBookIdStmt->fetchColumn();

    // Check if the bookId was fetched successfully
    if ($bookId !== false) {
        $increaseQty = true; // BookId found, set the flag to true
    }

    // Execute the update to mark the book as returned
    if ($update->execute()) {
        if ($increaseQty) {
            // Increase the book quantity in the Import table
            $increaseQtySql = "UPDATE Import SET qty = qty + 1 WHERE bookId = :bookId";
            $increaseQtyStmt = $conn->prepare($increaseQtySql);
            $increaseQtyStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $increaseQtyStmt->execute();
        }

        echo json_encode("Return Success");
    } else {
        echo json_encode("Return Failed");
    }
}


//Get Borrow Detail
if ($_GET["data"] == "get_borrow_detail") {
    $result = $conn->prepare("SELECT * FROM vBorrowDetail WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if($row["remark"] == null){
            $remark = '...';
        }else{
            $remark = $row["remark"];
        }
        $borrow[] = array(
            $row["id"], $row["studentName"], $row["className"], $row["teacherName"],
            $row["bookTitle"], $row["borrowDate"], $row["returnDate"], $remark
        );
    }
    echo json_encode($borrow);
}
?>

