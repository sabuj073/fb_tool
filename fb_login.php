<?php
include "includes/config.php";  
include "includes/functions.php";
$info = getinfo();
include "fb_config.php";  
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','pages_manage_posts',' pages_read_engagement','instagram_basic','instagram_content_publish','ads_management','business_management']; // Optional permissions
$loginUrl = $helper->getLoginUrl("https://".$_SERVER['SERVER_NAME'].'/callback.php', $permissions);
header("location:" . $loginUrl);
 ?>