<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['sfcode_user']==0) || !isset($_SESSION['sfcode_user'])) {
  header('location:logout.php');
} else{

    if(isset($_GET['del']) && $_SESSION['access_user'] == 'Administrator'){    
        $del=substr(base64_decode($_GET['del']),0,-5);
        $query=mysqli_query($con,"delete from orders where myircode_order='$del'");
        echo "<script>alert('Order record deleted.');</script>";   
        echo "<script>window.location.href='order_waiting.php'</script>";
        }

    if(isset($_GET['suc']) && $_SESSION['access_user'] == 'Fulfillment'){    
        $suc=substr(base64_decode($_GET['suc']),0,-5);
        $query=mysqli_query($con,"update orders set status_order=2 where myircode_order='$suc'");
        echo "<script>alert('Order has been successful');</script>";   
        echo "<script>window.location.href='order_waiting.php'</script>";
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Order Waiting</title>
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
                    <li class="breadcrumb-item"><a href="#">Order</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Waiting Order</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">

                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="database"></i></span></span>Waiting Order</h4>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">

                            <?php if ($_SESSION['access_user']== "Fulfillment"){?>
                            <section class="hk-sec-wrapper">
                                <h5>Ongoing</h5>
                                <div class="row">
                                <div class="col-xl-12">
                                    <?php
                                    $query=mysqli_query($con,"select *, takes.sfcode_user AS fulfilment1, patner.sfcode_user AS fulfilment2, orders.sfcode_user AS user_entry
                                                            from orders 
                                                            join takes on takes.myircode_order = orders.myircode_order
                                                            join patner on patner.myircode_order = orders.myircode_order
                                                            where orders.status_order = 1 &&( takes.sfcode_user = '$sfcode_user'||patner.sfcode_user = '$sfcode_user')");
                                    $rno=mt_rand(10000,99999);
                                    $num_row = mysqli_num_rows($query);
                                    if ( $num_row == 0){
                                        ?>
                                        <div style="color:red" align="center" class="col-12">You haven't taken the order</div>
                                        <?php
                                    }else {
                                        while($r=mysqli_fetch_array($query)){    
                                                            
                                    ?> 
                                    <div class="row">
                                                                        
                                        <div class="col-9">
                                            <button type="button" class="btn btn btn-block" data-toggle="modal" data-target="#myModal<?php echo $r['myircode_order'];?>">
                                                <?php echo $r['myircode_order'];?> <br>
                                                <?php echo $r['name_order'];?>
                                            </button>
                                        </div>

                                        <div class="col-3">
                                            <a href="order_waiting.php?suc=<?php echo base64_encode($r['myircode_order'].$rno);?>" data-toggle="tooltip" data-original-title="Success" onclick="return confirm('Did you succeed in the process?');"> <i class="btn btn-primary btn-block mb-10">Success</i></a>
                                            <a href="containts.php?pid=<?php echo base64_encode($r['myircode_order'].$rno);?>" class="mr-25" data-toggle="tooltip" data-original-title="Failed" onclick="return confirm('Did you really fail in the process?');"> <i class="btn btn-light btn-block">Failed</i></a>
                                        </div>
                                    </div>

                                
                                    <?php 
                                    include('detail_modal.php');
                                    }} ?>
                                    </div>
                                </div>
                            </section>
                            <?php
                            }?>

                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="table-wrap">
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>MYIR Code</th>
                                                        <th>Name</th>
                                                        <th>Pack</th>
                                                        <th>ODP</th>
                                                        <th></th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $query=mysqli_query($con,"select * from orders join status on orders.id_status = status.id_status WHERE status.phase_status=0");
                                                        $rno=mt_rand(10000,99999);
                                                        while($row=mysqli_fetch_array($query)){
                                                            
                                                    ?>                                                
                                                    <tr>
                                                        <td><?php echo $row['myircode_order'];?></td>
                                                        <td><?php echo $row['name_order'];?></td>
                                                        <td><?php echo $row['pack_order'];?></td>
                                                        <td><?php echo "ODP - ".$row['odpzone_order']." - ".$row['odp_order']." / ".$row['odpnum_order'];?></td>

                                                        <td>
                                                        <?php
                                                        switch ($_SESSION['access_user']){
                                                            case "Administrator":
                                                                echo "<a href='order_edit.php?pid=".base64_encode($row['myircode_order'].$rno)."&back=wait' class='mr-25' data-toggle='tooltip' data-original-title='Edit'> <i class='icon-pencil'></i></a>";
                                                                
                                                                echo "<a href='order_waiting.php?del=".base64_encode($row['id_team'].$rno)."' data-toggle='tooltip' data-original-title='Delete' onclick='return confirm(\"Do you really want to delete?\");'> <i class='icon-trash txt-danger'></i></a>";
                                                                ?>
                                                                
<?php
                                                                break;
                                                            case "HD":
                                                                echo "<a href='order_edit.php?pid=".base64_encode($row['myircode_order'].$rno)."&back=wait' class='mr-25' data-toggle='tooltip' data-original-title='Edit'> <i class='icon-pencil'></i></a>";
                                                                break;
                                                            case "Fulfillment":
                                                                echo "<a href='detail.php?invid=".base64_encode($row['myircode_order'].$rno)."' class='mr-25' data-toggle='tooltip' data-original-title='View Details'> <i class='glyphicon glyphicon-envelope'></i></a>";
                                                                break;

                                                        }
                                                        
                                                        ?>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                    } ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        EXPORT
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="export_taken.php">Not Yet / Ongoing</a>
                                        <a class="dropdown-item" href="export_success.php">Success</a>
                                        <a class="dropdown-item" href="export_constraints.php">Constraints</a>
                                        <a class="dropdown-item" href="export_all.php">All</a>
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
<?php } ?>