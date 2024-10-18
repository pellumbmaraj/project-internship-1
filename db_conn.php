<?php 
	//require __DIR__ . "./config.php";

	$host = "localhost";
	$uname = "root";
	$password = "";
	$db_name = "bookstore";

	try {
		$conn = new PDO("mysql:host=$host;dbname=$db_name", $uname, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $err) {
		echo "Connection failed: ".$err->getMessage();
	}

?>