<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit User</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title"> 
            <ul class="nav navbar-right panel_toolbox">
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addAdmin'; ?>">Add New</a></li>
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/viewUser/'.$editedId; ?>">View User</a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'user-form');
				echo form_open_multipart('users/editUser/'.$editedId, $attributes); 
			?>
				<div class="row">
					<div class="col-md-12 col-xs-12 bottom-buffer">
						<?php if(!empty($this->session->flashdata('updateUser'))){ ?>
							<h5 class="text-success"><?php echo $this->session->flashdata('updateUser'); ?></h5>
		              	<?php }if(!empty($this->session->flashdata('errorUser'))){ ?>
		              		<h5 class="text-danger"><?php echo $this->session->flashdata('errorUser'); ?></h5>
		              	<?php } ?>
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
								echo form_dropdown('user_zone', $allZone, set_value('user_zone', $editUserData->user_zone), 'class="form-control col-md-7 col-xs-12" id="user_zone" disabled="disabled"');
								echo form_error('user_zone', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
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
									echo form_dropdown('user_division', $allDivision, set_value('user_division',$editUserData->user_division), 'class="form-control col-md-7 col-xs-12" id="user_division"');
									echo form_error('user_division', '<div class="text-danger">', '</div>');
								?>
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
								$userTypeArray = [];
								$userTypeArray[''] = 'Select User Type';
								foreach($loginType as $userType){
									$userTypeArray[$userType->role_code] = $userType->role_name;
								}
								echo form_dropdown('user_type', $userTypeArray,set_value('user_type', $editUserData->user_role), 'class="form-control col-md-7 col-xs-12" id="user_type" disabled="disabled"');
								echo form_error('user_type', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
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
										'value' 		=> set_value('user_email',$editUserData->user_email),
										'class' 		=> 'form-control col-md-7 col-xs-12',
										'autocomplete' 	=> 'off',
								);
								echo form_input($data);
								echo form_error('user_email', '<div class="text-danger">', '</div>');
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
							echo form_label('Phone <span class="required">*</span>', 'user_phone', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php								
								$data = array(
										'type'  			=> 'tel',
										'name'  			=> 'user_phone',
										'id'    			=> 'user_phone',
										'value' 			=> set_value('user_phone',$editUserData->user_mobile),
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
											'name'  	=> 'user_f_name',
											'id'    	=> 'user_f_name',
											'value' 	=> set_value('user_f_name',$editUserData->user_f_name),
											'class' 	=> 'form-control col-md-7 col-xs-12',
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
											'value' 		=> set_value('user_l_name',$editUserData->user_l_name),
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
								echo form_label('DOB', 'user_dob', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
									if(!empty($editUserData->user_dob)){	
										$date 		= date_create($editUserData->user_dob);
										$user_dob 	= date_format($date,"d M Y");
									}
									$data = array(
											'type'  		=> 'text',
											'name'  		=> 'user_dob',
											'id'    		=> 'user_dob',
											'value' 		=> set_value('user_dob',$user_dob),
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
				          	<?php 
				          		$selected = $editUserData->user_gender;
				          		$maleActive = "";
				          		$femaleActive = "";
				          		$otherActive = "";
				          		if($selected === 'M'){
				          			$maleActive = " active focus";
				          		}elseif($selected === 'F'){
				          			$femaleActive = " active focus";
				          		}else{
				          			$otherActive = " active focus";									
								}
				          	?>
				            <label class="btn btn-default<?php echo $maleActive; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
				              <?php echo form_radio(array('name' => 'user_gender', 'value' => 'M', 'checked' => ('M' == $selected) ? TRUE : FALSE, 'id' => 'male')).form_label('Male', 'male'); ?>
				            </label>
				            <label class="btn btn-default<?php echo $femaleActive; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
				             <?php echo form_radio(array('name' => 'user_gender', 'value' => 'F', 'checked' => ('F' == $selected) ? TRUE : FALSE, 'id' => 'female')).form_label('Female', 'female'); ?>
				            </label>
							<label class="btn btn-default<?php echo $otherActive; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
				             <?php echo form_radio(array('name' => 'user_gender', 'value' => 'O', 'checked' => ('O' == $selected) ? TRUE : FALSE, 'id' => 'other')).form_label('Other', 'other'); ?>
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
												'name'  => 'user_address',
												'id'    => 'user_address',
												'value' => set_value('user_address',$editUserData->user_address),
												'class' => 'form-control col-md-7 col-xs-12',
												'rows' 	=> '4',
												'cols' 	=> '10',
											);
									echo form_textarea($data);
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							//echo "<pre>";print_r($editUserData->user_profile_pic);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );							
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
										'value' 			=> set_value('user_profile_pic',$editUserData->user_profile_pic),
										'class' 			=> 'form-control col-md-7 col-xs-12',
								);
								echo form_upload($data);
							?>
							<img id="profile_pic" src="<?php echo base_url().'uploads/'.$editUserData->user_profile_pic;?>" alt="" class="img-responsive"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group text-center my-5">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								echo form_submit('update', 'Update', "class='btn btn-success'");
								echo form_reset(array('class'=>'btn btn-danger','id'=>'clear','value'=>"Clear"));
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
