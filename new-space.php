<?php
include 'includes/header.php';
include 'includes/longToken.php';
try {
	  // Returns a `Facebook\FacebookResponse` object
	  $responseUser = $fb->get('/me?fields=id,name,email,cover,gender,picture,link', $_SESSION['fb_access']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$user = $responseUser->getGraphUser();
	$permissions = ['pages_manage_posts',' pages_read_engagement'];
	$fb->setDefaultAccessToken($_SESSION['fb_access']);
	$response_data = $fb->get($user['id'].'/accounts');
	$response_data = $response_data->getDecodedBody();
	$response_data = $response_data['data'];
	
if(isset($_POST['submit'])){
	$check = insertspace($_POST);
    if($check){
       echo "<script>window.location.href=''</script>";
    }else{
        echo "<script>alert('Something went wrong');</script>";
    }
}
?>
 <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">New Workspace</h1>

                    <div class="row">

                        <div class="col-lg-12">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Setup</h6>
                                    <h5 class="text-danger" id="Message"></h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="">
                                        <div class="row">
                                        	<div class="col-md-6">
                                                <label>Workspace Name</label>
                                                <textarea class="form-control" id="workspace_name" required name="workspace_name"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Select Facebook Page *</label>
                                                <select class="form-control selct2" id="facebook_page" name="facebook_page" required onChange="getinstagram(this)">
                                                	<option value="">--Select--</option>
                                                    <?php foreach($response_data as $row){ ?> 
                                                    <option value="<?=$row['id'];?>"><?=$row['name'];?></option>
                                                    <?php } ?>
                                                </select>
                                                
                                            </div>
                                            <?php foreach($response_data as $row){ ?> 
                                            <input type="hidden" value="<?=gettoken($row['id']);?>" id="<?=$row['id'];?>">
                                            <?php } ?>
                                            <div class="col-md-6">
                                                <label>Facebook Page Name</label>
                                                <textarea class="form-control" readonly="" id="fb_name" name="fb_name"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Facebook Page Id</label>
                                                <textarea class="form-control" readonly="" id="fb_id" name="fb_id"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Facebook Access Token</label>
                                                <textarea class="form-control" readonly="" id="fb_token" name="fb_token"></textarea>
                                            </div>
                                            <div class="col-md-6 d-none">
                                                <label>Instagram Page Name</label>
                                                <textarea class="form-control" readonly="" id="instagram_name" name="instagram_name"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Instagram Id</label>
                                                <textarea class="form-control" readonly="" id="instagram_id" name="instagram_id"></textarea>
                                            </div>
                                            <div class="col-md-6 d-none">
                                                <label>Facebook Access Token</label>
                                                <textarea class="form-control" readonly="" id="instagram_token" name="instagram_token"></textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <br>
                                                <button class="btn btn-primary" id="submit" name="submit" type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
<?php include 'includes/footer.php'; ?>
<script>
    function getinstagram(sel){
        var facebook_page_id = $("#facebook_page").val();
        var page_name = sel.options[sel.selectedIndex].text;
        var token = $("#"+facebook_page_id).val();
        $("#fb_name").val(page_name);
        $("#fb_id").val(facebook_page_id);
        $("#fb_token").val(token);
        $("#Message").html("Please Wait. Getting Instagram account info..");
        document.getElementById("submit").disabled = true;
        $.ajax({
            method:"POST",
            url:"getinstaaccount.php",
            data:{
                get_insta:1,
                page_id:facebook_page_id,
                token:token
            },
            success:function(response){
                document.getElementById("submit").disabled = false;
                $("#Message").html("");
                var response = JSON.parse(response);
                if(response.id==null){
                    alert("No instagram account linked");
                    $("#instagram_id").val("");
                }else{
                $("#instagram_id").val(response.id);
                }
            }
        })
        
    }
</script>