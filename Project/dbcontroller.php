<?php
class DBController {
	private $host = "130.184.26.149";
	private $user = "uateam07";
	private $password = "uateam07";
	private $database = "uateam07";
	
	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->selectDB($conn);
		}
	}
	
	function connectDB() {
		$conn = mysql_connect($this->host,$this->user,$this->password);
		return $conn;
	}
	
	function selectDB($conn) {
		mysql_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysql_query($query);
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysql_query($query);
		$rowcount = mysql_num_rows($result);
		return $rowcount;	
	}
	function Count($query) {
		$result  = mysql_query($query);
		while($row=mysql_fetch_array($result)) {
			$count_data = $row["C"];
		}
			return $count_data;
			
	}
	
	function getUsername($query) {
		$result  = mysql_query($query);
		while($row=mysql_fetch_array($result)) {
			$username = $row["username"];
		}
			return $username;
			
	}

	
}
?>