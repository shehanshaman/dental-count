<?php 
	
	

	function play_number($num){
		/*$x0 = $num%10;
		$x1 = ($num%100-$x0)/10;
		$x2 = ($num%1000-$x0-$x1*10)/100;
		*/
		$out = '';

		$out .=  "<audio controls autoplay>";
		$out .=  "<source src=sound/".$num.".wav type='audio/mpeg'>";
		/*$out .= "sleep(1)";
		$out .=  "<source src=sound/".$x1.".wav type='audio/mpeg'>";
		$out .= "sleep(1)";
		$out .=  "<source src=sound/".$x0.".wav type='audio/mpeg'>";
		$out .= "sleep(1)";*/
		$out .= "</audio>";
	    
	    return $out;
	}

	function set_time($x){

		//require_once('connection.php');

			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '1234';
			$dbname = 'dental';

			$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);


			//checking the connection
			if (mysqli_connect_errno()){
				die('Database connection failed'.mysqli_connect_error());
			}


		date_default_timezone_set('Asia/Colombo');

		$query = "select * from line";
		$result_set = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($result_set);


		$query = "select * from doctor where online = 1";
		$result_set = mysqli_query($connection, $query);
		$online_doctors = mysqli_num_rows($result_set);

		$avg = $row['patient_avg'];
		$last_patient_time = $row['last_patient_time'];

		if ($online_doctors) {
			$x = $x*$avg/$online_doctors;

			$m = ($x%60);
			$x = $x/60;
			$h = $x%60;

			//echo $m;
			//echo $h;

			$z = "+".$h." hour +".$m." minutes";

			$startTime = date("h:ia",strtotime($last_patient_time));
			//echo $startTime;

			$cenvertedTime = date('h:ia',strtotime($z,strtotime($startTime)));

			//echo $cenvertedTime;
		}else{
			$cenvertedTime = 0;
		}
		

		return $cenvertedTime;
	}

	function addExtraTime($start)
	{
		return date('h:ia',strtotime('+1 hour +30 minutes',strtotime($start)));
	}
?>