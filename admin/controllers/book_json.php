<?php

require '../includes/dbConnection.php';
//Get Book
if ($_GET["data"] == "get_book") {
    $sql = "SELECT * from vBook WHERE status = 1";
    $result = $conn->prepare($sql);
    $result->execute();
    $book = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-success'>Available</span>";
        } else {
            $status = "<span class='badge badge-pill badge-danger'>Not Available</span>";
        }
        $book[] = array(
            $row["id"], $row["bookCode"],
            $row["bookTitle"], $row["authorName"], $row["publishingHouse"],
            $row["publishYear"], $row["price"], $row["categoryCode"], $row["image"],
            $status, $row["createdAt"]
        );
    }
    echo json_encode($book);
}

//Get not available
if ($_GET["data"] == "not_available") {
    $sql = "SELECT * from vBook  WHERE status = 0";
    $result = $conn->prepare($sql);
    $result->execute();
    $book = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-success'>Available</span>";
        } else {
            $status = "<span class='badge badge-pill badge-danger'>Not Available</span>";
        }
        $book[] = array(
            $row["id"], $row["bookCode"],
            $row["bookTitle"], $row["authorName"], $row["publishingHouse"],
            $row["publishYear"], $row["price"], $row["categoryCode"], $row["image"],
            $status, $row["createdAt"]
        );
    }
    echo json_encode($book);
}


//Get Print
if ($_GET['data'] == "get_print") {
    $sql = "SELECT * FROM Print";
    $result = $conn->prepare($sql);
    $result->execute();
    $print = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $print[] = array(
            $row['id'],
            $row['publishingHouse'], $row['printingHouse'], $row['createdAt']
        );
    }
    echo json_encode($print);
}
//Get Category
if ($_GET['data'] == "get_category") {
    $sql = "SELECT * FROM Category";
    $result = $conn->prepare($sql);
    $result->execute();
    $print = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $category[] = array(
            $row['id'],
            $row['categoryCode'], $row['categoryName'], $row['createdAt']
        );
    }
    echo json_encode($category);
}
if ($_GET["data"] == "add_book") {

    //Get the last bookCode value from the database
    $sql = "SELECT MAX(bookCode) as maxBookCode FROM Book";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $maxBookCode = $row['maxBookCode'];

    //Increment the value by 1 to generate the next bookCode
    if ($maxBookCode == NULL) {
        $bookCode = 10000001;
    } else {
        $bookCode = $maxBookCode + 1;
    }

    //Retrieve other form data
    $bookTitle = $_POST["txtBookTitle"];
    $print = $_POST["ddlPrint"];
    $author = $_POST["txtAuthor"];
    $category = $_POST["ddlCategory"];
    $publishYear = $_POST["txtPublishYear"];
    $price = $_POST["txtPrice"];
    $image = $_FILES['image']['name'];


    //Move the uploaded image file to the specified folder
    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    //Prepare and execute the SQL INSERT statement
    $sql = "INSERT INTO Book (bookCode, bookTitle, authorName, printId, publishYear, price, categoryId, image) VALUES 
                                (:bookCode, :bookTitle, :authorName, :printId,  :publishYear, :price, :categoryId, :image)";
    $insert = $conn->prepare($sql);
    $insert->bindParam(':bookCode', $bookCode);
    $insert->bindParam(':bookTitle', $bookTitle);
    $insert->bindParam(':authorName', $author);
    $insert->bindParam(':printId', $print);
    $insert->bindParam(':publishYear', $publishYear);
    $insert->bindParam(':price', $price);
    $insert->bindParam(':categoryId', $category);
    $insert->bindParam(':image', $image);

    if ($insert->execute()) {
        echo json_encode("Insert Success");
    } else {
        echo json_encode("Insert Failed");
    }
}
// 4 get_byid
if ($_GET['data'] == 'get_byid') {
    $result = $conn->prepare("SELECT * FROM vBook WHERE id=:id");
    $result->bindParam(':id', $_GET['id']);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] == 1) {
            $status = "<span class='badge badge-pill badge-success'>Available</span>";
        } else {
            $status = "<span class='badge badge-pill badge-danger'>Not Available</span>";
        }
        $book[] = array(
            $row["id"], $row["bookCode"],
            $row["bookTitle"], $row["authorName"], $row["publishingHouse"],
            $row["publishYear"], $row["price"], $row["categoryCode"], $row["image"],
            $status, $row["createdAt"]
        );
    }
    echo json_encode($book);
}

