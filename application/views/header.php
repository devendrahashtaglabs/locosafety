<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url(); ?>assets/dashboard/images/favicon.ico" type="image/ico" />
    <title><?php echo $title; ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url(); ?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url(); ?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url(); ?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	<!-- Datetimepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/base_url.js"></script>
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dashboard/css/style.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
			<?php 
				$loggedInUserDetail = $this->session->userdata('loggedInUserDetail'); 
			?>
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url(); ?>" class="site_title"><span>RSW SAFETY</span></a>
            </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
				<?php
					$userId 			= $this->session->userdata('loggedInAdmin');
					$loggedInDetail 	= $this->session->userdata('loggedInAdminDetail');
					if(!empty($loggedInDetail->role_id)){
						$role_code = $loggedInDetail->role_id;
						if($role_code == '1'){ 
				?>
					<img src="<?php echo base_url(); ?>assets/dashboard/images/irctc.jpg" alt="profile pic" class="img-circle profile_img">		
				<?php }else{
						$allUser = $this->Users_model->getUserById($userId);
						if(!empty($allUser)){
						$loggedInUser = $allUser;
						$profile_pic = $loggedInUser->user_profile_pic;
				?>
					<img src="<?php echo base_url('uploads/'.$profile_pic); ?>" alt="profile pic" class="img-circle profile_img">
				<?php }}} ?>
              </div>
              <div class="profile_info">
				<?php
					if(!empty($loggedInDetail->role_id)){
						$role_code = $loggedInDetail->role_id;
				?>
                <span>Welcome</span>
				<?php 
					if($role_code == '1'){
				?>
					<h2><?php echo $loggedInDetail->role_name; ?></h2>
				<?php 
					}else{ 
						$allUser = $this->Users_model->getUserById($userId);
						if(!empty($allUser)){
						$loggedInUser = $allUser;
						$f_name = $loggedInUser->user_f_name;
						$l_name = $loggedInUser->user_l_name;
						$fullname = $f_name.' '.$l_name;
				?>
					<h2><?php echo isset($fullname)?$fullname:''; ?></h2>
				<?php } } } ?>
              </div>
            </div>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 class="dashboard"><a href="<?php echo base_url(); ?>"><?php echo 'Dashboard'; ?></a></h3>
                <ul class="nav side-menu">
					<li><a><i class="fa fa-users"></i> Users Management <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<?php 
								if(!empty($loggedInDetail->role_id)){
									$role_code = $loggedInDetail->role_id;
									if($role_code == '1'){ 
							?>
								<li><a href="<?php echo base_url('users/alladmin');?>">All User</a></li>
							<?php }else{  ?>
								<li><a href="<?php echo base_url('users');?>">All User</a></li>
							<?php } } ?>
						</ul>
					</li>
					<li><a><i class="fa fa-arrows"></i> Masters Management<span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<?php if($loggedInDetail->role_id == '1'){ ?>
								<li><a href="<?php echo base_url('zones');?>">Zone</a></li>
								<li><a href="<?php echo base_url('divisions');?>">Office/Division</a></li>
							<?php }else{ ?>
								<li><a href="<?php echo base_url('shops');?>">Shop</a></li>
								<li><a href="<?php echo base_url('sections');?>">Section</a></li>
								<li><a href="<?php echo base_url('maintenance_shops');?>">Maintenance Shop</a></li>
								<li><a href="<?php echo base_url('maintenance_sections');?>">Maintenance Section</a></li>
<!--								<li><a href="<?php //echo base_url('types');?>">Type</a></li>-->
								<li><a href="<?php echo base_url('categories');?>">Category</a></li>
							<?php } ?>
						</ul>
					</li>
					<?php if($loggedInDetail->role_id != '1'){ ?>
						<li><a><i class="fa fa-archive"></i> Hardware Management <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
							  <li><a href="<?php echo base_url('hardwares');?>">All Hardware</a></li>
							  <?php if($loggedInUserDetail->user_role != '3'){ ?>
								<li><a href="<?php echo base_url('hardwares/mapHardware');?>">Assign Hardware To Section</a></li>
							  <?php } ?>
							</ul>
						</li>
					<?php } ?>
					<?php if($loggedInDetail->role_id != '1'){ ?>
						<li><a><i class="fa fa-user-plus" aria-hidden="true"></i> Reports Management <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li><a href="<?php echo base_url('report/usersection');?>">User Section </a></li>
								<li><a href="<?php echo base_url('report/hardwaresection');?>">Hardware Section</a></li>
								<li><a href="<?php echo base_url('tickets');?>">Ticket</a></li>
							</ul>
						</li>
					<?php } ?>
					<?php if($loggedInDetail->role_id == '2'){ ?>
						<li><a><i class="fa fa-bell" aria-hidden="true"></i> Notifications Management <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li><a href="<?php echo base_url('notifications');?>">Send Notification</a></li> 
							</ul>
						</li>
					<?php } ?>
					<?php if($loggedInDetail->role_id == '2' || $loggedInDetail->role_id == '3'){ ?>
						<li><a><i class="fa fa-calendar " aria-hidden="true"></i></i> Meeting Management <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li><a href="<?php echo base_url('meeting');?>">Safety Meeting</a></li> 
								<li><a href="<?php echo base_url('meeting/get_meeting_list');?>">Meeting List</a></li> 
							</ul>
						</li>
					<?php } ?>
					<?php if($loggedInDetail->role_id == '2'){ ?>
						<li><a><i class="fa fa-cog" aria-hidden="true"></i> Settings<span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li><a href="<?php echo base_url('dashboard/dashboard_config');?>">Dashboard Settings</a></li> 
							</ul>
						</li>
					<?php } ?>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
				<div class="nav toggle">
					<a id="menu_toggle"><i class="fa fa-bars"></i></a>
				</div>
				<?php 
					if(isset($loggedInUserDetail)){
						$user_zone 	 	= $loggedInUserDetail->user_zone;
						$user_division 	= $loggedInUserDetail->user_division;
						$zoneDetail	 	= $this->Zones_model->getZoneBy($user_zone);
						$divisionDetail	= $this->Divisions_model->getDivisionBy($user_division);
						if($loggedInUserDetail->user_role != '1'){
				?>
					<ul class="list-inline header-info">
						<?php if(!empty($zoneDetail->zone_name)){ ?>
							<li>Zone : <span><?php echo $zoneDetail->zone_name; ?></span> </li>
						<?php }if(!empty($divisionDetail->division_name)){ ?>
							<li>Division : <span><?php echo $divisionDetail->division_name; ?></span> </li>
						<?php } ?>
					</ul>
				<?php } } ?>
				<ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<?php 
						if(!empty($loggedInDetail->role_id)){
							$role_code = $loggedInDetail->role_id;
							if($role_code == '1'){ 
					?>
						<img src="<?php echo base_url(); ?>assets/dashboard/images/irctc.jpg" alt=""><?php echo $loggedInDetail->role_name; ?>
					<?php 
						}else{ 
							$allUser = $this->Users_model->getUserById($userId);
							if(!empty($allUser)){
							$loggedInUser = $allUser;
							$f_name = $loggedInUser->user_f_name;
							$l_name = $loggedInUser->user_l_name;
							$profile_pic = $loggedInUser->user_profile_pic;
							$fullname = $f_name.' '.$l_name;
					?>
					<img src="<?php echo base_url('uploads/'.$profile_pic); ?>" alt=""><?php echo $fullname; ?>
					<?php }}} ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
					<?php 
						if(!empty($loggedInDetail->role_id)){
							$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
							$role_code = $loggedInDetail->role_id;
							if($role_code != '1'){ 
					?>
						<li><a href="<?php echo base_url('users/changePass/'.$loggedInAdmin);?>"> Change Password</a></li>
					<?php }} ?>
                    <li><a href="<?php echo base_url().'logout';?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->