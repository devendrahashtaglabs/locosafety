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
							/* $allStatus		= array(
								'all' 	=> 'All',
								'10' 	=> 'Active',
								'20' 	=> 'In Maintenance',
								'90' 	=> 'Inactive',
							);
							if($status === NULL){
								$status  = '10';
							}
							echo form_dropdown('searchByStatus', $allStatus,set_value('searchByStatus', $status), 'class="form-control pull-right" id="searchByStatus"'); */
						?>
					</form>
				</div>
			</div>
            <table id="hardwaredatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Model</th>
                  <th>Made By</th>
                  <th>Mapping</th>
                  <th>Category</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				<?php 
				  if(!empty($hardwareData)){
					$counter = 1; 
					foreach($hardwareData as $singleHardwareData){
						$hardware_name 		= $singleHardwareData->hardware_name;
						$hardware_model 	= $singleHardwareData->hardware_model;
						$hardware_company 	= $singleHardwareData->hardware_company;
						$catId 				= $singleHardwareData->hardware_category;
						$catDetail	 		= $this->Categories_model->getCatById($catId);
						$hardware_category 	= $catDetail->category_name;
						$typeId 			= $singleHardwareData->hardware_type;
						$typeDetail	 		= $this->Types_model->getTypeById($typeId);
						$hardware_type 		= $typeDetail->hardware_type_name;
						$Status 			= $singleHardwareData->hardware_status;
						$mappingData		= $this->Hardwares_model->getHardwareMappingById($singleHardwareData->hardware_id);
						$mapping			= '';
						if(!empty($mappingData)){
							$mapping			= count($mappingData);
						}
						$hwstatus 				= "";
						$hardware_status 		= $singleHardwareData->hardware_status;
						if(!empty($hardware_status)){
							$hardware_status		= $this->Hardwares_model->getHardwareStatus($hardware_status);
							$hwstatus = $hardware_status->status;
						}
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($hardware_name)?$hardware_name:''; ?></td>
                    <td><?php echo isset($hardware_model)?$hardware_model:''; ?></td>
                    <td><?php echo isset($hardware_company)?$hardware_company:''; ?></td>
                    <td><?php echo isset($mapping)?$mapping:''; ?></td>
                    <td><?php echo isset($hardware_category)?$hardware_category:''; ?></td>
                    <td><?php echo isset($hardware_type)?$hardware_type:''; ?></td>
                    <td><?php echo isset($hwstatus)?$hwstatus:''; ?></td>
					<td class="division-action">
						<?php if($Status == '10'){ ?>
							<a href="<?php echo base_url('hardwares/viewHardware/'.$singleHardwareData->hardware_id); ?>" class="view"> View </a> 
							<a href="<?php echo base_url('hardwares/editHardware/'.$singleHardwareData->hardware_id); ?>" class="edit"> Edit </a> 
							<?php /*<a href="<?php echo base_url('hardwares/deleteHardware/'.$singleHardwareData->hardware_id); ?>" onClick="return doconfirm();" class="inactive"> Inactive </a> */?>
						<?php }else{ ?>
							<?php /*<a href="<?php echo base_url('hardwares/viewHardware/'.$singleHardwareData->hardware_id); ?>" class="edit"> Active </a>*/?>
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