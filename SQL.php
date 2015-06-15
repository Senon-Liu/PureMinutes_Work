<?php
error_reporting(E_ALL ^ E_DEPRECATED);
class SQL{
	private $db_host = 'localhost';
	private $db_name = 'test';
	private $db_user = 'root';
	private $db_pw = 'root';
	private $db_form = 'sales';
	private $conn;

function open(){
	$this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_pw);
	if(!$this->conn){
		die("Could not connect: " . mysql_error());
	}

	$db_select = mysql_select_db($this->db_name);
	if (!$db_select)
	{
		die ("Could not select the database: ". mysql_error());
	}
}

function get_By_Cust($cust){
	$result = mysql_query("SELECT * FROM ".$this->db_form." WHERE cust = ".$cust);
	while($row = mysql_fetch_array($result)){
		//$id = $row['idweb'];
		$t_cust = $row['cust'];
		$arr[] = (array($id, $t_name));
	}
	echo(json_encode($arr));
}

function getAll(){
	//$db = new mysqli($this->db_host, $this->db_user, $this->db_pw, $this->db_name);
	$result = mysql_query("SELECT * FROM ".$this->db_form);
	//$arr = array();
	while($row = mysql_fetch_array($result)){
		$cust = $row['name'];
		$prod = $row['prod'];
		$date = $row['day']."-".$row['month']."-".$row['year'];
		$state =$row['state'];
		$amount = $row['count'];
		$arr[] = array('name' => $cust, 'prod' => $prod, 'date' => $date, 'state' => $state, 'amount' => $amount);
		//$arr = stripcslashes($arr);
	}
	return json_encode($arr);
}

function close(){
	mysql_close($this->conn);
}

}
?>


