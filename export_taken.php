<?php 
    // fungsi header dengan mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
     
    // membuat nama file ekspor "export-to-excel.xls"
    header("Content-Disposition: attachment; filename=orders_taken.xls");
     
    include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<div class="col-sm">
    <div class="table-wrap">
        <table id="datable_1" class="table table-hover w-100 display pb-30">
            <thead>
                <tr>
                    <th>MYIR Code</th>
                    <th>Name</th>
                    <th>Pack</th>
                    <th>ODP</th>
                    <th>Address</th>
                    <th>Benchmark</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Data Entry</th>
                    <th>Status</th>
                    <th>Date Taken</th>
                    <th>Fulfillment 1</th>
                    <th>Mitra</th>
                    <th>Fulfillment 2</th>
                    <th>Mitra</th>


                    
                                                        
                </tr>
            </thead>
            <tbody>
                <?php
                    $query=mysqli_query($con,"select *, orders.sfcode_user as data_entry, takes.sfcode_user as fulfilment1, 
                                            patner.sfcode_user as fulfilment2
                                            from orders 
                                            left join takes on orders.myircode_order = takes.myircode_order
                                            left join patner on orders.myircode_order = patner.myircode_order
                                            where orders.status_order < 2
                                            "
                                        );
                    $rno=mt_rand(10000,99999);
                    while($row=mysqli_fetch_array($query)){
                        $f1= $row['fulfilment1'];
                        $f2= $row['fulfilment2'];
                        $name_f1 = mysqli_query($con,"select * from users where sfcode_user = '$f1'");
                        $name_f1 = mysqli_query($con,"select * from users left join associate on users.id_associate = associate.id_associate where sfcode_user = '$f1'");
                        $ful1=mysqli_fetch_array($name_f1);
                        $name_f2 = mysqli_query($con,"select * from users left join associate on users.id_associate = associate.id_associate where sfcode_user = '$f2'");
                        $ful2=mysqli_fetch_array($name_f2);
                        
                ?>                                                
                <tr>
                    <td><?php echo $row['myircode_order'];?></td>
                    <td><?php echo $row['name_order'];?></td>
                    <td><?php echo $row['pack_order'];?></td>
                    <td><?php echo "ODP - ".$row['odpzone_order']." - ".$row['odp_order']." / ".$row['odpnum_order'];?></td>
                    <td><?php echo $row['address_order'];?></td>
                    <td><?php echo $row['benchmark_order'];?></td>
                    <td><?php echo $row['telp_order'];?></td>
                    <td><?php echo $row['email_order'];?></td>
                    <td><?php echo $row['data_entry'];?></td>
                    
                    <?php

                    switch ($row['status_order']){
                        case 0:
                            echo "<td class = 'text-primary font-weight-bold'>Not yet taken</td>";
                            echo "<td> empty </td>";
                            break;
                        case 1:
                            echo "<td class = 'text-warning font-weight-bold'>Ongoing</td>";
                            echo "<td>".$row['date_take']."</td>";
                            break;
                        case 2:
                            echo "<td class = 'text-success font-weight-bold'>Done</td>";
                            echo "<td>".$row['date_take']."</td>";
                            break;
                        case 3:
                            echo "<td class = 'text-danger font-weight-bold'>Constraints</td>";
                            echo "<td>".$row['date_take']."</td>";
                            break;
                        default:
                            echo "<td>No description</td>";
                            echo "<td>No description</td>";};

                    
                    if ($row['fulfilment1']!=null OR $row['fulfilment2']!=null){
                        echo "<td>".$ful1['name_user']."</td>";
                        echo "<td>".$ful1['name_associate']."</td>";
                        echo "<td>".$ful2['name_user']."</td>";
                        echo "<td>".$ful2['name_associate']."</td>";}
                        else {
                            echo "<td> none</td>";
                            echo "<td> none</td>";
                            echo "<td> none</td>";
                            echo "<td> none</td>";}
                
                    ?>


                </tr>
                <?php 
                } ?>
                
            </tbody>
        </table>
    </div>
</div>
    
</body>
</html>


