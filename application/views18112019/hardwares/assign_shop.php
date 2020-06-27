<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Add New Hardware</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <br />
            <?php 
                $attributes = array('class' => 'form-horizontal form-label-left','id'=> 'assign-hardware-form');
                echo form_open_multipart('hardwares/assignShop/'.$hardwareId, $attributes); 
            ?>
                <div class="row mt-5">
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
								);
								echo form_label('Serial Number *', 'hardware_serial_no', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
							   <?php                               
									$data = array(
											'name'              => 'hardware_serial_no',
											'id'                => 'hardware_serial_no',
											'value'             => set_value('hardware_serial_no'),
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
								echo form_label('Shop *', 'shop_id', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$allShop        = [];
									$allShop['']    = 'Select Shop';
									foreach($shopList as $singleShopList){
										$allShop[$singleShopList->shop_id] = $singleShopList->shop_name;
									}                    
									echo form_dropdown('shop_id', $allShop, set_value('shop_id'), 'class="form-control col-md-7 col-xs-12" id="hardware_shop_id"');
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
								echo form_label('Section *', 'section_id', $attributes);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$allSection         = [];
									$allSection['']    = 'Select Section';
									foreach($sectionList as $singleSectionList){
										$allSection[$singleSectionList->section_id] = $singleSectionList->section_name;
									}                    
									echo form_dropdown('section_id', $allSection, set_value('section_id'), 'class="form-control col-md-7 col-xs-12" id="hardware_section_id"');
								?>
							</div>
						</div>
					</div>	
					<div class="col-md-6 col-xs-12 bottom-buffer">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
							);
							echo form_label('Service Date <span class="required">*</span>', 'service_date', $attributes);
						?>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<?php                               
								$data = array(
										'type'          => 'text',
										'name'          => 'service_date',
										'id'            => 'service_date',
										'value'         => set_value('service_date'),
										'class'         => 'form-control col-md-7 col-xs-12',
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
                                echo form_submit('submit', 'Submit', "class='btn btn-success'");
                                echo form_reset(array('class'=>'btn btn-danger','id'=>'reset','value'=>"Reset"));
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