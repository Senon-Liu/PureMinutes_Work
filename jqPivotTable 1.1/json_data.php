<?php
$data = file_get_contents('php://input');
$obj = json_decode($data);

$table = $obj->{'tabla'};
$rws = $obj->{'renglones'};
$cols = $obj->{'columnas'};
$fils = $obj->{'filtros'};
$dats = $obj->{'dato'};
$op = $obj->{'op'};

$fields =  array();
$fields = array_merge($cols,$rws,$fils);

$oldChrs = array('[', ']', '"');
$newChrs   = array("", "", "`");
$newFields = str_replace($oldChrs, $newChrs, json_encode( $fields));

$sentence = "SELECT " . $newFields . ", " . $op . "(`" . $dats . "`) AS " . $dats . " FROM " . $table . " GROUP BY " . $newFields . ";";

   $db = mysql_connect('localhost', 'root', 'Cacho100%');
   if (!$db) {
     die('Could not connect: ' . mysql_error());
    }
   if (!mysql_select_db('enigh')) {
     die('Could not select database: ' . mysql_error());
    }
   $result = mysql_query($sentence);
   if (!$result) {
     die('Could not query:' . mysql_error());
    }

header("Content-type: application/json");
$jsonData = array('items'=>array());
while($r = mysql_fetch_assoc($result)) {
     $jsonData['items'][] = $r;
   }

echo json_encode($jsonData);
?>
