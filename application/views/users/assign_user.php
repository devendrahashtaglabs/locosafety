<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Assigned Shop and Section</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title"> 
            <ul class="nav navbar-right panel_toolbox">
				
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'assign-user-form');
				echo form_open_multipart('users/assignUser/'.$editedId.'/'.$activity, $attributes); 
				$allMapping = $this->Users_model->getAssignSectionInfo($editedId);
				$mapCount 	= count($allMapping);
				$allMappingData	= '';
				$sectionArry = array();	
				
				$GetAllAbleSectionCount = $this->Users_model->GetMapSectionIDs();				
					/* ============ */
					foreach($GetAllAbleSectionCount as $row){
						$sectionID =  $row->section_id;
						array_push($sectionArry,$sectionID);
					}
					/* ============ */	
							
				
				if($mapCount > 0 ){
					
					
					
					
					$allMappingData = $allMapping[0];
					
					
					if(!empty($activity)){
			?>
				<input type="hidden" value="<?php echo $allMappingData->user_map_id; ?>" class="map_id" name="map_id" id="map_id">
					<?php } ?>
			<?php } ?>
				<div class="row">
					<div class="col-md-12 col-xs-12 bottom-buffer">
						<?php if(!empty($this->session->flashdata('updateUser'))){ ?>
							<h5 class="text-success"><?php echo $this->session->flashdata('updateUser'); ?></h5>
		              	<?php }if(!empty($this->session->flashdata('errorUser'))){ ?>
		              		<h5 class="text-danger"><?php echo $this->session->flashdata('errorUser'); ?></h5>
		              	<?php } ?>
						<?php if(!empty($this->session->flashdata('success'))){ ?>
							<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
		              	<?php }if(!empty($this->session->flashdata('error'))){ ?>
		              		<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
		              	<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('User Type : ', 'user_type', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
								
									$userTypeName 	= $this->Users_model->getUserRole($editUserData->user_role);
									if(!empty($userTypeName)){
										$attribute = array(
											'class' => 'control-label',
										);
										echo form_label($userTypeName->role_name, 'user_type', $attribute);
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
								echo form_label('Name : ', 'user_name', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$attribute = array(
										'class' => 'control-label',
									);
									if(!empty($editUserData->user_f_name) || !empty($editUserData->user_l_name) ){
										$name = $editUserData->user_f_name.' ' .$editUserData->user_l_name;
										echo form_label($name, 'user_name', $attribute);
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
								echo form_label('Email : ', 'user_email', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$attribute = array(
										'class' => 'control-label',
									);
									if(isset($editUserData->user_email)){
										echo form_label($editUserData->user_email, 'user_email', $attribute);
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
								echo form_label('Phone : ', 'user_mobile', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$attribute = array(
										'class' => 'control-label',
									);
									if(isset($editUserData->user_mobile)){
										echo form_label($editUserData->user_mobile, 'user_mobile', $attribute);
									}
								?>
							</div>
						</div>
					</div>
					<?php 
						//echo "<pre>";print_r($editUserData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						if($editUserData->user_role == '6' || $editUserData->user_role == '7'){
					?>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Maintenance Shop <span class="required">*</span>', 'shop_type', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php								
								$userTypeArray 		= [];
								$userTypeArray[''] 	= 'Select Maintenance Shop';
								//$shop_id = $shopidByuser->shop_id;
								
									foreach($usermshop as $userType){
										$userTypeArray[$userType->maintenance_shop_id] = $userType->maintenance_shop_name;
									}
								
								if(!empty($activity) && isset($allMappingData->maintenance_shop_id)){
									echo form_dropdown('m_shop_type',$userTypeArray,set_value('m_shop_type',$allMappingData->maintenance_shop_id), 'class="form-control col-md-7 col-xs-12 mshopbyid" id="m_shop_type"');	
								}else{
									echo form_dropdown('m_shop_type',$userTypeArray,set_value('m_shop_type'), 'class="form-control col-md-7 col-xs-12 mshopbyid" id="m_shop_type"');					
								}
								echo form_error('m_shop_type', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
					<?php if($editUserData->user_role != '6'){ ?>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Maintenance Section <span class="required">*</span>', 'section_type', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12 one">
							<?php								
								$userTypeArray 		= [];
								$userTypeArray[''] 	= 'Select Maintenance Section';
								if(!empty($allMappingData->maintenance_shop_id)){
									$usermsection = $this->Maintenance_sections_model->getMSectionByMshopId($allMappingData->maintenance_shop_id);
								}
								if(!empty($usermsection)){
									//if(!empty($activity)){
									foreach($usermsection as $userType){
										$userTypeArray[$userType->maintenance_section_id] = $userType->maintenance_section_name;
									//}
									}
								}
								if(!empty($activity) &&  isset($allMappingData->maintenance_section_id)){
									echo form_dropdown('m_section_type',$userTypeArray,set_value('m_section_type',$allMappingData->maintenance_section_id), 'class="form-control col-md-7 col-xs-12 " id="m_section_type"');
								}else{
									echo form_dropdown('m_section_type',$userTypeArray,set_value('m_section_type'), 'class="form-control col-md-7 col-xs-12 " id="m_section_type"');					
								}										
								echo form_error('m_section_type', '<div class="text-danger">', '</div>');
							?>
						</div>							
					</div>
					<?php } }else{ ?>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Shop <span class="required">*</span>', 'shop_type', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php								
								$userTypeArray 		= [];
								$userTypeArray[''] 	= 'Select Shop';
								//if(!empty($activity)){
								if( isset($allMappingData->shop_id)){
									foreach($usershop as $userType){
										if($allMappingData->shop_id == $userType->shop_id){
										$userTypeArray[$userType->shop_id] = $userType->shop_name;
										}
									}
									
								}else{
									foreach($usershop as $userType){
										$userTypeArray[$userType->shop_id] = $userType->shop_name;
									}
								}
								//}
								
								if( isset($allMappingData->shop_id)){
									
									if($editUserData->user_role == 5){
										$dis = 'readonly="readonly"';
									}else{
										$dis = "";
									}
									
									echo form_dropdown('shop_type',$userTypeArray,set_value('shop_type',$allMappingData->shop_id),  'class="form-control col-md-7 col-xs-12 shopbyid" '.$dis.' id="shop_type"');
									
								}else{
									echo form_dropdown('shop_type',$userTypeArray,set_value('shop_type'), 'class="form-control col-md-7 col-xs-12 shopbyid" id="shop_type"');					
								}
								echo form_error('shop_type', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
					<?php if($editUserData->user_role != '4'){ ?>
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Section <span class="required">*</span>', 'section_type', $attributes);
						?>
						
						
							<div class="col-md-9 col-sm-9 col-xs-12 one">
								<?php								
									$userTypeArray 		= [];
									$userTypeArray[''] 	= 'Select Section';
									if(empty($usersection)){
										if(isset($allMappingData->shop_id) ){
											$shop_id = $allMappingData->shop_id;
											$usersection = $this->Users_model->getShopSection($shop_id);
										}
									}
									if(!empty($allMappingData->section_id)){
										
										foreach($usersection as $userType){
										 /* 	print_r($allMappingData->section_id);
										print_r("<pre>");
										print_r($userType);
										print_r("</br>");  */
										//print_r($sectionArry);
											if(empty($activity)){
												if(!in_array($userType->section_id,$sectionArry) && $userType->section_id != $allMappingData->section_id){
													$userTypeArray[$userType->section_id] = $userType->section_name;
												}
											}else{
												if(!in_array($userType->section_id,$sectionArry) ){
													$userTypeArray[$userType->section_id] = $userType->section_name;
												}elseif($userType->section_id == $editUserData->section_id){
													
													/* print_r($userType->section_id);
													echo "</br>";
													print_r($allMappingData->section_id);
													print_r($userType->section_name); */
													$userTypeArray[$userType->section_id] = $userType->section_name;
												}
											}
										}
									}else{
										
										/* print_r($sectionArry);
										exit; */
										foreach($usersection as $userType){
											if(!in_array($userType->section_id,$sectionArry) ){
												$userTypeArray[$userType->section_id] = $userType->section_name;
											}
											
										}
									}
									
									
									if( !empty($activity) &&  isset($allMappingData->section_id)){
										if(!empty($activity)){											
											$IDEdit =  $editUserData->section_id;
										}else{
											$IDEdit =  $allMappingData->section_id;
										}
										
										echo form_dropdown('section_type',$userTypeArray,set_value('section_type',$IDEdit), 'class="form-control col-md-7 col-xs-12 " id="section_type"');
									}else{
										echo form_dropdown('section_type',$userTypeArray,set_value('section_type'), 'class="form-control col-md-7 col-xs-12 " id="section_type"');					
									}									
									echo form_error('section_type', '<div class="text-danger">', '</div>');
									
									/* echo "<pre>";
									print_r($userTypeArray);
									exit; */
								?>
							</div>							
					</div>
					<?php } } ?>
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
	<?php if($editUserData->user_role == '5') { ?>
	<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title"> 
			<h3>Assigned Shop and Section</h3>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            
			 <table id="userdatatableAdmin" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>User Detail</th>
                  <th>Shop Name</th>
                  <th>Section Name</th>
                  <th>Maintenance Shop</th>
                  <th>Maintenance Section</th>                  
                  <th>Hardware Count</th>
                  <th>User Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				
				<?php 
					if(!empty($UserSectionData)){ 
                                                                                        
						$counter = 1;	
						foreach ($UserSectionData as $key => $value) {
						//$UserData 	= $this->Users_model->getAdmin($value->user_info_id)[0];
						$UserData 	= $this->Users_model->GetUserDataByID($value->user_info_id)[0];
						$shop_name 	= ''; 
						if(!empty($value->shop_id)){
							$shopDetail = $this->Shops_model->getShopBy($value->shop_id);
							if(!empty($shopDetail)){
								$shop_name = $shopDetail->shop_name;
							}
						}
						$maintenance_shop_name 	= ''; 
						if(!empty($value->maintenance_shop_id)){
							$mShopDetail = $this->Maintenance_shops_model->getMShopBy($value->maintenance_shop_id);
							if(!empty($mShopDetail)){
								$maintenance_shop_name = $mShopDetail->maintenance_shop_name;
							}
						}
						$maintenance_section_name = '';
                                                
						if(!empty($value->maintenance_section_id)){
                                                    
							$maintenance_section = $this->Maintenance_sections_model->getMSectionBy($value->maintenance_section_id);
							if(!empty($maintenance_section)){
								$maintenance_section_name = $maintenance_section->maintenance_section_name;
							}
						}
						$section_name = '';
						if($value->section_id != 0) { 
							$sectionDetail = $this->Sections_model->getSectionByID($value->section_id);
							if(!empty($sectionDetail)){
								$section_name = $sectionDetail->section_name;
							}
						} 
						$name 	= $UserData->user_f_name.' '.$UserData->user_l_name;
						$mobile = $value->user_mobile;
						$email 	= $value->user_email;
						
				?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td><?php echo isset($name)?$name:'';echo ' : [ ';echo isset($mobile)?$mobile:''; echo ' ]'; echo '<br/>';echo isset($email)?$email:'';?></td>
					<td><?php echo isset($shop_name)?$shop_name:''; ?></td>
					<td><?php echo isset($section_name)?$section_name:''; ?></td>
					<td><?php echo isset($maintenance_shop_name)?$maintenance_shop_name:''; ?></td>
					<td><?php echo isset($maintenance_section_name)?$maintenance_section_name:''; ?></td>
					<?php /*
					<td>      
					<?php if(count($this->Hardwares_model->getHardwareDataBySectionID($value->section_id)) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->section_id; ?>' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataBySectionID($value->section_id)); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataBySectionID($value->section_id)); ?></a>
					<?php } ?>
					</td>
					*/ ?>
					<?php if(!empty($value->section_id)){ ?>
					<td>      
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->section_id,'section_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->section_id; ?>','section_id');"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->section_id,'section_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->section_id,'section_id')); ?></a>
					<?php } ?>
					</td>
					<?php }elseif(!empty($value->shop_id)){ ?>
					<td> 
                                            
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->shop_id,'shop_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->shop_id; ?>','shop_id' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->shop_id,'shop_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->shop_id,'shop_id')); ?></a>
					<?php } ?>
					</td>
					<?php } if(!empty($value->maintenance_section_id)){ ?>
					<td> 
                                            
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_section_id,'maintenance_section_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->maintenance_section_id; ?>','maintenance_section_id' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_section_id,'maintenance_section_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_section_id,'maintenance_section_id')); ?></a>
					<?php } ?>
					</td>
					<?php }elseif(!empty($value->maintenance_shop_id)){ ?>
					<td>      
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_shop_id,'maintenance_shop_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->maintenance_shop_id; ?>','maintenance_shop_id' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_shop_id,'maintenance_shop_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_shop_id,'maintenance_shop_id')); ?></a>
					<?php } ?>
					</td>
					<?php } ?>
					<td>
						<?php 
							$status = $value->user_status;
							if(isset($status)){
								switch ($status) {
									case '10':
										echo "Active";
									break;
									case '80':
										echo "Inactive";
									break;
								}
							}
						?>
					</td>
					<td>
						<a href="<?php echo base_url('users/assignUser/'.$editedId.'/'.$value->user_map_id); ?>" class="edit" title="Edit"><i class="fa fa-pencil"></i></a>
						<a href="<?php echo base_url('users/usermapinactive/'.$editedId.'/'.$value->user_map_id); ?>" class="inactive useractive" onclick="confirmbox()" id="3" title="Inactive"> <i class="fa fa-times"></i> </a>
						
					</td>	
				</tr>
				<?php 
					$counter++; } 
				  }	
				?> 
				
				
				
			  </tbody>
			</table>
			
          </div>
        </div>
      </div>
    </div>
	
	<?php } ?>
  
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	var base_url 	= '<?php echo base_url(); ?>';
	$('.shopbyid').change(function() {
		var $option = $(this).find('option:selected');
			var shop_id = $option.val();	
			$.ajax({
				url: base_url+'/users/getSectionByShop',
				data: {'shop_id': shop_id}, 
				type: "post",
				success: function(data){
					$("#section_type").html(data);
				}
			});
	});
	$('.mshopbyid').change(function() {
		var $option = $(this).find('option:selected');
			var mshop_id = $option.val();	
			$.ajax({
				url: base_url+'/users/getMSectionByMShop',
				data: {'shop_id': mshop_id}, 
				type: "post",
				success: function(data){
					$("#m_section_type").html(data);
				}
			});
	});
	$("#assign-user-form").validate({
		rules: {
			shop_id: "required",
			section_id: "required",
			m_shop_type: {
				required : true,
			},
			m_section_type: {
				required : true,
			},
			shop_type: {
				required : true,
			},
			section_type: {
				required : true,
			},	
		},
	});
});
</script>
<!-- /page content -->
