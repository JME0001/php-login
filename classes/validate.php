<?php
require_once 'core/init.php';

class validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct() {
		$this->_db = db::getInstance();
	}
 
	public function check($source, $items = array()) {

		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){
				
				$value = trim($source[$item]);
				$item = htmlspecialchars($item);
				

				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required!");
				} else if (!empty($value)){
					switch($rule){
						case 'valid' :
							$value = filter_var($value, FILTER_SANITIZE_EMAIL);
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
								$this->addError("{$value} is not a valid email address!");
							}
						break;
						case 'min' :
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} characters!");
							}
						break;
						case 'max' :
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value} characters!");
							}
						break;
						case 'matches' :
							if($value !== $source[$rule_value]) {
								$this->addError("{$rule_value} must equal {$item}");
							}
						break;
						case 'unique' :
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

							$sql = "SELECT * FROM users WHERE username = '{$value}'";
							$result = mysqli_query($conn, $sql);

							if(mysqli_num_rows($result) > 0)
							{
							    $this->addError("{$item} already exists!");
							}


							//echo $row;

							/*if(count($result)){ 
								$this->addError("{$item} already exists!");
							}*/

							//Close connection
							$conn->close();

						break;
						/*case 'unique' :
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()){
								$this->addError("{$item} already exists!");
							}
						break;*/

						

					}
				}

			}
		}

		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}

}

?>
