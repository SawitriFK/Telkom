<?php
    session_start();
    //error_reporting(0);
    include('includes/config.php');
    if (strlen($_SESSION['sfcode_user']==0)) {
        header('location:logout.php');
    } else{

        $new = $_FILES['excel']['name'];
        $ext = pathinfo($new, PATHINFO_EXTENSION);
        if($ext != 'xlsx' && $ext != 'xls'){
            echo "<script>alert('$ext');</script>";   
            echo "<script>window.location.href='order_add.php'</script>";

        }else{
        $upload = $_FILES['excel']['tmp_name'];
        

        require 'classes/PHPExcel.php';
        require_once 'classes/PHPExcel/IOFactory.php';

        $objExcel = PHPExcel_IOFactory::load($upload);
        foreach($objExcel->getWorksheetIterator() as $worksheet){
            $highestrow=$worksheet->getHighestRow();
            

            for($row=2;$row<=$highestrow;$row++){
                $myircode_order = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
                $name_order = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
                $pack_order = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
                $odpzone_order = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
                $odp_order = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
                $odpnum_order = $worksheet->getCellByColumnAndRow(5,$row)->getValue();
                $address_order = $worksheet->getCellByColumnAndRow(6,$row)->getValue();
                $benchmark_order = $worksheet->getCellByColumnAndRow(7,$row)->getValue();
                $telp_order = $worksheet->getCellByColumnAndRow(8,$row)->getValue();
                $email_order = $worksheet->getCellByColumnAndRow(9,$row)->getValue();
                $data_entry = $_SESSION['sfcode_user'];
                date_default_timezone_set('Asia/Jakarta');
                $date_order = date('Y-m-d H:i:s'); 
                $fulfilment1 = $worksheet->getCellByColumnAndRow(10,$row)->getValue();
                $fulfilment2 = $worksheet->getCellByColumnAndRow(11,$row)->getValue();
                $date_take = $worksheet->getCellByColumnAndRow(12,$row)->getValue();
                $date_take = PHPExcel_Style_NumberFormat::toFormattedString($date_take, "YYYY-mm-d H:i:s");

                if ($myircode_order != ""){
                 
                    if ($fulfilment1 != "" && $fulfilment2 != ""){
                        $query = "INSERT INTO orders (myircode_order,name_order,pack_order,odpzone_order,
                                                odp_order,odpnum_order,address_order,benchmark_order,
                                                telp_order, email_order, sfcode_user, date_order,status_order)
                                    VALUES ('$myircode_order','$name_order','$pack_order','$odpzone_order','$odp_order',
                                            '$odpnum_order','$address_order','$benchmark_order','$telp_order','$email_order',
                                            '$data_entry','$date_order',1)";
                        $query1 = "INSERT INTO takes (myircode_order, sfcode_user, date_take)
                                    VALUES ('$myircode_order','$fulfilment1','$date_take')";
                        $query2 = "INSERT INTO patner (myircode_order, sfcode_user)
                                    VALUES ('$myircode_order', '$fulfilment2')";
                        $insert=mysqli_query($con,$query);
                        $insert1=mysqli_query($con,$query1);
                        $insert2=mysqli_query($con,$query2);
    
    
                    } else {
    
                        $query = "INSERT INTO orders (myircode_order,name_order,pack_order,odpzone_order,
                                                        odp_order,odpnum_order,address_order,benchmark_order,
                                                        telp_order, email_order, sfcode_user, date_order,status_order)
                                    VALUES ('$myircode_order','$name_order','$pack_order','$odpzone_order','$odp_order',
                                            '$odpnum_order','$address_order','$benchmark_order','$telp_order','$email_order',
                                            '$data_entry','$date_order',0)";
                        $query1 = "INSERT INTO takes (myircode_order)
                                    VALUES ('$myircode_order')";
                        $query2 = "INSERT INTO patner (myircode_order)
                                    VALUES ('$myircode_order')";
                        $insert=mysqli_query($con,$query);
                        $insert1=mysqli_query($con,$query1);
                        $insert2=mysqli_query($con,$query2);
                    }
    
                    if($insert && $insert1 && $insert2){
                        echo "<script>alert('Order import successfully.');</script>";   
                        echo "<script>window.location.href='order_add.php'</script>";
                        } else{
                                                
                        echo "<script>alert('Something went wrong. Please try again.');</script>";   
                        echo "<script>window.location.href='order_add.php'</script>";  
                        }
                    
                }


            }
        }
    }
    }




?>