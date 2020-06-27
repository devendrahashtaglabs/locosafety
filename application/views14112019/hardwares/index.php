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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'hardwares/addHardware'; ?>">Add New</a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
			<div class="row">
				<div class="col-md-offset-10 col-md-2 col-xs-12 bottom-buffer">
					<form action="<?php echo base_url('hardwares');?>" id="statusChnage" method="GET">
						<?php 
							$allStatus		= array(
								'all' 	=> 'All',
								'10' 	=> 'Active',
								'20' 	=> 'In Maintenance',
								'90' 	=> 'Inactive',
							);
							if($status === NULL){
								$status  = '10';
							}
							echo form_dropdown('searchByStatus', $allStatus,set_value('searchByStatus', $status), 'class="form-control pull-right" id="searchByStatus"');
						?>
					</form>
				</div>
			</div>
            <table id="hardwaredatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Shop</th>
                  <th>Section</th>
                  <th>Name</th>
                  <th>Hardware Status</th>
                  <th>Service Status</th>
                  <th>Next Service Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				<?php 
				  if(!empty($hardwareData)){
					$counter = 1; 
					foreach($hardwareData as $singleHardwareData){
						$shop_id 			= $singleHardwareData->shop_id;
						$shopData			= $this->Shops_model->getShopBy($shop_id);
						$section_id 		= $singleHardwareData->section_id;
						$sectionData		= $this->Sections_model->getSectionBy($section_id);
						$hardware_name 		= $singleHardwareData->hardware_name;
						$hardware_model 	= $singleHardwareData->hardware_model;
						$Status 			= $singleHardwareData->hardware_status;
						$service_status		= '';
						$nextDate		= '';
						if(empty($singleHardwareData->service_status)){
							$hardwareServiceData = $this->Hardwares_model->getHardwareBy($singleHardwareData->id);
							if(!empty($hardwareServiceData)){
								$serviceData 		= $hardwareServiceData[0];
								$service_status 	= $serviceData->service_status;
								$service_date_next 	= date_create($serviceData->service_date_next);
								$nextDate 			= 	date_format($service_date_next,"d M Y");
							}
						}else{
							$service_status 	= $singleHardwareData->service_status;
							$service_date_next 	= date_create($singleHardwareData->service_date_next);
							$nextDate 			= 	date_format($service_date_next,"d M Y");
						}
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($shopData->shop_name)?$shopData->shop_name:''; ?></td>
                    <td><?php echo isset($sectionData->section_name)?$sectionData->section_name:''; ?></td> 
                    <td><?php echo $hardware_name; ?></td>
                    <td><?php 
                        switch ($Status) {
							case '10':
								echo "Active";
							break;
							case '90':
								echo "Inactive";
							break;
                        }
                    ?></td>
					<td>
						<?php 
							if(!empty($service_status)){
								switch ($service_status) {
									case '10':
										echo "Active";
									break;
									case '20':
										echo "In Maintenance";
									break;
									case '30':
										echo "Condemn";
									break;
									case '90':
										echo "Inactive";
									break;
								}
							}
						?>
					</td>
                    <td><?php echo $nextDate; ?></td>
					<td class="action">
						<a href="<?php echo base_url('hardwares/viewHardware/'.$singleHardwareData->id); ?>" class="view"> View </a> 
						<a href="<?php echo base_url('hardwares/editHardware/'.$singleHardwareData->id); ?>" class="edit"> Edit </a> 
						<?php if($Status == '10'){ ?>
							<a href="<?php echo base_url('hardwares/deleteHardware/'.$singleHardwareData->id); ?>" onClick="return doconfirm();" class="inactive"> Inactivate </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('hardwares/viewHardware/'.$singleHardwareData->id); ?>" class="edit"> Activate </a>
						<?php } ?>
					</td>
                  </tr>
                <?php 
					$counter++; } 
					} ?> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->