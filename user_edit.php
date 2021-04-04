<?php
session_start();
//error_reporting(0);
include('includes/config.php');
include('function.php');
if (strlen($_SESSION['sfcode_user']==0)) {
  header('location:logout.php');
  } else{
    if($_SESSION['access_user'] != 'Administrator'){
        header('location:logout.php');}
    else{
// Edit product Code
        if(isset($_POST['btn_useredit'])){
            $pid=substr(base64_decode($_GET['pid']),0,-5); 

            $name_user=$_POST['name_user'];   
            $access_user=$_POST['access_user'];
            $pass_user=$_POST['pass_user'];

            updateUser($name_user,$access_user,$pass_user,$pid);
} 

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit User</title>
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    
    
	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

    <!-- Top Navbar -->
    <?php 
        include_once('includes/navbar.php');
        include_once('includes/sidebar.php');
    ?>
       
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Edit User</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">

                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        <?php
                                            $pid=substr(base64_decode($_GET['pid']),0,-5);
                                            $query=mysqli_query($con,"select * from users where sfcode_user='$pid'");
                                            while($result=mysqli_fetch_array($query)){    
                                        ?>        

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">SF Code</label>
                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['sfcode_user'];?>" name="sfcode_user" disabled>
                                                <div class="invalid-feedback">Please provide a valid SF Code.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Name</label>
                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['name_user'];?>" name="name_user" required>
                                                <div class="invalid-feedback">Please provide a valid name user.</div>
                                            </div>
                                        </div>  

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Access</label>
                                                <select class="form-control custom-select" name="access_user" required>
                                                    <option value="<?php echo $result['access_user'];?>"><?php echo $result['access_user'];?></option>
                                                    <?php
                                                    $opsi = array("Administrator","HD","Fulfillment"); 
                                                        for($a = 0; $a < count($opsi); $a++){
                                                            if ($opsi[$a] !=$result['access_user'] ){
                                                    ?>
                                                    <option value="<?php echo $opsi[$a];?>"><?php echo $opsi[$a];?></option>
                                                    <?php }} ?>
                                                </select>
                                            <div class="invalid-feedback">Please select a category.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Password</label>
                                                <input type="password" class="form-control" id="validationCustom03"  placeholder="Ignore it if you don't want to change the password"name="pass_user">
                                                <div class="invalid-feedback">Please provide a valid password user.</div>
                                            </div>
                                        </div> 

                                        
                                        <?php } ?>
                                        <button class="btn btn-primary" type="submit" name="btn_useredit">Update</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                     
                    </div>
                </div>
            </div>


            <!-- Footer -->
            <?php include_once('includes/footer.php');?>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
    <script src="dist/js/validation-data.js"></script>

</body>
</html>
<?php } }?>