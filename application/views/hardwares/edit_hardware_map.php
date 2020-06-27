<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $title; ?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
			<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('hardwareSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('hardwareSuccess'); ?></h5>
              	<?php }if(!empty($this->session->flashdata('hardwareError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('hardwareError'); ?></h5>
              	<?php } ?>
              </div>
            </div>
			
            <?php 
                $attributes = array('class' => 'form-horizontal form-label-left','id'=> 'assign-hardware-form');
                echo form_open_multipart('hardwares/editHardwareMap/'.$mapId, $attributes); 
            ?>
                <div class="row">
					<div class="col-md-6 col-xs-12">
						<?php 
							$hardware_category = $hBasicDetails->hardware_category;
							if(!empty($hardware_category)){
								$catList 	= $this->Categories_model->getCatById($hardware_category);
								$hwCatName = $catList->category_name;
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Hardware Category :', 'hardware_category', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
								   <?php
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($hwCatName, 'hardware_category',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-6 col-xs-12">
						<?php 
							$hardware_type = $hBasicDetails->hardware_type;
							if(!empty($hardware_type)){
								$typeList 	= $this->Types_model->getTypeById($hardware_type);
								$hwTypeName = $typeList->hardware_type_name;
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Hardware Type :', 'hardware_type', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<?php 
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($hwTypeName, 'hardware_type',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<?php 
							$hardware_code = $hBasicDetails->hardware_code;
							if(!empty($hardware_code)){
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Hardware Code :', 'hardware_code', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
								    <?php 
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($hardware_code, 'hardware_code',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-6 col-xs-12">
						<?php 
							$hardware_name = $hBasicDetails->hardware_name;
							if(!empty($hardware_name)){
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Hardware Name :', 'hardware_name', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<?php 
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($hardware_name, 'hardware_name',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<?php 
							$hardware_model = $hBasicDetails->hardware_model;
							if(!empty($hardware_model)){
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Hardware Model :', 'hardware_model', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
								    <?php 
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($hardware_model, 'hardware_model',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-6 col-xs-12">
						<?php 
							$hardware_company = $hBasicDetails->hardware_company;
							if(!empty($hardware_company)){
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Hardware Company :', 'hardware_company', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<?php 
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($hardware_company, 'hardware_company',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<?php 
							$schedule_frequency_count = $hBasicDetails->schedule_frequency_count;
							if(!empty($schedule_frequency_count)){
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Frequency Count :', 'schedule_frequency_count', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
								    <?php 
										$attributes = array(
											'class' => 'control-label',
										);
										echo form_label($schedule_frequency_count, 'schedule_frequency_count',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-6 col-xs-12">
						<?php 
							$schedule_frequency_cycle = $hBasicDetails->schedule_frequency_cycle;
							if(!empty($schedule_frequency_cycle)){
						?>
							<div class="form-group">
								<?php 
									$attributes = array(
										'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
									);
									echo form_label('Frequency Cycle :', 'schedule_frequency_cycle', $attributes);
								?>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<?php 
										$attributes = array(
											'class' => 'control-label',
										);
										$cycleName = '';
										switch($schedule_frequency_cycle){
											case 'D':
												$cycleName = "Daily";
											break;
											case 'W':
												$cycleName = "Weekly";
											break;
											case 'M':
												$cycleName = "Monthly";
											break;
											case 'Y':
												$cycleName = "Yearly";
											break;											
										}
										echo form_label($cycleName, 'schedule_frequency_cycle',$attributes);
									?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
								);
								echo form_label('Shop* :', 'shop_id', $attributes);
							?>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<?php
									$allShop        = [];
									$allShop['']    = 'Select Shop';
									$shop_id		='';
									if(!empty($hwMapDetails->shop_id)){
										$shop_id 		= $hwMapDetails->shop_id;
									}
									foreach($shopList as $singleShopList){
										$allShop[$singleShopList->shop_id] = $singleShopList->shop_name;
									}                    
									echo form_dropdown('shop_id', $allShop, set_value('shop_id',$shop_id), 'class="form-control col-md-7 col-xs-12" id="hardware_shop_id"');
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
								);
								echo form_label('Section* :', 'section_id', $attributes);
							?>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<?php
									$allSection         = [];
									$allSection['']    	= 'Select Section';
									$section_id			= '';
									if(!empty($hwMapDetails->section_id)){
										$section_id 	= $hwMapDetails->section_id;
									}
									foreach($sectionList as $singleSectionList){
										$allSection[$singleSectionList->section_id] = $singleSectionList->section_name;
									}                    
									echo form_dropdown('section_id', $allSection, set_value('section_id',$section_id), 'class="form-control col-md-7 col-xs-12" id="hardware_section_id"');
								?>
							</div>
						</div>
					</div>	
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
								);
								echo form_label('Serial Number* :', 'hardware_serial_no', $attributes);
							?>
							<div class="col-md-7 col-sm-7 col-xs-12">
							   <?php
									$serial_no 	= "";
									if(!empty($hwMapDetails->hardware_serial_no)){
										$serial_no 	= $hwMapDetails->hardware_serial_no;
									}
									$data = array(
											'name'              => 'hardware_serial_no',
											'id'                => 'hardware_serial_no',
											'value'             => set_value('hardware_serial_no',$serial_no),
											'class'             => 'form-control col-md-7 col-xs-12',
									);
									echo form_input($data);
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<?php 
								$attributes = array(
									'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
								);
								echo form_label('Hardware Remark :', 'hardware_remark', $attributes);
							?>
							<div class="col-md-7 col-sm-7 col-xs-12">
							   <?php                               
									$data = array(
										'name'      => 'hardware_remark',
										'id'        => 'hardware_remark',
										'value'     => set_value('hardware_remark',$hwMapDetails->hardware_remark),
										'class'     => 'form-control col-md-7 col-xs-12',
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
					<div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <?php 
                                $attributes = array(
                                    'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
                                );
                                echo form_label('Hardware Start Date :', 'start_date', $attributes);
                            ?>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <?php
									$hwStartDate = "";
									if(isset($hwMapDetails->start_date)){
										$start_date 	= $hwMapDetails->start_date;
										$start_date		= date_create($start_date);
										$hwStartDate	= date_format($start_date,"d M Y");
									}
                                    $data = array(
                                            'name'     => 'start_date',
                                            'id'       => 'start_date',
                                            'value'    => set_value('start_date',$hwStartDate),
                                            'class'    => 'form-control col-md-7 col-xs-12 datepicker',
                                    );
                                    echo form_input($data);
                                ?>
                            </div>
                        </div>
                    </div>
					<div class="col-md-6 col-xs-12">
						<?php 
							$attributes = array(
								'class' => 'control-label col-md-5 col-sm-5 col-xs-12',
							);
							echo form_label('Last Service Date<span class="required">*</span> :', 'service_date', $attributes);
						?>
						<div class="col-md-7 col-sm-7">
							<?php
								$hwScheduleDate = "";
								if(isset($hwMapDetails->map_id)){
									$map_id 		= $hwMapDetails->map_id;
									$hwSchedule 	= $this->Hardwares_model->getHardwareScheduleById($map_id);
									$start_date 	= $hwSchedule->schedule_start_date;
									$start_date		= date_create($start_date);
									$hwScheduleDate	= date_format($start_date,"d M Y");
								}
								$data = array(
										'type'          => 'text',
										'name'          => 'service_date',
										'id'            => 'service_date',
										'value'         => set_value('service_date',$hwScheduleDate),
										'class'         => 'form-control col-md-7 col-xs-12',
								);
								echo form_input($data);
							?>
						</div>
					</div>	
				</div>
				<?php /*<!--- schedule --->
				<div class="row" style="margin: 20px 0px;">
				<?php 
					if(isset($hwMapDetails->map_id)){
						$map_id = $hwMapDetails->map_id;
					}
					$mapScheduleData = $this->Hardwares_model->getScheduleDataByMapId($map_id);	
					//echo "<pre>";print_r($mapScheduleData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
				?>
				<div class="col-md-12">
					<div class="col-md-3"> 
						<label> Cycle </label>
						<select class="form-control"  name="hardware_cycle" id="hardware_cycle" onchange="filterByCycle(this.value)" >
							<option value="1" <?php //if($mapScheduleData->hardware_cycle == 1){ echo 'selected';} ?>>Daily</option>
							<option value="2" <?php //echo ($mapScheduleData->hardware_cycle == 2)?'selected':'';?>>Weekly</option>
							<option value="3" <?php //echo ($mapScheduleData->hardware_cycle == 3)?'selected':'';?>>Monthly</option>
						</select>
					</div>
				</div>	
				<div class="col-md-12" id="dailyBox">
					<div class="col-md-3"> 
						<label> Every Day </label>
						<input type="text" class="form-control" name="daily_every_day" id="daily_every_day" value="<?php //echo isset($mapScheduleData->daily_every_day)?$mapScheduleData->daily_every_day:'';?>">
					</div>					
				</div>	

				<div class="col-md-12" id="weeklyBox"  style="display: none;">
					<div class="col-md-3"> 
						<label> Recur Every Week </label>
						<input type="text" class="form-control" name="weekly_recur_every" id="weekly_recur_every" value="<?php //echo isset($mapScheduleData->weekly_recur_every)?$mapScheduleData->weekly_recur_every:'';?>" >
					</div>	
					<div class="col-md-3"> 
						<label> Week Name </label>
						<select class="form-control"  name="weekly_day" id="weekly_day"   >
							<option value="Monday">Monday</option>
							<option value="Tuesday">Tuesday</option>
							<option value="Wednesday">Wednesday</option>
							<option value="Thursday">Thursday</option>
							<option value="Friday">Friday</option>
							<option value="Saturday">Saturday</option>
							<option value="Sunday">Sunday</option>
						</select>
					</div>					
				</div>


				<div class="col-md-12" id="monthlyBox" style="display: none;">	
					<div class="col-md-3"> 
						<label>Monthly Type</label>
						<select class="form-control"  name="monthly_type" id="monthly_type" onchange="filterByMonth(this.value)" >
							
							<option value="day">Day</option>
							<option value="monthly">Monthly</option>
						</select>
					</div>
					<div class="col-md-12" id="monthlyDay">
						<div class="col-md-4"> 
							<label>Day</label>
							<input type="text" class="form-control"  name="monthly_date" id="monthly_date" value="">
						</div> 
					</div>
					<div class="col-md-12" id="monthlyMonth" style="display: none;">
						 
						<div class="col-md-4"> 
							<label>Week</label>							
							<select class="form-control"  name="monthly_week" id="monthly_week" >
								
								<option value="1">First</option>
								<option value="2">Second</option>
								<option value="3">Third</option>
								<option value="4">Fourth</option>
								<option value="5">Last</option>
							</select>
						</div> 

						<div class="col-md-4"> 
							<label>Day</label>
							
							<select class="form-control"  name="monthly_week_day" id="monthly_week_day" >
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
								<option value="Sunday">Sunday</option>
							</select>
						</div>
						<div class="col-md-4"> 
							<label>Month Name</label>
							<input type="text" class="form-control"  name="monthly_name" id="monthly_name" value="">
						</div> 
					</div>
				</div>
			</div>
				<!--- schedule ---> */?>
                <div class="row">
                    <div class="form-group text-center my-5">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php 
                                echo form_submit('update', 'Update', "class='btn btn-success'");
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
	
	function filterByCycle(IDS){
		//alert(IDS);
		if(IDS == "1"){
			$('#dailyBox').show();
			$('#weeklyBox').hide();
			$('#monthlyBox').hide();			
			$('#monthlyMonth').hide();
		}else if(IDS == "2"){
			$('#dailyBox').hide();
			$('#weeklyBox').show();
			$('#monthlyBox').hide();			
			$('#monthlyMonth').hide();
		}else{
			$('#dailyBox').hide();
			$('#weeklyBox').hide();
			$('#monthlyBox').show();			
			$('#monthlyMonth').hide();
		}

	}

	function filterByMonth(IDS){

		if(IDS == 'day'){
			$('#dailyBox').hide();
			$('#weeklyBox').hide();
			$('#monthlyBox').show();			
			$('#monthlyDay').show();
			$('#monthlyMonth').hide();
		}else{
			$('#dailyBox').hide();
			$('#weeklyBox').hide();
			$('#monthlyBox').show();			
			$('#monthlyDay').hide();
			$('#monthlyMonth').show();
		}

	}

</script>
