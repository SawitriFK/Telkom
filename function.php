<?php
include('includes/config.php');

function deleteUser($getDel){
    global $con;
    $del=substr(base64_decode($getDel),0,-5);
    $query=mysqli_query($con,"delete from users where sfcode_user='$del'");
    echo "<script>alert('Users record deleted.');</script>";
    echo "<script>window.location.href='user_manage.php'</script>";
  };

function updateUser($name_user,$access_user,$pass_user,$pid){
    global $con;
    if($pass_user != ""){
        $options = [
            'cost' => 12,];
        $hash= password_hash('$pass_user', PASSWORD_BCRYPT, $options); 
        $query=mysqli_query($con,"update users set 
                            name_user='$name_user', access_user='$access_user', pass_user='$hash' 
                            where sfcode_user='$pid'"); 
    }else{
        $query=mysqli_query($con,"update users set 
                            name_user='$name_user', access_user='$access_user'
                            where sfcode_user='$pid'"); 
    }
    
    if($query){
        echo "<script>alert('User updated successfully.');</script>";   
        echo "<script>window.location.href='user_manage.php'</script>";
    } else{
        echo "<script>alert('Something went wrong. Please try again.');</script>";   }
}

//=============================================================================================

function deleteTeam($getDel){
    global $con;
    $del=substr(base64_decode($getDel),0,-5);
    $query=mysqli_query($con,"delete from teams where id_team='$del'");
    echo "<script>alert('Team record deleted.');</script>";
    echo "<script>window.location.href='team_manage.php'</script>";
  };

function updateTeam($name_team,$fulfillment1,$fulfillment2,$quantity_team,$id_patner,$pid){
    global $con;
    $query=mysqli_query($con,"update teams set 
                        name_team='$name_team', fulfillment1='$fulfillment1', fulfillment2='$fulfillment2', quantity_team='$quantity_team', id_patner='$id_patner' 
                        where id_team='$pid'"); 

    if($query){
        echo "<script>alert('Team updated successfully.');</script>";   
        echo "<script>window.location.href='team_manage.php'</script>";
    } else{
        echo "<script>alert('Something went wrong. Please try again.');</script>";   }
}

//------------------------------------------------------------------------------------------------------------

function checkTeam($id_team,$id_status){
    global $con;
    $check = mysqli_query($con,"select teams.quantity_team b,count(case when status.phase_status=1  THEN 1 END) as c,  if(count(case when status.phase_status=1  THEN 1 END) = 0 || count(case when status.phase_status=1  THEN 1 END) < teams.quantity_team, 'true','false') as bol_check
                                from orders
                                left join status on orders.id_status = status.id_status
                                left join teams on orders.id_team = teams.id_team
                                where orders.id_team = '$id_team'");
    $bol_check= mysqli_fetch_array($check);


    if ($id_team != "" && $bol_check['bol_check']=='false'){
        $id_status= 'NULL';
        $id_team='NULL';
        a('yjn');
    }elseif ($id_team != "" && $bol_check['bol_check']=='true'){
        $id_status=$id_status;
        $id_team=$id_team;
        a('okoj');
    }else{
        $id_status=1;
        $id_team='NULL';
    }
return array ($id_status,$id_team);
}


function team ($id_team){
    global $con;
    $userfull=mysqli_query($con,"select *, users1.name_user as name_user1, users2.name_user as name_user2 from teams 
    join users as users1 on teams.fulfillment1 = users1.sfcode_user
    join users as users2 on teams.fulfillment2 = users2.sfcode_user
    join patner on teams.id_patner = patner.id_patner
    where teams.id_team=$id_team");
    $full= mysqli_fetch_array($userfull);
    $full1 = $full['name_user1'];
    $full2 = $full['name_user2'];
    $patner = $full['name_patner'];
    return array ($full1, $full2, $patner);
};

//------------------------------------------------------------------------------------------------------------

function loopin($id_status){
    global $con;
        a("ha");
    if($id_status > 0 ){

        $query=mysqli_query($con,"select *, users1.name_user as name_user1, users2.name_user as name_user2 from teams 
                                    join users as users1 on teams.fulfillment1 = users1.sfcode_user
                                    join users as users2 on teams.fulfillment2 = users2.sfcode_user
                                    join patner on teams.id_patner = patner.id_patner");
        $row=mysqli_fetch_array($query);
        if($row['id_team']==$id_team){
            $result1 ="<option value=".$row['id_team'].">".$row['name_user1']." & ".$row['name_user2']."   - ".$row['name_patner']."</option>";
        }
        while($row){
            $result2 ="<option value=".$row['id_team'].">".$row['name_user1']." & ".$row['name_user2']."   - ".$row['name_patner']."</option>";
        };
    }else{
        $result1 ="<option value=''>select one</option>";
        $query=mysqli_query($con,"select *, users1.name_user as name_user1, users2.name_user as name_user2 from teams 
                                    join users as users1 on teams.fulfillment1 = users1.sfcode_user
                                    join users as users2 on teams.fulfillment2 = users2.sfcode_user
                                    join patner on teams.id_patner = patner.id_patner");
        while($row=mysqli_fetch_array($query)){
        $result1 ="<option value=".$row['id_team'].">".$row['name_user1']." & ".$row['name_user2']."   - ".$row['name_patner']."</option>";
        };
    }
    return array ($result1,$result2);
}
function loopingTeams(){
    global $con;
    $query=mysqli_query($con,"select *, users1.name_user as name_user1, users2.name_user as name_user2 from teams 
        join users as users1 on teams.fulfillment1 = users1.sfcode_user
        join users as users2 on teams.fulfillment2 = users2.sfcode_user
        join patner on teams.id_patner = patner.id_patner");
    return $query;
}





function a($get){
    echo "<script>alert('".$get."');</script>"; 
}