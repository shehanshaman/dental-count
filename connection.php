<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '1234';
	$dbname = 'dental';

	$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);


	//checking the connection
	if (mysqli_connect_errno()){
		die('Database connection failed'.mysqli_connect_error());
	}

?>