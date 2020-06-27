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
	
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dashboard/css/style.css" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url(); ?>" class="site_title"><span>LOCOSAFETY</span></a>
            </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
				<?php
					$userId 			= $this->session->userdata('loggedInAdmin');
					$loggedInDetail 	= $this->session->userdata('loggedInAdminDetail');
					//echo "<pre>";print_r($loggedInDetail);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
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
                <span>Welcome,</span>
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
					<li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
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
					<?php if($loggedInDetail->role_id != '1'){ ?>
						<li><a><i class="fa fa-archive"></i> Hardware Management <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
							  <li><a href="<?php echo base_url('hardwares');?>">All Hardware</a></li>
							  <li><a href="<?php echo base_url('hardwares/mapHardware');?>">Assign Hardware To Section</a></li>
							  <li><a href="<?php echo base_url('tickets');?>">Ticket</a></li>
							</ul>
						</li>
					<?php } ?>
                   <li><a><i class="fa fa-arrows"></i> Masters <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<?php if($loggedInDetail->role_id == '1'){ ?>
							<li><a href="<?php echo base_url('zones');?>">Zones</a></li>
							<li><a href="<?php echo base_url('divisions');?>">Offices / Divisions</a></li>
						<?php }else{ ?>
							<li><a href="<?php echo base_url('shops');?>">Shops</a></li>
							<li><a href="<?php echo base_url('sections');?>">Sections</a></li>
							<li><a href="<?php echo base_url('types');?>">Types</a></li>
							<li><a href="<?php echo base_url('categories');?>">Categories</a></li>
						<?php } ?>
                    </ul>
                  </li>
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