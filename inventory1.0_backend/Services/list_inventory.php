<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
//$response = array("error" => FALSE);

 $searchkey = "";
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
    	// Get data
	$jsonData = json_decode(file_get_contents('php://input'));
   $searchkey = $jsonData->{"searchkey"};
   
   //echo json_encode($response);
	$list = $db->get_inventories($searchkey);
	
	echo json_encode($list);
}
else
{
	//$response = array("error" => TRUE);
	//echo json_encode($response);
}



?>
