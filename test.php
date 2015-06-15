<?php
 include ("mssql.php");
 $mssql = new SQL();
 $mssql -> open();
	echo "json_decode test"."<br>";
	$input = '["TransDate","TransSource"]';

	$data = json_decode($input);
	$length = count($data);
 	 $input="";
 	 for($i = 0; $i < $length; $i++){
 	 	$input .= $data[$i].",";
 	 	echo $input."<br>";
 	 }
 	 $input = substr($input, 0, strlen($input)-1);
 	 
 	$mssql -> get_checked($input);
?>