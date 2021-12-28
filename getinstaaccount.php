<?php
include "includes/config.php";  
include "includes/functions.php";
$info = getinfo();
include "fb_config.php";  
if(isset($_POST['get_insta'])){
    $page_id = $_POST['page_id'];
    $token = $_POST['token'];
    $fb->setDefaultAccessToken($token);
	$response_data_instagram =  $fb->get(
    '/'.$page_id.'?fields=instagram_business_account&access_toke='.
    $token
  );
	$response_data_instagram = $response_data_instagram->getDecodedBody();
	$data = $response_data_instagram['instagram_business_account']['id'];
    echo json_encode(array("id"=>$data));
}
?>