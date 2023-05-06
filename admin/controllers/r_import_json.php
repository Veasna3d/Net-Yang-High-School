<?php
require '../includes/dbConnection.php';

// Get Import
if ($_GET["data"] == "get_import") {
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

    $sql = "SELECT * FROM vImport WHERE 1=1";

    if (!empty($startDate) && !empty($endDate)) {
        $sql .= " AND receivedDate BETWEEN '$startDate' AND '$endDate'";
    }

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
?>
