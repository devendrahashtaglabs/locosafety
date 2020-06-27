<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>View User</h3>
      </div>
    </div>
    <div class="clearfix"></div>
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		<?php 
			$loggedInUserDetail = $this->session->userdata('loggedInUserDetail'); 
		?>
		  <div class="x_title">
			<?php   //if($loggedInUserDetail->user_role != '3'){ ?>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users'; ?>"> Back </a></li>
				</ul>
			<?php //}  ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'user-view-form');
				echo form_open_multipart('users/editAdmin/'.$editedId, $attributes);
			?>
			<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
			  <div class="profile_img">
				<div id="crop-avatar">
				  <!-- Current avatar -->
					<?php 
						$profile_pic 		= $userDataById->user_profile_pic; 
						if(empty($profile_pic)){
							$profile_pic = "no-available.jpg";
						}else{
							$profilePicExist 	= file_exists('./uploads/'.$profile_pic);
							if(empty($profilePicExist)){
								$profile_pic = "no-available.jpg";
							}
						}
					?>
					<img class="img-responsive avatar-view" src="<?php echo base_url().'uploads/'.$profile_pic; ?>" alt="Avatar" title="Change the avatar">
				</div>
			  </div>
				<h3>
					<?php echo $userDataById->user_f_name.' '.$userDataById->user_l_name; ?>
				</h3>
			  <ul class="list-unstyled user_data">
				<?php if(!empty($userDataById->user_address)){ ?>
					<li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $userDataById->user_address; ?>
					</li>
				<?php 
					}
					$userTypeName 	= $this->Users_model->getUserRole($userDataById->user_role);
					if(!empty($userTypeName)){
				?>
					<li>
					  <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $userTypeName->role_name; ?>
					</li>
				<?php 
					}
					if(!empty($userDataById->user_email)){
				?>
					<li>
						<i class="fa fa-envelope"></i> <a href="mailto:<?php echo $userDataById->user_email; ?>"><?php echo $userDataById->user_email; ?></a>
					</li>
				<?php } 
					if(!empty($userDataById->user_mobile)){
				?>
					<li>
						<i class="fa fa-volume-control-phone"></i> <a href="tel:<?php echo $userDataById->user_mobile; ?>"><?php echo $userDataById->user_mobile; ?> </a>
					</li>
				<?php } ?>
			  </ul>
			<?php
				/*if($loggedInUserDetail->user_role != '3'){
					if($loggedInUserDetail->user_role == '1'){
			?>
				<a class="btn btn-success" href="<?php echo base_url().'users/editAdmin/'.$userDataById->user_info_id;?>"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
				<?php }else{ ?>
				<a class="btn btn-success" href="<?php echo base_url().'users/editUser/'.$userDataById->user_info_id;?>"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
					
				<?php } } */?>
			  <br />

			</div>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 class="user-details">User Details</h2>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Zone :', 'user_zone', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$allZone 		= [];
									$allZone[''] 	= 'Select Zone';
									foreach($zoneData as $zoneList){
										$allZone[$zoneList->zone_id] = $zoneList->zone_name;
									}
									$attributes = array(
											'class' => 'control-label',
										);
									if(!empty($allZone[$userDataById->user_zone])){
										echo form_label($allZone[$userDataById->user_zone], 'user_zone', $attributes);
									}
								?> 
							</div>	
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Division :', 'user_division', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 							
									$allDivision 		= [];
									$allDivision[''] 	= 'Select Division';
									foreach($divisionData as $divisionList){
										$allDivision[$divisionList->division_id] = $divisionList->division_name;
									}
									$attributes = array(
										'class' => 'control-label',
									);
									if(!empty($allDivision[$userDataById->user_division])){
										echo form_label($allDivision[$userDataById->user_division], 'user_division', $attributes);
									}
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Gender :', 'user_gender', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <div id="gender" class="btn-group" data-toggle="buttons">
								<?php 
									$attributes = array(
										'class' => 'control-label',
									);
									$gender = '';
									switch($userDataById->user_gender){
										case 'M':
										$gender ='Male';
										break;
										case 'F':
										$gender ='Female';
										break;
									}
									echo form_label($gender, 'user_gender', $attributes);
								?>
							  </div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('DOB :', 'user_dob', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$attributes = array(
										'class' => 'control-label',
									);
									$dob ="";
									if(!empty($userDataById->user_dob)){
										$dob	= date_create($userDataById->user_dob); 
										$dob	= date_format($dob, "d M Y");
									}									
									echo form_label($dob, 'user_dob', $attributes);
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php form_close(); ?>
		  </div>
		</div> 
	  </div>
	</div>
  </div>
</div>
<!-- /page content -->
