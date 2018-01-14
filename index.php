<?php 
	 session_start();
	require_once('connection.php'); 
	date_default_timezone_set('Europe/Rome');

	if (!isset($_SESSION['user_name'])) {
		header("Location:doctor.php");
	}
	
	$type =  $_SESSION['type'];
	$max = $_SESSION['max'];
	$my_patient = $_SESSION['my_patient'];
	$val = $_SESSION['val'];
	$count = $_SESSION['count'];
	$total = '';
	$error = '';
/*
	echo $val."/";
	echo $max-time()."/";
	echo time()."/";
*/
	$query = "select * from patient";
	$result_set = mysqli_query($connection, $query);
	$total = mysqli_num_rows($result_set);

	$query = "select * from doctor where online = 1";
	$result_set = mysqli_query($connection, $query);
	$online_doctors = mysqli_num_rows($result_set);

	if ($type == 'n') {
		$count = $_SESSION['count'];
	}else if($type == 't'){
		$count = time();
	}

	if (isset($_POST['next'])) {
		//echo "enter";
		$query = "select no from line";
		$result_set = mysqli_query($connection, $query);

		if($result_set){
			if(mysqli_num_rows($result_set) == 1){
				$row = mysqli_fetch_assoc($result_set);

				if ($row['no']<$total) {
					$_SESSION['my_patient'] = $row['no']+1;
					//echo $_SESSION['my_patient'];
					$my_patient = $_SESSION['my_patient'];

					$query = "UPDATE line SET no = no+1";
					$result_set = mysqli_query($connection, $query);

					if(!$result_set){
						die("Database query failed.");
					}

					$_SESSION['count'] = $_SESSION['count'] + 1;
					$count = $_SESSION['count'];

					$my_patient = $_SESSION['my_patient'];

					$query = "UPDATE line SET last_patient_time = NOW()";
					$result_set = mysqli_query($connection, $query);

					if(!$result_set){
						die("Couldn't update last patient time.");
					}

					if ($_SESSION['start']!='0') {

						$duration = time() - $_SESSION['start'];
						$duration = $duration/60;
						//echo $duration;

						//$query = "call avg_time('{$duration}')";
						//$result_set = mysqli_query($connection, $query);
						
						//dont use procedure
						$query = "SET @count := (select patient_count from line)";
						$result_set = mysqli_query($connection, $query);
						
						$query = "update line set patient_avg = (patient_avg * @count + dif)/(@count+1)";
						$result_set = mysqli_query($connection, $query);
						
						$query = "update line set patient_count = patient_count + 1";
						$result_set = mysqli_query($connection, $query);

						if(!$result_set){
							die("coudn't update avg time");
						}

						$_SESSION['start'] = time();
					}else{
						$_SESSION['start'] = time();
					}
				}else{
					$error = '<div class="alert alert-info">
							  <strong>Info!</strong> There are no patients
							</div>';
				}
			}
		}

		


	}else if (isset($_POST['reset'])) {
		$query = "UPDATE line SET no = 0";
		$result_set = mysqli_query($connection, $query);

		$_SESSION['my_patient'] = '0';
		$my_patient = $_SESSION['my_patient'];

		if(!$result_set){
			die("Database query failed.");
		}
	}

	$per = '';
	if ($type == 'n') {
		$per = $count*100/$max;
	}else if($type = 't'){
		$a = time();
		$per = (($val*60*60)-($max-$a))*100/($val*60*60);
	}

	$display = '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.round($per,2).'" aria-valuemin="0" aria-valuemax="100" style="width:'.round($per,2).'%">
		      '.round($per,2).'%
		    </div>';
	$timeout = '';
	$timeout1 = '';
	if ($per==100) {
		$timeout =  '<div class="alert alert-warning alert-dismissable">
			    <a href="log_out.php" class="close" data-dismiss="alert" aria-label="close">×</a>
			    <strong>Warning!</strong> Your time out. Your account will logout automatically within 3s.
			  </div>';
		$timeout1 = '<script type="text/javascript">
			setTimeout(function () {
		  //do something once
		   window.location.href = "log_out.php";
		}, 3000); 
		</script>';
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Doctor</title>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="4">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<div class="conterner clearfix">
		<div class="top">
			<div class="name">
				<h3>Hello <?php echo $_SESSION['user_name']; ?></h3>
			</div>

			<div class="logout">
				<a href="log_out.php">Log out</a>
			</div>

		</div>

		

		<div class="button-top">
			<form action="index.php" method="post" class="button-top">
				<button type="submit" class="btn btn-default col-sm-6" name="next">Next</button>
			  <button type="submit" class="btn btn-danger col-sm-5" name="reset">Reset</button>
			</form>
			  
		</div>

		<?php 
			echo $timeout;
			echo $timeout1;
			echo $error;
	 	?>

		<div class="details">
			<table class="table table-striped">
				<tr><td>Current Patient no </td> 
					<td><?php echo $my_patient; ?></td>
				</tr>
				<tr>
					<td>Total patints </td>
					<td><?php echo $total; ?></td>
				</tr>
				<tr>
					<td>Number of patients (I Checked)</td>
					<td><?php echo $count; ?></td>
				</tr>
				<tr>
					<td>Number of online doctors</td>
					<td><?php echo $online_doctors; ?></td>
				</tr>

			</table>
		</div>

		<div class="progress fixed_bottom_doctor">
		    <?php echo $display; ?>
		</div>
	</div>
</body>
</html>