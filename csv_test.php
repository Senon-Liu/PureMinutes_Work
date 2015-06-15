<?php
	//include("SQL.php")
	$result = array();
	if(($handle = fopen("data.csv", "r")) !== FALSE){
		$column_headers = fgetcsv($handle);
		//$result = array('test' => $column_headers);
		for($i = 0; $i < count($column_headers); $i++){
			echo $column_headers[$i].'<br>';
		}

		while(($data = fgetcsv($handle)) !== FALSE){
			$i = 0;
			$temp = array();
			for(; $i < count($column_headers); $i++){
				$temp[$i] = $data[$i];
			}
			$result[] = array(array_combine($column_headers, $temp));
		}
		
		fclose($handle);
	}
	$json = json_encode($result);
	echo $json;
?>