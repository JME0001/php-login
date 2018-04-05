	<?php
	require_once 'core/init.php';

	$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "jjo";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 

if (isset($_POST['reset'])){
		if(isset($_POST) & !empty($_POST)){
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$sql = "SELECT * FROM `users` WHERE username = '$username'";
			$res = mysqli_query($conn, $sql);
			$count = mysqli_num_rows($res);
			if($count == 1){
				//Send email to user with password
				$password = 'password';
				$salt = hash::salt(32);
				$pw = Hash::make($password, $salt);
				echo $pw;
				mail($username,"New Password", $password);
				//session::flash('home', 'If this email has an assosciated accounted, a new password has been emailed to it!');
				//redirect::to('index.php');
			}else{
				//User name does not exist in database
			}
		}
	}


				//Close connection
				$conn->close();

	?>


<head>
	<title>Log In</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">W6 Assignment</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Home</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
				<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
			</ul>
		</div>
	</nav>


	<br>

	<div class="container">

		<form class="well form-horizontal" action=" " method="post" >
			<fieldset>

				<!-- Form Name -->
				<legend>Log In!</legend>

				<!-- Text input-->

				<p id="errors"></p>

				<div class="form-group">
					<label class="col-md-4 control-label" >Email:</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input name="username" placeholder="Email Address" class="form-control"  type="text" value="<?php echo htmlspecialchars(Input::get('name')); ?>" id="username" onBlur="validate()">
						</div>
						<p id='result'></p>
					</div>
				</div>


				<div class="form-group">
					<label class="col-md-4 control-label"></label>
					<div class="col-md-4">
						<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
						<input type="submit" value="Reset Password" class="btn btn-default btn-lg btn-block" name="reset"><br>
					
					</div>
				</div>
			</div>
		</div>

	</fieldset>
</form>
</div>
</div><!-- /.container -->


</body>


