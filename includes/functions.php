<?php

	function getcategories(){
		global $con;
		$data = mysqli_query($con,"SELECT * FROM categories");
		return $data;
	}

	function getinfo(){
		global $con;
		$data = mysqli_query($con,"SELECT * FROM `info`");
		return mysqli_fetch_assoc($data);
	}

	function updateinfo($post){
		global $con;
		$shop_name = mysqli_real_escape_string($con,$post['shop_name']);
		$app_id = mysqli_real_escape_string($con,$post['app_id']);
		$app_secret = mysqli_real_escape_string($con,$post['app_secret']);
		$data = mysqli_query($con,"UPDATE info set shop_name='$shop_name',app_id='$app_id',app_secret='$app_secret'");
		return $data;
	}

	function getpages(){
		global $con;
		$data = mysqli_query($con,"SELECT * FROM `page`");
		return $data;
	}

	function insertspace($post){
		global $con;
		$workspace_name = mysqli_real_escape_string($con,$post['workspace_name']);
		$fb_name = mysqli_real_escape_string($con,$post['fb_name']);
		$fb_id = mysqli_real_escape_string($con,$post['fb_id']);
		$fb_token = mysqli_real_escape_string($con,$post['fb_token']);
		$instagram_name = mysqli_real_escape_string($con,$post['instagram_name']);
		$instagram_id = mysqli_real_escape_string($con,$post['instagram_id']);
		$instagram_token = mysqli_real_escape_string($con,$post['instagram_token']);
		$sql = "INSERT INTO `page` (`client_name`, `fb_page_name`, `fb_page_id`, `fb_page_token`, `instagram_name`, `instagram_id`, `instagram_token`) VALUES ('$workspace_name', '$fb_name', '$fb_id', '$fb_token', '$instagram_name', '$instagram_id', '$instagram_token')";
		$data = mysqli_query($con,$sql);
		return $data;
	}
	
	function getworkspace_details($id){
	    global $con;
	    $details = mysqli_query($con,"SELECT * from page where id='$id'");
	    return mysqli_fetch_assoc($details);
	}
	
	function delpage($id){
	    global $con;
	    $details = mysqli_query($con,"DELETE from page where id='$id'");
	    return $details;
	}
	
	function storepost($image,$post,$id,$platform){
	    global $con;
	    $date = date("Y-m-d");
	    $sql = "INSERT INTO `posts` (`page_id`, `content`, `image`,platform,`date`) VALUES ('$id', '$post', '$image', '$platform','$date')";
	    $details = mysqli_query($con,$sql);
	    return $details;
	}
	
	function getposts($id){
	    global $con;
	    $details = mysqli_query($con,"SELECT * from posts where page_id='$id'");
	    return $details;
	}

?>