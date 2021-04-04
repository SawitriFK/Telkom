<?php
session_start();
//error_reporting(0);
include('includes/config.php');
include('function.php');
if ($_SESSION['access_user'] != 'Administrator' && $_SESSION['access_user'] != 'HD') {
  header('location:logout.php');
} else{

    $sfcode_user = $_SESSION['sfcode_user'];

    if(isset($_GET['del']) && $_SESSION['access_user'] == 'Administrator'){    
        $del=substr(base64_decode($_GET['del']),0,-5);
        $query=mysqli_query($con,"delete from orders where myircode_order='$del'");
        echo "<script>alert('Order record deleted.');</script>";
        echo "<script>window.location.href='order_processed.php'</script>";
        }
//Hapus
//    if(isset($_GET['suc']) && $_SESSION['access_user'] == 'HD'){   
    if(isset($_GET['suc'])){    
        $suc=substr(base64_decode($_GET['suc']),0,-5);
        $query=mysqli_query($con,"update orders set status_order=2 where myircode_order='$suc'");
        $querys=mysqli_query($con,"update takes set prob_take = null, exp_take = null where myircode_order='$suc'");
        echo "<script>alert('Order has been successful');</script>";   
        echo "<script>window.location.href='order_processed.php'</script>";
        }
//Hapus

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Processed Order</title>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/1.1.1/css/searchPanes.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"/>

 
<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/1.1.1/js/dataTables.searchPanes.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>




<script>


$(document).ready(function() {

    $('#datable_1').DataTable({
        
        language: {
            search: '', searchPlaceholder: "Search...",
            searchPanes: {
                clearMessage: 'Clear All',
                collapse: {0: 'Search Options', _: 'Search Options (%d)'}
            }
        },
        buttons: [{
      extend: 'searchPanes', className: 'btn btn-secondary',
      initComplete: function (settings, json) {
        $("#datable_1").removeClass("dt-button");
},
      
    }],
        
        dom: 'Bfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [3],
                visible: false
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [4],
                visible: false
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [5],
                visible: false
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [6]
            }
        ]
    });
});
</script>

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
                    <li class="breadcrumb-item active" aria-current="page">Processed</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">

                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="database"></i></span></span>Processed Order</h4>
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
                                                        <th>Fulfiment</th>
                                                        <th>Phase</th>
                                                        <th>ODP</th>
                                                        <th>Patner</th>
                                                        <th>Status</th>
                                                    
                                                    

                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                <?php
                                                    $que = mysqli_query($con, "select * from orders join status on orders.id_status = status.id_status WHERE status.phase_status>0");
                                                    
                                                    $rno=mt_rand(10000,99999);
                                                    while($r=mysqli_fetch_array($que)){
                                                        $id_team = $r['id_team'];
                                                        $name_full1 = team($id_team)[0];
                                                        $name_full2 = team($id_team)[1];
                                                        $patner = team($id_team)[2];
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $r['myircode_order'];?></td>
                                                        <td><?php echo $r['name_order'];?></td>

                                                        <?php if ($id_team!=null){
                                                            echo "<td>".$name_full1." dan ".$name_full2." [".$patner."]</td>";}
                                                            else {
                                                                echo "<td> none </td>";}
                                                        switch ($r['phase_status']){
                                                            case 0:
                                                                echo "<td class = 'text-primary font-weight-bold'>NOT YET TAKEN</td>";
                                                                break;
                                                            case 1:
                                                                echo "<td class = 'text-warning font-weight-bold'>ONGOING</td>";
                                                                break;
                                                            case 2:
                                                                echo "<td class = 'text-danger font-weight-bold'>CONSTRAINTS</td>";
                                                                break;
                                                            case 3:
                                                                echo "<td class = 'text-success font-weight-bold'>DONE</td>";
                                                                break;
                                                            default:
                                                                echo "<td>No description</td>";


                                                        };?>
                                                        <td><?php echo $r['odpzone_order'];?></td>
                                                        <td><?php echo $patner;?></td>
                                                        <td><?php echo $r['name_status'];?></td>

    
                                                    </tr>
                                                    <?php
                                                };?>

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


    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>

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