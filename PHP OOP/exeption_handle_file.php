<?php


$path = "hellow.txt";

/* $myfile = fopen($path, "r") or die("Unable to open file!");
echo fread($myfile,filesize($path));
fclose($myfile); */



error_reporting(E_ALL);
ini_set('display_errors', 1);
function openFile(string $path)
{
	if (!file_exists($path)) {
		throw new Exception('File not found');
	}
	
	return fopen($path, "r");
}

function readFirstLine(string $path)
{
	$handler = null;
	$line    = null;
	
	try {
		$handler = openFile($path);
		$line    = fgets($handler);
	
		
	} catch (Exception $e) {
		echo "Error reading from ${path}. Message = " . $e->getMessage();
} finally {
	
	

	if (!is_null($handler)) {
		echo "this ifinal bloc";
		fclose($handler);
	}
}
//echo $line;
return $line;
}

 

echo readFirstLine($path);