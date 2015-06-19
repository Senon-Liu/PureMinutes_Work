<?php
	$server = '10.10.50.74';
	$uid = 'winuser';
	$pwd= 'revivo2011';
	$database = 'CubeStaging';

	$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database" => $database);
	$conn = sqlsrv_connect($server, $connectionInfo);

	if($conn == false){
		echo "Connection Failed";
		die(print_r(sqlsrv_errors(), true));
	}
		ini_set('max_execution_time', 300);
	$sql = "select top 100 * from CubeStaging.dbo.TransactionHistory";
// 	$sql = "select TransType, TransDate, COUNT(Store) as 'Store Count' from CubeStaging.dbo.TransactionHistory 
// Group By TransType, TransDate
// Order By TransType ASC, TransDate ASC";
	$query = sqlsrv_query($conn, $sql);
	$i = 1;
	//$input_1 = $_POST["input_1"];
	while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
		$arr[] = array('id' => strval($i++), 'TransDate' => $row['TransDate'], 'TransID' => $row['TransID'], 'TransType' => $row['TransType'], 'Store' => $row['Store'],
			'Amount' => $row['Amount']);
		//echo ($i++)."-----".$row[0]."-----".$row[1]."-----".$row[2];
		//echo "<br>";
	}
	echo json_encode($arr);

?>