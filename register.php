<?php
require_once 'core/init.php';

if(Input::exists()){

	if(token::check(Input::get('token'))) {

		$validate = new validate();
		$validation = $validate->check($_POST, array(

			'username' => array(
				'required' 	=> 'true',
				'valid' => 'true',
				'unique' 	=> 'users'
			),

			'password' => array(
				'required' 	=> 'true',
				'min' 		=> 7
			),

			'password_again' => array(
				'required' 	=> 'true',
				'matches' => 'password'
			),

			'name' => array(
				'required' 	=> 'true',
				'min' 		=> 2,
				'max' 		=> 50
			)

		));

		if($validation->passed()) {
			$user = new User();
			try{

				$salt = hash::salt(32);

				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => '1'
				));

				session::flash('home', 'You have been registered and can now log in!');
				redirect::to('index.php');

			} catch (Exception $e) {
				die($e->getMessage());
			}
		} else {
			foreach($validation->errors() as $error){
				
			}

		}
	}
}

if (isset($_POST['generate'])){

	$x = 0;

	$post_uppr_case = $_POST['uppr_case'];
	$post_lower_case = $_POST['lower_case'];
	$post_numbers = $_POST['numbers'];

	$uppr_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$lower_case = "abcdefghijklmnopqrstuvwxyz";
	$numbers = "0123456789";

	$generated_uppr_case = substr(str_shuffle($uppr_case),0,$post_uppr_case);
	$generated_lower_case = substr(str_shuffle($lower_case),0,$post_lower_case);
	$generated_numbers = substr(str_shuffle($numbers),0,$post_numbers);

	$mixed = "$generated_uppr_case$generated_lower_case$generated_numbers";

	$sum = $post_uppr_case + $post_lower_case + $post_numbers;

	$shuffled_mix = substr(str_shuffle($mixed),0,$sum);

	$x++;

}

if(isset($_POST["name2check"]) && $_POST["name2check"] != ""){

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

    $username = ($_POST['name2check']); 
    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $uname_check = mysqli_num_rows($result);
		
    if ($uname_check < 1) {
    	if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
			
		} else { echo '<font color="green"><strong>' . $username . '</strong> is available</font>'; }
	    exit();
    } else {
    	if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
			
		} else { echo '<font color="red"><strong>' . $username . '</strong> is currently unavailable</font>'; }
	    exit();
    }
	

    //Close connection
	$conn->close();
}

?>


<head>
	<title>Register</title>
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

	<form class="well form-horizontal" action=" " method="post" onsubmit="validate()">
		<fieldset>

			<!-- Form Name -->
			<legend>Register Today!</legend>

			<!-- Text input-->

			<div class="form-group">
				<label class="col-md-4 control-label">Full Name</label>  
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="name" name="name" placeholder="Full Name" class="form-control"  type="text" value="<?php echo htmlspecialchars(Input::get('name')); ?>" onBlur="validate()">
					</div>
					<p id='nameresult'></p>
				</div>
			</div>

			<!-- Text input-->

			<div class="form-group">
				<label class="col-md-4 control-label" >Email:</label> 
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input name="username" placeholder="Email Address" class="form-control"  type="text"  id="username" onBlur="validate()">
					</div>
					<span id="usernamestatus"></span>
					<p id='result'></p>
				</div>
			</div>

			

			<div class="form-group">
				<label class="col-md-4 control-label" >Password</label> 
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input name="password" placeholder="Password" class="form-control"  type="password" id="password" onBlur="validate()">
					</div>
					<progress value="0" max="100" id="strength" style="width:100%"></progress>
					<p id='pwresult'></p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" >Re-enter Password</label> 
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input name="password_again" placeholder="Password Verification" class="form-control"  type="password" id="password_again" onBlur="validate()">
					</div>
					<p id='pw_again_result'></p>
				</div>
			</div>
			<div class="form-group">
						<label class="col-md-4 control-label"></label>
						<div class="col-md-4">
							<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
							<input type="submit" value="Register" class="btn btn-default btn-lg btn-block">
						</div>
					</div>

		</fieldset>
	</form>

</div><!-- /.container -->


