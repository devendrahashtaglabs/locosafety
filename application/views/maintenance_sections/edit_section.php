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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'maintenance_sections';?>" title="Add New">Add New</a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'maintenance-section-form');
				echo form_open('maintenance_sections/editMSection/'.$editedId, $attributes); 
			?>
			<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('sectionSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('sectionSuccess'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('sectionError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('sectionError'); ?></h5>
              	<?php } ?>
				<?php if(!empty($this->session->flashdata('success'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('error'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
              	<?php } ?>
              </div>
            </div>
            <div class="row">
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php
								$maintenance_shop_name = ''; 
								if(!empty($msectionDataById)){
									$maintenance_shop_name = $msectionDataById->maintenance_shop_id;
								}
								$allShop         = [];
								$allShop['']    = 'Select Maintenance Shop';
								foreach($mShopData as $singleMShopList){
									$allShop[$singleMShopList->maintenance_shop_id] = $singleMShopList->maintenance_shop_name;
								}   								
								echo form_dropdown('maintenance_shop_id', $allShop, set_value('maintenance_shop_id',$maintenance_shop_name), 'class="form-control col-md-7 col-xs-12" id="maintenance_shop_id"');
							?>
						</div>
					</div>
				</div>
				<?php /*
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php
								$default_hardware_cat = ''; 
								if(!empty($msectionDataById)){
									$default_hardware_cat = $msectionDataById->default_hardware_cat;
								}
								$allCat         = [];
								$allCat['']    	= 'Select Hardware Category';
								if(!empty($hCatData)){
									foreach($hCatData as $singleCatList){
										$allCat[$singleCatList->id] = $singleCatList->category_name;
									}
								}
								echo form_dropdown('hardware_cat', $allCat, set_value('hardware_cat',$default_hardware_cat), 'class="form-control col-md-7 col-xs-12" id="hardware_cat"');
							?>
						</div>
					</div>
				</div> */ ?>
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'maintenance_section_code',
										'id'    			=> 'maintenance_section_code',
										'value' 			=> set_value('maintenance_section_code',$msectionDataById->maintenance_section_code),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' 		=> 'Maintenance Section Code *',
								);
								echo form_input($data);
								echo form_error('maintenance_section_code', '<div class="error">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'maintenance_section_name',
										'id'    			=> 'maintenance_section_name',
										'value' 			=> set_value('section_name',$msectionDataById->maintenance_section_name),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' 		=> 'Maintenance Section Name *',
								);
								echo form_input($data);
								echo form_error('maintenance_section_name', '<div class="error">', '</div>');
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
                                                    <a href="<?php echo base_url().'maintenance_sections/editMSection/'.$editedId.'/'; ?>" class="btn btn-danger"  >Reset</a>
						</div>
					</div>
				</div>
			</div>
           <?php echo form_close(); ?>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Sections'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($msectionData)){
            ?>
            <table id="sectiondatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
					<th>S.No.</th>
					<th>Shop</th>
					<?php /*<th>Category</th> */?>
					<th>Section Code</th>
					<th>Section Name</th>
					<th>Status</th>
					<th>Action</th>
                </tr>
              </thead>
              <tbody>
				<?php 
				  if(!empty($msectionData)){ 
					$counter = 1;
					foreach($msectionData as $singleMSectionData){
						$shop_id   		= $singleMSectionData->maintenance_shop_id;
						$hardware_cat	= $singleMSectionData->default_hardware_cat;
						$shopDetails 	= $this->Maintenance_shops_model->getMShopBy($shop_id);
						$catDetails 	= $this->Categories_model->getCatById($hardware_cat);
						$section_code   = $singleMSectionData->maintenance_section_code;
						$name   		= $singleMSectionData->maintenance_section_name;
						$status   		= $singleMSectionData->maintenance_section_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($shopDetails->maintenance_shop_name)?$shopDetails->maintenance_shop_name:''; ?></td>
                   <?php /* <td><?php echo isset($catDetails->category_name)?$catDetails->category_name:''; ?></td> */?>
                    <td><?php echo isset($section_code)?$section_code:''; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
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
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('maintenance_sections/editMSection/'.$singleMSectionData->maintenance_section_id); ?>" class="edit" title="Edit"> Edit </a> 
							<a href="<?php echo base_url('maintenance_sections/deleteMSection/'.$singleMSectionData->maintenance_section_id); ?>" onClick="return doconfirmMsg('Are you sure to inactive this item?');" class="inactive" title="Inactive"> Inactive </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('maintenance_sections/activateMSection/'.$singleMSectionData->maintenance_section_id); ?>" class="edit" class="Active" onClick="return doconfirmMsg('Are you sure to active this item?');"> Active </a>
						<?php } ?>
					</td>
                  </tr>
                <?php $counter++; } } ?>
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