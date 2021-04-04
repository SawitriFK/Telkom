<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['sfcode_user']==0)) {
  header('location:logout.php');
  } else{
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

                    <li class="breadcrumb-item active" aria-current="page">Help</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">

                <!-- Title -->
<div class="hk-pg-header">
 <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="file"></i></span></span>Help</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">

                        <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                            <div class="invoice-from-wrap">
                            

                            <?php
                            switch ($_SESSION['access_user']){

                                case "Administrator":
                            ?>
                                <div class="accordion" id="accordion">

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse1">
                                        Procedures for adding users
                                        </a>
                                    </div>
                                    <div id="collapse1" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'User' item then select 'Add'</li>
                                                <li>After the window opens, fill in the available input fields.</li>
                                                <li>Then, press 'Submit' button to add new user</li>
                                            </ol>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse2">
                                        How to change user data
                                        </a>
                                    </div>
                                    <div id="collapse2" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'User' item then select 'Manage'</li>
                                                <li>After the window opens, find the user whose data you want to change</li>
                                                <li>In the 'Action' column, press the pencil icon</li>
                                                <li>After the user edit window opens, change the data you want to change in the column provided</li>
                                                <li>Then, press the 'Update' button to make changes to user data</li>
                                            </ol>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse3">
                                        Procedure for deleting users
                                        </a>
                                    </div>
                                    <div id="collapse3" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'User' item then select 'Manage'</li>
                                                <li>After the window opens, find the user whose data you want to delete</li>
                                                <li>In the 'Action' column, press the trash box icon to perform user deletion</li>
                                            </ol>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse4">
                                        Procedures for adding orders
                                        </a>
                                    </div>
                                    <div id="collapse4" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'Order' item then select 'Add'</li>
                                                <li>After the window opens, there are 2 options to make additions
                                                    <ul>
                                                        Import excel (.xls)
                                                        <li>a. Press the choose button then select the excel file you want to import</li>
                                                        <li>b. Then click the 'Import' button to add data</li>
                                                    </ul>
                                                    <ul>
                                                        Manual
                                                        <li>a. Fill in the available input fields</li>
                                                        <li>b. Then click 'Submit' to add data</li>
                                                    </ul>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse5">
                                        Procedure for changing order data
                                        </a>
                                    </div>
                                    <div id="collapse5" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'Order' item then select 'Manage'</li>
                                                <li>After the window opens, find the order whose data you want to change</li>
                                                <li>In the 'Action' column press the pencil icon</li>
                                                <li>After the order edit window opens, change the data you want to change in the column provided</li>
                                                <li>Then, press the 'Update' button to make changes to order data</li>
                                            </ol>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse6">
                                        Procedure for deleting an order
                                        </a>
                                    </div>
                                    <div id="collapse6" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'Order' item then select 'Manage'</li>
                                                <li>After the window opens, find the order whose data you want to delete</li>
                                                <li>In the 'Action' column, press the trash box icon to delete the order</li>
                                            </ol>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse7">
                                        Procedure for downloading data to Microsoft Excel
                                        </a>
                                    </div>
                                    <div id="collapse7" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <ol>
                                                <li>Go to the sidebar</li>
                                                <li>Select the 'Order' item then select 'Manage'</li>
                                                <li>After the window opens, press the 'Export' button at the bottom of the table</li>
                                                <li>Then select the data category you want to export to make the download</li>
                                            </ol>             
                                        </div>
                                    </div>
                                    </div>


                                </div>
                            <?php

                                break;

                                case "HD":
                            ?>
                            
                            <div class="accordion" id="accordion">

                                
                                <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse4">
                                    Procedures for adding orders
                                    </a>
                                </div>
                                <div id="collapse4" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <ol>
                                            <li>Go to the sidebar</li>
                                            <li>Select the 'Add Order' item </li>
                                            <li>After the window opens, there are 2 options to make additions
                                                <ul>
                                                    Import excel (.xls)
                                                    <li>a. Press the choose button then select the excel file you want to import</li>
                                                    <li>b. Then click the 'Import' button to add data</li>
                                                </ul>
                                                <ul>
                                                    Manual
                                                    <li>a. Fill in the available input fields</li>
                                                    <li>b. Then click 'Submit' to add data</li>
                                                </ul>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                </div>

                                <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse5">
                                    Procedure for changing order data
                                    </a>
                                </div>
                                <div id="collapse5" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <ol>
                                            <li>Go to the sidebar</li>
                                            <li>Select the 'Manage Order' item </li>
                                            <li>After the window opens, find the order whose data you want to change</li>
                                            <li>In the 'Action' column press the pencil icon</li>
                                            <li>After the order edit window opens, change the data you want to change in the column provided</li>
                                            <li>Then, press the 'Update' button to make changes to order data</li>
                                        </ol>
                                    </div>
                                </div>
                                </div>

                                <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse6">
                                    Procedure for deleting an order
                                    </a>
                                </div>
                                <div id="collapse6" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <ol>
                                            <li>Go to the sidebar</li>
                                            <li>Select the 'Manage Order' item</li>
                                            <li>After the window opens, find the order whose data you want to delete</li>
                                            <li>In the 'Action' column, press the trash box icon to delete the order</li>
                                        </ol>
                                    </div>
                                </div>
                                </div>

                                <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse7">
                                    Procedure for downloading data to Microsoft Excel
                                    </a>
                                </div>
                                <div id="collapse7" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <ol>
                                            <li>Go to the sidebar</li>
                                            <li>Select the 'Manage Order'</li>
                                            <li>After the window opens, press the 'Export' button at the bottom of the table</li>
                                            <li>Then select the data category you want to export to make the download</li>
                                        </ol>             
                                    </div>
                                </div>
                                </div>


                            </div>
                            
                            <?php
                                break;

                                case "Fulfillment":

                                    ?>
                                    <div class="accordion" id="accordion">
    
                                        <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse1">
                                            Procedure for taking orders
                                            </a>
                                        </div>
                                        <div id="collapse1" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <ol>
                                                    <li>Go to the side bar</li>
                                                    <li>Select the item 'Waiting List'</li>
                                                    <li>After the window opens, press the letter icon in the 'Action' column</li>
                                                    <li>The page will switch to the order details</li>
                                                    <li>Make sure the order you want to take and select a partner</li>
                                                    <li>Then, press the 'Take' to take orders</li>
                                                </ol>
                                            </div>
                                        </div>
                                        </div>
    
                                        <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse2">
                                            Procedure for canceling orders
                                            </a>
                                        </div>
                                        <div id="collapse2" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <ol>
                                                    <li>Go to the side bar</li>
                                                    <li>Select the item 'Waiting List'</li>
                                                    <li>After the window opens, press the 'Failed' button in the 'Ongoing' section</li>
                                                    <li>The page will turn to the problem and fill in the available fields</li>
                                                    <li>Then, press the 'Submit' button to cancel the order</li>
                                                </ol>
                                            </div>
                                        </div>
                                        </div>
    
                                        <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse3">
                                            Procedures for completing orders
                                            </a>
                                        </div>
                                        <div id="collapse3" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <ol>
                                                    <li>Go to the sidebar</li>
                                                    <li>Select the item 'Waiting List'</li>
                                                    <li>Once the window opens, press the 'Success' button in the Ongoing section to signify completion of the order</li>
                                                </ol>
                                            </div>
                                        </div>
                                        </div>
    
                                        
                                    </div>
                                <?php

                                break;
                            }
                            ?>

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
<?php } ?>