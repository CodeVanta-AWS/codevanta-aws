<?php
	$db_server = "codevanta-db.c9yie6y44znf.ap-southeast-1.rds.amazonaws.com";
	$db_user = "codevanta_admin";
	$db_password = "codevanta2200";
	$db_name = "codevanta";

	try {
		$conn = new mysqli($db_server, $db_user, $db_password, $db_name);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
	} 
	catch (Exception $e) {
		die("Could not connect: " . $e->getMessage());
	}
?>
