<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['sfcode_user']==0)) {
  header('location:logout.php');
  } else{
    if($_SESSION['access_user'] != 'Administrator' && $_SESSION['access_user'] != 'HD' && $_SESSION['access_user'] != 'Fulfillment'){
        header('location:logout.php');}
    else{
        date_default_timezone_set('Asia/Jakarta');
        $date = date('D, d M Y');  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Dashboard</title>
    <link href="vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6041e23c385de407571cc7b5/1f00lng4s';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body>
    
	
	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

        <?php include_once('includes/navbar.php');
        include_once('includes/sidebar.php');
        ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
                <!-- Row -->
                <div class="jumbotron">
                    <h1>Welcome, <?php echo ($_SESSION['name_user']);?> ! </h1>
                    <p>Let's take a look at today's orders</p>
                    <p><?php echo $date;?></p>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="hk-row">



                            <?php
                            if($_SESSION['access_user'] == 'Administrator'){
                            $query=mysqli_query($con,"select sfcode_user from users");
                            $listedcat=mysqli_num_rows($query);
                            ?>

                            <div class="col-lg-2 col-md-2">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Users</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $listedcat;?></span>
                                            <small class="d-block">Listed Users</small>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php
                            }
                            if($_SESSION['access_user'] != 'Fulfillment'){
                            $ret=mysqli_query($con,"select myircode_order from orders");
                            $listedcomp=mysqli_num_rows($ret);
                            ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Orders</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp;?></span></span>
                                            <small class="d-block">Listed Orders</small>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            }
                            $ret=mysqli_query($con,"select myircode_order from orders join status on orders.id_status=status.id_status where phase_status = 0");
                            $listedcomp=mysqli_num_rows($ret);
                            ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Not Yet Taken</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp;?></span></span>
                                            <small class="d-block">Listed Orders</small>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if($_SESSION['access_user'] != 'Fulfillment'){
                            $ret=mysqli_query($con,"select myircode_order from orders join status on orders.id_status=status.id_status where phase_status = 1");
                            $listedcomp=mysqli_num_rows($ret);
                            ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Ongoing</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp;?></span></span>
                                            <small class="d-block">Listed Orders</small>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            }
                            if($_SESSION['access_user'] == 'Fulfillment'){
                                $ret=mysqli_query($con,"select * from orders 
                                                        join takes on orders.myircode_order = takes.myircode_order
                                                        join patner on orders.myircode_order = patner.myircode_order
                                                        where orders.status_order = 2 && (takes.sfcode_user = '$sfcode_user' || patner.sfcode_user = '$sfcode_user')");
                            }else{
                                $ret=mysqli_query($con,"select myircode_order from orders join status on orders.id_status=status.id_status where phase_status = 2");
                            }
                            
                            $listedcomp=mysqli_num_rows($ret);
                            ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Success</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp;?></span></span>
                                            <small class="d-block">Listed Orders</small>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if($_SESSION['access_user'] == 'Fulfillment'){
                                $ret=mysqli_query($con,"select * from orders 
                                                        join takes on orders.myircode_order = takes.myircode_order
                                                        join patner on orders.myircode_order = patner.myircode_order
                                                        where orders.status_order = 3 && (takes.sfcode_user = '$sfcode_user' || patner.sfcode_user = '$sfcode_user')");
                            }else{
                                $ret=mysqli_query($con,"select myircode_order from orders join status on orders.id_status=status.id_status where phase_status = 3");
                            }
                            $listedcomp=mysqli_num_rows($ret);
                            ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Constarints</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp;?></span></span>
                                            <small class="d-block">Listed Orders</small>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            
                            if($_SESSION['access_user'] == 'Fulfillment'){

                                $query=mysqli_query($con,"select *, takes.sfcode_user AS fulfilment1, patner.sfcode_user AS fulfilment2, orders.sfcode_user AS user_entry
                                                            from orders 
                                                            join takes on takes.myircode_order = orders.myircode_order
                                                            join patner on patner.myircode_order = orders.myircode_order
                                                            where orders.status_order = 1 &&( takes.sfcode_user = '$sfcode_user'||patner.sfcode_user = '$sfcode_user')");
                                $rno=mt_rand(10000,99999);
                                $num_row = mysqli_num_rows($query);
                            ?>
                            <div class="col-lg-4 col-md-4">
                                <div class="card card-sm ">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Ongoing</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        

                                        <?php
                                            if ( $num_row == 0){
                                                ?>
                                                <div style="color:red" align="center" class="col-12">You haven't taken the order</div>
                                        <?php
                                            }else {
                                                while($r=mysqli_fetch_array($query)){ ?>
                                         <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn btn btn-block" data-toggle="modal" data-target="#myModal<?php echo $r['myircode_order'];?>">
                                                    <?php echo $r['myircode_order'];?> <br>
                                                    <?php echo $r['name_order'];?>
                                                </button>
                                            </div>

                                            <div class="col-6">
                                                <a href="waiting_list.php?suc=<?php echo base64_encode($r['myircode_order'].$rno);?>" data-toggle="tooltip" data-original-title="Success" onclick="return confirm('Did you succeed in the process?');"> <i class="btn btn-primary btn-block mb-5">Success</i></a>
                                                <a href="containts.php?pid=<?php echo base64_encode($r['myircode_order'].$rno);?>" class="mr-25" data-toggle="tooltip" data-original-title="Failed" onclick="return confirm('Did you really fail in the process?');"> <i class="btn btn-light btn-block">Failed</i></a>
                                            </div>
                                        </div>
                                        
                                               <?php 
                                               include('detail_modal.php');
                                                }} ?>
                                                

                                    </div>
                                </div>
                            </div>
                            <?php
                            }?>

                        </div>
                    </div> 
                </div>

                <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="table-wrap">
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                    <tr>
                                                        <th>Mitra</th>
                                                        <th>Progress</th>
                                                        <th>Open</th>
                                                        <th>Kendala Pelanggan</th>
                                                        <th>Kendala Sistem</th>
                                                        <th>Kendala Minta Batal</th>
                                                        <th>Kendala Teknis</th>
                                                        <th>Reschedule Teknis</th>
                                                        <th>Double Input</th>
                                                        <th>Live</th>
                                                        <th>Count</th>    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $rcon1 = $rcon2 = $rcon3 = $rcon4 = $rcon5 = $rcon6 = $rcon7 = $rcon8 = $rcon9 = $rcount = 0;
                                                $query=mysqli_query($con,"select * from patner");
                                                while($ret=mysqli_fetch_array($query)){
                                                    $associate = $ret['id_patner'];
                                                    $check = mysqli_query($con,"select 
                                                                        count(case when status.type_status='progress' THEN 1 END) as con1,
                                                                        count(case when status.type_status='open' THEN 1 END) as con2,
                                                                        count(case when status.type_status='kendala pelanggan' THEN 1 END) as con3,
                                                                        count(case when status.type_status='kendala sistem' THEN 1 END) as con4,
                                                                        count(case when status.type_status='kendala minta batal' THEN 1 END) as con5,
                                                                        count(case when status.type_status='teknis' THEN 1 END) as con6,
                                                                        count(case when status.type_status='reschedule teknisi' THEN 1 END) as con7,
                                                                        count(case when status.type_status='double input' THEN 1 END) as con8,
                                                                        count(case when status.type_status='live' THEN 1 END) as con9
                                                                        from orders
                                                                        left join status on orders.id_status = status.id_status
                                                                        left join teams on orders.id_team = teams.id_team
                                                                        where teams.id_patner = '$associate'
                                                                        ");
                                                    $num= mysqli_fetch_assoc($check);
                                                    $count = $num['con1'] + $num['con2'] + $num['con3'] + $num['con4'] + $num['con5'] + $num['con6'] + $num['con7']+ $num['con8']+$num['con9'];
                                                    $rcon1 += $num['con1'];
                                                    $rcon2 +=$num['con2'];
                                                    $rcon3 +=$num['con3'];
                                                    $rcon4 +=$num['con4'];
                                                    $rcon5 +=$num['con5'];
                                                    $rcon6 +=$num['con6'];
                                                    $rcon7 +=$num['con7'];
                                                    $rcon8 +=$num['con8'];
                                                    $rcon8 +=$num['con9'];
                                                    $rcount +=$count;
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $ret['name_patner'];?></td>
                                                    <td><?php echo $num['con1'];?></td>
                                                    <td><?php echo $num['con2'];?></td>
                                                    <td><?php echo $num['con3'];?></td>
                                                    <td><?php echo $num['con4'];?></td>
                                                    <td><?php echo $num['con5'];?></td>
                                                    <td><?php echo $num['con6'];?></td>
                                                    <td><?php echo $num['con7'];?></td>
                                                    <td><?php echo $num['con8'];?></td>
                                                    <td><?php echo $num['con9'];?></td>
                                                    <td><?php echo $count;?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?> 
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <td>Count</td> 
                                                    <td><?php echo $rcon1;?></td>
                                                    <td><?php echo $rcon2;?></td>
                                                    <td><?php echo $rcon3;?></td>
                                                    <td><?php echo $rcon4;?></td>
                                                    <td><?php echo $rcon5;?></td>
                                                    <td><?php echo $rcon6;?></td>
                                                    <td><?php echo $rcon7;?></td>
                                                    <td><?php echo $rcon8;?></td>
                                                    <td><?php echo $rcon9;?></td>
                                                    <td><?php echo $rcount;?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hk-row"> 

                    <?php
                    $qodp=mysqli_query($con,"SELECT odpzone_order,COUNT(*) AS total_odpzone FROM orders GROUP BY odpzone_order");
                    while($odp = mysqli_fetch_array($qodp)){


                        ?>
 
                                <div class="col-lg-1 col-md-3">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-5">
                                                <div>
                                                    <span class="d-block font-15 text-dark font-weight-500"><?php echo $odp['odpzone_order'];?></span>
                                                </div>
                                                <div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <span class="d-block display-9 text-dark mb-5"><?php echo $odp['total_odpzone'];?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    <?php


                    }
                    
                    ?>

                            </div>
                        </div>
                    </div>



                    

                
            
            
            
            
            
            
            
            
            
            
            </div>

            <!-- /Container -->
		    </div>
            <!-- Footer -->
                <?php include_once('includes/footer.php');?>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->

        </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
	<script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="dist/js/vectormap-data.js"></script>
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="vendors/apexcharts/dist/apexcharts.min.js"></script>
	<script src="dist/js/irregular-data-series.js"></script>
    <script src="dist/js/init.js"></script>
	
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
 

    <script>
        $('#datable_1').dataTable( {
        searching: false,
        paging: false,
        responsive: true

        } );
        $.fn.dataTable.ext.errMode = 'none';

    </script>

</body>

</html>
<?php }} ?>