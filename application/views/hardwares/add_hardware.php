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
		  
		  <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('hardwareSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('hardwareSuccess'); ?></h5>
              	<?php }if(!empty($this->session->flashdata('hardwareError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('hardwareError'); ?></h5>
              	<?php } ?>
              </div>
            <br />
            <?php 
                $attributes = array('class' => 'form-horizontal form-label-left','id'=> 'hardware-form');
                echo form_open_multipart('hardwares/addHardware', $attributes); 
            ?>
                <div class="row">                    
                    <div class="col-md-6 col-xs-12 bottom-buffer">
                        <div class="form-group">
                            <?php 
                                $attributes = array(
                                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
                                );
                                echo form_label('Category*', 'hardware_category', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                    $allCat        = [];
                                    $allCat['']    = 'Select Category';
                                    foreach($catList as $singleCatList){
                                        $allCat[$singleCatList->id] = $singleCatList->category_name;
                                    }                    
                                    echo form_dropdown('hardware_category', $allCat, set_value('hardware_category'), 'class="form-control col-md-7 col-xs-12" id="add_hardware_category"'); 
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
                                echo form_label('Type*', 'hardware_type', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                    $allType         = [];
                                    $allType['']    = 'Select Type';
                                    foreach($typeList as $singleTypeList){
                                        $allType[$singleTypeList->hardware_type_id] = $singleTypeList->hardware_type_name;
                                    }                    
                                    echo form_dropdown('hardware_type', $allType, set_value('hardware_type'), 'class="form-control col-md-7 col-xs-12" id="hardware_type"');
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
                                echo form_label('Hardware Code<span class="required">*</span>', 'hardware_code', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                               <?php                               
                                    $data = array(
                                            'name'              => 'hardware_code',
                                            'id'                => 'hardware_code',
                                            'value'             => set_value('hardware_code'),
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
                                echo form_label('Hardware Name <span class="required">*</span>', 'hardware_name', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php                               
                                    $data = array(
                                            'name'              => 'hardware_name',
                                            'id'                => 'hardware_name',
                                            'value'             => set_value('hardware_name'),
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
                                echo form_label('Hardware Model', 'hardware_model', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php                               
                                    $data = array(
                                            'name'          => 'hardware_model',
                                            'id'            => 'hardware_model',
                                            'value'         => set_value('hardware_model'),
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
                                echo form_label('Hardware Company', 'hardware_company', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php                               
                                    $data = array(
                                            'name'              => 'hardware_company',
                                            'id'                => 'hardware_company',
                                            'value'             => set_value('hardware_company'),
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
                                echo form_label('Hardware Specification', 'hardware_specification', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php                               
									$data = array(
												'name'  	=> 'hardware_specification',
												'id'    	=> 'hardware_specification',
												'value' 	=> set_value('hardware_specification'),
												'class' 	=> 'form-control col-md-7 col-xs-12',
												'rows' 		=> '4',
												'cols' 		=> '10',
											);
									echo form_textarea($data);
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
                                echo form_label('Maintenance Shop', 'maintenance_shop', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                    $allMShop        = [];
                                    $allMShop['']    = 'Select Maintenance Shop';
									if(!empty($mshopList)){
										foreach($mshopList as $singleMshopList){
											$allMShop[$singleMshopList->maintenance_shop_id] = $singleMshopList->maintenance_shop_name;
										}   
									}
                                    echo form_dropdown('maintenance_shop', $allMShop, set_value('maintenance_shop'), 'class="form-control col-md-7 col-xs-12" id="maintenance_shop"'); 
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
                                echo form_label('Maintenance Section', 'maintenance_section', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                    $allmSection	= [];
                                    $allmSection['']    = 'Select Maintenance Section';
									/* if(!empty($msectionList)){
										foreach($msectionList as $singlemsectionList){
											$allmSection[$singlemsectionList->maintenance_section_id] = $singlemsectionList->maintenance_section_name;
										}   
									} */
                                    echo form_dropdown('maintenance_section', $allmSection, set_value('maintenance_section'), 'class="form-control col-md-7 col-xs-12" id="maintenance_section"');
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
                            echo form_label('Frequency Count <span class="required">*</span>', 'schedule_frequency_count', $attributes);
                        ?>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php                               
                                $data = array(
                                        'name'          => 'schedule_frequency_count',
                                        'id'            => 'schedule_frequency_count',
                                        'value'         => set_value('schedule_frequency_count'),
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
                            echo form_label('Frequency Cycle <span class="required">*</span>', 'schedule_frequency_cycle', $attributes);
                        ?>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php
                                $allcycle = array(
                                    '' 	=> 'Select Cycle',
                                    'D' => 'Daily',
                                    'W' => 'Weekly',
                                    'M' => 'Monthly',
                                    'Y' => 'Yearly',
                                );
                                echo form_dropdown('schedule_frequency_cycle', $allcycle, set_value('schedule_frequency_cycle'), 'class="form-control col-md-7 col-xs-12" id="schedule_frequency_cycle"');
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
                                        'value'             => set_value('hardware_image'),
                                        'class'             => 'form-control col-md-7 col-xs-12',
                                );
                                echo form_upload($data);
                            ?>
                            <img id="hardware_pic" src="#" alt="" class="img-responsive"/>
							<?php if(isset($img_error)){ ?>
								<label id="user_l_name-error" class="error" for=""><?php echo $img_error; ?></label>
							<?php } ?>
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
<script type="text/javascript">  
    $(document).ready(function() {
		$('#maintenance_shop').change(function(){
			var option 				= $(this).find('option:selected');
			var maintenance_shop 	= option.val();			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>hardwares/getmSectionByMshop/',
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				data: {'shop_id': maintenance_shop}, 
				success: function (data) {
					$("#maintenance_section").html(data);           
				},
				error: function (data) {
					console.log(data);
				}
			});
		});
	});
</script>