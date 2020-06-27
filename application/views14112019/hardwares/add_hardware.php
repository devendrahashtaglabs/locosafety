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
                    <div class="col-md-12 col-xs-12 bottom-buffer">
                        <h3>Hardware Details</h3>
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
                                    //echo "<pre>";print_r($shopList);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
                                    $allShop         = [];
                                    $allShop['0']    = 'Select Shop';
                                    foreach($shopList as $singleShopList){
                                        $allShop[$singleShopList->shop_id] = $singleShopList->shop_name;
                                    }                    
                                    echo form_dropdown('shop_id', $allShop, set_value('shop_id'), 'class="form-control col-md-7 col-xs-12" id="shop_id"');
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
                                    $allSection         = [];
                                    $allSection['0']    = 'Select Section';
                                    foreach($sectionList as $singleSectionList){
                                        $allSection[$singleSectionList->section_id] = $singleSectionList->section_name;
                                    }                    
                                    echo form_dropdown('section_id', $allSection, set_value('section_id'), 'class="form-control col-md-7 col-xs-12" id="section_id"');
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
                                    //echo "<pre>";print_r($catList);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
                                    $allCat         = [];
                                    $allCat['0']    = 'Select Category';
                                    foreach($catList as $singleCatList){
                                        $allCat[$singleCatList->id] = $singleCatList->category_name;
                                    }                    
                                    echo form_dropdown('hardware_category', $allCat, set_value('hardware_category'), 'class="form-control col-md-7 col-xs-12" id="hardware_category"');
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
                                    $allType['0']    = 'Select Type';
                                    foreach($typeList as $singleTypeList){
                                        $allType[$singleTypeList->type_id] = $singleTypeList->type_name;
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
                                echo form_label('Hardware Number <span class="required">*</span>', 'hardware_number', $attributes);
                            ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                               <?php                               
                                    $data = array(
                                            'name'              => 'hardware_number',
                                            'id'                => 'hardware_number',
                                            'value'             => set_value('hardware_number'),
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
                                    $data = array(
                                            'name'          => 'hardware_dimensions',
                                            'id'            => 'hardware_dimensions',
                                            'value'         => set_value('hardware_dimensions'),
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
                                    $data = array(
                                                'name'              => 'hardware_description',
                                                'id'                => 'hardware_description',
                                                'value'             => set_value('hardware_description'),
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
                                $data = array(
                                        'type'          => 'text',
                                        'name'          => 'hardware_mfg_date',
                                        'id'            => 'hardware_mfg_date',
                                        'value'         => set_value('hardware_mfg_date'),
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
                                $data = array(
                                        'type'          => 'text',
                                        'name'          => 'hardware_exp_date',
                                        'id'            => 'hardware_exp_date',
                                        'value'         => set_value('hardware_exp_date'),
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
                                        'value'             => set_value('hardware_image'),
                                        'class'             => 'form-control col-md-7 col-xs-12',
                                );
                                echo form_upload($data);
                            ?>
                            <img id="hardware_pic" src="#" alt="" class="img-responsive"/>
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
                            echo form_label('Frequency Count <span class="required">*</span>', 'service_frequency_count', $attributes);
                        ?>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php                               
                                $data = array(
                                        'name'          => 'service_frequency_count',
                                        'id'            => 'service_frequency_count',
                                        'value'         => set_value('service_frequency_count'),
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
                            echo form_label('Frequency Cycle <span class="required">*</span>', 'service_frequency_cycle', $attributes);
                        ?>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php
                                $allcycle = array(
                                    '' => 'Select Cycle',
                                    'D' => 'Daily',
                                    'W' => 'Weekly',
                                    'M' => 'Monthly',
                                    'Y' => 'Yearly',
                                );
                                echo form_dropdown('service_frequency_cycle', $allcycle, set_value('service_frequency_cycle'), 'class="form-control col-md-7 col-xs-12" id="service_frequency_cycle"');
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
                            echo form_label('Service Date <span class="required">*</span>', 'service_date', $attributes);
                        ?>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php                               
                                $data = array(
                                        'type'          => 'text',
                                        'name'          => 'service_date',
                                        'id'            => 'service_date',
                                        'value'         => set_value('service_date'),
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