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
            	<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addAdmin'; ?>">Add New</a></li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
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
            <table id="userdatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Division</th>
                  <th>Zone</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>User Type</th>
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
                ?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td><?php echo isset($name)?$name:''; ?></td>
					<td><?php echo isset($divisionData->division_name)?$divisionData->division_name:''; ?></td>
					<td><?php echo isset($zoneData->zone_name)?$zoneData->zone_name:''; ?></td>
					<td><?php echo isset($email)?$email:''; ?></td>
					<td><?php echo isset($phone)?$phone:''; ?></td>
					<td><?php echo isset($loginTypeName)?$loginTypeName:'';?></td>
					<td><a href="<?php echo base_url('users/viewUser/'.$singleUser['user_id']); ?>"><i class="fa fa-eye"></i></a>  <a href="<?php echo base_url('users/editUser/'.$singleUser['user_id']); ?>"><i class="fa fa-pencil-square-o"></i></a>   <a href="<?php echo base_url('users/deleteUser/'.$singleUser['user_id']); ?>" onClick="return doconfirm();"><i class="fa fa-trash-o"></i></a></td>
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