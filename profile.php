<!DOCTYPE html>
<html>
<head>
	<title>Facebook Profile</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<style type="text/css">
		.fb-profile img.fb-image-lg{
		    z-index: 0;
		    width: 1140px; 
		    height: 375px; 
		    margin-bottom: 10px;
		    border: 1px solid blue;
		}
		.fb-image-profile {
		    margin: -90px 10px 0px 50px;
		    z-index: 9;
		    width: 250px; 
		    height: 250px; 
		    border: 1px solid red;
		}
	</style>
</head>
<body>
<?php 

include "includes/config.php";  
include "includes/functions.php";
$info = getinfo();
include "fb_config.php"; 
	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $responseUser = $fb->get('/me?fields=id,name,email,cover,gender,picture,link', $_SESSION['fb_access']);
	  $responseImage = $fb->get('/me/picture?redirect=false&width=250&height=250', $_SESSION['fb_access']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$user = $responseUser->getGraphUser();
	$image = $responseImage->getGraphUser();
	
	$permissions = ['pages_manage_posts',' pages_read_engagement'];
	$fb->setDefaultAccessToken($_SESSION['fb_access']);
	$response_data = $fb->get($user['id'].'/accounts');
	$response_data = $response_data->getDecodedBody();
	$response_data = $response_data['data'];
	$fb->setDefaultAccessToken($response_data[4]['access_token']);
	//$response_data_post = $fb->post($response_data[4]['id'].'/feed?message=Hello Fans!&access_token=message=Hello Fans!
  //&access_token='.$response_data[4]['access_token']);
  

 ?>
<div class="container">
	<h1>Retrieve Facebook Profile using Graph API(v2.11) in PHP</h1>
    <div class="fb-profile">
        <img align="left" class="fb-image-lg" src="<?=json_decode($user['cover'], true)['source'];?>" alt="Cover image"/>
        <img align="left" class="fb-image-profile thumbnail" src="<?=$image['url']?>" alt="Profile image"/>
        <div class="fb-profile-text">
            <h1><?=$user['name']?></h1>
            <p><?=$user['email']?></p>
            <p><?=$user['gender']?></p>
            <p><a href="<?=$user['link']?>">Facebook</a></p>
        </div>
    </div>
</div> <!-- /container --> 

<table>
    <tr>
        <th>Page name</th>
        <th>Page Id</th>
        <th>Page Token</th>
    </tr>
<?php
echo count($response_data);
echo $response_data[4]['id'];
echo $response_data[4]['access_token'];
foreach($response_data as $row){
?>
<tr>
    <td><?=$row['name']?></td>
    <td><?=$row['id']?></td>
    <td><?=$row['access_token']?></td>
</tr>
<?php } ?>
</table>
</body>
</html>
