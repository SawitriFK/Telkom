<div class="modal" id="myModal<?php echo $r['myircode_order'];?>">
<div class="modal-dialog">
<div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">

    <h4 class="modal-title">Detail</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <?php
    $myir = $r['myircode_order'];
    $query=mysqli_query($con,"select *, takes.sfcode_user AS fulfilment1, patner.sfcode_user AS fulfilment2, orders.sfcode_user AS user_entry
                                from orders 
                                join takes on takes.myircode_order = orders.myircode_order
                                join patner on patner.myircode_order = orders.myircode_order
                                where orders.myircode_order='$myir'");
        $rno=mt_rand(10000,99999);
        while($row=mysqli_fetch_array($query)){
            $f1= $row['fulfilment1'];
            $f2= $row['fulfilment2'];
            $name_f1 = mysqli_query($con,"select * from users where sfcode_user = '$f1'");
            $ful1=mysqli_fetch_array($name_f1);
            $name_f2 = mysqli_query($con,"select * from users where sfcode_user = '$f2'");
            $ful2=mysqli_fetch_array($name_f2);    
    ?>
    
    <!-- Modal body -->
    <div class="modal-body">
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Name</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['name_order'];?></label>   
        </div>
    </div>
 
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">MYIR Code</h6> 
        </div>
        <div class="col-md-8 mb-10">
        <label for="validationCustom03"><?php echo $row['myircode_order'];?></label>  
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Status</h6> 
        </div>
        <div class="col-md-8 mb-10">
        <?php
        switch ($row['status_order']){
            case 0:
                echo "<label for='validationCustom03' class = 'text-primary font-weight-bold'>NOT YET TAKEN</label>";
                break;
            case 1:
                echo "<label for='validationCustom03' class = 'text-warning font-weight-bold'>ONGOING</label>";
                break;
            case 2:
                echo "<label for='validationCustom03' class = 'text-success font-weight-bold'>DONE</label>";
                break;
            case 3:
                echo "<label for='validationCustom03' class = 'text-danger font-weight-bold'>CONSTRAINTS</label>";
                break;
            default:
                echo "<label for='validationCustom03' class = 'text-secondary font-weight-bold'>No description</label>";



        };?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">ODP</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo "ODP - ".$row['odpzone_order']." - ".$row['odp_order']." / ".$row['odpnum_order'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Pack</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['pack_order'];?></label>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Address</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['address_order'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Benchmark</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['benchmark_order'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Telephone</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['telp_order'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Email</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['email_order'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Data Entry</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['user_entry'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Date Take</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['date_take'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Fulfillment</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $ful1['name_user']." dan ".$ful2['name_user']?></label>   
        </div>
    </div>
    <?php
    if($row['status_order']==3){
    ?>

    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Problem</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['prob_take'];?></label>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-10">
            <h6 for="validationCustom03">Explanation</h6> 
        </div>
        <div class="col-md-8 mb-10">
            <label for="validationCustom03"><?php echo $row['exp_take'];?></label>   
        </div>
    </div>

    <?php
    }
    ?>

    </div>

    <?php
    }
    ?>
    
    <!-- Modal footer -->
    <div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
    </div>

</div>
</div>
</div>  

