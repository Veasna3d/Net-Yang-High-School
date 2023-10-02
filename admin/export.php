<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'netyangdb';
$connect = mysqli_connect($servername, $username, $password, $dbname);

//export.php  
if (!empty($_FILES["excel_file"])) {  
    $file_array = explode(".", $_FILES["excel_file"]["name"]);  
    if ($file_array[1] == "xls") {  
        include("PHPExcel/IOFactory.php");
        $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);
        $successCount = 0;

        foreach ($object->getWorksheetIterator() as $worksheet) {  
            $highestRow = $worksheet->getHighestRow();  
            for ($row = 2; $row <= $highestRow; $row++) {  
                $bookCode = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());  
                $bookTitle = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
                $authorName = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());  
                $printId = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());  
                $publishYear = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  
                $price = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());  
                $categoryId = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());  

                $query = "  
                    INSERT INTO book  
                    (bookCode, bookTitle, authorName, printId, publishYear, price, categoryId)   
                    VALUES ('".$bookCode."', '".$bookTitle."', '".$authorName."', '".$printId."', '".$publishYear."', '".$price."', '".$categoryId."')  
                ";  
                if (mysqli_query($connect, $query)) {  
                    $successCount++;
                }
            }  
        }

        // Send the response back to the front-end
        $response = array(
            'success' => true,
            'message' => 'Excel file data has been imported successfully.',
            'successCount' => $successCount
        );
        echo json_encode($response);
    } else {  
        // Send the response back to the front-end
        $response = array(
            'success' => false,
            'message' => 'Invalid File. Please upload an Excel file with .xls extension.'
        );
        echo json_encode($response);
    }  
}
