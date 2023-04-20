<?php 

	$servername = "localhost";
	$database = "netyangdb";
	$username = "root";
	$password = "";

	try{
		$conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8",$username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo "Connection failed" . $e->getMessage();
	}

 ?>