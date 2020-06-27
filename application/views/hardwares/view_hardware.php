<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
		<div class="title_left">
			<h3><?php echo $title; ?></h3>
		</div>
                
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			<?php 
				$loggedInUserDetail = $this->session->userdata('loggedInUserDetail'); 
			?>
			<div class="x_content">
                                <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="add-new btn btn-primary" href="<?php echo base_url().'hardwares';?>" title="Back">Back</a>
                                        </li>
                                </ul>
				<br />
				<?php 
					$attributes = array('class' => 'form-horizontal form-label-left','id'=> 'hardware-view-form');
					echo form_open_multipart('hardwares/editHardware/'.$editedId, $attributes); 
				?>
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="x_panel">
							<div class="x_content">
								<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
								  <div class="profile_img">
									<div id="crop-avatar">
										<?php 
											$hardware_image = $hardwareDataById->hardware_image;
											if(!empty($hardware_image)){
												$hardwareImageExist 	= file_exists('./uploads/hardware/'.$hardware_image);
												if(empty($hardwareImageExist)){
												?>
												<img id="hardware_pic" src="<?php echo base_url().'uploads/no-available.jpg';?>" alt="" class="img-responsive avatar-view"/>
												<?php }else{ ?>
											<img id="hardware_pic" src="<?php echo base_url().'uploads/hardware/'.$hardwareDataById->hardware_image;?>" alt="" class="img-responsive avatar-view"/>
											<?php }}else{ ?>
											<img id="hardware_pic" src="<?php echo base_url().'uploads/hardware/no-available.jpg';?>" alt="" class="img-responsive avatar-view"/>
										<?php } ?>
									</div>
								  </div>
								  <?php if(!empty($hardwareDataById->hardware_name)){ ?>
									  <h3>
										<?php                               
											$attributes = array(
											'class' => 'control-label no-padding',
											);
											echo form_label($hardwareDataById->hardware_name, 'hardware_name', $attributes);
										?>
									  </h3>
								  <?php } ?>
								  <ul class="list-unstyled user_data">
									<?php if(!empty($hardwareDataById->hardware_model)){ ?>
									<li> <i class="fa fa-anchor"></i>
									<?php                               
										$attributes = array(
											'class' => 'control-label no-padding',
										);
										echo form_label($hardwareDataById->hardware_model, 'hardware_model', $attributes);
									?>
									</li>
									<?php } ?>
									<?php if(!empty($hardwareDataById->hardware_number)){ ?>
									<li> <i class="fa fa-slack"></i>
									<?php                               
										$attributes = array(
											'class' => 'control-label no-padding',
										);
										echo form_label($hardwareDataById->hardware_number, 'hardware_number', $attributes);
									?>
									</li>
									<?php } ?>
									<?php if(!empty($hardwareDataById->hardware_company)){ ?>
									<li> <i class="fa fa-briefcase user-profile-icon"></i>
									<?php                               
										$attributes = array(
											'class' => 'control-label no-padding',
										);
										echo form_label($hardwareDataById->hardware_company, 'hardware_company', $attributes);
									?> </li>
									<?php } ?>
									<?php 
									if(!empty($hardwareDataById->start_date)){ ?>
									<li> <i class="fa fa-calendar"></i>
									<?php                               
										$attributes = array(
											'class' => 'control-label no-padding',
										);
										echo form_label('Hardware Start Date', 'start_date', $attributes);
										$sdate = date_create($hardwareDataById->start_date);
										$sdate = date_format($sdate,'Y');
										echo ' : '. form_label($sdate, 'start_date', $attributes);
									?> </li>
									<?php } ?>
									<?php 
									if(!empty($hardwareDataById->hardware_specification)){ ?>
									<li> <i class="fa fa-file-text"></i>
									<?php                               
										$attributes = array(
											'class' => 'control-label no-padding',
										);
										echo form_label('Hardware Specification : ', 'hardware_specification', $attributes);
										echo form_label( ' ' . $hardwareDataById->hardware_specification, 'hardware_specification', $attributes);
									?> </li>
									<?php } ?>
								  </ul>

								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<?php 
										//$hardwareMapData = $this->Hardwares_model->getHardwareMappingById($hardwareDataById->hardware_id);
									?>
									<div class="row">
										<div class="col-md-12 col-xs-12 bottom-buffer">
											<h3>Hardware Map Details</h3>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_category = $hardwareDataById->hardware_category;
												if(!empty($hardware_category)){
													$catList 	= $this->Categories_model->getCatById($hardware_category);
													$hwCatName 	= $catList->category_name;
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Hardware Category :', 'hardware_category', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
													   <?php
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hwCatName, 'hardware_category',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_type = $hardwareDataById->hardware_type;
												if(!empty($hardware_type)){
													$typeList 	= $this->Types_model->getTypeById($hardware_type);
													$hwTypeName = $typeList->hardware_type_name;
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Hardware Type :', 'hardware_type', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hwTypeName, 'hardware_type',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div> 
									<div class="row">
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_code = $hardwareDataById->hardware_code;
												if(!empty($hardware_code)){
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Hardware Code :', 'hardware_code', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hardware_code, 'hardware_code',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_name = $hardwareDataById->hardware_name;
												if(!empty($hardware_name)){
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Hardware Name :', 'hardware_name', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hardware_name, 'hardware_name',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_model = $hardwareDataById->hardware_model;
												if(!empty($hardware_model)){
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Hardware Model :', 'hardware_model', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hardware_model, 'hardware_model',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_company = $hardwareDataById->hardware_company;
												if(!empty($hardware_company)){
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Hardware Company :', 'hardware_company', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hardware_company, 'hardware_company',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$shop_id = $hardwareDataByMapId->shop_id;
												if(!empty($shop_id)){
													$shopData = $this->Shops_model->getShopBy($shop_id);
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Shop :', 'shop_id', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($shopData->shop_name, 'shop_id',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$section_id = $hardwareDataByMapId->section_id;
												if(!empty($section_id)){
													$sectionData = $this->Sections_model->getSectionByID($section_id);
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Section :', 'section_id', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($sectionData->section_name, 'section_id',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_serial_no = $hardwareDataByMapId->hardware_serial_no;
												if(!empty($hardware_serial_no)){
											?>
												<div class="form-group">
													<?php 
														$attributes = array(
															'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
														);
														echo form_label('Serial No. :', 'hardware_serial_no', $attributes);
													?>
													<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
														<?php 
															$attributes = array(
																'class' => 'control-label no-padding',
															);
															echo form_label($hardware_serial_no, 'hardware_serial_no',$attributes);
														?>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<?php 
												$hardware_remark = $hardwareDataByMapId->hardware_remark;
											?>
											<div class="form-group">
												<?php 
													$attributes = array(
														'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
													);
													echo form_label('Remark :', 'hardware_remark', $attributes);
													if(!empty($hardware_remark)){
												?>
												<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
													<?php 
														$attributes = array(
															'class' => 'control-label no-padding',
														);
														echo form_label($hardware_remark, 'hardware_remark',$attributes);
													?>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<div class="form-group">
												<?php 
													//echo "<pre>";print_r($hardwareDataByMapId);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
													$attributes = array(
														'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
													);
													echo form_label('Hardware Start Date :', 'start_date', $attributes);
													$hwstart_date = $hardwareDataByMapId->start_date;
													if(!empty($hwstart_date)){
														$hwstart_date		= date_create($hwstart_date);
														$hwstartDate		= date_format($hwstart_date,"d M Y");
												?>
												<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
													<?php 
														$attributes = array(
															'class' => 'control-label no-padding',
														);
														echo form_label($hwstartDate, 'start_date',$attributes);
													?>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="col-md-6 col-xs-12 bottom-buffer">
											<div class="form-group">
												<?php 
													$attributes = array(
														'class' => 'control-label col-md-5 col-sm-5 col-xs-12 no-padding',
													);
													echo form_label('Last Service Date :', 'last_service_date', $attributes);
													$hwSchedule 	= $this->Hardwares_model->getHardwareScheduleById($editedId);
													$start_date 	= $hwSchedule->schedule_start_date;
													if(!empty($start_date)){
														$start_date		= date_create($start_date);
														$hwScheduleDate	= date_format($start_date,"d M Y");
												?>
												<div class="col-md-7 col-sm-7 col-xs-12 no-padding">
													<?php 
														$attributes = array(
															'class' => 'control-label no-padding',
														);
														echo form_label($hwScheduleDate, 'last_service_date',$attributes);
													?>
												</div>
												<?php } ?>
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
	</div>
</div>
<!-- /page content -->