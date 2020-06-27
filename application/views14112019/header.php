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
                <img src="<?php echo base_url(); ?>assets/dashboard/images/irctc.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
				<?php
					$loggedInDetail 	= $this->session->userdata('loggedInDetail');
					//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
				?>
                <span>Welcome,</span>
				<?php if(!empty($loggedInDetail->admin_name)){ ?>
					<h2><?php echo $loggedInDetail->admin_name; ?></h2>
				<?php } ?>
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
                      <li><a href="<?php echo base_url('users');?>">All User</a></li>
                      <li><a href="<?php echo base_url('users/addUser');?>">Add New</a></li>
                    </ul>
                  </li>
                   <li><a><i class="fa fa-archive"></i> Hardwares <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('hardwares');?>">All Hardware</a></li>
                      <li><a href="<?php echo base_url('hardwares/addHardware');?>">Add New</a></li> <li><a href="<?php echo base_url('tickets');?>">Ticket</a></li>
                    </ul>
                  </li>
                   <li><a><i class="fa fa-arrows"></i> Masters <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu"> 
						<li><a href="<?php echo base_url('categories');?>">Categories</a></li>
						<li><a href="<?php echo base_url('types');?>">Types</a></li>
						<li><a href="<?php echo base_url('shops');?>">Shops</a></li>
						<li><a href="<?php echo base_url('sections');?>">Sections</a></li>
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
					<?php if(!empty($loggedInDetail->admin_name)){ ?>
						<img src="<?php echo base_url(); ?>assets/dashboard/images/irctc.jpg" alt=""><?php echo $loggedInDetail->admin_name; ?>
					<?php } ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Change Password</a></li>
                    <li><a href="<?php echo base_url().'logout';?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->