<?php

$servername='localhost';
$username='root';
$password='';
$dbname = "netyangdb";
$conn=mysqli_connect($servername,$username,$password,"$dbname");

 
if(!empty($_FILES["file"]["name"]))
{
 
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
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
    {
 
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);
 
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
            {
                // Get row data
                $bookCode = $getData[0];
                $bookTitke = $getData[1];
                $authorName = $getData[2];
                $printId = $getData[3];
                $publishYear = $getData[4];
                $price = $getData[5];
                $categoryId = $getData[6];
              //  $image = $getData[7]; // image nullable
                // $status = $getData[8];
 
                // If user already exists in the database with the same email
               // If user already exists in the database with the same email
                $query = "SELECT id FROM Book WHERE bookCode = '" . $getData[0] . "'";

                $check = mysqli_query($conn, $query);

                if ($check->num_rows > 0)
                {
                    mysqli_query($conn, "UPDATE Book SET bookTitle = '".$bookTitke."', categoryId = '".$categoryId."', authorName = '".$authorName."', printId = '".$printId."', publishYear = '".$publishYear."', price = '".$price."', status = '".$status."', createdAt = NOW() WHERE bookCode = '" . $bookCode . "'");
                }

                else
                {
                    mysqli_query($conn, "INSERT INTO Book (bookCode, bookTitle, authorName, printId, publishYear, price, categoryId, status, createdAt) VALUES ('" . $bookCode . "', '" . $bookTitke . "', '" . $authorName. "', '" . $printId. "', '" . $publishYear. "', '" . $price. "', '" . $categoryId. "', '" . $status. "', NOW() )");

 
                }
            }
 
            // Close opened CSV file
            fclose($csvFile);
 
            echo "Success";
         
    }
    else
    {
        echo "Error1";
    }
}else{
  echo "Error2";  
}
?>