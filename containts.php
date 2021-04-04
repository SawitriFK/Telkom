<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['sfcode_user']==0)) {
  header('location:logout.php');
  } else{
// Edit product Code
        if(isset($_POST['btn_ordercon'])){
            $pid=substr(base64_decode($_GET['pid']),0,-5); 

            $prob_take=$_POST['prob_order'];
            $exp_take=$_POST['exp_order'];

            $q = mysqli_query($con,"select status_order from orders where  myircode_order='$pid'");
            $ret= mysqli_fetch_array($q);

            if ($prob_take != "" && $exp_take != "" && $ret['status_order']==1){
                $query=mysqli_query($con,"update takes set id_constraints = '$prob_take', exp_take ='$exp_take' where myircode_order='$pid'");
                $query1=mysqli_query($con,"update orders set status_order = 3 where myircode_order='$pid'");
                if($query && $query1){
                    echo "<script>alert('Order updated successfully.');</script>";   
                } else{
                    echo "<script>alert('Something went wrong. Please try again.');</script>";   
                } 

            }else{
                echo "<script>alert('Sorry the column is empty or the order has been executed');</script>";   

            }
            if($_SESSION['access_user']=="Fulfillment"){
                echo "<script>window.location.href='my_takes.php'</script>";
            }else{
                switch ($_GET['back']){
                    case 'pro':
                        echo "<script>window.location.href='order_processed.php'</script>";
                        break;
                    case 'wait':
                        echo "<script>window.location.href='order_waiting.php'</script>";
                        break;
                }
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
                    <li class="breadcrumb-item"><a href="#">Takes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Problem</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Problem Order</h4>
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
                                            $query=mysqli_query($con,"select *, orders.sfcode_user as data_entry, takes.sfcode_user as fulfilment1, patner.sfcode_user as fulfilment2 from orders 
                                                                    left join takes on orders.myircode_order = takes.myircode_order
                                                                    left join patner on orders.myircode_order = patner.myircode_order
                                                                    where orders.myircode_order='$pid'");
                                            while($result=mysqli_fetch_array($query)){    
                                        ?>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Problem</label>
                                                <select class="form-control custom-select" name="prob_order" required>
                                                    <option value="">select one</option>
                                                    <?php
                                                    $qprob=mysqli_query($con,"select * from constraints");
                                                    while($prob=mysqli_fetch_array($qprob)){
                                                        echo "<option value='".$prob['id_constraints']."'>".$prob['name_constraints']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Please select a problem.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Explanation</label>
                                                <textarea class="form-control" id="validationCustom03" name="exp_order" required></textarea>
                                                <div class="invalid-feedback">Please provide a valid explanation.</div>
                                            </div>
                                        </div>

<!--
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Images</label>
                                                <input type="file" class="form-control border-0"name="img" />
                                                <div class="invalid-feedback">Please provide a valid images.</div>
                                            </div>
                                        </div>
-->
                                
                                        <?php } ?>
                                        <button class="btn btn-primary" type="submit" name="btn_ordercon">Submit</button>
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