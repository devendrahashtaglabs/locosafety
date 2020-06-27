<!-- page content -->
<style>
.FilterCustom h4{
	text-align:right;
}
</style>
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          	<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('success'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
              	<?php }if(!empty($this->session->flashdata('error'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
              	<?php } ?>
              </div>
            </div>
			<?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'notification-filter-form','autocomplete' => 'off');
				echo form_open_multipart('notifications', $attributes); 
			?>
            <div class="row" style="margin-bottom:20px; ">
                <div class="col-md-offset-1 col-md-2 FilterCustom"> 
					<h4>Filter :</h4>
				</div>
                <div class="col-md-2 FilterCustom"> 
					<?php
						$allShop         = [];
						$allShop['']    = 'Select Shop';
						if(!empty($shopData)){
							foreach($shopData as $singleShopList){
								$allShop[$singleShopList->shop_id] = $singleShopList->shop_name;
							}  
						}						
						echo form_dropdown('shop_id', $allShop, set_value('shop_id'), 'class="form-control col-md-7 col-xs-12" id="shop_id"');
					?>
				</div>
				<div class="col-md-2 FilterCustom">
					<?php
						$allRole         = [];
						$allRole['']    = 'Select Role';
						foreach($roleData as $singleRoleList){
							$allRole[$singleRoleList->role_id] = $singleRoleList->role_name;
						}                    
						echo form_dropdown('user_role', $allRole, set_value('user_role'), 'class="form-control col-md-7 col-xs-12" id="user_role"');
					?>
				</div>
				<div class="col-md-2 FilterCustom">
					<?php
						$allmShop        = [];
						$allmShop['']    = 'Select Maintenance Shop';
						if(!empty($mShopData)){
							foreach($mShopData as $singlemShopList){
								$allmShop[$singlemShopList->maintenance_shop_id] = $singlemShopList->maintenance_shop_name;
							} 
						}						
						echo form_dropdown('m_shop_id', $allmShop, set_value('m_shop_id'), 'class="form-control col-md-7 col-xs-12" id="m_shop_id"');
					?>
				</div>
				<div class="col-md-2 FilterCustom"></div>
            </div>
			<div class="row" style="margin-bottom:20px; ">
                <div class="col-md-offset-1 col-md-2 FilterCustom">
					<h4>To :</h4>
				</div>
                <div class="col-md-6 FilterCustom">
					<?php
						$allUser       	= [];
						//$allUser['']    = 'Select User';
						if(!empty($allUserData)){
							foreach($allUserData as $singleUserList){
								$userInfo = $this->Users_model->getUserById($singleUserList->user_info_id);
								$name = ''; 
								if(isset($userInfo->user_f_name) || isset($userInfo->user_l_name)){
									$name = $userInfo->user_f_name .' ' . $userInfo->user_l_name;
								}
								$allUser[$userInfo->user_info_id] = $name;
							}  
						}						
						echo form_multiselect('userlist[]', $allUser, set_value('userlist'), 'class="form-control col-md-7 col-xs-12" id="userlist"');
					?>
				</div>
                </div>
                <div class="row" style="margin-bottom:20px;">
				<div class="col-md-offset-1 col-md-2 FilterCustom">
					<h4>Title *:</h4>
				</div>
                <div class="col-md-6 FilterCustom">
					<?php 								
						$data = array(
									'name'  	=> 'notification_title',
									'id'    	=> 'notification_title',
									'value' 	=> set_value('notification_title'),
									'class' 	=> 'form-control col-md-7 col-xs-12',
								);
						echo form_input($data);
					?>
				</div>
			</div>
			<div class="row"  style="margin-bottom:20px;">
				<div class="col-md-offset-1 col-md-2 FilterCustom">
					<h4>Message *:</h4>
				</div>
                <div class="col-md-6 FilterCustom">
					<?php 								
						$data = array(
									'name'  			=> 'user_message',
									'id'    			=> 'user_message',
									'value' 			=> set_value('user_message'),
									'class' 			=> 'form-control col-md-7 col-xs-12',
									'rows' 				=> '6',
									'cols' 				=> '10',
									'maxlength' 		=> '150',
								);
						echo form_textarea($data);
					?>
					<br/>
					<span>Enter Maximum 150 character.</span>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-md-12 text-center">
					<?php 
						echo form_submit('submit', 'Submit', "class='btn btn-success'");
						echo form_reset(array('class'=>'btn btn-danger','id'=>'reset','value'=>"Reset"));
					?>
				</div>
            </div>
			<?php form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">  
    $(document).ready(function() {
		$('#shop_id').change(function(){
			$('#user_role').prop('selectedIndex','');
			$('#m_shop_id').prop('selectedIndex','');
			var option 		= $(this).find('option:selected');
			var shop_id 	= option.val();			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>notifications/getuserbyshop/',
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				data: {'shop_id': shop_id}, 
				success: function (data) {
					$("#userlist").html(data);           
				},
				error: function (data) {
					console.log(data);
				}
			});
		});
		$('#user_role').change(function(){
			$('#shop_id').prop('selectedIndex','');
			$('#m_shop_id').prop('selectedIndex','');
			var option 		= $(this).find('option:selected');
			var role_id 	= option.val();			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>notifications/getuserbyrole/',
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				data: {'role_id': role_id}, 
				success: function (data) {
					$("#userlist").html(data);           
				},
				error: function (data) {
					console.log(data);
				}
			});
		});
		$('#m_shop_id').change(function(){
			$('#shop_id').prop('selectedIndex','');
			$('#user_role').prop('selectedIndex','');
			var option 		= $(this).find('option:selected');
			var m_shop_id 	= option.val();			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>notifications/getuserbymshop/',
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				data: {'m_shop_id': m_shop_id}, 
				success: function (data) {
					$("#userlist").html(data);           
				},
				error: function (data) {
					console.log(data);
				}
			});
		});
	});
</script>