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

if ($_GET["data"] == "get_date_value") {
   // Get the latest date value from the database
$sql = "SELECT MAX(receivedDate) AS max_date FROM vImport";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$maxDate = $row['max_date'];

// Return the date value as a JSON string
echo json_encode($maxDate);
}

?>

