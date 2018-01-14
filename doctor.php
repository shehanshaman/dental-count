<?php 
    @ob_start();
    session_start();
    require_once('connection.php'); 
?>

<?php 

	//admins
	if(isset($_POST['submit_admin'])) {
		$errors = array();
		//check enter user id
		if (!isset($_POST['user_name']) ) {
			$errors[] = 'User name is Missing / Invalid';
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password']) < 1)) {
			$errors[] = 'User password is Missing / Invalid';
		}

		if (!isset($_POST['number']) || strlen(trim($_POST['number']) < 1)) {
			$errors[] = 'User value is Missing / Invalid';
		}

		if (!isset($_POST['optradio'])) {
			$errors[] = 'Select any button';
		}

		//check if there is an error
		if(empty($errors)){

			//id to variable
			$user_name = mysqli_real_escape_string($connection, $_POST['user_name']);

			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$number = mysqli_real_escape_string($connection, $_POST['number']);

			//database query
			$query = "SELECT * FROM doctor 
						WHERE user_name = '{$user_name}'
						AND pwd = '{$password}'
						LIMIT 1";

			$result_set = mysqli_query($connection, $query);

			if($result_set){
				//query sussesfull

				if(mysqli_num_rows($result_set) == 1){
					//valid user found
					$admin = mysqli_fetch_assoc($result_set);
					$_SESSION['user_name'] = $admin['user_name'];

					//add last login date
					$query = "UPDATE doctor SET last_update = NOW() WHERE user_name = '{$_SESSION['user_name']}' LIMIT 1";


					$result_set = mysqli_query($connection, $query);

					if(!$result_set){
						die("Database query failed.");
					}
					
					$query = "UPDATE doctor SET online = 1  WHERE user_name = '{$_SESSION['user_name']}' LIMIT 1";

					$result_set = mysqli_query($connection, $query);

					if(!$result_set){
						die("Database 2nd query failed.");
					}
					
					$_SESSION['type'] = $_POST['optradio'];
					$_SESSION['val'] = $number;
					$_SESSION['my_patient'] = '0';
					$_SESSION['count'] = '0';
					$_SESSION['start'] = '0';
					
					if ($_SESSION['type'] == 'n') {
						$_SESSION['max'] = $number;
						
					}else{
						$_SESSION['max'] = time()+ 60*60*$number;
					}
					//echo $_SESSION['type'];

					header('Location: index.php');
				}else{
					$errors[] = 'Invalid user';
				}

			}else{
				$errors[] = 'Database query failed';
			}
		}
	}

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>LOG IN</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="page.css">
	
</head>
<body>
	<div class="top_bar col-sm-12 col-xs-12">
		<div class="db_name">
			<p>Welcome to User Mangement System</p>
		</div>
	</div><!-- top_bar -->
	
	<div class="middle">
		
		<div class="search_usr clearfix">
			<form action="index.php" method="post">
				<fieldset>
					<legend>

						<?php 

							if(isset($_GET['logout'])){
								echo '<div class="alert alert-success alert-dismissable fade in log_out">
									    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									    <strong>Success!</strong> You have successfully Log Out from the system
									  </div>';
							}

						 ?>

						<?php 
							if (isset($error_search) && !empty($error_search)) {
								echo '<div class="alert alert-danger alert-dismissable fade in">
									    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									    <strong>Danger!</strong> Invalid Id
									  </div>';
							}

						 ?>
					</legend>
				</fieldset>
			</form>
		</div><!-- search_usr -->

		<div class="admin_login clearfix">
			<form action="doctor.php" method="post">
				<fieldset>
					<legend>

						<h1>LOG IN</h1>

						<?php 
							if (isset($errors) && !empty($errors)) {
								/*echo '<div class="alert alert-danger alert-dismissable fade in">
									    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									    <strong>Danger!</strong> Invalid User Name or Password
									  </div>';*/
									  echo '<div class="alert alert-danger alert-dismissable fade in">';
									  for($x = 0; $x < count($errors); $x++) {
										    echo $errors[$x];
										    echo "<br>";
										}
									echo "</div>";
							}

						 ?>

						<p>
							<label>User ID : </label>
							<input class="form-control" type="txt" name="user_name" placeholder="Enter your user name">
							<label>Password : </label>
							<input class="form-control" type="password" name="password" placeholder="Enter your Password">
						</p>

						<p>
							<div class="radio">
						      <label><input type="radio" name="optradio" value="t">time</label>
						    </div>
						    <div class="radio">
						      <label><input type="radio" name="optradio" value="n">number</label>
						    </div>
						</p>

						<p>
							<input class="form-control" type="txt" name="number" placeholder="Enter your value">
						</p>

						<p>
							<button type ="submit" name="submit_admin" class="btn btn-success">LOG IN </button>
						</p>
						
					</legend>
				</fieldset>
			</form>		
		</div>

	</div>

	<div class="col-sm-12 col-xs-12">
		<div class="create col-sm-9 col-xs-12">
			
		</div>
		<div class="link col-sm-3 col-xs-12">
			
		</div>
	</div>
</body>
</html>
<?php mysqli_close($connection); ?>