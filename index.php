<?php
require_once 'core/init.php';

$user = new user();

?>

<head>
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

	<?php 

	if ($user->isLoggedIn()){

		?>

		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">W6 Assignment</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="changepassword.php"><span class="glyphicon glyphicon-question-sign"></span> Reset Password</a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
			</ul>
		</div>
	</nav>

	<?php 
} else {
	?>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">W6 Assignment</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Home</a></li>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
		</ul>
	</div>
</nav>

	<div class="container">
		<div class="alert alert-danger">
			<strong>Alert!</strong> You are not currently logged in, please <a style="text-decoration: none" href="login.php"><Strong><u>log in</u></Strong></a> or <a style="text-decoration: none" href="register.php"><Strong><u>register</u></Strong></a> an account!
		</div>
	</div>

<?php } ?>

<br>

<?php

if(session::exists('home')){
	echo 
	'<div class="container">
	<div class="alert alert-success">
	<strong>Success! </strong>'
	. 
	session::flash('home') 
	. 
	'</div>
	</div>';
}

?>


	<?php 

	if ($user->isLoggedIn()){

		?>

<!-- Page Content -->
<div class="container">
	<div class="well">
	<div class="row">
		<div class="col-lg-12 text-center">
			<p class="lead">Welcome <?php echo $user->_data[4] ?>, you have now signed in! :) </p>
			<ul class="list-group">
			  <li class="list-group-item" width="250px">User ID: <?php echo $user->_data[0] ?></li>
			  <li class="list-group-item">Name: <?php echo $user->_data[4] ?></li>
			  <li class="list-group-item">Joined at: <?php echo $user->_data[5] ?></li>
			</ul>
		</div>
	</div>
</div>
</div>

<?php } ?>

<!-- Welcome Content -->
<div class="container">
	<div class="well">
	<div class="row">
		<div class="col-lg-12 text-center">
			<h1 class="mt-5">CSCU9W6 Assignment</h1>
			<p class="lead">Welcome to the home page for Jamie Johnston's W6 Assignment!</p>
			<p>Built using the following technologies:</p>
			<img src="https://zippy.gfycat.com/UnhappyEnchantedBellsnake.gif" width="415" height="171">
			<ul class="list-unstyled">
				<li>Bootstrap 4.0.0</li>
				<li>PHP 7.1.14</li>
				<li>JavaScript</li>
			</ul>
		</div>
	</div>
</div>
</div>



</body>
