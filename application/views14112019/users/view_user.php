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
		  <div class="x_title">
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addUser'; ?>">Add New</a></li>
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users'; ?>">View List</a></li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'user-view-form');
				echo form_open_multipart('users/editUser/'.$editedId, $attributes);
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
			  <h3><?php echo $userDataById->user_f_name.' '.$userDataById->user_l_name; ?></h3>

			  <ul class="list-unstyled user_data">
				<?php if(!empty($userDataById->user_address)){ ?>
					<li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $userDataById->user_address; ?>
					</li>
				<?php 
					}
					$userTypeName 	= $this->Users_model->getUserTypeName($userDataById->user_type);
					if(!empty($userTypeName)){
				?>
					<li>
					  <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $userTypeName; ?>
					</li>
				<?php 
					}
					if(!empty($userDataById->user_email)){
				?>
					<li>
						<i class="fa fa-envelope"></i> <a href="mailto:<?php echo $userDataById->user_email; ?>"><?php echo $userDataById->user_email; ?></a>
					</li>
				<?php } if(!empty($userDataById->user_phone)){
				?>
					<li>
						<i class="fa fa-volume-control-phone"></i> <a href="tel:<?php echo $userDataById->user_phone; ?>"><?php echo $userDataById->user_phone; ?> </a>
					</li>
				<?php } ?>
			  </ul>

			  <a class="btn btn-success" href="<?php echo base_url().'users/editUser/'.$userDataById->user_id;?>"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
			  <br />

			</div>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 class="user-details">User Details</h2>
					</div>
					<?php 
						$allSection 		= [];
						$allSection['0'] 	= 'Select Section';
						foreach($sectionData as $sectionList){
							$allSection[$sectionList->section_id] = $sectionList->section_name;
						}
						//echo "<pre>";print_r($userDataById);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						if($userDataById->section_id != '0'){
					?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
									);
									echo form_label('Section :', 'section_id', $attributes);
								?>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<?php 
										if(!empty($allSection[$userDataById->section_id])){
											$attributes = array(
													'class' => 'control-label',
												);
											echo form_label($allSection[$userDataById->section_id], 'section_id', $attributes);
										}
									?>
								</div>	
							</div>
						</div>
					<?php } ?>
					<?php 
						$allShop 		= [];
						$allShop[''] 	= 'Select Shop';
						foreach($shopData as $shopList){
							$allShop[$shopList->shop_id] = $shopList->shop_name;
						}
						if($userDataById->shop_id != '0'){
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Shop :', 'shop_id', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$allShop 		= [];
									$allShop[''] 	= 'Select Shop';
									foreach($shopData as $shopList){
										$allShop[$shopList->shop_id] = $shopList->shop_name;
									}
									$attributes = array(
											'class' => 'control-label',
										);
									if($userDataById->shop_id == '0'){
										$shopName = 'Not Available';
									}else{
										$shopName = $allShop[$userDataById->shop_id];
									}
									echo form_label($shopName, 'shop_id', $attributes);
								?>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php /*<div class="col-md-6 col-sm-6 col-xs-12">
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
					</div> */?>
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
									echo form_label($gender, 'user_dob', $attributes);
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
										$dob	= date_format($dob, "d-m-Y");
									}									
									echo form_label($dob, 'user_dob', $attributes);
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
								echo form_label('City :', 'user_city', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$attributes = array(
										'class' => 'control-label',
									);
									if(!empty($userDataById->user_city)){
										echo form_label($userDataById->user_city, 'user_city', $attributes);
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
								echo form_label('State :', 'user_state', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$allState 		= [];
									$allState[''] 	= 'Select State';
									foreach($state as $stateList){
										$allState[$stateList->state_id] = $stateList->state_name;
									}
									$attributes = array(
										'class' => 'control-label',
									);
									if(!empty($allState[$userDataById->user_state])){
										echo form_label($allState[$userDataById->user_state], 'user_state', $attributes);
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
								echo form_label('Country :', 'user_country', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$attributes = array(
										'class' => 'control-label',
									);
									if(!empty($userDataById->country_name)){
										echo form_label($userDataById->country_name, 'user_country', $attributes);
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
								echo form_label('Zipcode :', 'user_zipcode', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$attributes = array(
										'class' => 'control-label',
									);
									if(!empty($userDataById->user_zipcode)){
										echo form_label($userDataById->user_zipcode, 'user_zipcode', $attributes);
									}										
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		  </div>
		</div> 
	  </div>
	</div>
  </div>
</div>
<!-- /page content -->
