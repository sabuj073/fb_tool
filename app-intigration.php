<?php include 'includes/header.php';
if(isset($_POST['submit'])){
    $check = updateinfo($_POST);
    if($check){
       echo "<script>alert('successfull')</script>";
    }else{
        echo "<script>alert('Something went wrong');</script>";
    }
}
$info = getinfo();
 ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Facebook App Intigration</h1>

                    <div class="row">

                        <div class="col-lg-12">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Setup</h6>
                                    <h4 class="text-info">Add this url in your facebook developer app (Facebook Login (Deauthorize Callback URL)) <?=$url = "https://".$_SERVER['SERVER_NAME']."/callback.php";?></h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>System Name</label>
                                                <input type="text" class="form-control" value="<?=$info['shop_name'];?>" name="shop_name">
                                            </div>
                                            <div class="col-md-6">
                                                <label>App Id</label>
                                                <textarea class="form-control" name="app_id"><?=$info['app_id'];?></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>App Secret</label>
                                                <textarea class="form-control" name="app_secret"><?=$info['app_secret'];?></textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <br>
                                                <button class="btn btn-primary" name="submit" type="submit">Save</button>
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


<?php include "includes/footer.php"; ?>