<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
 if($_SERVER['REQUEST_METHOD'] == "POST"){
    	// Get data
	$jsonData = json_decode(file_get_contents('php://input'));
    
	$register_userid = $jsonData->{"user_id"};
	$part_number = $jsonData->{"part_number"};
	$serial_number = $jsonData->{"serial_number"};
	$remark = $jsonData->{"remark"};
	$description = $jsonData->{"description"};
	$location = $jsonData->{"location"};
	$quantity = $jsonData->{"quantity"};
	$imageData = $jsonData->{"photo"};
	
	date_default_timezone_set("UTC");
	$register_time = date("Y-m-d H:i:s");
	
	 if ($register_userid > 0 && $description != "" && $location != "" && $quantity > 0) {
		 for ($i = 0; $i < $quantity; $i++ ) {
			 
			 
			 $result = $db->add_inventory($part_number, $serial_number, $remark, $description, $location, $register_userid, $register_time);

			 if ($imageData != null && $result) {
				//$result['inserted_id']
				$imageName = "../img/inventory/".$result['inserted_id'].".jpg";
				$imageData1 = base64_decode($imageData);
				$source = imagecreatefromstring($imageData1);
				$rotate = imagerotate($source, 0, 0); // if want to rotate the image
				$imageSave = imagejpeg($rotate,$imageName,100);
				imagedestroy($source);

			 }	
		 }
	}
	else
		$response = array("error" => TRUE);


 }
 else {
	$response = array("error" => TRUE);

	
 }



echo json_encode($response);
?>
