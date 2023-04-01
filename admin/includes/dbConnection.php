<?php 

	$servername = "localhost";
	$database = "netyangdb";
	$username = "root";
	$password = "";

	try{
		$conn = new PDO("mysql:host=$servername;dbname=$database",$username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Conncetion successfully!";
	}
	catch(PDOException $e)
	{
		echo "Connection failed" . $e->getMessage();
	}

 ?>