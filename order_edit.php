<?php
session_start();
//error_reporting(0);
include('includes/config.php');
include('function.php');
if ($_SESSION['access_user'] != 'Administrator' && $_SESSION['access_user'] != 'HD') {
  header('location:logout.php');
  } else{
// Edit product Code
        if(isset($_POST['btn_orderedit'])){
            $pid=substr(base64_decode($_GET['pid']),0,-5); 
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s'); 

            if($_SESSION['access_user']=="Administrator"){ 
                $name_order=$_POST['name_order'];
                $address_order=$_POST['address_order'];
                $mark_order=$_POST['mark_order'];
                $telp_order=$_POST['telp_order'];
                $pack_order=$_POST['pack_order'];
                $email_order=$_POST['email_order'];
                $odpzone_order=$_POST['odpzone_order'];
                $odp_order=$_POST['odp_order'];
                $odpnum_order=$_POST['odpnum_order'];
            }
            $date_order=date('Y-m-d');
            $time_order=date('H:i:s');
            $updateuser_order=$_SESSION['sfcode_user'];
            $id_team=$_POST['id_team'];
            $id_status=$_POST['id_status'];


            if($id_team != "" && $id_status > 1){
                $id_status = checkTeam($id_team,$id_status)[0];
                $id_team = checkTeam($id_team,$id_status)[1];

                if($_SESSION['access_user']=="Administrator"){   
                    $query=mysqli_query($con,"update orders set 
                    name_order='$name_order',address_order='$address_order', mark_order='$mark_order',
                    telp_order='$telp_order',pack_order='$pack_order', email_order='$email_order', odpzone_order='$odpzone_order',
                    odp_order='$odp_order', odpnum_order='$odpnum_order', date_order='$date_order', time_order='$time_order', 
                    updateuser_order = '$updateuser_order', id_team='$id_team', id_status = '$id_status'
                    where myircode_order='$pid'"); 

                }else{                    
                    $query=mysqli_query($con,"update orders set 
                    date_order='$date_order', time_order='$time_order', 
                    updateuser_order = '$updateuser_order', id_team='$id_team', id_status = '$id_status'
                    where myircode_order='$pid'"); 
                }


            }else{
                if($_SESSION['access_user']=="Administrator"){   
                    $query=mysqli_query($con,"update orders set 
                    name_order='$name_order',address_order='$address_order', mark_order='$mark_order',
                    telp_order='$telp_order',pack_order='$pack_order', email_order='$email_order', odpzone_order='$odpzone_order',
                    odp_order='$odp_order', odpnum_order='$odpnum_order', date_order='$date_order', time_order='$time_order', 
                    updateuser_order = '$updateuser_order'
                    where myircode_order='$pid'"); 

            }

            }
            if($query && $id_team != ""){
                echo "<script>alert('Order updated successfully');</script>";
            }elseif($query && $id_team == ""){
                echo "<script>alert('Order updated successfully  without a team taking orders');</script>";
            }else{
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }                        
            switch ($_GET['back']){
                case 'pro':
                    echo "<script>window.location.href='order_processed.php'</script>";
                    break;
                case 'wait':
                    echo "<script>window.location.href='order_waiting.php'</script>";
                    break;
            }
        }
          

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Order</title>
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
                    <li class="breadcrumb-item"><a href="#">Order</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Edit Order</h4>
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
                                            $query=mysqli_query($con,"select * from orders 
                                                                    left join teams on orders.id_team = teams.id_team
                                                                    left join status on orders.id_status = status.id_status
                                                                    left join users on orders.updateuser_order = users.sfcode_user
                                                                    where orders.myircode_order='$pid'");
                                            while($result=mysqli_fetch_array($query)){    
                                        ?>

                                        <div class="form-row">
                                            <div class="col-md-7 mb-10">
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">MYIR Code</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['myircode_order'];?>" name="myircode_order" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Name</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['name_order'];?>" name="name_order" required <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                        <div class="invalid-feedback">Please provide a valid name customer.</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Address</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['address_order'];?>" name="address_order" <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                        <div class="invalid-feedback">Please provide a valid address customer.</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Benchmark</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['mark_order'];?>" name="mark_order" <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                        <div class="invalid-feedback">Please provide a valid benchmark customer.</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Telephone</label>
                                                        <input type="tel" class="form-control" id="validationCustom03" value="<?php echo $result['telp_order'];?>" name="telp_order" <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                        <div class="invalid-feedback">Please provide a valid telephone customer.</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Email</label>
                                                        <input type="email" class="form-control" id="validationCustom03" value="<?php echo $result['email_order'];?>" name="email_order" <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                        <div class="invalid-feedback">Please provide a valid email customer.</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Pack</label>
                                                        <select class="form-control custom-select" name="pack_order" required <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                            <option value="<?php echo $result['pack_order'];?>"><?php echo $pack_order=$result['pack_order'];?></option>
                                                            <?php
                                                            $opsi_pack = array("1P (Inet)","2P (Inet + TV)","2P (Inet + Phone)", "3p"); 
                                                                for($b = 0; $b < count($opsi_pack); $b++){
                                                                    if ($opsi_pack[$b] != $result['pack_order'] ){
                                                            ?>
                                                            <option value="<?php echo $opsi_pack[$b];?>"><?php echo $opsi_pack[$b];?></option>
                                                            <?php }} ?>
                                                        </select>

                                                        <div class="invalid-feedback">Please select a pack.</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">ODP</label>
                                                        <div class="row">
                                                            <div class="col-4 ">
                                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['odpzone_order'];?>" name="odpzone_order" required <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                            </div>
                                                            <label for="validationCustom03">-</label>
                                                            <div class="col-4">
                                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['odp_order'];?>" name="odp_order" required <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                            </div>
                                                            <label for="validationCustom03">/</label>
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['odpnum_order'];?>"name="odpnum_order" required <?php if($_SESSION['access_user']=="HD"){echo "disabled";}?>>
                                                            </div>
                                                            <div class="invalid-feedback">Please select a ODP.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Fulfillment</label>
                                                        <select class="form-control custom-select" name="id_team">
                                                            <?php $fuli=loopingTeams();
                                                                if($result['phase_status']==0){
                                                                    echo "<option value=''>select one</option>";
                                                                    while($row=mysqli_fetch_array($fuli)){
                                                                    echo "<option value=".$row['id_team'].">".$row['name_user1']." & ".$row['name_user2']."   - ".$row['name_patner']."</option>";
                                                                    };
                                                                }else{
                                                                    
                                                                    
                                                                    echo "<option value=".$result['id_team'].">".team($result['id_team'])[0]." & ".team($result['id_team'])[1]."   - ".team($result['id_team'])[2]."</option>";
                                                                    

                                                                    while($row=mysqli_fetch_array($fuli)){
                                                                        echo "<option value=".$row['id_team'].">".$row['name_user1']." & ".$row['name_user2']."   - ".$row['name_patner']."</option>";
                                                                        };
                                                                    

                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">Status</label>
                                                            <select class="form-control custom-select" name="id_status">
                                                            <?php
                                                            echo "<option value=".$result['id_status'].">".$result['name_status']."</option>";
                                                            $query=mysqli_query($con,"select * from status where phase_status > 0");
                                                            while($row=mysqli_fetch_array($query)){
                                                                echo "<option value=".$row['id_status'].">".$row['name_status']."</option>";
                                                            };
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">Please provide a valid status order.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-10">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-10">
                                                        <label for="validationCustom03">Date</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['date_order'];?>" name="updateuser_order" disabled>
                                                    </div>
                                                    <div class="col-md-6 mb-10">
                                                        <label for="validationCustom03">Time Update</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['time_order'];?>" name="updateuser_order" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-10">
                                                        <label for="validationCustom03">User Update</label>
                                                        <input type="text" class="form-control" id="validationCustom03" value="<?php echo $result['name_user'];?>" name="myircode_order" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                                                        
                                        <?php } ?>
                                        <button class="btn btn-primary" type="submit" name="btn_orderedit">Submit</button>
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
<?php 
}
?>