//5 Update Book
if ($_GET['data'] == 'update_book') {

    if (empty($_POST['txtBookTitle'])) {
        echo json_encode("Please check the empty fields!");
    } else {

        $id = $_GET['id'];
        $bookTitle = $_POST["txtBookTitle"];
        $print = $_POST["ddlPrint"];
        $author = $_POST["txtAuthor"];
        $category = $_POST["ddlCategory"];
        $publishYear = $_POST["txtPublishYear"];
        $price = $_POST["txtPrice"];

        // Check if a new image file was uploaded
        if (!empty($_FILES['image']['name'])) {
            // Get the image file and move it to the uploads directory
            $image = $_FILES['image']['name'];
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            // Get the old image file name from the database
            $stmt = $conn->prepare("SELECT image FROM Book WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $image = $row['image'];
        }

        // Update the image file and user data in the database
        $sql = "UPDATE Book SET bookTitle=:bookTitle, authorName=:authorName, printId=:printId,
             publishYear=:publishYear, price=:price, categoryId=:categoryId, image=:image where id=:id;";
        $update = $conn->prepare($sql);
        $update->bindParam(':image', $image);
        $update->bindParam(':bookTitle', $bookTitle);
        $update->bindParam(':authorName', $author);
        $update->bindParam(':printId', $print);
        $update->bindParam(':publishYear', $publishYear);
        $update->bindParam(':price', $price);
        $update->bindParam(':categoryId', $category);
        $update->bindParam(':id', $id);

        if ($update->execute()) {
            // If the update was successful, delete the old image file if it exists
            if (!empty($_FILES['image']['name'])) {
                if (isset($_POST['oldImage']) && !empty($_POST['oldImage'])) {
                    $old_image = $_POST['oldImage'];
                    if (file_exists('../upload/' . $old_image)) {
                        unlink('../upload/' . $old_image);
                    }
                }
            }
            echo json_encode("Update Success");
        } else {
            echo json_encode("Update Failed");
        }
    }
}

//Delete Book
if ($_GET['data'] == 'delete_book') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT image FROM Book WHERE id=:id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $result['image'];

    $delete = $conn->prepare("DELETE FROM Book WHERE id=:id;");
    $delete->bindParam(':id', $id);

    if ($delete->execute()) {
        // delete image from folder
        $target_file = "../upload/" . $image;
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        echo json_encode("Delete Success");
    } else {
        echo json_encode("Delete Failed");
    }
}

//Not available 
if($_GET['data'] == 'is_not_available'){
        
    $id = $_GET['id'];
    $status = 0;
    $sql = "UPDATE Book SET status=:status WHERE id=:id;";
    $update = $conn->prepare($sql);

    $update->bindParam(':status', $status);
    $update->bindParam(':id', $id);

    if($update->execute()){
        echo json_encode("Success");
    }else{
        echo json_encode("Faild");
    }
}

//available 
if($_GET['data'] == 'is_available'){
        
    $id = $_GET['id'];
    $status = 1;
    $sql = "UPDATE Book SET status=:status WHERE id=:id;";
    $update = $conn->prepare($sql);

    $update->bindParam(':status', $status);
    $update->bindParam(':id', $id);

    if($update->execute()){
        echo json_encode("Success");
    }else{
        echo json_encode("Faild");
    }
}

