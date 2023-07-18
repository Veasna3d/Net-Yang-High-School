<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'netyangdb';
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Load the database configuration file
// include('./config/db.php');

if (!empty($_FILES['file']['name'])) {

    // Allowed mime types
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );

    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {

        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        // Skip the first line
        fgetcsv($csvFile);

        // Parse data from CSV file line by line
        while (($getData = fgetcsv($csvFile, 10000, ',')) !== false) {
            // Get row data
            $bookCode = $getData[0];
            $bookTitle = $getData[1];
            $authorName = $getData[2];
            $printId = $getData[3] !== '' ? $getData[3] : 'NULL';
            $publishYear = $getData[4];
            $price = $getData[5];
            $categoryId = $getData[6] !== '' ? $getData[6] : 'NULL';
            $status = 1;

            // If user already exists in the database with the same email
            $query = "SELECT id FROM Book WHERE bookCode = '" . $getData[0] . "'";

            $check = mysqli_query($conn, $query);

            if ($check->num_rows > 0) {
                mysqli_query($conn, "UPDATE Book SET bookTitle = '" . $bookTitle . "', authorName = '" . $authorName . "', printId = " . $printId . ", publishYear = '" . $publishYear . "', price = '" . $price . "', categoryId = " . $categoryId . ", status = " . $status . " WHERE bookCode = '" . $bookCode . "'");
            } else {
                mysqli_query($conn, "INSERT INTO Book (bookCode, bookTitle, authorName, printId, publishYear, price, categoryId, status) VALUES ('" . $bookCode . "', '" . $bookTitle . "', '" . $authorName . "', " . $printId . ", '" . $publishYear . "', '" . $price . "', " . $categoryId . ", " . $status . ")");
            }
        }

        // Close opened CSV file
        fclose($csvFile);

        echo "Success";
    } else {
        echo "Error1";
    }
} else {
    echo "Error2";
}
?>
