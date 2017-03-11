<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 

 
 if($_SERVER['REQUEST_METHOD'] == "POST"){
    	// Get data
	$jsonData = json_decode(file_get_contents('php://input'));
    	$inventory_id = $jsonData->{"inventory_id"};
	$user_id = $jsonData->{"user_id"};
	$quantity = $jsonData->{"quantity"};
	
	$db->remove_inventory($inventory_id, $user_id, $quantity);
		
 }
 else {
	$response = array("error" => TRUE);
 }
 
	 
 
echo json_encode($response);

//$db->remove_inventory(91, 16, 1);

?>
