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

            $name_team=$_POST['name_team']; 
            $fulfillment1=$_POST['fulfillment1']; 
            $fulfillment2=$_POST['fulfillment2']; 
            $quantity_team=$_POST['quantity_team']; 
            $id_patner=$_POST['id_patner'];

            updateTeam($name_team,$fulfillment1,$fulfillment2,$quantity_team,$id_patner,$pid);

} 

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Team</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Team</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Edit Team</h4>
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
                                            $query=mysqli_query($con,"select *, users1.name_user as name_user1, users2.name_user as name_user2 from teams 
                                                                            join users as users1 on teams.fulfillment1 = users1.sfcode_user
                                                                            join users as users2 on teams.fulfillment2 = users2.sfcode_user
                                                                            join patner on teams.id_patner = patner.id_patner
                                                                            where id_team='$pid'");
                                            while($result=mysqli_fetch_array($query)){    
                                        ?>        

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Team Name</label>
                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['name_team'];?>" name="name_team" required>
                                                <div class="invalid-feedback">Please provide a valid team name.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Fulfillment</label>
                                                <div class="row">
                                                    <div class="col-md-6 mb-10">
                                                        <select class="form-control custom-select" name="fulfillment1" required>
                                                            <option value="<?php echo $result['fulfillment1'];?>"><?php echo $result['name_user1'];?></option>
                                                            <?php
                                                            $queryful=mysqli_query($con,"select * from users 
                                                                                        where access_user='Fulfillment' && 
                                                                                        sfcode_user NOT IN (SELECT fulfillment1 FROM teams) && 
                                                                                        sfcode_user NOT IN (SELECT fulfillment2 FROM teams)");
                                                            while($rful=mysqli_fetch_array($queryful)){    
                                                                echo "<option value=".$rful['sfcode_user'].">".$rful['name_user']."</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-10">
                                                        <select class="form-control custom-select" name="fulfillment2" required>
                                                            <option value="<?php echo $result['fulfillment2'];?>"><?php echo $result['name_user2'];?></option>
                                                            <?php
                                                            $queryful=mysqli_query($con,"select * from users 
                                                                                        where access_user='Fulfillment' && 
                                                                                        sfcode_user NOT IN (SELECT fulfillment1 FROM teams) && 
                                                                                        sfcode_user NOT IN (SELECT fulfillment2 FROM teams)");
                                                            while($rful=mysqli_fetch_array($queryful)){    
                                                                echo "<option value=".$rful['sfcode_user'].">".$rful['name_user']."</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please provide a valid fullfillment.</div>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="col-md-2 mb-10">
                                            
                                                <label for="validationCustom03">Quantity Take</label>
                                                <input type="number" class="form-control" id="validationCustom03" value="<?php echo $result['quantity_team'];?>" name="quantity_team" required>
                                                <div class="invalid-feedback">Please provide a valid Quantity Take.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-2 mb-10">
                                                <label for="validationCustom03">Patner</label>
                                                    <select class="form-control custom-select" name="id_patner" required>
                                                        <option value="<?php echo $id_pat = $result['id_patner'];?>"><?php echo $result['name_patner'];?></option>
                                                        <?php
                                                        $querypat=mysqli_query($con,"select * from patner where  id_patner != $id_pat");
                                                        while($rpat=mysqli_fetch_array($querypat)){    
                                                            echo "<option value=".$rpat['id_patner'].">".$rpat['name_patner']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                <div class="invalid-feedback">Please provide a valid Quantity Take.</div>
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