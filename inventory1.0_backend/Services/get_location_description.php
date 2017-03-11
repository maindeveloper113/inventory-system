<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$location = $db->get_duplicatedlocation();
$description = $db->get_duplicateddescription();
$response = array("description" => $description, "location" => $location);
echo json_encode($response);
?>
