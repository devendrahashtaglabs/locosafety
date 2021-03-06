<!-- page content -->
	<div class="right_col" role="main">
	  <div class="">
		<div class="page-title">
		  <div class="title_left">
			<h3>Add New User</h3>
		  </div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content"> 
				<br />
				<?php
					$zoneCode 		= "";
					$divisionCode 	= "";
					if(!empty($getData)){
						if(!empty($getData['zoneId'])){
							$zoneCode = $getData['zoneId'];
						}
						if(!empty($getData['divisionId'])){
							$divisionCode = $getData['divisionId'];
						}
					}
					$attributes = array('class' => 'form-horizontal form-label-left','id' => 'user-form','autocomplete' => 'off');
					if(!empty($zoneCode) && !empty($divisionCode)){
						echo form_open_multipart('users/addAdmin?zoneId='.$zoneCode.'&divisionId='.$divisionCode, $attributes); 					}else{
						echo form_open_multipart('users/addAdmin', $attributes); 
					}
					$loggedInDetail = $this->session->userdata('loggedInDetail');
				?>
				<div class="row mt-5">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Zone <span class="required">*</span>', 'user_zone', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$allZone 		= [];
								$allZone[''] 	= 'Select Zone';
								$zone_id = $zoneDataadmin->zone_id;
								foreach($zoneData as $zoneList){
									$allZone[$zoneList->zone_id] = $zoneList->zone_name;
								}
								echo form_dropdown('user_zone', $allZone, set_value('user_zone',$zone_id), 'class="form-control col-md-7 col-xs-12" id="user_zone" disabled="disabled"');
								echo form_error('user_zone', '<div class="text-danger">', '</div>');
							?>
							<input type="hidden" value="<?php echo $zone_id; ?>" name="user_zone">
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Office / Division <span class="required">*</span>', 'user_division', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$allDivision 		= [];
									$allDivision[''] 	= 'Select Division';
									$division_id = $divisionDataadmin->division_id;
									foreach($divisionData as $divisionList){
										$allDivision[$divisionList->division_id] = $divisionList->division_name;
									}
									
									echo form_dropdown('user_division', $allDivision, set_value('user_division',$division_id), 'class="form-control col-md-7 col-xs-12" id="user_division" disabled="disabled"');
									echo form_error('user_division', '<div class="text-danger">', '</div>');
								?>
								<input type="hidden" value="<?php echo $division_id; ?>" name="user_division">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('User Type <span class="required">*</span>', 'user_type', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php								
								$userTypeArray 		= [];
								$userTypeArray[''] 	= 'Select User Type';
								
								foreach($loginType as $userType){
									$userTypeArray[$userType->role_code] = $userType->role_name;
								}	
								// echo "<pre>";
								// print_r($userTypeArray);
								// exit;							
								echo form_dropdown('user_type',$userTypeArray,set_value('user_type'), 'class="form-control col-md-7 col-xs-12" id="user_type"');								
								echo form_error('user_type', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('First Name <span class="required">*</span>', 'user_f_name', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'name'  			=> 'user_f_name',
											'id'    			=> 'user_f_name',
											'value' 			=> set_value('user_f_name'),
											'class' 			=> 'form-control col-md-7 col-xs-12',
									);
									echo form_input($data);
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Last Name <span class="required">*</span>', 'user_l_name', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'name'  		=> 'user_l_name',
											'id'    		=> 'user_l_name',
											'value' 		=> set_value('user_l_name'),
											'class' 		=> 'form-control col-md-7 col-xs-12',
									);
									echo form_input($data);
									echo form_error('user_l_name', '<div class="text-danger">', '</div>');
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('DOB', 'user_dob', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'type'  		=> 'text',
											'name'  		=> 'user_dob',
											'id'    		=> 'user_dob',
											'value' 		=> set_value('user_dob'),
											'class' 		=> 'form-control col-md-7 col-xs-12 datepicker',
									);
									echo form_input($data);
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
					  <div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Gender', 'user_gender', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
						  <div id="gender" class="btn-group" data-toggle="buttons">
							<?php $selected = 'M'; ?>
							<label class="btn btn-default active focus" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							  <?php echo form_radio(array('name' => 'user_gender', 'value' => 'M', 'checked' => ('M' == $selected) ? TRUE : FALSE, 'id' => 'male')).form_label('Male', 'male'); ?>
							</label>
							<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							 <?php echo form_radio(array('name' => 'user_gender', 'value' => 'F', 'checked' => ('F' == $selected) ? TRUE : FALSE, 'id' => 'female')).form_label('Female', 'female'); ?>
							</label>
							<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							 <?php echo form_radio(array('name' => 'user_gender', 'value' => 'O', 'checked' => ('O' == $selected) ? TRUE : FALSE, 'id' => 'Other')).form_label('Other', 'other'); ?>
							</label>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Address', 'user_address', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
												'name'  			=> 'user_address',
												'id'    			=> 'user_address',
												'value' 			=> set_value('user_address'),
												'class' 			=> 'form-control col-md-7 col-xs-12',
												'rows' 				=> '4',
												'cols' 				=> '10',
											);
									echo form_textarea($data);
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Profile Image', 'user_profile_pic', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'user_profile_pic',
										'id'    			=> 'user_profile_pic',
										'value' 			=> set_value('user_profile_pic'),
										'class' 			=> 'form-control col-md-7 col-xs-12',
								);
								echo form_upload($data);
							?>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Email <span class="required">*</span>', 'user_email', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$data = array(
										'name'  		=> 'user_email',
										'id'    		=> 'user_email',
										'value' 		=> set_value('user_email'),
										'class' 		=> 'form-control col-md-7 col-xs-12',
										'autocomplete' 	=> 'off',
								);
								echo form_input($data);
								echo form_error('user_email', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Phone <span class="required">*</span>', 'user_phone', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php								
								$data = array(
										'type'  			=> 'tel',
										'name'  			=> 'user_phone',
										'id'    			=> 'user_phone',
										'value' 			=> set_value('user_phone'),
										'minlength' 		=> '10',
										'maxlength' 		=> '10',
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'autocomplete' 		=> 'off',
								);
								echo form_input($data);
								echo form_error('user_phone', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Password <span class="required">*</span>', 'user_pass', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'user_pass',
										'id'    			=> 'user_pass',
										'value' 			=> set_value('user_pass'),
										'class' 			=> 'form-control col-md-7 col-xs-12',
								);
								echo form_password($data);
								echo form_error('user_pass', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Confirm Password <span class="required">*</span>', 'user_cpass', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'user_cpass',
										'id'    			=> 'user_cpass',
										'value' 			=> set_value('user_cpass'),
										'class' 			=> 'form-control col-md-7 col-xs-12',
								);
								echo form_password($data);
								echo form_error('user_cpass', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Pin <span class="required">*</span>', 'user_pin', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'name'  			=> 'user_pin',
											'id'    			=> 'user_pin',
											'minlength' 		=> '6',
											'maxlength' 		=> '6',
											'value' 			=> set_value('user_pin'),
											'class' 			=> 'form-control col-md-7 col-xs-12',
									);
									echo form_input($data);
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Confirm Pin <span class="required">*</span>', 'user_cpin', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'name'  			=> 'user_cpin',
											'id'    			=> 'user_cpin',
											'minlength' 		=> '6',
											'maxlength' 		=> '6',
											'value' 			=> set_value('user_cpin'),
											'class' 			=> 'form-control col-md-7 col-xs-12',
									);
									echo form_input($data);
								?>
							</div>
						</div>
					</div>
				</div> 
				<!-- <div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group text-center my-5">
							<div class="col-md-3 col-sm-3 col-xs-12"></div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="g-recaptcha" data-sitekey="6LepE8IUAAAAAIfj7JR-t673aHXJBxEnatQ2Gm0S"></div>
							</div>
						</div>
					</div>
				</div> -->
				<div class="row">
					<div class="form-group text-center my-5">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								echo form_submit('submit', 'Submit', "class='btn btn-success'");
								echo form_reset(array('class'=>'btn btn-danger','id'=>'reset','value'=>"Reset"));
							?>
							<input type="button" class="btn btn-primary" value="Cancel" onclick="location.href='<?php echo base_url();?>users'">
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
