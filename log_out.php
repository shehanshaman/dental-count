<?php 
	@ob_start();
	session_start();
	require_once('connection.php'); 

	$query = "UPDATE doctor SET online = 0  WHERE user_name = '{$_SESSION['user_name']}' LIMIT 1";

	$result_set = mysqli_query($connection, $query);

	if(!$result_set){
		die("Database query failed.");
	}

	$_SESSION = array();

	if (isset($_COOKIE[session_name()])) {
		# code...
		setcookie(session_start(),'',time()-86400,'/');
	}

	session_destroy();

	header('Location:doctor.php?logout=yes');

 ?>