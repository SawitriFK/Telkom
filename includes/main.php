<?php
if(isset($_GET['page'])){
    echo "<script>alert('lease try again.');</script>";  

    $page = (isset($_GET['page']))? $_GET['page'] : '';
    switch($page){
    case 'dashboard':
        include "admin_dashboard.php";
        break;

    case 'pRofiLE':
        include "profile.php";
        break;

    case 'user-Add':
        include "user_add.php";
        break;

    case 'user-mAnage':
        include "user_manage.php";
        break;

    case 'user-edIt':
        include "user_edit.php";
        break;

    case 'Order-add':
        include "order_add.php";
        break;

    case 'oRder-manage':
        include "order_manage.php";
        break;

    case 'orDer-constraints':
        include "order_constraints.php";
        break;
    
    case 'ordEr-success':
        include "order_success.php";
        break;

    case 'waitIng-List':
        include "waiting_list.php";
        break;
    
    case 'My-takES':
        include "my_takes.php";
        break;

    case 'dL':
        include "detail.php";
        break;

    
    
    default: // Ini untuk set default jika isi dari $page tidak ada pada 3 kondisi diatas
        include "logout.php";
    }
}else{
    echo "<script>alert('Invalid SF Code. Please try again.');</script>";   
}
 
