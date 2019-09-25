<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


 function groupByOwners(array $files) : array{
 	
 	$NewArray = [];
 	foreach ($files as $key => $value) {
 		$NewArray[$value][] = $key;
 	}
 	
 	return $NewArray;
} 
 
$files = array (
		"Input.txt"=>"Randy",
		"Code.py" =>"Stan",
		"Output.text"=>"Randy"
);


$TestArray = array();

$NewArray = [];
foreach ($files as $key => $value) {
	$NewArray[$value][] = $key;
}


$TestArray['deen'][]= 10;
$TestArray['deen'][]= 10;
$TestArray['deen'][]= 20;
$TestArray['zzzd'] = 20;

var_dump($TestArray);

//print_r(groupByOwners($files));
var_dump(groupByOwners($files));




?>
