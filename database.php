<?php
	$db_server = "localhost";
	$db_user = "root";
	$db_password = "";
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