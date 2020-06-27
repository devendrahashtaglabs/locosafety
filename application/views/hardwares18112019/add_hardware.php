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
                                echo form_label('Category', 'hardware_category', $attributes);
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
                                echo form_label('Type', 'hardware_type', $attributes);
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