<?php
class SQL{
	private $server = '10.10.50.74';
	private $db_name = 'CubeStaging';
	private $uid = 'winuser';
	private $pwd = 'revivo2011';
	private $db_table = 'dbo.TranscationHistory';
	private $conn;

	function open(){
		$connectionInfo = array("UID" => $this->uid, "PWD" => $this->pwd, "Database" => $this->db_name);
		$this->conn = sqlsrv_connect($this->server, $connectionInfo);
		if($this->conn == false){
			echo "Connection Failed";
			die(print_r(sqlsrv_errors(), true));
		}
	}

	/* get data */
	function get_data(){
		ini_set('max_execution_time', 300);
		// $sql = "select Store, Sum(Amount) as sum_amount
		// 	from CubeStaging.dbo.TransactionHistory
		// 	group by store
		// 	order by Store ASC";
		$sql = "select top 10 * from CubeStaging.dbo.TransactionHistory";
		$query = sqlsrv_query($this->conn, $sql);
		$i = 1;

		while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_NUMERIC)){
			$arr[] = array('id' => strval($i++), 'TransType' => $row[0], 'TransDate' => $row[1]);
			//echo ($i++)."-----".$row[0]."-----".$row[1]."-----".$row[2];
			//echo "<br>";
		}
		echo json_encode($arr);
	}

	function get_checked($input){
		ini_set('max_execution_time', 300);
		$sql = "select top 1000".$input." from CubeStaging.dbo.TransactionHistory";
			//group by ".$input;
		$query = sqlsrv_query($this->conn, $sql);
		$i = 1;
		$str = explode(",", $input);
		$length = count($str);
		while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_NUMERIC)){
			$arr = array('id' => strval($i++));
			//, 'TransDate' => $row[0], 'TransSource' => $row[1]);
			for($k = 0; $k < $length; $k++){
				$temp = array($str[$k] => $row[$k]);
				$arr += $temp;
			}
			//print_r($arr);
			$result[] = $arr;
		}
		//echo $result;
		echo json_encode($result);
	}
}
?>