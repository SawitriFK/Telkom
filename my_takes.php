<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['sfcode_user']==0)) {
  header('location:logout.php');
} else{
    if($_SESSION['access_user'] != 'Administrator' && $_SESSION['access_user'] != 'Fulfillment'){
        header('location:logout.php');}
    else{

    $sfcode_user = $_SESSION['sfcode_user'];
    if(isset($_GET['suc']) && $_SESSION['access_user'] == 'Fulfillment'){    
        $suc=substr(base64_decode($_GET['suc']),0,-5);
        $query=mysqli_query($con,"update orders set status_order=2 where myircode_order='$suc'");
        echo "<script>alert('Order has been successful');</script>";   
        echo "<script>window.location.href='my_takes.php'</script>";
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Manage Products</title>
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
                    <li class="breadcrumb-item active" aria-current="page">My Takes</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">

                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="database"></i></span></span>My Takes</h4>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="table-wrap">
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>MYIR Code</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Date Take</th>
                                                        <th>Action</th>
                                                        <!--
                                                        <th>Pack</th>
                                                        <th>ODP</th>
                                                        <th>Action</th>
                                                        -->
                                                    </tr>
                                                </thead> 
                                                
                                                <tbody>

                                                <?php
                                                    $que=mysqli_query($con,"select *, takes.sfcode_user AS fulfilment1, patner.sfcode_user AS fulfilment2, orders.sfcode_user AS user_entry
                                                                            from orders 
                                                                            join takes on takes.myircode_order = orders.myircode_order
                                                                            join patner on patner.myircode_order = orders.myircode_order
                                                                            where orders.status_order > 0 && (takes.sfcode_user = '$sfcode_user' || patner.sfcode_user = '$sfcode_user')");
                                                    $rno=mt_rand(10000,99999);
                                                    while($r=mysqli_fetch_array($que)){ 
                                                ?>

                                                    <tr data-toggle="modal" data-target="#myModal<?php echo $r['myircode_order'];?>">
                                                        <td><?php echo $r['myircode_order'];?></td>
                                                        <td><?php echo $r['name_order'];?></td>
                                                        <?php
                                                        switch ($r['status_order']){
                                                            case 0:
                                                                echo "<td class = 'text-primary font-weight-bold'>NOT YET TAKEN</td>";
                                                                echo "<td> empty </td>";
                                                                break;
                                                            case 1:
                                                                echo "<td class = 'text-warning font-weight-bold'>ONGOING</td>";
                                                                echo "<td>".$r['date_take']."</td>";
                                                                break;
                                                            case 2:
                                                                echo "<td class = 'text-success font-weight-bold'>DONE</td>";
                                                                echo "<td>".$r['date_take']."</td>";
                                                                break;
                                                            case 3:
                                                                echo "<td class = 'text-danger font-weight-bold'>CONSTRAINTS</td>";
                                                                echo "<td>".$r['date_take']."</td>";
                                                                break;
                                                            default:
                                                                echo "<td>No description</td>";
                                                                echo "<td>No description</td>";};
                                                        
                                                        echo "<td>";
                                                        if($r['status_order']==1){
                                                            echo "<a href='my_takes.php?suc=".base64_encode($r['myircode_order'].$rno)."' class='mr-25' data-toggle='tooltip' data-original-title='Success'> <i class='ion ion-md-checkmark'></i></a>";
                                                            echo "<a href='containts.php?pid=".base64_encode($r['myircode_order'].$rno)."' data-toggle='tooltip' data-original-title='Failed' onclick='return confirm('Did the order failed?');'> <i class='ion ion-md-close'></i></a>";
                                                        }
                                                        echo "</td>";
                                                        ?>
                                                                                                    

                                                    </tr>

                                                    <?php 
                                                    include('detail_modal.php');
                                                    }
                                                    ?>
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
</body>
</html>
<?php }} ?>