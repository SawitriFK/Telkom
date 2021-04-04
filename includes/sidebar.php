<?php

if($_SESSION['access_user']=="Administrator"){?>

    <nav class="hk-nav hk-nav-light">
        <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
        <div class="nicescroll-bar">
            <div class="navbar-nav-wrap">
                <ul class="navbar-nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="ion ion-ios-keypad"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>

                                            
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#user">
                            <i class="ion ion-ios-person"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                        <ul id="user" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="user_add.php">Add</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="user_manage.php">Manage</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#team">
                            <i class="ion ion-ios-person"></i>
                            <span class="nav-link-text">Teams</span>
                        </a>
                        <ul id="team" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="team_add.php">Add</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="team_manage.php">Manage</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#order">
                            <i class="ion ion-ios-copy"></i>
                            <span class="nav-link-text">Order</span>
                        </a>
                        <ul id="order" class="nav flex-column collapse collapse-level-1">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="order_add.php">Add</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="order_waiting.php">Waiting</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="order_processed.php">Processed</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
                                    
                <hr class="nav-separator">    
            </div>
        </div>
    </nav>

<?php
}elseif($_SESSION['access_user']=="Fulfillment"){?>

    <nav class="hk-nav hk-nav-light">
        <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
        <div class="nicescroll-bar">
            <div class="navbar-nav-wrap">
                <ul class="navbar-nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="ion ion-ios-keypad"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="order_waiting.php">
                            <i class="ion ion-md-list-box"></i>
                            <span class="nav-link-text">Waiting Order</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="my_takes.php">
                            <i class="ion ion-md-hand"></i>
                            <span class="nav-link-text">My Takes</span>
                        </a>
                    </li>

    
                </ul>
                        
                <hr class="nav-separator">    
            </div>
        </div>
    </nav>


<?php
}elseif($_SESSION['access_user']=="HD"){?>

    <nav class="hk-nav hk-nav-light">
        <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
        <div class="nicescroll-bar">
            <div class="navbar-nav-wrap">
                <ul class="navbar-nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="ion ion-ios-keypad"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="order_add.php">
                            <i class="ion ion-md-add"></i>
                            <span class="nav-link-text">Add Order</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="order_waiting.php">
                            <i class="ion ion-md-cog"></i>
                            <span class="nav-link-text">Waiting Order</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="order_processed.php">
                            <i class="ion ion-md-checkmark"></i>
                            <span class="nav-link-text">Processed Order</span>
                        </a>
                    </li>
    
                </ul>
                    
                    
                <hr class="nav-separator">    
            </div>
        </div>
    </nav>

<?php
}else{
    header('location:logout.php');
}

?>

