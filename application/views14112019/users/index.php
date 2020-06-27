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
            	<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addUser'; ?>">Add New</a></li> 
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
            <?php 
              if(!empty($userData)){
            ?>
			<div class="row">
				<div class="col-md-offset-10 col-md-2 col-xs-12 bottom-buffer">
					<form action="<?php echo base_url('users');?>" id="statusChnage" method="GET">
						<?php 
							$allStatus		= array(
								'all' 	=> 'All',
								'10' 	=> 'Active',
								'0' 	=> 'Inactive',
							);
							if($status === NULL){
								$status  = '10';
							}
							echo form_dropdown('searchByStatus', $allStatus,set_value('searchByStatus', $status), 'class="form-control pull-right" id="searchByStatus"');
						?>
					</form>
				</div>
			</div>
            <table id="userdatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <?php /*<th>Division</th>
                  <th>Zone</th>*/ ?>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Section</th>
                  <th>Shop</th>
                  <th>User Type</th>
                  <th>User Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					$counter 				= 1;
					foreach($userData as $singleUser){
						$name       	= $singleUser['user_f_name']." ".$singleUser['user_l_name'];
						$login_type 	= $singleUser['login_type'];
						$loginTypeName 	= $this->Users_model->getUserTypeName($login_type);   
						$phone      	= $singleUser['login_phone'];
						$email      	= $singleUser['login_email'];
						$division   	= $singleUser['user_division'];
						$divisionData 	= $this->Divisions_model->getDivisionBy($division);
						$zone       	= $singleUser['user_zone'];
						$zoneData 		= $this->Zones_model->getZoneBy($zone);
						$status 		= $singleUser['login_status'];
						$section_name 	= $singleUser['section_name'];
						$shop_name 		= $singleUser['shop_name'];
                ?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td><?php echo isset($name)?$name:''; ?></td>
					<?php /*<td><?php echo isset($divisionData->division_name)?$divisionData->division_name:''; ?></td>
					<td><?php echo isset($zoneData->zone_name)?$zoneData->zone_name:''; ?></td>*/ ?>
					<td><?php echo isset($email)?$email:''; ?></td>
					<td><?php echo isset($phone)?$phone:''; ?></td>
					<td><?php echo isset($section_name)?$section_name:''; ?></td>
					<td><?php echo isset($shop_name)?$shop_name:''; ?></td>
					<td><?php echo isset($loginTypeName)?$loginTypeName:'';?></td>
					<td>
						<?php 
							switch ($status) {
								case '10':
									echo "Active";
								break;
								case '0':
									echo "Inactive";
								break;
								case '90':
									echo "Deleted";
								break;
							}
						?>
					</td>
					<td class="action">
						<a href="<?php echo base_url('users/viewUser/'.$singleUser['user_id']); ?>" class="view"> View </a> 
						<a href="<?php echo base_url('users/editUser/'.$singleUser['user_id']); ?>" class="edit"> Edit </a> 
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('users/deleteUser/'.$singleUser['user_id']); ?>" onClick="return doconfirm();" class="inactive"> Inactivate </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('users/viewUser/'.$singleUser['user_id']); ?>" class="edit"> Activate </a>
						<?php } ?>
					</td>
				</tr>
                <?php $counter++; } ?>
              </tbody>
            </table>
          <?php } ?> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->