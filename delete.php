<?php

$days = 1;
//$queryDel=mysqli_query($con,"delete from orders where DATEDIFF(CURDATE(), date_order) >= '$days'");
$queryDel=mysqli_query($con,"DELETE FROM orders WHERE date_order <= DATE_SUB(NOW(), INTERVAL 1 DAYS)");

