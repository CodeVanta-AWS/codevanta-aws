<?php
	$db_server = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "codevanta";
	$db_conn = "";

	try {
		$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

		if($conn) {
			echo "You are connected!" 
		} 
		else { 
			echo "Could not connect" 
		}
	}
    catch (mysqli_sql_exception) {
        echo "Could not connect!"
    }

    if($conn) {
        echo "You are connected!"    
    }
?>