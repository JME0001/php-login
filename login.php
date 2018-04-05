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

	<?php
	require_once 'core/init.php';

	if(Input::exists()){

		if(token::check(Input::get('token'))) {

			$validate = new validate();
			$validation = $validate->check($_POST, array(

				'username' => array('required' 	=> 'true'),
				'password' => array('required' 	=> 'true')
			));

			if($validation->passed()) {
			//Log user in

				$user = new user();
				$login = $user->login(Input::get('username'), Input::get('password'));

				if($login){
					session::flash('home', 'You are now logged in!');
					redirect::to('index.php');
				} else {
					echo '

					<div class="container">
					<div class="alert alert-danger">
					<strong>Alert!</strong> You entered incorrect credentials, please try again!
					</div>
					</div>

					';
				}

			} else {
				foreach($validation->errors() as $error){

				}

			}
		}
	}

	?>

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
					<label class="col-md-4 control-label" >Password</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input name="password" placeholder="Password" class="form-control"  type="password" id="password">
						</div>

					</div>
				</div>



				<div class="form-group">
					<label class="col-md-4 control-label"></label>
					<div class="col-md-4">
						<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
						<input type="submit" value="Log In" class="btn btn-default btn-lg btn-block" ><br>
						
						<input value="Forgtten your password?" class="btn btn-danger btn-lg btn-block" id="fpw">
					
					</div>
				</div>
			</div>
		</div>

	</fieldset>
</form>
</div>
</div><!-- /.container -->


</body>

<script>
/*	function checkvalid(){
		var box = document.getElementById("username").value;
		var box2 = document.getElementById("password").value;
		var errors = "";

		if(box.length <= 0){
			//message.innerHTML = "Username field is required.";
			errors += "Username field is required. \n";
		}

		if(box2.length <= 0){
			errors += "Password field is required. \n";
		}			

		if (errors.length > 0) {
			alert(errors);
		}
	}*/

	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function validate() {
		var $result = $("#result");
		var email = $("#username").val();
		$result.text("");
		if (email.length === 0){
			$result.text("Please enter your email address");
			$result.css("color", "red");
		}
		return false;
	}


</script>

	<script type="text/javascript">
    document.getElementById("fpw").onclick = function () {
        location.href = "fpw.php";
	    };
	</script>