<div class="container">

	<form class="well form-horizontal" action=" " method="post">
		<fieldset>

			<!-- Form Name -->
			<legend>Register Today!</legend>
			<p>Please select the number of uppercase, lowercase, special charachters and numbers you would like in your password.</p>
			<!-- Select Basic -->
   
			<div class="form-group"> 
				<label class="col-md-4 control-label">Uppercase</label>
				<div class="col-md-4 selectContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
						<select id="uppr_case" name="uppr_case" class="form-control selectpicker" >
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
						</select>
					</div>
				</div>
			</div>

		<div class="form-group"> 
				<label class="col-md-4 control-label">Lowercase</label>
				<div class="col-md-4 selectContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
						<select id="lower_case" name="lower_case" class="form-control selectpicker" >
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
						</select>
					</div>
				</div>
			</div>

			<div class="form-group"> 
				<label class="col-md-4 control-label">Number</label>
				<div class="col-md-4 selectContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
						<select id="numbers" name="numbers" class="form-control selectpicker" >
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
						</select>
					</div> 
					<br>
					<input type="submit" value="Generate" class="btn btn-default btn-lg btn-block" name="generate">
				</div>

			</div>

			<div class="form-group"> 
				<label class="col-md-4 control-label"></label>
				<div class="col-md-4 selectContainer">
					<div class="input-group">
						
						<br>
					<div>
						<h4>
							<?php 
							error_reporting(0);
							echo "Generated password: {$shuffled_mix} ({$sum})" 
							?>
						</h4>
					</div>
					</div>
				</div>
			</div>

		</fieldset>
	</form>

</div><!-- /.container -->


</body>



<script type="text/javascript">
	var pass = document.getElementById("password")
	pass.addEventListener('keyup', function(){
		checkPassword(pass.value)
	})

	function checkPassword(password) {
		var strengthBar = document.getElementById("strength")
		var strength = 0;
		if (password.length == 0){
			strength = 0
		}
		if (password.match(/[a-z][a-zA-Z0-9]+/)) {
			strength += 1
		}
		if (password.match(/[A-Z][a-zA-Z0-9]+/)) {
			strength += 1
		}
		if (password.match(/[0-9][a-zA-Z0-9]+/)) {
			strength += 1
		}
		if (password.length > 8) {
			strength += 1
		}

		switch(strength) {
			case 0 :
			strengthBar.value = 0;
			break;
			case 1 :
			strengthBar.value = 33;
			break;
			case 2 :
			strengthBar.value = 66;
			break;
			case 3 :
			strengthBar.value = 100;
			break;
		}
	}

	function checkusername(){
	var status = document.getElementById("usernamestatus");
	var u = document.getElementById("username").value;
	if(u != ""){
		status.innerHTML = 'checking...';
		var hr = new XMLHttpRequest();
		hr.open("POST", "register.php", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4 && hr.status == 200) {
				status.innerHTML = hr.responseText;
			}
		}
        var v = "name2check="+u;
        hr.send(v);
	}
}
	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}


	function validate() {

		checkusername();

		var $result = $("#result");
		var email = $("#username").val();
		$result.text("");
		if (email.length === 0){
			$result.text("Please enter your email address");
			$result.css("color", "red");
		}
		else if (validateEmail(email)) {
			//$result.text(email + " is valid :)");
			//$result.css("color", "green");
		} else {
			$result.text(email + " is not valid a valid email address");
			$result.css("color", "red");
		}

		var $pwresult = $("#pwresult");
		var pw = $("#password").val();
		$pwresult.text("");

		var allLetters = /^[a-zA-Z]+$/;
		var letter = /[a-zA-Z]/;
		var number = /[0-9]/;

		var invalid = [];

		if (password.length < 8 || !letter.test(pw) || !number.test(pw)) {
			$pwresult.text("Password is not valid. It must contain at least one letter, one number and be 8 characters in length");
			$pwresult.css("color", "red");
		}

		if (invalid.length != 0) {
			$pwresult.text("Please enter your a password");
			$pwresult.css("color", "red");
			return false;
		}

		var pw_check = $("#password").val();
		var $pw_again_result  = $("#pw_again_result");
		var pw_again = $("#password_again").val();
		$pw_again_result.text("");

		if(pw_again != pw_check || pw_again.length === 0){
			$pw_again_result.text("Passwords do not match");
			$pw_again_result.css("color", "red");
		}

		var $nameresult = $("#nameresult");
		var name = $("#name").val();
		$nameresult.text("");

		if(name.length < 2 || name.length > 50){
			$nameresult.text("Name must be within 2 - 50 characters");
			$nameresult.css("color", "red");
		}

		if(name.length === 0){
			$nameresult.text("This field is required");
			$nameresult.css("color", "red");
		}
		

		return false;
	}

</script>


