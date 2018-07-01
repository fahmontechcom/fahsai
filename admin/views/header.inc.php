
<nav class="navbar navbar-expand-lg navbar-light" style="background-color:white;box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.2);">
    
    <a class="navbar-brand " style="padding:0px;" href="index.php?content=customer">
        <div class="row">
            <img  class="img-responsive logo"  src="../template/images/logo_fahsai.jpg" >
            <div style="color:#347ab7;margin-left:5px;">                    
                <div>
                    <span style="font-weight:bold;">Customer</span>                        
                </div>
                <div style="margin-top:-6px;font-size:16px;">                        
                    <span >Management</span>
                </div>
            </div>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar" style="float:right;">
        <span class="navbar-toggler-icon" ></span>
    </button>
    
    
    <div class="navbar-collapse collapse justify-content-center" id="collapsingNavbar">
        <ul class="navbar-nav ml-auto mr-auto">
            
            <li class="nav-item nav-item-style" >
                <a href="?content=customer"   <?php if($page=="customer"||$page=="schedule"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-user header-i-size " ></i>
                <span >ลูกค้า</span></a>
            </li>
            <li class="nav-item nav-item-style" >
                <a href="?content=user"   <?php if($page=="user"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-group header-i-size" ></i>
                <span >ผู้ใช้งาน</span></a>
            </li>
            <li class="nav-item nav-item-style" >
                <a href="?content=status"    <?php if($page=="status"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-tasks header-i-size" ></i>
                <span >สถานะหนี้</span></a>
            </li>
            <li class="nav-item nav-item-style" >
                <a href="?content=gateway"    <?php if($page=="gateway"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-money header-i-size" ></i>
                <span >ช่องทางชำระ</span></a>
            </li>
            <li class="nav-item nav-item-style" >
                <a href="?content=sale"  <?php if($page=="sale"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-id-badge header-i-size" ></i>
                <span >พนักงานขาย</span></a>
            </li>
            
        </ul>
        
        
        <ul class="navbar-nav ">
            <!-- PROFILE DROPDOWN - scrolling off the page to the right -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-center" id="navDropDownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-bell" style="font-size:18px;color:#337ab7;">
                    <?php if(count($notifications_new) > 0){?>
                        <span class="alert">
                            <?php echo count($notifications_new);?>
                        </span>
                    <?php } ?></i>
                </a>
                <div class="dropdown-menu  dropdown-menu-right" style="width: 310px; min-width: 0;" aria-labelledby="navDropDownLink">
                <?php 
                    for($i=0 ; $i < count($notifications) ;$i++){ ?>
                    <a class="dropdown-item <?php if($notifications[$i]['notification_seen_date'] == ""){ echo "notify-active"; }else{  echo "notify";  } ?>" style="font-size:12px" href="<?php echo $notifications[$i]['notification_url'];?>&notification=<?php echo $notifications[$i]['notification_id'];?>">
                        <div>
                            <i class="fa fa-comment fa-fw"></i><?php echo $notifications[$i]['notification_detail'];?><span class="pull-right text-muted small"><?php echo $notifications[$i]['notification_date'];?></span>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php
                        if($i == 10){break;}
                    } 
                
                    ?>
                    
                    
                    <a class="dropdown-item  text-center" href="index.php?content=notification" style="color:black;font-size: 12px;">Show All</a>
                </div>
            </li>
            <!--/////////////////////////////////////////////-->
            
            <!--/////////////////////////////////////////////-->
        </ul>
        
        <ul class="navbar-nav ">
            <!-- PROFILE DROPDOWN - scrolling off the page to the right -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-center" id="navDropDownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-user" style="font-size:18px;color:#337ab7;"></i>
                <?php echo $user[0][1];?></a>
                <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="navDropDownLink">
                    <!-- <a class="dropdown-item" href="#">Preferences</a> -->
                    <!-- <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item  text-center" href="../logout.php" style="color:black;font-size: 12px;"><i class="fa fa-power-off" ></i>&nbsp;Logout</a>
                </div>
            </li>
        </ul>
        
            
    </div>
    
    <!-- <div class="dropdown show">
        <a class="dropdown-toggle" style="width:100%;color:#181818" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user" style="font-size:18px;color:#347ab7;"></i>
            <?php echo $user[0][1];?>
            <i class="fa fa-caret-down" style="font-size:24px;color:#347ab7;"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="font-size:10px;">
            <a class="dropdown-item" href="../logout.php" style="color:red"><i class="fa fa-power-off" ></i>&nbsp; lockout</a>
            
            
        </div>
    </div> -->
    
        
</nav>
            
            
            
		


