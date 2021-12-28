<?php
$date = str_replace(" ", "", sha1(date('r', time())));
include 'includes/header.php';
$id = $_GET['id'];
$detail = getworkspace_details($id);

function facebook($data, $image)
{
    global $fb;
    global $detail;
    $fb->setDefaultAccessToken($detail['fb_page_token']);
    try
    {
        // Returns a `Facebook\FacebookResponse` object
        if ($image != "")
        {
            $response = $fb->post('/' . $detail['fb_page_id'] . '/photos', $data, $detail['fb_page_token']);
        }
        else
        {
            $response = $fb->post('/' . $detail['fb_page_id'] . '/feed', $data, $detail['fb_page_token']);
        }
    }
    catch(Facebook\Exceptions\FacebookResponseException $e)
    {
        echo 'Graph returned an error: ' . $e->getMessage();
    }
    catch(Facebook\Exceptions\FacebookSDKException $e)
    {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }

    $graphNode = $response->getGraphNode();

    echo "<script>alert('Facebook Post Successfull');</script>";
}

function facebook_multiple_files($post,$files){
    global $fb;
    global $detail;
    $post = mysqli_real_escape_string($con, $post['post']);
    $photoIdArray = uploadPhoto($files);
    publishMultiPhotoStory($post,$photoIdArray);
     echo "<script>alert('Facebook Post Successfull');</script>";
    
}

function uploadPhoto($files)
{
    global $fb;
    global $detail;
    $fb->setDefaultAccessToken($detail['fb_page_token']);
    $photoIdArray = array();
    foreach($files['image']['name'] as $key=>$val){
        $url = "https://" . $_SERVER['SERVER_NAME'];
        $photoURL = $url . "/img/" . $date . $files["image"]["name"][$key];
        move_uploaded_file($files["image"]["tmp_name"][$key], "img/" . $date . $files["image"]["name"][$key]);
        $params = array(
            "url" => $photoURL,
            "published" => false
        );
        try {
            $postResponse = $fb->post('/' . $detail['fb_page_id'] . '/photos', $params, $detail['fb_page_token']);
            $photoId = $postResponse->getDecodedBody();
            if(!empty($photoId["id"])) {
                $photoIdArray[] = $photoId["id"];
            }
        } catch (FacebookResponseException $e) {
            echo $e->getMessage();
        } catch (FacebookSDKException $e) {
            echo $e->getMessage();
        }
    }
    return $photoIdArray;
}

function publishMultiPhotoStory($caption, $photoIdArray)
{
        global $fb;
        global $detail;
        $fb->setDefaultAccessToken($detail['fb_page_token']);
        $params = array( "message" => $caption );
        foreach($photoIdArray as $k => $photoId) {
            $params["attached_media"][$k] = '{"media_fbid":"' . $photoId . '"}';
        }
        try {
            $postResponse = $fb->post('/' . $detail['fb_page_id'] . '/feed', $params, $detail['fb_page_token']);
        } catch (FacebookResponseException $e) {
            echo $e->getMessage();
        } catch (FacebookSDKException $e) {
            echo $e->getMessage();
        }

}

function facebook_video($data, $image)
{
    global $fb;
    global $detail;
    $fb->setDefaultAccessToken($detail['fb_page_token']);
    try
    {
        if ($image != "")
        {
            $response = $fb->post('/' . $detail['fb_page_id'] . '/videos', $data, $detail['fb_page_token']);
        }
        else
        {
            $response = $fb->post('/' . $detail['fb_page_id'] . '/feed', $data, $detail['fb_page_token']);
        }
    }
    catch(Facebook\Exceptions\FacebookResponseException $e)
    {
        echo 'Graph returned an error: ' . $e->getMessage();
    }
    catch(Facebook\Exceptions\FacebookSDKException $e)
    {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }

    $graphNode = $response->getGraphNode();

    echo "<script>alert('Facebook Post Successfull');</script>";
}

