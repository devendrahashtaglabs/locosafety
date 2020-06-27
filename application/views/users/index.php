<style>
.view i {
	color:#FFF;
	font-size:15px;
	padding:0px;
}
</style>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
		<?php 
			$loggedInUserDetail = $this->session->userdata('loggedInUserDetail'); 
		?>
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
			<?php if($loggedInUserDetail->user_role != '3'){ ?>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addUser'; ?>" title="Add New">Add New</a></li> 
				</ul>
			<?php } ?>
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
			<div class="row">
				<div class="col-md-offset-10 col-md-2 col-xs-12 bottom-buffer">
					<form action="<?php echo base_url('users');?>" id="statusChnage" method="GET">
						
					</form>
				</div>
				<div class="col-md-1">
				<label>Filter : </label>
				</div>
				<div class="col-md-2 FilterCustom1" >
				
				</div>
			</div>
            <table id="userdatatableAdmin" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>User Type</th>
                  <th>Assigned (Shop/Section,<br/>MShop/MSection)</th>
                  <th>User Email</th>
                  <th>User Phone</th>
                  <th>User Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					$i = 1;
					$spData ='';
					foreach($userData as $alluser){
				  	$status = isset($alluser->user_status)?$alluser->user_status:'';
					$name 	= $alluser->user_f_name." ".$alluser->user_l_name;	
					$assignuserdata 	= $this->Users_model->Getassigneddata($alluser->user_info_id);
					
					$spData = '';
					$sectionData		= '';
					$msectionData		= '';
					if(isset($assignuserdata)){
						if(isset($assignuserdata->shop_id)){
							
							$shop 			= $this->Shops_model->getShopBy($assignuserdata->shop_id);
							$shop_name 		= $shop->shop_name;
							//$sectionData 	= $shop_name;
							$spData 	= $shop_name;
						}
						if(isset($assignuserdata->section_id)){
							$section 		= $this->Sections_model->getSectionByID($assignuserdata->section_id);
							$section_name 	= $section->section_name;
							//$sectionData 	= $shop_name . ' / ' . $section_name;
						}
						if(isset($assignuserdata->maintenance_shop_id)){
							$mshop 			= $this->Maintenance_shops_model->getMShopBy($assignuserdata->maintenance_shop_id);
							$m_shop_name 	= $mshop->maintenance_shop_name;
							$msectionData 	= $m_shop_name;
						}
						if(isset($assignuserdata->maintenance_section_id)){
							$msection 		= $this->Maintenance_sections_model->getMSectionBy($assignuserdata->maintenance_section_id);
							//echo "<pre>";print_r($msection);echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
							$m_section_name = $msection->maintenance_section_name;
							$msectionData 	= $m_shop_name . ' / ' . $m_section_name;
						}
					}
					
					if($spData != ''){
						$spData =$spData;
					}else{
						$spData = '';
					}
					
					
					if($alluser->user_role == 5)
					{						
						$allMapping = $this->Users_model->getAssignSectionInfo($alluser->user_info_id);					
						/* ============ */
						$sectionArry =array();
						foreach($allMapping as $row){
							$sectionID =  $row->section_id;
							$section 		= $this->Sections_model->getSectionByID($sectionID);
							$section_name 	= $section->section_name;
							array_push($sectionArry,$section_name);
						}
						$sectionArry = implode(', ',$sectionArry);
						//echo "<pre>";print_r($sectionArry);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						if(strlen($sectionArry) > 0 && $spData != ''){
							$sectionData = $spData.'/'.$sectionArry;
						}else{
							$sectionData = '';
						}
						/* ============ */
					}else{
						$sectionData = $spData;
					}
                ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo isset($name)?$name:''; ?></td>
					<td><?php echo isset($alluser->newrolename)?$alluser->newrolename:''; ?></td>
					<?php if(!empty($sectionData)){ ?>
						<td><?php echo isset($sectionData)?$sectionData:''; ?></td>
					<?php }else{ ?>
						<td><?php echo isset($msectionData)?$msectionData:''; ?></td>
					<?php } ?>
					<td><?php echo isset($alluser->user_email)?$alluser->user_email:''; ?></td>
					<td><?php echo isset($alluser->user_mobile)?$alluser->user_mobile:''; ?></td>
					<td>
						<?php
							
							switch ($status) {
								case '10':
									echo "Active";
								break;
								case '80':
									echo "Inactive";
								break;
							}
						?>
					</td>
					<td class="action">	
						<?php if($status != '10'){ ?>
							<!-- <a href="JavaScript:Void(0);" class="edit userinactive" title="Active"> Active </a> -->
							<a href="<?php echo base_url('users/viewUser/'.$alluser->user_info_id); ?>" class="view" title="View"><i class="fa fa-eye"></i></a>
							<?php if($loggedInUserDetail->user_role != '3'){ ?>
								<a href="<?php echo base_url('users/editUser/'.$alluser->user_info_id); ?>" class="edit" title="Edit"> <i class="fa fa-pencil"></i> </a>
								<a href="<?php echo base_url('users/activateUser/'.$alluser->user_info_id); ?>" class="edit userinactive" title="Active"> <i class="fa fa-check"></i> </a>
							<?php } ?>
							<input type="hidden" class="inact" value="<?php echo $alluser->user_info_id; ?>">
						<?php }else{ ?>
								<a href="<?php echo base_url('users/viewUser/'.$alluser->user_info_id); ?>" class="view" title="View"><i class="fa fa-eye"></i></a>
								<?php 
								if($loggedInUserDetail->user_role != '3'){
									//echo "<pre>";print_r();echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
								?>
								<a href="<?php echo base_url('users/editUser/'.$alluser->user_info_id); ?>" class="edit" title="Edit"><i class="fa fa-pencil"></i></a>
								<!-- <a href="JavaScript:Void(0);" class="inactive useractive" onclick="confirmbox()" id="<?php // echo $alluser->user_info_id ?>" title="Inactive"> Inactive </a> -->
								<a href="<?php echo base_url('users/deleteUser/'.$alluser->user_info_id); ?>" class="inactive useractive" onclick="confirmbox()" id="<?php echo $alluser->user_info_id ?>" title="Inactive"> <i class="fa fa-times"></i> </a>
								<?php 
									$allMapping = $this->Users_model->getAssignSectionInfo($alluser->user_info_id);
									$mapCount 	= count($allMapping);
									if($alluser->user_role != 3){
										//print_r($mapCount);
										if($alluser->user_role != 5){
											
											$editUserData				= $this->Users_model->getAssignSectionInfo($alluser->user_info_id);
											if(!empty($editUserData)){
												$mapID = $editUserData[0]->user_map_id;
											}else{
												$mapID ='';
											}
											if($mapCount > 0 && !empty($mapID)){
										?>		
											
											<a href="<?php echo base_url('users/assignUser/'.$alluser->user_info_id.'/'.$mapID); ?>" class="assign" title="Reassign"> <i class="fa fa-user-plus" aria-hidden="true"></i> </a>
										<?php 
											}else{
										?>
											<a href="<?php echo base_url('users/assignUser/'.$alluser->user_info_id); ?>" class="assign" title="Assign"> <i class="fa fa-user-plus" aria-hidden="true"></i> </a>
										<?php 	
											}												
										}else{
										
										
										//exit;
										if($mapCount > 0 ){
										?>
										<!--
										<a href="<?php // echo base_url('users/assignUser/'.$alluser->user_info_id .'/reassign' ); ?>" class="edit" title="Reassign"> <i class="fa fa-user-plus" aria-hidden="true"></i> </a>
										-->
										<a href="<?php echo base_url('users/assignUser/'.$alluser->user_info_id); ?>" class="assign" title="Assign"> <i class="fa fa-user-plus" aria-hidden="true"></i> </a>
									<?php }else{ ?>
										<a href="<?php echo base_url('users/assignUser/'.$alluser->user_info_id); ?>" class="assign" title="Assign"> <i class="fa fa-user-plus" aria-hidden="true"></i> </a>
									<?php 
										}
									}
									}
									}
									?>
						<?php } ?>
					</td>
				</tr>
				<?php $i++; } ?> 
				
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('.useractive').click(function() {
  var txt;
  var r = confirm("Are you sure you want to inactivate this user");
  if (r) {
  	//alert('ok');
  	 var user_status = 80;
  	 var user_ids = (this.id);
		  	 $.ajax({
		        url: "<?php echo base_url(); ?>Users/index",
		        type : "POST",
		        dataType : "json",
		        data : {"user_status" : user_status,"user_ids" : user_ids },
		        success : function(data) {
		          //alert(data);
		        },
		        error : function(data) {
		            //alert(data);
		        }
		    });
		location.reload();
  } else {
  	//alert('cancel');
  }

});
});
</script>
<script>
$(document).ready(function(){
$('.userinactive').click(function(el) {
  var txt;
  var r = confirm("Are you sure you want to activate this user");
  if (r) {
  	//alert('okk');
  	 var user_status = 10;
  	 var user_ids = $(".inact").val();
     //alert(user_ids);
		  	 $.ajax({
		        url: "<?php echo base_url(); ?>Users/index",
		        type : "POST",
		        dataType : "json",
		        data : {"user_status" : user_status,"user_ids" : user_ids },
		        success : function(data) {
		          //alert(data);
		          location.reload();
		        },
		        error : function(data) {
		            //alert(data);
		        }
		    });
		location.reload();
  } else {
  	//alert('cancell');
  }

});
});
</script>

<!-- /page content -->