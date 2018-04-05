<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
	redirect::to('index.php');
} else {

if(Input::exists()){

	if(token::check(Input::get('token'))) {

		$validate = new validate();
		$validation = $validate->check($_POST, array(

			'password_current' => array(
				'required' 	=> 'true',
				'min' 		=> 7
			),

			'password_new' => array(
				'required' 	=> 'true',
				'min' 		=> 7
			),

			'password_again' => array(
				'required' 	=> 'true',
				'matches' => 'password_new'
			)

		));

		if($validation->passed()) {

			$data = $user->data();
			
			if (hash::make(Input::get('password_current'), $user->_data[3]) !== $user->_data[2]){
				//password is wrong
			} else {
				//password is correct
				$salt = hash::salt(32);
				$user->update(array(
					'password' => hash::make(Input::get('password_new'), $salt),
					'salt' => $salt
				));

				session::flash('home', 'Your password has been changed!');
				redirect::to('index.php');
			}

		} else {
			foreach($validation->errors() as $error){
				//errors
			}
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

?>


<head>
	<title>Reset Password</title>
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

	<div class="container">
		<div class="well well-sm">
			<form action="" method="post">
				<div class="form-group">
					<label title="info" for="password_current">Current Password: </label> 
					<input type="password" name="password_current" id="password_current" class="form-control" placeholder="Current Password">
				</div>

				<div class="form-group">
					<label title="info" for="password_new">New Password: </label> 
					<input type="password" name="password_new" id="password_new" class="form-control" placeholder="Password">
					<progress value="0" max="100" id="strength" style="width:100%"></progress>
				</div>

				<div class="form-group">
					<label for="password_again">Re-enter New Password: </label>
					<input type="password" name="password_again" id="password_again" class="form-control" placeholder="Password Verification">
				

				</div>
						<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
						<input type="submit" value="Reset Password" class="btn btn-default">
				</div>



			</form>

		</form>
	</div>


</body>

<div class="container">
	<div class="well well-sm">
		<div class="p-3 mb-2 bg-dark text-white">
			<h2>Password Generator</h2>
			<form action="" method="POST">
				<div class="form-group">
					<p>Please select the number of uppercase, lowercase, special charachters and numbers you would like in your password.</p>
					<br>
					<label>Uppercase (select one):</label>
					<select class="form-control" id="uppr_case" name="uppr_case">
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
					</select>
					<label for="sel1">Lowercase (select one):</label>
					<select class="form-control" id="lower_case" name="lower_case">
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
					</select>
					<label for="sel1">Numbers (select one):</label>
					<select class="form-control" id="numbers" name="numbers">
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
					</select>
					<br>


					<input type="submit" value="Generate" class="btn btn-default" name="generate">

					<div style="float: right">
						<h4>
							<?php 
							error_reporting(0);
							echo "Generated password: {$shuffled_mix} ({$sum})" 
							?>
						</h4>
					</div>

				</div>
			</form>

		</div>

	</div>


</body>



			<script type="text/javascript">
					var pass = document.getElementById("password_new")
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
			</script>
