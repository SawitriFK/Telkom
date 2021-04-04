<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['sfcode_user']==0)) {
  header('location:logout.php');
  } else{

    if($_SESSION['access_user'] != 'Fulfillment'){
        header('location:logout.php');}
    else{

    if(isset($_POST['btn_ordertake'])){
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d'); 
        $cmpid=substr(base64_decode($_GET['invid']),0,-5);
        $sfcode_user = $_SESSION['sfcode_user'];
        $fulfilment2 = $_POST['fulfilment2'];


        $q = mysqli_query($con,"select status_order from orders where  myircode_order='$cmpid'");
        $ret= mysqli_fetch_array($q);

        $check = mysqli_query($con,"select 
                    count(case when orders.status_order=1 && takes.sfcode_user='$fulfilment1' THEN 1 END) as takesf1,
                    count(case when orders.status_order=1 && patner.sfcode_user='$fulfilment1' THEN 1 END) as patnerf1,
                    count(case when orders.status_order=1 && takes.sfcode_user='$fulfilment2' THEN 1 END) as takesf2,
                    count(case when orders.status_order=1 && patner.sfcode_user='$fulfilment2' THEN 1 END) as patnerf2
                    from orders
                    join takes on orders.myircode_order = takes.myircode_order
                    join patner on orders.myircode_order = patner.myircode_order");
            $num= mysqli_fetch_assoc($check);
            $numf1 = $num['takesf1']+$num['patnerf1'];
            $numf2 = $num['takesf2']+$num['patnerf2'];

            $qfuli1 = mysqli_query($con,"select orders_user from users where sfcode_user='$fulfilment1'");
            $fuli1= mysqli_fetch_array($qfuli1);
            $qfuli2 = mysqli_query($con,"select orders_user from users where sfcode_user='$fulfilment2'");
            $fuli2= mysqli_fetch_array($qfuli2);


        if ($fulfilment2!="" ){
            if($ret['status_order']==0  && $numf1 <= $fuli1['orders_user'] && $numf2 <= $fuli2['orders_user']){
            //Getting Post Values

                $query=mysqli_query($con,"update takes set sfcode_user = '$sfcode_user', date_take ='$date' where myircode_order='$cmpid'");
                $query2=mysqli_query($con,"update patner set sfcode_user = '$fulfilment2' where myircode_order='$cmpid'"); 
                
                $query1=mysqli_query($con,"update orders set status_order = 1
                where myircode_order='$cmpid'");
                
                if($query && $query1 && $query2){
                echo "<script>alert('Order updated successfully.');</script>";
                } else{
                echo "<script>alert('Something went wrong. Please try again.');</script>";
                }  
            }else {
                echo "<script>alert('Sorry, your order has been taken or you are still in the process of ordering');</script>";
            }
            echo "<script>window.location.href='order_waiting.php'</script>";
        }else {
            echo "<script>alert('Select your partner');</script>";   }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Manage Invoices</title>
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
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
<li class="breadcrumb-item"><a href="#">Takes</a></li>
<li class="breadcrumb-item"><a href="waiting_list.php">Waiting List</a></li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">

                <!-- Title -->
<div class="hk-pg-header">
 <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="file"></i></span></span>Detail</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">

                        <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                        <form class="needs-validation" method="post" novalidate>
                            <div class="invoice-from-wrap">
                            <?php 
                                    //Consumer Details
                                    $inid=substr(base64_decode($_GET['invid']),0,-5);
                                    $query=mysqli_query($con,"select *  from orders  where myircode_order='$inid'");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {    
                                    ?>
                                <div class="row">
                                
                                    <div class="col-md-4 mb-20">
                                        <h3 class="mb-35 font-weight-600"><?php echo $row['name_order'];?></h3>
                                        <h6 class="mb-5"><?php echo "ODP - ".$row['odpzone_order']." - ".$row['odp_order']." / ".$row['odpnum_order'];?></h6>

                                    </div>


                                    <div class="col-md-8 mb-20">
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">MYIR Code</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['myircode_order'];?></label>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Pack</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['pack_order'];?></label>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Date</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['date_order'];?></label>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Address</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['address_order'];?></label>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Benchmark</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['benchmark_order'];?></label>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Telephone</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['telp_order'];?></label>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Email</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['email_order'];?></label>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Data Entry</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <label for="validationCustom03"><?php echo $row['sfcode_user'];?></label>   
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-10">
                                                <h6 for="validationCustom03">Patner</h6> 
                                            </div>
                                            <div class="col-md-8 mb-10">
                                                <select class="form-control custom-select" name="fulfilment2"  required>
                                                    <option value="">Select One</option>

                                                    <?php    
                                                    $sfcode_user = $_SESSION['sfcode_user'];                
                                                    $ful1=mysqli_query($con,"select * from users left join associate on associate.id_associate=users.id_associate
                                                    where access_user = 'Fulfillment'  && sfcode_user !='$sfcode_user' ORDER BY associate.id_associate ASC");
                                                    while($rful1=mysqli_fetch_array($ful1)){  
                                                        echo "<option value=".$rful1['sfcode_user'].">".$rful1['name_user']." [".$rful1['name_associate']."]";}
                                                    ?>

                                                                              
                                                    </select>   
                                            </div>
                                        </div>

                                        
                                    </div>
                            
                                </div>
                        
                                <div class="row">

                                    <button class="btn btn-secondary mr-25" type="submit" name="btn_ordercancel" onclick = "cancel()">Cancel</button>
                                    
                                
                                    <button class="btn btn-primary mr-25" type="submit" name="btn_ordertake">Take</button>
                                    

                                </div>
                                <?php } ?>
                            </div>
                            </form>
                        </section>

                    </div>
                </div>
                <!-- /Row -->

            </div>
            <!-- /Container -->

            <!-- Footer -->
<?php include_once('includes/footer.php');?>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /HK Wrapper -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="dist/js/dataTables-data.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
    <script>
    function cancel() {
    var retVal = confirm("Did you not take orders?");
        if( retVal == true ) {
          window.location.href='waiting_list.php'
          return true;
        } else {
            return false;
        }
    }
    </script>
</body>
</html>
<?php }} ?>