
    <!-- <div class="col-md-2 col-sm-2">
        <a href="#menu-toggle" class="btn" id="menu-toggle">
            <div class="menu-icon"></div>
            <div class="menu-icon"></div>
            <div class="menu-icon"></div></a>
        </div>
        <div class="col-md-7 col-sm-7">

        </div>
        <div class="col-md-3 col-sm-3">
            <div class="row" align="right">
                <div class="col-md-6 col-sm-6">
                    <i class="fa fa-user" style="font-size:24px;color:white"></i> 
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <a style="font-size:10px"><?php echo $user[0][1];?></a>
                    </div>
                    
                    <div class="row">
                        <div class="dropdown" style="float:left;">
                            <button class="dropbtn">online</button>
                            <div class="dropdown-content">
                                <a style="font-size:10px; padding: 4px;" href="../logout.php">logout</a>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="navbar-header" style="padding:8px;">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" style="padding:0px;" href="#">
            <div class="row">
                <img alt="Brand" class="img-responsive logo"  src="../template/images/logo_fahsai.png" >
                <div style="color:#347ab7;margin-left:5px;">                    
                    <div>
                        <span style="font-weight:bold;">Customer</span>                        
                    </div>
                    <div style="margin-top:-6px;">                        
                        <span >Management</span>
                    </div>
                </div>
            </div>
        </a>
		</div>
        <div id="navbar" align="center" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;background: #fff;">
		<ul class="nav navbar-nav">
			<li class="nav-item Active">
				<a href="index.php?modules=Engineer" class="" style="padding:8px;">
					<span><i class="fa fa-cubes" aria-hidden="true"></i>&nbsp; JOB</span>
				</a>
			</li>
			<li class="nav-item ">
				<a href="index.php?modules=customer" class="" style="padding:8px;">
					<span><i class="glyphicon glyphicon-user" aria-hidden="true"></i>&nbsp; CUSTOMER</span>
				</a>
			</li>
			<li class="nav-item ">
				<a href="index.php?modules=employee" class="" style="padding:8px;">
					<span><i class="fa fa-users" aria-hidden="true"></i>&nbsp; EMPLOYEE</span>
				</a>
			</li>
			<li class="nav-item ">
				<a href="index.php?modules=department" class="" style="padding:8px;">
					<span><i class="fa fa-home" aria-hidden="true"></i>&nbsp; DEPARTMENT</span>
				</a>
			</li>
			
		</ul> -->

 		<!-- <ul class="nav navbar-nav navbar-right" style="background-color:#FFF; z-index:99999;float:right;">
			<li style="margin:10px;">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<img src="../theme/image/user.png" style="width:48px; height:48px; border-radius:48px;">
			</a>
			<ul class="dropdown-menu dropDown_user" style="margin-top:10px; width:50px;">
				<li>
					<a href="home_detail.php?viewID="><div class="divUser"> <i class="fa fa-pencil fa-fw" style="padding-right:8px;"></i> Edite Profile</div></a>
				</li>
				<li>
					<a href="logout_user.php"><div class="divUser" style="color:#F00;"> <i class="fa fa-power-off" aria-hidden="true" style="padding-right:8px;"></i> Sign out</div></a>
				</li>
			</ul>
			</li>
        </ul> -->
        
            <nav class="navbar navbar-expand-lg navbar-light " >
            <a class="navbar-brand" style="padding:0px;" href="#">
                <div class="row">
                    <img  class="img-responsive logo"  src="../template/images/logo_fahsai.png" >
                    <div style="color:#347ab7;margin-left:5px;">                    
                        <div>
                            <span style="font-weight:bold;">Customer</span>                        
                        </div>
                        <div style="margin-top:-6px;">                        
                            <span >Management</span>
                        </div>
                    </div>
                </div>
            </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="padding-left:5px;padding-right:5px;">
                    <ul class="navbar-nav mr-auto">
                    
                    <li class="nav-item">
                        <a href="?content=user"   <?php if($page=="user"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-user" style="font-size:24px"></i>
                        <span style="padding:5px; font-size:15px; ">ผู้ดูเเลระบบ</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="?content=status"   <?php if($page=="status"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-user" style="font-size:24px"></i>
                        <span style="padding:5px; font-size:15px; ">สถานะหนี้</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="?content=gateway"   <?php if($page=="gateway"){echo "class='button-head button-head-menu-active'";} else {echo "class='button-head button-head-menu'";}?> ><i class="fa fa-user" style="font-size:24px"></i>
                        <span style="padding:5px; font-size:15px; ">ช่องทางการชำระเงิน</span></a>
                    </li>
                    
                </div>
            </nav>

		
		</div>

