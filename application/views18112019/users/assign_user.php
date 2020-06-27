<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Assign Shop</h3>
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
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'user-form');
				echo form_open_multipart('users/assignUser/'.$editedId, $attributes); 
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
							<input type="hidden" value="<?php echo $editUserData->user_info_id ?>" class="info_id" name="info_id" id="info_id">
						</div>
					</div>


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
								//$shop_id = $shopidByuser->shop_id;
								foreach($usershop as $userType){
									$userTypeArray[$userType->shop_id] = $userType->shop_name;
								}							
									echo form_dropdown('shop_type',$userTypeArray,set_value('shop_type'), 'class="form-control col-md-7 col-xs-12 shopbyid" id="shop_type"');
								
								echo form_error('shop_type', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>

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
										foreach($usersection as $userType){
											$userTypeArray[$userType->section_id] = $userType->section_name;
										}	
															
											echo form_dropdown('section_type',$userTypeArray,set_value('section_type'), 'class="form-control col-md-7 col-xs-12 shopbyid" id="section_type"');
										
										echo form_error('section_type', '<div class="text-danger">', '</div>');
									?>
								</div>			
						
						</div>
					</div>
					
				<div class="row">
				
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	var base_url 	= window.location.origin;
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
});
</script>
<!-- /page content -->
