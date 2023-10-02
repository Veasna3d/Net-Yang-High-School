<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'netyangdb';
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!empty($_FILES['file']['name'])) {

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

    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        fgetcsv($csvFile);

        while (($getData = fgetcsv($csvFile, 10000, ',')) !== false) {

            $startYear = $getData[0];
            $endYear = $getData[1];
            $studentName = $getData[2];
            $image = !empty($getData[3]) ? "'" . mysqli_real_escape_string($conn, $getData[3]) . "'" : 'NULL';
            $gender = !empty($getData[4]) ? "'" . mysqli_real_escape_string($conn, $getData[4]) . "'" : 'NULL';
            $classId = !empty($getData[5]) ? "'" . mysqli_real_escape_string($conn, $getData[5]) . "'" : 'NULL';
            $birthday = !empty($getData[6]) ? "'" . mysqli_real_escape_string($conn, $getData[6]) . "'" : 'NULL';

            mysqli_query($conn, "INSERT INTO Student (startYear, endYear, studentName, image, gender, classId, birthday) VALUES ('$startYear', '$endYear', '$studentName', $image, $gender, $classId, $birthday)");
        }
        fclose($csvFile);

        echo "Success";
    } else {
        echo "Error1";
    }
} else {
    echo "Error2";
}

mysqli_close($conn);
?>
