<?php

require '../includes/dbConnection.php';
//Get Borrow
if ($_GET["data"] == "get_borrow") {
    $sql = "SELECT * FROM vBorrow";
    $result = $conn->prepare($sql);
    $result->execute();
    $borrow = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-primary'>បានខ្ចី</span>";
        } else {
            $status = "<span class='badge badge-pill badge-info'>បានសង</span>";
        }
        $borrow[] = array(
            $row["id"], $row["studentName"], $row["teacherName"],
            $row["className"], $row["bookTitle"], $row["borrowDate"], $row["returnDate"], $row["remark"],
            $status, $row["createdAt"]
        );
    }
    echo json_encode($borrow);
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
if ($_GET['data'] == "get_student") {
    $sql = "SELECT * FROM vStudent";
    $result = $conn->prepare($sql);
    $result->execute();
    $student = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $student[] = array(
            $row['id'], $row['startYear'], $row['endYear'], $row["studentName"],
            $row['image'],  $row['gender'], $row['className'],
            $row["birthday"], $row["password"], $row['createdAt']
        );
    }
    echo json_encode($student);
}

//Get Class
if ($_GET['data'] == "get_class") {
    $sql = "SELECT * FROM Class";
    $result = $conn->prepare($sql);
    $result->execute();
    $class = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $class[] = array(
            $row['id'],
            $row['className'], $row['createdAt']
        );
    }
    echo json_encode($class);
}

//Get Teacher
if ($_GET['data'] == "get_teacher") {
    $sql = "SELECT * FROM Teacher";
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

//Add Borrow
if ($_GET["data"] == "add_borrow") {
    $student = !empty($_POST["ddlStudent"]) ? $_POST["ddlStudent"] : null;
    $teacher = !empty($_POST["ddlTeacher"]) ? $_POST["ddlTeacher"] : null;
    $class = !empty($_POST["ddlClass"]) ? $_POST["ddlClass"] : null;
    $book = !empty($_POST["ddlBook"]) ? $_POST["ddlBook"] : null;
    $borrowDate = !empty($_POST["txtBorrowDate"]) ? $_POST["txtBorrowDate"] : null;
    $returnDate = !empty($_POST["txtReturnDate"]) ? $_POST["txtReturnDate"] : null;
    $remark = !empty($_POST["txtRemark"]) ? $_POST["txtRemark"] : null;

    $sql = "INSERT INTO Borrow (studentId, teacherId, classId, bookId, borrowDate, returnDate, remark) 
            VALUES (:studentId, :teacherId, :classId, :bookId, :borrowDate, :returnDate, :remark)";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':studentId', $student, PDO::PARAM_INT);
    $insert->bindParam(':teacherId', $teacher, PDO::PARAM_INT);
    $insert->bindParam(':classId', $class, PDO::PARAM_INT);
    $insert->bindParam(':bookId', $book, PDO::PARAM_INT);
    $insert->bindParam(':borrowDate', $borrowDate, PDO::PARAM_STR);
    $insert->bindParam(':returnDate', $returnDate, PDO::PARAM_STR);
    $insert->bindParam(':remark', $remark, PDO::PARAM_STR);

    if ($insert->execute()) {
        echo json_encode("Insert Success");
    } else {
        echo json_encode("Insert Failed");
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
            $row["classId"], $row["bookId"], $row["borrowDate"],
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
        $class = !empty($_POST["ddlClass"]) ? $_POST["ddlClass"] : null;
        $book = !empty($_POST["ddlBook"]) ? $_POST["ddlBook"] : null;
        $borrowDate = !empty($_POST["txtBorrowDate"]) ? $_POST["txtBorrowDate"] : null;
        $returnDate = !empty($_POST["txtReturnDate"]) ? $_POST["txtReturnDate"] : null;
        $remark = !empty($_POST["txtRemark"]) ? $_POST["txtRemark"] : null;

        $sql = "UPDATE Borrow SET className=:className WHERE id=:id;";
        $update = $conn->prepare($sql);

        $update->bindParam(':className', $name);
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
    $delete = $conn->prepare("DELETE FROM Borrow WHERE id=:id;");
    $delete->bindParam(':id', $id);
    if ($delete->execute()) {
        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Faild");
    }
}
