<?php
	class user {
		private $_db,
				$_sessionName,
				$_isLoggedIn;

		public  $_data;

		public function __construct($user = null) {
			$this->_db = db::getInstance();
			$this->sessionName = config::get('session/session_name');

			if(!$user){
				if(session::exists($this->_sessionName)) {
					$user = session::get($this->_sessionName);
						if($this->find($user)){
							$this->_isLoggedIn = true;
						} else {
							//process logout
						}
				} else {
					$this->find($user);
				}
			}


		}

		public function create($fields = array()) {
			if($this->_db->insert('user', $fields)) {
				throw new Exception('There was a problem creating your account');
			}
		}

		public function update($fields = array(), $id = null){

			if(!$id && $this->isLoggedIn()){
				$id = $this->_data[0];
			}

			if(!$this->_db->update('users', $id, $fields)){
				throw new Exception('There was a problem updating');
			}

		}

		public function find($user = null){

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

			if($user){
				$field = (is_numeric($user)) ? 'id' : 'username'; //find user by id
				//$data = $this->_db->get('users', array($field, '=', $user)); //find specified user 
				//$data = "SELECT * FROM users WHERE {$field} = {$user}"; //test the SQL statement
				//echo $user;

				$sql = "SELECT * FROM users WHERE {$field} = '{$user}'";

				$result = mysqli_query($conn, $sql);

				//echo count($result);
				//echo $result;


			if(count($result)){ 
					$row= mysqli_fetch_row($result);
					$this->_data = $row; 
					return true;
				}

				//Close connection
				$conn->close();
			
		}
			
			return false;
		}

		public function login($username = null, $password = null){
			$user = $this->find($username);
			//print_r($this->_data);
			if($user){
				$pass = hash::make($password, $this->_data[3]);
				if($this->_data[2] === $pass) {
					session::put($this->_sessionName, $this->_data[0]);
					return true;
				}
			}

			
			return false;
		}

		public function data(){
			return $this->_data;
		}

		public function isLoggedIn(){
			return $this->_isLoggedIn;
		}

		public function logout(){
			session::delete($this->_sessionName);
		}
	}