function instagram($data, $image)
{
    global $fb;
    global $detail;
    $caption = $data['message'];
    $fb->setDefaultAccessToken($detail['fb_page_token']);
    try
    {
        $response = $fb->post('/' . $detail['instagram_id'] . '/media', array(
            'image_url' => $image,
            'caption' => $caption
        ) , $detail['fb_page_token']);
    }
    catch(FacebookExceptionsFacebookResponseException $e)
    {
        echo 'Graph returned an error: ' . $e->getMessage();
    }
    catch(FacebookExceptionsFacebookSDKException $e)
    {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
    $graphNode = $response->getGraphNode();
    $content = $graphNode['id'];
    insta_publish($content);
    echo "<script>alert('Instagram Post Successfull');</script>";
}

function instagram_upload_video($data, $image)
{
    global $fb;
    global $detail;
    $caption = $data['message'];
    $fb->setDefaultAccessToken($detail['fb_page_token']);
    try
    {
        $response = $fb->post('/' . $detail['instagram_id'] . '/media', array(
            'media_type' => 'VIDEO',
            'video_url' => $image,
            'caption' => $caption,
            'access_token' =>  $detail['fb_page_token']
        ) , $detail['fb_page_token']);
    }
    catch(FacebookExceptionsFacebookResponseException $e)
    {
        echo 'Graph returned an error: ' . $e->getMessage();
    }
    catch(FacebookExceptionsFacebookSDKException $e)
    {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
    $graphNode = $response->getGraphNode();
    $content = $graphNode['id'];
    insta_video_publish($content);
    echo "<script>alert('Instagram Post Successfull');</script>";
}

function insta_publish($content)
{
    global $fb;
    global $detail;

    $fb->setDefaultAccessToken($detail['fb_page_token']);
    try
    {
        $response = $fb->post('/' . $detail['instagram_id'] . '/media_publish', array(
            'creation_id' => $content,
        ) , $detail['fb_page_token']);
    }
    catch(FacebookExceptionsFacebookResponseException $e)
    {
        echo 'Graph returned an error: ' . $e->getMessage();
    }
    catch(FacebookExceptionsFacebookSDKException $e)
    {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
    $graphNode = $response->getGraphNode();
    return $graphNode;
}

function insta_video_publish($content)
{
    sleep(30);
    global $fb;
    global $detail;;
    $media_id = (int)$media_id;
    try
    {
        $response = $fb->post('/' . $detail['instagram_id'] . '/media_publish', array(
            'creation_id' => $content,
        ) , $detail['fb_page_token']);
    }
    catch(FacebookExceptionsFacebookResponseException $e)
    {
        echo 'Graph returned an error: ' . $e->getMessage();
    }
    catch(FacebookExceptionsFacebookSDKException $e)
    {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
    catch(Facebook\Exceptions\FacebookResponseException $e)
    {
        echo 'Message: ' . $e->getMessage();
        $previousException = $e->getPrevious();
        // Do some further processing on $previousException
    }
    $graphNode = $response->getGraphNode();
    return $graphNode;
}

if (isset($_GET['del']))
{
    $del_id = $_GET['del'];
    $check = delpage($del_id);
    if ($check)
    {
        echo "<script>window.location.href=''</script>";
    }
    else
    {
        echo "<script>alert('Something went wrong');</script>";
    }
}

if (isset($_POST['submit']))
{
    if (isset($_POST['platform']))
    {
        $post_type = $_POST['post_type'];
        $post = mysqli_real_escape_string($con, $_POST['post']);
        $image = "";
        $image_temp = '';
        if ($_FILES["image"]["name"] != "")
        {
            $image_count = count($_FILES["image"]["name"]);
            if($image_count>1){
                facebook_multiple_files($_POST,$_FILES);
            }else{
                
            $url = "https://" . $_SERVER['SERVER_NAME'];
            $image = $url . "/img/" . $date . $_FILES["image"]["name"][0];
            $image_temp = "img/" . $date . $_FILES["image"]["name"][0];
            move_uploaded_file($_FILES["image"]["tmp_name"][0], "img/" . $date . $_FILES["image"]["name"][0]);
            if ($post_type == 'image')
            {
                $data = ['message' => $post, 'source' => $fb->fileToUpload($image) , ];
                storepost($image_temp, $post, $id, implode(",", $_POST['platform']));
            }
            else
            {
                $data = ['description' => $post, 'source' => $fb->videoToUpload($image)  ];
            }
        }
            
        }
        else
        {
            $data = ['message' => $post, ];
        }
        
        if($image_count==1){
        foreach ($_POST['platform'] as $platform)
        {
            if ($platform == 'facebook')
            {
                if ($post_type == 'image')
                {
                    facebook($data, $image);
                }
                else
                {
                    facebook_video($data, $image);
                }
            }
            if ($platform == 'instagram')
            {
                if ($image != "")
                {
                    if ($post_type == "image")
                    {
                        instagram($data, $image);
                    }
                    else
                    {
                        instagram_upload_video($data, $image);
                    }
                }
                else
                {
                    alert("Image Is mandatory for instagram");
                }
            }
        }
        }

    }
    else
    {
        echo '<script>alert("Please select a platform");</script>';

    }
}
?>

<div id="content-wrapper" class="d-flex flex-column">
   <!-- Main Content -->
   <div id="content">
      <!-- Begin Page Content -->
      <div class="container-fluid">
         <!-- Page Heading -->
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-6">
                  <h1 class="h3 mb-4 text-gray-800"><?=$detail['client_name'];?></h1>
                  <h4>Page name : <?=$detail['fb_page_name'];?></h4>
               </div>
               <div class="col-md-6  text-right">
                  <a href="workspace?id=<?=$id;?>&del=<?=$id?>" class="btn btn-danger">Delete</a>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <!-- Circle Buttons -->
               <div class="card shadow mb-4">
                  <form method="post" action="" enctype="multipart/form-data">
                     <div class="card-header py-3">
                        <div class="row">
                           <div class="col-md-6">
                              <h6 class="m-0 mt-4 font-weight-bold text-primary">Post</h6>
                           </div>
                           <div class="col-md-3"></div>
                           <div class="col-md-3">
                              <label>Post Type</label>
                              <select class="form-control" name="post_type" id="post_type" onchange="image_toggler()">
                                 <option selected value="image">Image *</option>
                                 <option value="video">Video</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>Post</label>
                              <textarea class="form-control" id="post" name="post"></textarea>
                           </div>
                           <div class="col-md-6 image"><br>
                              <label id="caption">Image</label>
                              <input class="form-control" type="file" multiple name="image[]" id="image">
                           </div>
                           <div class="col-md-6"><br>
                              <label>Post Platform *</label><br>
                              <input type="checkbox" name="platform[]" value="facebook">&nbsp;Facebook&nbsp;&nbsp;
                              <?php
                                 if($detail['instagram_id']!=""){
                                 ?>
                              <input type="checkbox"  name="platform[]" value="instagram">&nbsp;Instagram
                              <?php } ?>
                           </div>
                           <div class="col-md-12">
                              <br>
                              <button class="btn btn-primary" id="submit" name="submit" type="submit">Post</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="col-lg-12">
               <!-- Circle Buttons -->
               <div class="card shadow mb-4">
                  <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold text-primary">Posts Diary</h6>
                  </div>
                  <div class="card-body">
                     <table class="table">
                        <tr>
                           <th>Post Image</th>
                           <th>Post</th>
                           <th>Platform</th>
                           <th>Date</th>
                        </tr>
                        <?php
                           $data = getposts($id);
                           while($row = mysqli_fetch_assoc($data)){
                           
                           ?>
                        <tr>
                           <td><img src="<?=$row['image']?>" style="max-width:100px;"></td>
                           <td><?=$row['content']; ?></td>
                           <td><?=$row['platform']; ?></td>
                           <td><?=$row['date']; ?></td>
                        </tr>
                        <?php } ?>
                     </table>
                  </div>
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
   function image_toggler(){
       var type = $("#post_type").val();
       if(type=='image'){
           $("#caption").html("Image (For multiple image select multiple image together)");
            $("#image").prop("multiple",true);
       }
       else{
           $("#caption").html("Video");
           $("#image").prop("multiple",false);
       }
   }
</script>