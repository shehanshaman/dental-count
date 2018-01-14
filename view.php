<?php 
	require_once('connection.php'); 
	require_once('function.php'); 

	$num = '';
	$change = '';
	$x0 = '';
	$x1 = '';
	$x2 = '';
	$print0 = '';
	$print1 = '';
	$print2 = '';
	$print3 = '';

	$query = "SELECT * from line";
	$result_set = mysqli_query($connection, $query);

	if($result_set){
		if(mysqli_num_rows($result_set) == 1){
			$row = mysqli_fetch_assoc($result_set);
			$num = $row['no'];
			$change = $row['ischange'];
			if ($num!=$change) {
				$query = "UPDATE line SET ischange = '{$num}'";
				$result_set = mysqli_query($connection, $query);

				if(!$result_set){
					die("Database query failed.");
				}else if ($num==0) {
					$num = 0;
				}
				else{
					$num = $change+1;
					$x0 = $num%10;
					$x1 = ($num%100-$x0)/10;
					$x2 = ($num%1000-$x0-$x1*10)/100;

					$print0 = '<audio id="myAudio0">
								  <source src="sound/number.mp3" type="audio/mpeg">
								  Your browser does not support the audio element.
								</audio>';

					$print1 = '<audio id="myAudio1">
								  <source src="sound/'.$x2.'.mp3" type="audio/mpeg">
								  Your browser does not support the audio element.
								</audio>';
					$print2 = '<audio id="myAudio2">
								  <source src="sound/'.$x1.'.mp3" type="audio/mpeg">
								  Your browser does not support the audio element.
								</audio>';
					$print3 = '<audio id="myAudio3">
								  <source src="sound/'.$x0.'.mp3" type="audio/mpeg">
								  Your browser does not support the audio element.
								</audio>';
				}
			}
		}else{
			echo "error row";
		}
	}else{
		echo "error";
	}

	//estimation
	$query = "select * from patient";
	$result_set = mysqli_query($connection, $query);
	$total = mysqli_num_rows($result_set);

	$next_no = $total - $num;
	$est = array();
	$est_time = array();

	if ($next_no>5) {
		$div = $next_no/5;

		$est[0] = $num+$div;
		$est[1] = $num+($div*2);
		$est[2] = $num+($div*3);
		$est[3] = $num+($div*4);
		$est[4] = $num+($div*5);

		$est_time[0] = set_time($est[0]);
		$est_time[1] = set_time($est[1]);
		$est_time[2] = set_time($est[2]);
		$est_time[3] = set_time($est[3]);
		$est_time[4] = set_time($est[4]);

		/*$est_time[0] = addExtraTime($est_time[0]);
		$est_time[1] = addExtraTime($est_time[1]);
		$est_time[2] = addExtraTime($est_time[2]);
		$est_time[3] = addExtraTime($est_time[3]);
		$est_time[4] = addExtraTime($est_time[4]);*/
		
	}else{
		$est[0] = '';
		$est[1] = '';
		$est[2] = '';
		$est[3] = '';
		$est[4] = '';

		$est_time[0] = '';
		$est_time[1] = '';
		$est_time[2] = '';
		$est_time[3] = '';
		$est_time[4] = '';
	}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>view</title>
 	<meta http-equiv="refresh" content="4">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 	<link rel="stylesheet" type="text/css" href="main.css">
 </head>
 <body>
 	<div class="fixed_top">
 		<p>DENTAL HOSPITAL PERADENIYA OPD</p>
 	</div>
 	<div class="container">
 		<?php 
 			echo $print0;
 			echo $print1;
 			echo $print2;
 			echo $print3;
 		 ?>
 	</div>
 	<div class="middle">
 		<h1><?php echo str_pad($num,3,"0",STR_PAD_LEFT); ?></h1>
 	</div>

 	<div class="estimate fixed_bottom col-sm-12">
 		<div class="col-sm-2 sub">Next numbers</div>
 		<div class="col-sm-2"><?php echo round($est[0],0); ?></div>
 		<div class="col-sm-2"><?php echo round($est[1],0); ?></div>
 		<div class="col-sm-2"><?php echo round($est[2],0); ?></div>
 		<div class="col-sm-2"><?php echo round($est[3],0); ?></div>
 		<div class="col-sm-2"><?php echo round($est[4],0); ?></div>

 		<div class="col-sm-2 sub"> Estimated Time</div>
 		<div class="col-sm-2 dis_time"><?php echo $est_time[0]; ?></div>
 		<div class="col-sm-2 dis_time"><?php echo $est_time[1]; ?></div>
 		<div class="col-sm-2 dis_time"><?php echo $est_time[2]; ?></div>
 		<div class="col-sm-2 dis_time"><?php echo $est_time[3]; ?></div>
 		<div class="col-sm-2 dis_time"><?php echo $est_time[4]; ?></div>
 	</div>
 	<script>

		var n = document.getElementById("myAudio0"); 
		var x = document.getElementById("myAudio3"); 
		var y = document.getElementById("myAudio2"); 
		var z = document.getElementById("myAudio1"); 

		setTimeout(function () {
		  //do something once
		   n.play();
		}, 0); 
		setTimeout(function () {
		  //do something once
		   z.play();
		}, 1000);
		setTimeout(function () {
		  //do something once
		   y.play();
		}, 2000);

		setTimeout(function () {
		  //do something once
		   x.play();
		}, 3000);

	</script>
 </body>
 </html>