<?php
    session_start();
    //error_reporting(0);
    include('includes/config.php');
    include('function.php');
    if ($_SESSION['access_user'] != 'Administrator' && $_SESSION['access_user'] != 'HD') {
        header('location:logout.php');
    } else{
        if(isset($_POST['btn_orderadd'])){

            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s'); 

            $myircode_order=$_POST['myircode_order']; 
            $name_order=$_POST['name_order'];
            $address_order=$_POST['address_order'];
            $mark_order=$_POST['mark_order'];
            $telp_order=$_POST['telp_order'];
            $pack_order=$_POST['pack_order'];
            $email_order=$_POST['email_order'];
            $odpzone_order=$_POST['odpzone_order'];
            $odp_order=$_POST['odp_order'];
            $odpnum_order=$_POST['odpnum_order'];
            $date_order=date('Y-m-d');
            $time_order=date('H:i:s');
            $updateuser_order=$_SESSION['sfcode_user'];
            $id_team=$_POST['id_team'];
            $id_status=$_POST['id_status'];

            $id_status = checkTeam($id_team,$id_status)[0];
            $id_team = checkTeam($id_team,$id_status)[1];


            $query=mysqli_query($con,"insert into orders(myircode_order,name_order,address_order, mark_order, telp_order,
                                        pack_order, email_order, odp_order,odpzone_order, odpnum_order,date_order,time_order, 
                                        updateuser_order, id_team, id_status) 
                                values('".$myircode_order."', '".$name_order."', '".$address_order."', '".$mark_order."', '".$telp_order."',
                                '".$pack_order."', '".$email_order."', '".$odp_order."', '".$odpzone_order."', '".$odpnum_order."', '".$date_order."',
                                '".$time_order."', '".$updateuser_order."',  $id_team, '".$id_status."')"); 
            if($query){
                echo "<script>alert('Order added successfully.');</script>";   
                echo "<script>window.location.href='order_add.php'</script>";
            } else{                          
                echo "<script>alert('Something went wrong. Please try again or this team has reached the limit for the quantity of take');</script>";
            }

                
        }

    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Add Order</title>
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
                <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">
                        <span class="pg-title-icon">
                            <span class="feather-icon">
                                <i data-feather="external-link"></i>
                            </span>
                        </span>
                        Add Order
                    </h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm  float-right">
                                <form action="import-excel.php" method="POST" enctype="multipart/form-data">
                                <div class="form-row justify-content-end">
                                    
                                        <div class="col-1">
                                            <button type="submit" name="upload" class="btn btn-light float-right"value="upload">Import</button>

                                        </div>
                                        <div class="col-3">
                                            <input type="file" class="btn btn-light float-right form-control border-0"name="excel" />

                                        </div>
                                </div>
                                    
                                </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        <div class="form-row">

                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">MYIR Code</label>
                                                <input type="text" class="form-control" id="validationCustom03" name="myircode_order" required>
                                                <div class="invalid-feedback">Please provide a valid MYIR Code.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Name</label>
                                                <input type="text" class="form-control" id="validationCustom03" name="name_order" required>
                                                <div class="invalid-feedback">Please provide a valid name customer.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Address</label>
                                                <input type="text" class="form-control" id="validationCustom03" name="address_order">
                                                <div class="invalid-feedback">Please provide a valid address customer.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Benchmark</label>
                                                <input type="text" class="form-control" id="validationCustom03" name="mark_order">
                                                <div class="invalid-feedback">Please provide a valid benchmark customer.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Telephone</label>
                                                <input type="tel" class="form-control" id="validationCustom03" name="telp_order" >
                                                <div class="invalid-feedback">Please provide a valid telephone customer.</div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Email</label>
                                                <input type="email" class="form-control" id="validationCustom03" name="email_order">
                                                <div class="invalid-feedback">Please provide a valid email customer.</div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Pack</label>
                                                <select class="form-control custom-select" name="pack_order" required>
                                                    <option value="">select one</option>
                                                    <option value="1P (Inet)">1P (Inet)</option>
                                                    <option value="2P (Inet + TV)">2P (Inet + TV)</option>
                                                    <option value="2P (Inet + Phone)">2P (Inet + Phone)</option>
                                                    <option value="3P">3P</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a pack.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">ODP</label>
                                                <div class="row">
                                                    <div class="col-4 ">
                                                        <input type="text" class="form-control" id="validationCustom03" name="odpzone_order" required>
                                                    </div>
                                                    <label for="validationCustom03">-</label>
                                                    <div class="col-4">
                                                        <input type="text" class="form-control" id="validationCustom03" name="odp_order" required>
                                                    </div>
                                                    <label for="validationCustom03">/</label>
                                                    <div class="col-3">
                                                        <input type="text" class="form-control" id="validationCustom03" name="odpnum_order" required>
                                                    </div>
                                                    <div class="invalid-feedback">Please select a access user.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Fulfillment</label>
                                                    <select class="form-control custom-select" name="id_team">
                                                        <?php
                                                        echo "<option value=''>select one</option>";
                                                        $query=loopingTeams();
                                                        while($row=mysqli_fetch_array($query)){
                                                            echo "<option value=".$row['id_team'].">".$row['name_user1']." & ".$row['name_user2']."   - ".$row['name_patner']."</option>";
                                                        };
                                                        ?>
                                                    </select>
                                                <div class="invalid-feedback">Please provide a valid Fulfillment.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Status</label>
                                                    <select class="form-control custom-select" name="id_status">
                                                        <?php
                                                        echo "<option value=''>select one</option>";
                                                        $query=mysqli_query($con,"select * from status where phase_status > 0");
                                                        while($row=mysqli_fetch_array($query)){
                                                            echo "<option value=".$row['id_status'].">".$row['name_status']."</option>";
                                                        };
                                                        ?>
                                                    </select>
                                                <div class="invalid-feedback">Please provide a valid status order.</div>
                                            </div>
                                        </div>
                                                                        

                                        
                                        <button class="btn btn-primary" type="submit" name="btn_orderadd">Submit</button>
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
<?php } ?>