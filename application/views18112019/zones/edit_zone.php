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
                <li><a class="add-new btn btn-primary" href="<?php echo base_url().'zones';?>">Add New</a>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
                $attributes = array('class' => 'form-horizontal form-label-left','id' => 'zone-form');
                echo form_open('zones/editZone/'.$editedId, $attributes); 
            ?>
            <div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
                <?php if(!empty($this->session->flashdata('updateZone'))){ ?>
                    <h5 class="text-success"><?php echo $this->session->flashdata('updateZone'); ?></h5>
                <?php } ?>
				<?php if(!empty($this->session->flashdata('activateZone'))){ ?>
                    <h5 class="text-success"><?php echo $this->session->flashdata('activateZone'); ?></h5>
                <?php } ?>
                <?php if(!empty($this->session->flashdata('errorZone'))){ ?>
                    <h5 class="text-danger"><?php echo $this->session->flashdata('errorZone'); ?></h5>
                <?php } ?>
              </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-12 bottom-buffer">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php                               
                                $data = array(
                                        'name'              => 'zone_code',
                                        'id'                => 'zone_code',
                                        'value'             => set_value('zone_code',$zoneDataById->zone_code),
                                        'class'             => 'form-control col-md-7 col-xs-12',
                                        'placeholder' => 'Zone Code *',
                                );
                                echo form_input($data);
                                echo form_error('zone_code', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 bottom-buffer">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php                               
                                $data = array(
                                        'name'              => 'zone_name',
                                        'id'                => 'zone_name',
                                        'value'             => set_value('zone_name',$zoneDataById->zone_name),
                                        'class'             => 'form-control col-md-7 col-xs-12',
                                        'placeholder' => 'Zone Name *',
                                );
                                echo form_input($data);
                                echo form_error('zone_name', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4 col-xs-12 bottom-buffer">
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
            <h2><?php echo 'Zones'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($zoneData)){
            ?>
            <table id="zonedatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Zone Code</th>
                  <th>Zone Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $counter = 1; 
                  foreach($zoneData as $singleZoneData){
					$code       = $singleZoneData->zone_code;
					$name       = $singleZoneData->zone_name;
					$status     = $singleZoneData->zone_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $code; ?></td>
                    <td><?php echo $name; ?></td>
                    <td>
						<?php 
							switch ($status) {
							  case '10':
								echo "Active";
								break;
							   case '90':
								echo "Not Active";
								break;
							}
						?>
					</td>
                    <td class="action">
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('zones/editZone/'.$singleZoneData->zone_id); ?>" class="edit"> Edit </a> 
							<a href="<?php echo base_url('zones/deleteZone/'.$singleZoneData->zone_id); ?>" onClick="return doconfirm();" class="inactive"> Inactive </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('zones/activateZone/'.$singleZoneData->zone_id); ?>" class="edit"> Active </a>
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