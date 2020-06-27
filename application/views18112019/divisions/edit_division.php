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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'divisions';?>">Add New</a> </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'division-form');
				echo form_open('divisions/editDivision/'.$editedId, $attributes); 
			?>
			<div class="row">
				<div class="col-md-12 col-xs-12 bottom-buffer">
					<?php if(!empty($this->session->flashdata('updateDivision'))){ ?>
						<h5 class="text-success"><?php echo $this->session->flashdata('updateDivision'); ?></h5>
					<?php } ?>
					<?php if(!empty($this->session->flashdata('deleteDivision'))){ ?>
						<h5 class="text-success"><?php echo $this->session->flashdata('deleteDivision'); ?></h5>
					<?php } ?>
					<?php if(!empty($this->session->flashdata('activateDivision'))){ ?>
						<h5 class="text-success"><?php echo $this->session->flashdata('activateDivision'); ?></h5>
					<?php } ?>
					<?php if(!empty($this->session->flashdata('errorDivision'))){ ?>
						<h5 class="text-danger"><?php echo $this->session->flashdata('errorDivision'); ?></h5>
					<?php } ?>
				</div>
            </div>
            <div class="row">
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								$zone_id = $divisionDataById->zone_id;
    							$allZone 		= [];
    							$allZone[''] 	= 'Select Zone *';
    							foreach($zoneData as $singleZoneData){
    								$allZone[$singleZoneData->zone_id] = $singleZoneData->zone_name;
    							}
								if(empty($zone_id)){
									$zone_id = "";
								}
    							echo form_dropdown('zone_id', $allZone, set_value('zone_id',$zone_id), 'class="form-control col-md-7 col-xs-12" id="zone_id" disabled="disabled"');
    						?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								$division_code = $divisionDataById->division_code;
								if(empty($division_code)){
									$division_code ="";
								}
								$data = array(
										'name'  		=> 'division_code',
										'id'    		=> 'division_code',
										'value' 		=> set_value('division_code',$division_code),
										'class' 		=> 'form-control col-md-7 col-xs-12',
										'placeholder'	=> 'Division Code *',
								);
								echo form_input($data);
								echo form_error('division_code', '<div class="error">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								$division_name = $divisionDataById->division_name;
								if(empty($division_name)){
									$division_name ="";
								}
								$data = array(
										'name'  			=> 'division_name',
										'id'    			=> 'division_name',
										'value' 			=> set_value('division_name',$division_name),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' 		=> 'Division Name *',
								);
								echo form_input($data);
								echo form_error('division_name', '<div class="error">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								echo form_submit('update', 'Update', "class='btn btn-success'");
							?>
						</div>
					</div>
				</div>
			</div>
            </form>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Divisions'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($divisionData)){
            ?>
            <table id="divisiondatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
					<th>S.No.</th>
					<th>Zone Code</th>
					<th>Zone Name</th>
					<th>Office / Division Code</th>
					<th>Office / Division Name</th>
					<th>Admin Email</th>
					<th>Status</th>
					<th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                	$counter = 1; 
                  foreach($divisionData as $singleDivisionData){
					$code   		= $singleDivisionData->division_code;
					$zoneName 		= "";
					$zoneCode 		= "";
					$zoneId 		= "";
					$divisionId 	= $singleDivisionData->division_id;
					if($singleDivisionData->zone_id){
						$zoneData 		= $this->Zones_model->getZoneBy($singleDivisionData->zone_id);
						$zoneName 		= $zoneData->zone_name;
						$zoneCode 		= $zoneData->zone_code;
						$zoneId 		= $zoneData->zone_id;
					}
					$code   		= $singleDivisionData->division_code;
					$name   		= $singleDivisionData->division_name;
					$status   		= $singleDivisionData->division_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($zoneName)?$zoneName:''; ?></td>
                    <td><?php echo isset($zoneName)?$zoneName:''; ?></td>
                    <td><?php echo isset($code)?$code:''; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
                    <td><?php 
                        switch ($status) {
                          case '10':
                            echo "Active";
                            break;
                           case '90':
                            echo "Not Active";
                            break;
                        }
                    ?></td>
                    <td class="division-action">
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('divisions/editDivision/'.$singleDivisionData->division_id); ?>" class="edit"> Edit </a> 
							<a href="<?php echo base_url('divisions/deleteDivision/'.$singleDivisionData->division_id); ?>" onClick="return doconfirm();" class="inactive"> Inactive </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('divisions/activateDivision/'.$singleDivisionData->division_id); ?>" class="edit"> Active </a>
						<?php } ?>
						<a href="<?php echo base_url('users/addAdmin?zoneId='.$zoneId.'&divisionId='.$divisionId); ?>" class="add-btn"> Add User </a>
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