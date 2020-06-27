<script>
	$(document).ready(function() {
		$(".toggle-password").click(function(e) {
			e.preventDefault();
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
				input.attr("type", "text"); 
			} else {
				input.attr("type", "password");
			}
		});
	});
</script>
<style>
	.field-icon {
		float: right;
		margin-left: -25px;
		margin-top: -30px;
		position: relative;
		z-index: 2;
		margin-right: 13px;
	}
	.fa-eye{
		color:#73879C;
		font-size: 13px;
	}
	.fa-eye-slash{
		color:#73879C;
		font-size: 13px;
		margin-top: -24px;
	}
	.control-label{
		padding-top: 0px !important;
	}
</style>

<!-- page content -->
	<div class="right_col" role="main">
	  <div class="">
		<div class="page-title">
		  <div class="title_left">
			<h3>Change Password</h3>
		  </div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content" style="min-height:200px;"> 
				<br />
				<div class="row mt-5">
					<div class="col-md-12 col-xs-12 bottom-buffer">
						<?php if(!empty($this->session->flashdata('success'))){ ?>
							<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
						<?php }if(!empty($this->session->flashdata('error'))){ ?>
							<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<?php 
						$attributes = array('class' => 'form-horizontal form-label-left','id' => 'changepass-form','autocomplete' => 'off');
						echo form_open_multipart('users/changePass/'.$userId, $attributes); 
					?>
					<div class="col-md-4 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Old Password<span class="required">*</span>', 'user_old_pass', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'user_old_pass',
										'id'    			=> 'user_old_pass',
										'value' 			=> set_value('user_old_pass'),
										'class' 			=> 'form-control col-md-7 col-xs-12',
								);
								echo form_password($data);
								echo form_error('user_old_pass', '<div class="text-danger">', '</div>');
							?>
							<span toggle="#user_old_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>
					</div>
					<div class="col-md-4 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('New Password<span class="required">*</span>', 'user_pass', $attributes);
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
							<span toggle="#user_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>
					</div>
					<div class="col-md-4 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Confirm Password<span class="required">*</span>', 'user_cpass', $attributes);
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
							<span toggle="#user_cpass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>
					</div>
					<div class="col-md-4 col-xs-12 bottom-buffer">
						<?php 
							echo form_submit('submit', 'Submit', "class='btn btn-success'");
							echo form_reset(array('class'=>'btn btn-danger','id'=>'reset','value'=>"Reset"));
						?>
						<input type="button" class="btn btn-primary" value="Cancel" onclick="location.href='<?php echo base_url();?>'">
					</div>
				</div>
			<?php echo form_close(); ?>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- /page content -->
