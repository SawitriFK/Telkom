<?php
    session_start();
    //error_reporting(0);
    include('includes/config.php');
    if (strlen($_SESSION['sfcode_user']==0)) {
        header('location:logout.php');
    } else{
    // Add company Code
        if(isset($_POST['btn_profiledit'])){
            $sfcode_user=$_SESSION['sfcode_user'];
            $query = mysqli_query($con,"select * from users where  sfcode_user='$sfcode_user'");
            $ret= mysqli_fetch_array($query);   
            //Getting Post Values
           
            if(isset($_POST['check'])){

                $name_user=$_POST['name_user'];   
                $email_user=$_POST['email_user'];
                $currentpassword=$_POST['currentpassword'];
                $newpassword=$_POST['newpassword'];
                $confirmpassword=$_POST['confirmpassword'];

                if(password_verify($currentpassword, $ret['pass_user'])){
                    if($newpassword==$confirmpassword){

                        $options = [
                            'cost' => 12,];
                        $hash= password_hash("$newpassword", PASSWORD_BCRYPT, $options);

                        $query=mysqli_query($con,"update users set 
                                            name_user='$name_user',email_user='$email_user',
                                            pass_user='$hash' 
                                            where sfcode_user='$sfcode_user'"); 
                        if($query){
                        echo "<script>alert('User updated successfully.');</script>";   
                        echo "<script>window.location.href='profile.php'</script>";
                        } else{
                        echo "<script>alert('Something  went wrong. Please try again.');</script>";   
                        //echo "<script>window.location.href='user_add.php'</script>"; 
                        }
                    }else{
                        echo "<script>alert('Please confirm your password.');</script>"; 
                    }
                }else{
                    echo "<script>alert('Current Password went wrong. Please try again.');</script>"; 
                }

              
            }else{
                $name_user=$_POST['name_user'];   
                $email_user=$_POST['email_user'];
                $query=mysqli_query($con,"update users set 
                                    name_user='$name_user',email_user='$email_user'
                                    where sfcode_user='$sfcode_user'"); 
                if($query){
                echo "<script>alert('User updated successfully.');</script>";   
                echo "<script>window.location.href='profile.php'</script>";
                } else{
                echo "<script>alert('Something went wrong. Please try again.');</script>";   
                //echo "<script>window.location.href='user_add.php'</script>"; 
                }   
            }
        }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Admin profile</title>
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    
    
	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

    <!-- Top Navbar -->
    <?php include_once('includes/navbar.php');
    include_once('includes/sidebar.php');
    ?>
       


        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->



        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
        
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Profile</h4>
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
                                        //Getting admin name
                                        $adminid=$_SESSION['sfcode_user'];
                                        $query=mysqli_query($con,"select * from users where sfcode_user='$sfcode_user'");
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
                                                <label for="validationCustom03">Access</label>
                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['access_user'];?>" name="access_user" disabled>
                                                <div class="invalid-feedback">Please provide a valid access.</div>
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
                                                <label for="validationCustom03">Email</label>
                                                <input type="email" class="form-control" id="validationCustom03" value="<?php echo $result['email_user'];?>" name="email_user" required>
                                                <div class="invalid-feedback">Please provide a valid email user.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">  
                                            <input type="checkbox" id="myCheck" onclick="myFunction()" name="check"> 
                                            <label for="validationCustom03">Change password</label>  
                                            </div>
                                        </div>


                                        <div class="form-row"id="text1" style="display:none">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Current Password</label>
                                                <input type="password" class="form-control" id="currentpassword" placeholder="Current Passsword" name="currentpassword">
                                                <div class="invalid-feedback">Please provide  current password.</div>
                                            </div>
                                        </div>

                                        <div class="form-row" id="text2" style="display:none">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">New Password</label>
                                                <input type="password" class="form-control" id="newpassword" placeholder="New Passsword" name="newpassword" >
                                                <div class="invalid-feedback">Please provide  new password.</div>
                                            </div>
                                        </div>

                                        <div class="form-row" id="text3" style="display:none">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Confirm Password</label>
                                                <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm Passsword" name="confirmpassword" >
                                                <div class="invalid-feedback">Please provide  confirm password.</div>
                                            </div>
                                        </div>



                                        <?php } ?>
                                                                        
                                        <button class="btn btn-primary" type="submit" name="btn_profiledit">Update</button>
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
    <script>
    function myFunction() {
  // Get the checkbox
  var checkBox = document.getElementById("myCheck");
  // Get the output text
  var text1 = document.getElementById("text1");
  var text2 = document.getElementById("text2");
  var text3 = document.getElementById("text3");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    text1.style.display = "block";
    text2.style.display = "block";
    text3.style.display = "block";
    document.getElementById("currentpassword").required =  true;
    document.getElementById("newpassword").required =  true;
    document.getElementById("confirmpassword").required =  true;
  } else {
    text1.style.display = "none";
    text2.style.display = "none";
    text3.style.display = "none";
    document.getElementById("currentpassword").required =  false;
    document.getElementById("newpassword").required =  false;
    document.getElementById("confirmpassword").required =  false;

  }
}
</script>

</body>
</html>
<?php } ?>