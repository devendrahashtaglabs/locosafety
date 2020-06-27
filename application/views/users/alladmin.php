<style>
.fa-eye {
    color: #fdfdfd;
    font-size: 15px;
    padding: 2px;
}
a.view {
    padding: 5px 0px 5px 3px;
}
</style>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
            	<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addAdmin'; ?>" title="Add New">Add New</a></li> 
            </ul>
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

				<div class="col-md-offset-82 col-md-12 col-xs-12 bottom-buffer">
					<div class="col-md-9 ">
					</div>
					<div class="col-md-1 text-right">
						<label>
							Filter : 
						</label>
					</div>
					<div class="col-md-2 ">
					<form action="<?php echo base_url('users/alladmin');?>" id="statusChnage" method="GET">
						<?php 
							$allStatus		= array(
								'all' 	=> 'All',
								'10' 	=> 'Active',
								'80' 	=> 'Inactive',
							);
							if($status === NULL){
								$status  = 'all';
							}
							echo form_dropdown('searchByStatus', $allStatus,set_value('searchByStatus', $status), 'class="form-control pull-right" id="searchByStatus"');
						?>
					</form>
				</div>
				</div>
			</div>
            <table id="userdatatableAdmin" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Zone</th>
                  <th>Division</th>
                  <th>User Type</th>
                  <th>User Email</th>
                  <th>User Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				<?php 
				  if(!empty($userData)){ 
					$counter 				= 1;
					foreach($userData as $singleUser){
						$name       	= $singleUser->user_f_name." ".$singleUser->user_l_name;
						$user_info_id	= $singleUser->user_info_id;
						$userInfo		= "";
						$userRoleArray	= "";
						if(!empty($user_info_id)){
							$userInfo = $this->Users_model->getUserInfo($user_info_id);						
						}
						$user_role 		= $userInfo->user_role;
						if($user_role == '2'){
							if(!empty($user_role)){
								$userRoleArray 	= $this->Users_model->getUserRole($user_role); 
							}
							$userType = $userRoleArray->role_name;
							$phone      	= isset($userInfo->user_mobile)?$userInfo->user_mobile:'';
							$email      	= isset($userInfo->user_email)?$userInfo->user_email:'';
							$division      	= isset($userInfo->user_division)?$userInfo->user_division:'';
							$divisionData 	= $this->Divisions_model->getDivisionBy($division);
							$zone      		= isset($userInfo->user_zone)?$userInfo->user_zone:'';
							$zoneData 		= $this->Zones_model->getZoneBy($zone);
							$status      	= isset($userInfo->user_status)?$userInfo->user_status:'';
                ?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td><?php echo isset($name)?$name:''; ?></td>
					<td><?php echo isset($zoneData->zone_name)?$zoneData->zone_name:''; ?></td>
					<td><?php echo isset($divisionData->division_name)?$divisionData->division_name:''; ?></td>
					<td><?php echo isset($userType)?$userType:'';?></td>
					<td><?php echo isset($singleUser->user_email)?$singleUser->user_email:'';?></td>
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
						<a href="<?php echo base_url('users/viewUser/'.$userInfo->user_info_id); ?>" class="view" title="View"> <i class="fa fa-eye"></i> </a> 
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('users/editAdmin/'.$userInfo->user_info_id); ?>" class="edit" title="Edit"> <i class="fa fa-pencil"></i>  </a> 
							<a href="<?php echo base_url('users/deleteUser/'.$userInfo->user_info_id); ?>" onClick="return doconfirm();" class="inactive" title="Inactive"> <i class="fa fa-times"></i> </a>
							<?php /*<a href="<?php echo base_url('users/changePass/'.$userInfo->user_info_id); ?>" class="view"> Change Password </a>*/?>
						<?php }else{ ?>
							<a href="<?php echo base_url('users/editAdmin/'.$userInfo->user_info_id); ?>" class="edit" title="Edit"> <i class="fa fa-pencil"></i>  </a> 
							<a href="<?php echo base_url('users/activateUser/'.$userInfo->user_info_id); ?>" class="edit" title="Active"> <i class="fa fa-check"></i> </a>
						<?php } ?>
					</td>
				</tr>
				<?php $counter++; } } } ?> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<script type="text/javascript">
	

</script>