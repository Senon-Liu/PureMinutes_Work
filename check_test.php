<?php
 include ("mssql.php");
 $mssql = new SQL();
 $mssql -> open();
 //$input = "TransDate,TransSource";
 	 $check_data = json_decode($_POST['data']);
 	 $length = count($check_data);
 	 $input="";
 	 for($i = 0; $i < $length; $i++){
 	 	$input .= $check_data[$i].",";
 	 }
 	 $input = substr($input, 0, strlen($input)-1);
 $mssql -> get_checked($input);

	// //$check_data = array("TranDate", "TransSource");
	// $length = count($check_data);

	// $i = 1;
	// foreach($check_data as $d){
	// 	$arr[] = array('id' => strval($i++),'name' => $d);
	// }
	
	// echo json_encode($arr);

	
?>