<?php
	class Database{
		private $servername = "localhost";
		private $database = "rsac";
		private $username = "root";
		private $password = "";
		
		function __construct($server=false,$database=false,$username=false,$password=false){
			if($server!=false)$this->servername = $server;
			if($database!=false)$this->database = $database;
			if($username!=false)$this->username = $username;
			if($password!=false)$this->password = $password;
		}
		
		public function connect(){
			try {
				$this->conn = new PDO("mysql:host=".$this->servername.";dbname=".$this->database, $this->username, $this->password);
				// set the PDO error mode to exception
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this->conn;
			}
			catch(PDOException $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}
		}
		
		public function close(){
			$this->conn = null;
		}
		
	}
?>