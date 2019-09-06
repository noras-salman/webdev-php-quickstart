<?php 
/*----------------------------------------
*	DatabaseConnect CLASS
* 	Creates and returns database connection.
* ----------------------------------------	
*/

class DatabaseConnection{
	
	private $conn;
	private $from_file;

    function __construct($from_file=true){ 
		$this->from_file=$from_file;
		$this->conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD);
		if(mysqli_connect_errno()){
			die('Could not connect to MySQL server.');
		}
		if (!$this->conn->select_db(DB_DATABASE)) {
			$this->build();
		}

		
	}

	

    function close(){
		$this->conn->close();
	}

	function escape_for_insert($value){
		return mysqli_real_escape_string($this->conn,$value);
	}

	function getConnection(){
		return $this->conn;
	}

	function getConnectionError(){
		return $this->conn->connect_errno;
	}

 
	function getError(){
		return $this->conn->error;
	}

	function build(){
		if($this->createDatabase()){
			$this->conn->select_db(DB_DATABASE);
			if($this->from_file){
				if(!$this->createTables()){
					die('Could not create tables.'.$this->getError());
				}
			}
		}else{
			die('Could not create database.'.$this->getError());
		}
	}

	function rebuild(){
		$this->dropDatabase();
		$this->build();
	}

	function createTables(){
		$init_file=__DIR__ ."/../../init.sql";
		if(!file_exists($init_file)){
			return True;
		}
	  
		$init_file_content = file_get_contents($init_file);
		return $this->conn->multi_query($init_file_content);
	}


	function createDatabase(){
		$sql = "CREATE DATABASE IF NOT EXISTS ".DB_DATABASE;
		return $this->conn->query($sql);
	}
	/* Drop Database on setup (If needed) */
	function dropDatabase(){
		$this->dropTables();
		$sql = "DROP DATABASE IF EXISTS ".DB_DATABASE;
		return $this->conn->query($sql);
	}
	
	function dropTables(){
		$drop_tables_sql="";
		$tables=$this->getTables();
		if(count($tables)>0){
			$drop_tables_sql="DROP TABLE IF EXISTS ".join("; DROP TABLE IF EXISTS ",$tables).";";
		}
		return $this->conn->multi_query($this->drop_tables_sql);
	}
	
	
	


	function getTables(){
		$tables=array();
		$sql="SELECT table_name FROM information_schema.tables WHERE table_schema ='".DB_DATABASE."'";
		$result=$this->conn->query($sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($tables,$row["table_name"]);
			}
		}
		return $tables;
	}
	
		
}
 
?>