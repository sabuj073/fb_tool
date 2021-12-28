<?php
function gettoken($pageId){
    global $fb;
    $token = $_SESSION['fb_access'];
	$fb->setDefaultAccessToken($_SESSION['fb_access']);
	$response_data = $fb->get('/'.$pageId.'?fields=access_token&access_token='.$token);
	$response_data = $response_data->getDecodedBody();
    return $response_data['access_token'];
}
?>