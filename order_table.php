<?php
session_start();
//error_reporting(0);
include('includes/config.php');
include('function.php');


if($_POST["que"] != '' AND $_POST["que2"] != '')
{
 $search_array = explode(",", $_POST["que"]);
 $search_text = "'" . implode("', '", $search_array) . "'";
 $search_array2 = explode(",", $_POST["que2"]);
 $search_text2 = "'" . implode("', '", $search_array2) . "'";
 $que = mysqli_query($con,"
 select * from orders join status on orders.id_status = status.id_status WHERE status.phase_status>0
 AND status.phase_status IN (".$search_text.")  AND status.id_status IN (".$search_text2.")
 ORDER BY status.id_status DESC
 ");
}elseif($_POST["que"] != ''){
    $search_array = explode(",", $_POST["que"]);
    $search_text = "'" . implode("', '", $search_array) . "'";

    $que = mysqli_query($con,"
    select * from orders join status on orders.id_status = status.id_status WHERE status.phase_status>0
    AND status.phase_status IN (".$search_text.")
    ORDER BY status.id_status DESC
    ");
}elseif($_POST["que2"] != ''){
    $search_array2 = explode(",", $_POST["que2"]);
    $search_text2 = "'" . implode("', '", $search_array2) . "'";

    $que = mysqli_query($con,"
    select * from orders join status on orders.id_status = status.id_status WHERE status.phase_status>0
    AND status.id_status IN (".$search_text2.")
    ORDER BY status.id_status DESC
    ");
}
else
{
 $que = mysqli_query($con, "select * from orders join status on orders.id_status = status.id_status WHERE status.phase_status>0");
}



if(mysqli_num_rows($que) > 0)
{
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
    <td><?php echo $r['name_status'];?></td>

    <?php
    echo "<td>";    
    if($_SESSION['access_user'] == "Administrator"){                          
    
    echo "<a href='order_edit.php?pid=".base64_encode($r['myircode_order'].$rno)."&back=pro' class='mr-25' data-toggle='tooltip' data-original-title='Edit'> <i class='icon-pencil'></i></a>";
    echo "<a href='order_processed.php?del=".base64_encode($r['myircode_order'].$rno)."' class='mr-25' data-toggle='tooltip' data-original-title='Delete' onclick='return confirm('Do you reallyy want to delete?');''> <i class='icon-trash txt-danger'></i></a>";
   
    //Hapus
    }elseif($_SESSION['access_user'] == "HD" && $r['phase_status']==1){
        echo "<a href='order_edit.php?pid=".base64_encode($r['myircode_order'].$rno)."&back=pro' class='mr-25' data-toggle='tooltip' data-original-title='Edit'> <i class='icon-pencil'></i></a>";
    }
    echo "</td>";?>
</tr>

<?php 

        }
    }else
        {
         ?>
         <tr>
          <td colspan="5" align="center">No data available in table</td>
         </tr>
        <?php
        }
?>