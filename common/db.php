<?php
	Class Db {
		var $mysql_server;
		var $mysql_username;
		var $mysql_pass;
		var $database_name;
		var $dbtype;
		var $db;

		function Db(){
			
			$this -> mysql_server = "localhost";
			$this -> mysql_username = "webapp";
			$this -> mysql_pass = "webapp";
			$this -> database_name = "webapp";
			$this -> db;
			
		}

		function OpenDb(){
			
			error_reporting (0);
			$this->db = new mysqli($this->mysql_server, $this->mysql_username, $this->mysql_pass, $this->database_name);
			if($this->db->connect_errno > 0){
				die("Unable to connect to database [".$this->db->connect_error."]");
			}
			error_reporting (E_ALL);
			
		}


		function CloseDb(){
			
			return $this->db->close();
		
		}


		function QueryDb($query){
			
			error_reporting (0);
			if(!$result = $this->db->query($query)){
				die("There was an error running the query [".$this->db->error."]");
			}
			error_reporting (E_ALL);
			return $result;
			
		}

		function EscapeString($string){
			
			return $this->db->real_escape_string($string);

		}


	}
?>