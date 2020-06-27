<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Hardware</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="add-new btn btn-primary" href="<?php echo base_url().'hardwares/viewHardware/'.$editedId;?>">View This Hardware</a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
                $attributes = array('class' => 'form-horizontal form-label-left','id'=> 'hardware-form');
                echo form_open_multipart('hardwares/editHardware/'.$editedId, $attributes); 
            ?>
            <div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('updatedHardware'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('updatedHardware'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('deleteType'))){ ?>
              		<h5 class="text-success"><?php echo $this->session->flashdata('deleteType'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('errorHardware'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('errorHardware'); ?></h5>
              	<?php } ?>
              </div>
            </div>
			<div class="row">
				<div class="col-md-6 col-xs-12 bottom-buffer">
				  <div class="form-group">
					  <?php 
						  $attributes = array(
							  'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
						  );
						  echo form_label('Shop', 'shop_id', $attributes);
					  ?>
					  <div class="col-md-9 col-sm-9 col-xs-12">
						<?php
							$shop_id = $hardwareDataById->shop_id;
							if(empty($shop_id)){
								$shop_id ="";
							}
							$allShop         	= [];
							$allShop['']    	= 'Select Shop';
							foreach($shopList as $singleShopList){
								$allShop[$singleShopList->shop_id] = $singleShopList->shop_name;
							}                    
							echo form_dropdown('shop_id', $allShop, set_value('shop_id',$shop_id), 'class="form-control col-md-7 col-xs-12" id="shop_id"');
						?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Section', 'section_id', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$section_id = $hardwareDataById->section_id;
								if(empty($section_id)){
									$section_id ="";
								}
								$allSection         	= [];
								$allSection['0']    	= 'Select Section';
								  foreach($sectionList as $singleSectionList){
									  $allSection[$singleSectionList->section_id] = $singleSectionList->section_name;
								  }                    
								  echo form_dropdown('section_id', $allSection, set_value('section_id',$section_id), 'class="form-control col-md-7 col-xs-12" id="section_id"');
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Category', 'hardware_category', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
						<?php
							$catId 			= $hardwareDataById->hardware_category;
							$catDetail		= '';
							if(!empty($catId)){
								$catDetail 		= $this->Categories_model->getCategoryBy($catId);
							}
							$allCat         = [];
							$allCat['']    = 'Select Category';
							foreach($catList as $singleCatList){
								$allCat[$singleCatList->id] = $singleCatList->category_name;
							}
							if(!empty($catDetail->id)){
								$cat_id = $catDetail->id;
							}
							if(empty($cat_id)){
								$cat_id ="";
							}
							echo form_dropdown('hardware_category', $allCat, set_value('hardware_category',$cat_id), 'class="form-control col-md-7 col-xs-12" id="hardware_category"');
						?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					 <div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Type', 'hardware_type', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$typeId 	= $hardwareDataById->hardware_type;
								$typeDetail = '';
								if(!empty($typeId)){
									$typeDetail = $this->Types_model->getTypeBy($typeId);
								}
								$allType         = [];
								$allType['']    = 'Select Type';
								foreach($typeList as $singleTypeList){
									$allType[$singleTypeList->type_id] = $singleTypeList->type_name;
								} 
								if(!empty($typeDetail->id)){
									$type_id = $typeDetail->id;
								}
								if(empty($type_id)){
									$type_id = "";
								}
								echo form_dropdown('hardware_type', $allType, set_value('hardware_type',$type_id), 'class="form-control col-md-7 col-xs-12" id="hardware_type"');
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Hardware Number <span class="required">*</span>', 'hardware_number', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
						   <?php 
								$hardware_number = $hardwareDataById->hardware_number;
								if(empty($hardware_number)){
									$hardware_number = "";
								}
								$data = array(
										'name'              => 'hardware_number',
										'id'                => 'hardware_number',
										'value'             => set_value('hardware_number',$hardware_number),
										'class'             => 'form-control col-md-7 col-xs-12',
								);
								echo form_input($data);
								echo form_error('hardware_number', '<div class="error">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Hardware Name<span class="required">*</span>', 'hardware_name', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$hardware_name = $hardwareDataById->hardware_name;
								if(empty($hardware_name)){
									$hardware_name = "";
								}
								$data = array(
										'name'              => 'hardware_name',
										'id'                => 'hardware_name',
										'value'             => set_value('hardware_name',$hardware_name),
										'class'             => 'form-control col-md-7 col-xs-12',
								);
								echo form_input($data);
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Hardware Company', 'hardware_company', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$hardware_company = $hardwareDataById->hardware_company;
								if(empty($hardware_company)){
									$hardware_company = "";
								}else{
									$hardware_company = html_entity_decode($hardware_company); 
								}									
								$data = array(
										'name'              => 'hardware_company',
										'id'                => 'hardware_company',
										'value'             => set_value('hardware_company',$hardware_company),
										'class'             => 'form-control col-md-7 col-xs-12',
								);
								echo form_input($data);
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Hardware Model', 'hardware_model', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php 
								$hardware_model = $hardwareDataById->hardware_model;
								if(empty($hardware_model)){
									$hardware_model = "";
								}
								$data = array(
										'name'          => 'hardware_model',
										'id'            => 'hardware_model',
										'value'         => set_value('hardware_model',$hardware_model),
										'class'         => 'form-control col-md-7 col-xs-12',
								);
								echo form_input($data);
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Dimensions', 'hardware_dimensions', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							 <?php
								$hardware_dimensions = $hardwareDataById->hardware_dimensions;
								if(empty($hardware_dimensions)){
									$hardware_dimensions = "";
								}
								$data = array(
										'name'          => 'hardware_dimensions',
										'id'            => 'hardware_dimensions',
										'value'         => set_value('hardware_dimensions',$hardware_dimensions),
										'class'         => 'form-control col-md-7 col-xs-12',
								);
								echo form_input($data);
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<div class="form-group">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Description', 'hardware_description', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
						   <?php 
								$hardware_description = $hardwareDataById->hardware_description;
								if(empty($hardware_description)){
									$hardware_description = "";
								}
								$data = array(
											'name'              => 'hardware_description',
											'id'                => 'hardware_description',
											'value'             => set_value('hardware_description',$hardware_description),
											'class'             => 'form-control col-md-7 col-xs-12',
											'rows'              => '4',
											'cols'              => '10',
										);
								echo form_textarea($data);
							?>
						</div>
					</div>
				</div>
			</div>
			 <div class="row">
					<div class="col-md-6 col-xs-12 bottom-buffer">
					<?php 
						$attributes = array(
							'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
						);
						echo form_label('MFG Date', 'hardware_mfg_date', $attributes);
					?>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<?php 
						$mfg_date 	= 	date_create($hardwareDataById->hardware_mfg_date);
						$mfgDate 	= 	date_format($mfg_date,"d M Y");                         
						$data 		= 	array(
											'type'          => 'text',
											'name'          => 'hardware_mfg_date',
											'id'            => 'hardware_mfg_date',
											'value'         => set_value('hardware_mfg_date',$mfgDate),
											'class'         => 'form-control col-md-7 col-xs-12 datepicker',
										);
						echo form_input($data);
						?>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 bottom-buffer">
					<?php 
						$attributes = array(
							'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
						);
						echo form_label('EXP Date', 'hardware_exp_date', $attributes);
					?>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<?php 
							$exp_date 	= date_create($hardwareDataById->hardware_exp_date);
							$expDate 	= date_format($exp_date,"d M Y");
							$data = array(
									'type'          => 'text',
									'name'          => 'hardware_exp_date',
									'id'            => 'hardware_exp_date',
									'value'         => set_value('hardware_exp_date',$expDate),
									'class'         => 'form-control col-md-7 col-xs-12 datepicker',
							);
							echo form_input($data);
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-xs-12 bottom-buffer">
				<?php 
					$attributes = array(
						'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
					);
					echo form_label('Hardware Image', 'hardware_image', $attributes);
				?>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<?php                               
						$data = array(
								'name'              => 'hardware_image',
								'id'                => 'hardware_image',
								'value'             => set_value('hardware_image',$hardwareDataById->hardware_image),
								'class'             => 'form-control col-md-7 col-xs-12',
						);
						echo form_upload($data);
					?>
					<img id="hardware_pic" src="<?php echo base_url().'uploads/hardware/'.$hardwareDataById->hardware_image;?>" alt="" class="img-responsive"/>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-12 col-xs-12 bottom-buffer">
				<h3>Maintenance Cycle Details</h3>
			</div>
		  </div>
		  <div class="row">
			  <div class="col-md-6 col-xs-12 bottom-buffer">
				  <?php 
					  $attributes = array(
						  'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
					  );
					  echo form_label('Frequency Count', 'service_frequency_count', $attributes);
				  ?>
				  <div class="col-md-9 col-sm-9 col-xs-12">
					<?php
						$service_frequency_count = $hardwareDataById->service_frequency_count;
						if(empty($service_frequency_count)){
							$service_frequency_count = "";
						}
						$data = array(
							  'name'          => 'service_frequency_count',
							  'id'            => 'service_frequency_count',
							  'value'         => set_value('service_frequency_count',$service_frequency_count),
							  'class'         => 'form-control col-md-7 col-xs-12',
						);
						echo form_input($data);
					  ?>
				  </div>
			  </div>
			  <div class="col-md-6 col-xs-12 bottom-buffer">
				  <?php 
					  $attributes = array(
						  'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
					  );
					  echo form_label('Frequency Cycle', 'service_frequency_cycle', $attributes);
				  ?>
				  <div class="col-md-9 col-sm-9 col-xs-12">
					<?php
						$service_frequency_cycle = $hardwareDataById->service_frequency_cycle;
						if(empty($service_frequency_cycle)){
							$service_frequency_cycle = "";
						}
						$allcycle = array(
							'' => 'Select Cycle',
							'D' => 'Daily',
							'W' => 'Weekly',
							'M' => 'Monthly',
							'Y' => 'Yearly',
						);
						echo form_dropdown('service_frequency_cycle', $allcycle, set_value('service_frequency_cycle',$service_frequency_cycle), 'class="form-control col-md-7 col-xs-12" id="service_frequency_cycle"');
					?>
				  </div>
			  </div>
		  </div>
			<div class="row">
				<div class="col-md-6 col-xs-12 bottom-buffer">
				  <?php 
					  $attributes = array(
						  'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
					  );
					  echo form_label('Service Date', 'service_date', $attributes);
				  ?>
				  <div class="col-md-9 col-sm-9 col-xs-12">
					<?php  
						$service_date   = date_create($hardwareDataById->service_date);
						$service_date   = date_format($service_date,"d M Y");
						$data = array(
						'type'          => 'text',
						'name'          => 'service_date',
						'id'            => 'service_date',
						'value'         => set_value('service_date',$service_date),
						'class'         => 'form-control col-md-7 col-xs-12 datepicker',
						);
						echo form_input($data);
					?>
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="form-group text-center my-5">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php 
							echo form_submit('update', 'Update', "class='btn btn-success'");
							echo form_reset(array('class'=>'btn btn-danger','id'=>'clear','value'=>"Clear"));
						?>
						<input type="button" class="btn btn-primary" value="Cancel" onclick="location.href='<?php echo base_url();?>hardwares'">
					</div>
				</div>
			</div>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->