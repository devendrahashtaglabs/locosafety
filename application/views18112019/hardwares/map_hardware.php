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
				if(!empty($hardwareData)){
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
							echo form_dropdown('hardware_category', $allHardware, set_value('hardware_category'), 'class="form-control" id="hardware_category"');
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
						<a href="javascript:void(0)" id="choose_hardware" class="view choose_hardware form-control"> Choose from list </a>
					</div>
				</div>
				<?php } echo form_close(); ?>
			</div>
			<div class="row">
				<div id="hardwarelist">
				<p class="validateTips">All form fields are required.</p> 
				<form>
					<fieldset>
					  <label for="name">Name</label>
					  <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
					  <label for="email">Email</label>
					  <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
					  <label for="password">Password</label>
					  <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">

					  <!-- Allow form submission with keyboard without duplicating the dialog button -->
					  <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
					</fieldset>
				</form>
				</div>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->