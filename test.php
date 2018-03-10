<?php
$dialString = "SIP/avalon/83789999893767";

$tmpArray = explode("/",$dialString);
print_r($tmpArray);
echo count($tmpArray);
$numberline=$tmpArray[count($tmpArray)-1];
if (strstr($numberline,",")){
	$tmpArray=explode(",",$numberline);
	print_r($tmpArray);
	$numberline = $tmpArray[0];
}
echo $numberline;
?>
