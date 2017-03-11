<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 

 if($_SERVER['REQUEST_METHOD'] == "POST"){
    	// Get data
	$jsonData = json_decode(file_get_contents('php://input'));
    $email = $jsonData->{"email"};
	$password = $jsonData->{"password"};
	
	if (isset($email) && isset($password)) {
		// get the user by email and password
		$user = $db->getUserByEmailAndPassword($email, $password);
		
		if ($user != false) {
			// use is found
			$response["error"] = FALSE;
			$response["user_id"] = $user["user_id"];
			$response["user_name"] = $user["user_name"];
			$response["email"] = $user["email"];
			//$response["error_msg"] = "Success login!";
			
			echo json_encode($response);
		} else {
			// user is not found with the credentials
			$response["error"] = TRUE;
			$response["error_msg"] = "Login credentials are wrong. Please try again!";
			echo json_encode($response);
		}
	} else {
		// required post params is missing
		$response["error"] = TRUE;
		$response["error_msg"] = "Required parameters email or password is missing!";
		echo json_encode($response);
	}
 }
 else
 {
	$response["error"] = TRUE;
	$response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);	
 }

//echo json_encode($response);
?>
