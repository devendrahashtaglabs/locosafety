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
			  <div class="x_title">
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				  </li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<br />
				<?php 
					$attributes = array('class' => 'form-horizontal form-label-left','id' => 'user-form');
					echo form_open_multipart('users/addAdmin', $attributes); 
				?>
				<div class="row">
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
								echo form_label('Country', 'user_country', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$allCountry 		= [];
									$allCountry[''] 	= 'Select Country';
									foreach($country as $countryList){
										$allCountry[$countryList->country_id] = $countryList->country_name;
									}		 
									echo form_dropdown('user_country', $allCountry, set_value('user_country','1'), 'class="form-control col-md-7 col-xs-12" id="user_country"');
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
								echo form_label('State', 'user_state', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$allState 		= [];
									$allState[''] 	= 'Select State';
									foreach($state as $stateList){
										$allState[$stateList->state_id] = $stateList->state_name;
									}
									echo form_dropdown('user_state', $allState, set_value('user_state','1'), 'class="form-control col-md-7 col-xs-12" id="user_state"');
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
								echo form_label('City', 'user_city', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'name'  			=> 'user_city',
											'id'    			=> 'user_city',
											'value' 			=> set_value('user_city'),
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
								echo form_label('Zipcode', 'user_zipcode', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 								
									$data = array(
											'name'  		=> 'user_zipcode',
											'id'    		=> 'user_zipcode',
											'value' 		=> set_value('user_zipcode'),
											'class' 		=> 'form-control col-md-7 col-xs-12',
									);
									echo form_input($data);
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
				</div>
				<div class="row">
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
							<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							  <?php echo form_radio(array('name' => 'user_gender', 'value' => 'M', 'checked' => ('M' == $selected) ? TRUE : FALSE, 'id' => 'male')).form_label('Male', 'male'); ?>
							</label>
							<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							 <?php echo form_radio(array('name' => 'user_gender', 'value' => 'F', 'checked' => ('F' == $selected) ? TRUE : FALSE, 'id' => 'female')).form_label('Female', 'female'); ?>
							</label>
						  </div>
						</div>
					  </div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('User Type <span class="required">*</span>', 'user_type', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$userTypeArray = [];
								$userTypeArray[''] = 'Select User Type';
								foreach($loginType as $userType){
									$userTypeArray[$userType->login_type] = $userType->login_type_name;
								}
								echo form_dropdown('user_type', $userTypeArray,set_value('user_type'), 'class="form-control col-md-7 col-xs-12" id="user_type"');
								echo form_error('user_type', '<div class="text-danger">', '</div>');
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
							echo form_label('Zone <span class="required">*</span>', 'user_zone', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$allZone 		= [];
								$allZone[''] 	= 'Select Zone';
								foreach($zoneData as $zoneList){
									$allZone[$zoneList->zone_id] = $zoneList->zone_name;
								}
								echo form_dropdown('user_zone', $allZone, set_value('user_zone'), 'class="form-control col-md-7 col-xs-12" id="user_zone"');
								echo form_error('user_zone', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Shop <span class="required">*</span>', 'shop_id', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$allShop 		= [];
								$allShop[''] 	= 'Select Shop';
								foreach($shopData as $shopList){
									$allShop[$shopList->shop_id] = $shopList->shop_name;
								}
								echo form_dropdown('shop_id', $allShop, set_value('shop_id'), 'class="form-control col-md-7 col-xs-12" id="shop_id"');
								echo form_error('shop_id', '<div class="text-danger">', '</div>');
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
								echo form_label('Division <span class="required">*</span>', 'user_division', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									$allDivision 		= [];
									$allDivision[''] 	= 'Select Division';
									foreach($divisionData as $divisionList){
										$allDivision[$divisionList->division_id] = $divisionList->division_name;
									}
									echo form_dropdown('user_division', $allDivision, set_value('user_division'), 'class="form-control col-md-7 col-xs-12" id="user_division"');
									echo form_error('user_division', '<div class="text-danger">', '</div>');
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Section <span class="required">*</span>', 'section_id', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$allSection 		= [];
								$allSection[''] 	= 'Select Section';
								foreach($sectionData as $sectionList){
									$allSection[$sectionList->section_id] = $sectionList->section_name;
								}
								echo form_dropdown('section_id', $allSection, set_value('section_id'), 'class="form-control col-md-7 col-xs-12" id="section_id"');
								echo form_error('section_id', '<div class="text-danger">', '</div>');
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
							echo form_label('Email <span class="required">*</span>', 'user_email', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$data = array(
										'name'  		=> 'user_email',
										'id'    		=> 'user_email',
										'value' 		=> set_value('user_email'),
										'class' 		=> 'form-control col-md-7 col-xs-12',
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
										'minlength' 		=> '6',
										'maxlength' 		=> '6',
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
