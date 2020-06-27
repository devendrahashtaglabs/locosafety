<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- page content -->
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
			<div class="row mt-5">
			<?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id'=> 'assign-hardware-form');
				echo form_open_multipart('hardwares', $attributes);
				//if(!empty($hardwareData)){
			?>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="col-md-3 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
							'class' => 'control-label',
							);
							echo form_label('Select Hardware', 'hardware_type', $attributes);
						?>
					</div>
					<div class="col-md-9 col-xs-12 bottom-buffer">
						<?php
							$allHardware   		= [];
							$allHardware['']    = 'Select Hardware';
							foreach($hardwareData as $singleHardware){
								$catId 				= $singleHardware->hardware_category;
								$catDetail	 		= $this->Categories_model->getCatById($catId);
								$hardware_category 	= $catDetail->category_name;
								$typeId 			= $singleHardware->hardware_type;
								$typeDetail	 		= $this->Types_model->getTypeById($typeId);
								$hardware_type 		= $typeDetail->hardware_type_name;
								$allHardware[$singleHardware->hardware_id] = $singleHardware->hardware_name .' '.$hardware_category.' '.$hardware_type;
							}    
							echo form_dropdown('hardware_category', $allHardware, set_value('hardware_category'), 'class="js-example-basic-single form-control" id="hardware_list"');
						?>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="col-md-3 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
							'class' => 'control-label',
							);
							echo form_label('OR','choose_hardware', $attributes);
						?>
					</div>
					<div class="col-md-9 col-xs-12">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Choose From List</button>
					</div>
				</div>
				<?php  //} 
				echo form_close(); ?>
			</div>
			<div class="row">
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">All Hardware </h4>
							</div>
							<div class="modal-body">
								<?php //echo "<pre>";print_r($hardwareData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ ); ?>
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
											$mapping			= '';
											/* if(empty($singleHardwareData->service_status)){
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
											} */
									?>
										<tr>
											<td><?php echo $counter; ?></td>
											<td><?php echo isset($hardware_name)?$hardware_name:''; ?></td>
											<td><?php echo isset($hardware_model)?$hardware_model:''; ?></td>
											<td><?php echo isset($hardware_company)?$hardware_company:''; ?></td>
											<td><?php echo isset($mapping)?$mapping:''; ?></td>
											<td><?php echo isset($hardware_category)?$hardware_category:''; ?></td>
											<td><?php echo isset($hardware_type)?$hardware_type:''; ?></td>
											<td class="division-action">
											<?php if($Status == '10'){ ?>
												<a href="<?php echo base_url('hardwares/assignShop/'.$singleHardwareData->hardware_id); ?>" class="edit" title="Assign Shop"> Assign Shop</a> 
											<?php }?>
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
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>