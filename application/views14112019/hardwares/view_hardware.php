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
				<div class="x_title">
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="add-new btn btn-primary" href="<?php echo base_url().'hardwares/addHardware'; ?>">Add New</a></li>
						<li><a class="add-new btn btn-primary" href="<?php echo base_url().'hardwares'; ?>">View List</a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
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
													<?php }else{
											?>
												<img id="hardware_pic" src="<?php echo base_url().'uploads/hardware/'.$hardwareDataById->hardware_image;?>" alt="" class="img-responsive avatar-view"/>
												<?php }}else{ ?>
												<img id="hardware_pic" src="<?php echo base_url().'uploads/no-available.jpg';?>" alt="" class="img-responsive avatar-view"/>
											<?php } ?>
										</div>
									  </div>
									  <?php if(!empty($hardwareDataById->hardware_name)){ ?>
										  <h3>
											<?php                               
												$attributes = array(
												'class' => 'control-label',
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
											'class' => 'control-label',
											);
											echo form_label($hardwareDataById->hardware_model, 'hardware_model', $attributes);
										?>
										</li>
										<?php } ?>
										<?php if(!empty($hardwareDataById->hardware_number)){ ?>
										<li> <i class="fa fa-slack"></i>
										<?php                               
											$attributes = array(
											'class' => 'control-label',
											);
											echo form_label($hardwareDataById->hardware_number, 'hardware_number', $attributes);
										?>
										</li>
										<?php } ?>
										<?php if(!empty($hardwareDataById->hardware_company)){ ?>
										<li> <i class="fa fa-briefcase user-profile-icon"></i>
										<?php                               
											$attributes = array(
											'class' => 'control-label',
											);
											echo form_label($hardwareDataById->hardware_company, 'hardware_company', $attributes);
										?> </li>
										<?php } ?>
									  </ul>

									  <a class="btn btn-success" href="<?php echo base_url().'hardwares/editHardware/'.$editedId; ?>"><i class="fa fa-edit m-right-xs"></i>Edit Hardware</a>
									  <br />

									</div>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<div class="row">
											<div class="col-md-12 col-xs-12 bottom-buffer">
												<h3>Hardware Details</h3>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<?php 
														$attributes = array(
														'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
														);
														echo form_label('Shop :', 'shop_id', $attributes);
													?>
													<div class="col-md-9 col-sm-9 col-xs-12">
														<?php
															$shopData    = $this->Shops_model->getShopBy($hardwareDataById->shop_id);
															$attributes = array(
															'class' => 'control-label',
															);
															echo form_label($shopData->shop_name, 'shop_id', $attributes);
														?>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<?php 
														$attributes = array(
														'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
														);
														echo form_label('Section :', 'section_id', $attributes);
													?>
													<div class="col-md-9 col-sm-9 col-xs-12">
														<?php
															$sectionData = $this->Sections_model->getSectionBy($hardwareDataById->section_id);
															$attributes = array(
															'class' => 'control-label',
															);
															if(!empty($sectionData->section_name)){
															echo form_label($sectionData->section_name, 'section_id', $attributes);
															}
														?>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<?php 
														$attributes = array(
														'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
														);
														echo form_label('Category :', 'hardware_category', $attributes);
													?>
													<div class="col-md-9 col-sm-9 col-xs-12">
														<?php
															$catId      = $hardwareDataById->hardware_category;
															$catDetail	= '';
															if(!empty($catId)){
																$catDetail 	= $this->Categories_model->getCategoryBy($catId);
															}
															$attributes = array(
																'class' => 'control-label',
															);
															if(!empty($catDetail->category_name)){
																echo form_label($catDetail->category_name, 'hardware_category', $attributes);
															}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<?php 
														$attributes = array(
														'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
														);
														echo form_label('Type :', 'hardware_type', $attributes);
													?>
													<div class="col-md-9 col-sm-9 col-xs-12">
														<?php
															$typeId     = $hardwareDataById->hardware_type;
															$typeDetail = '';
															if(!empty($typeId)){
																$typeDetail = $this->Types_model->getTypeBy($typeId);
															}
															$attributes = array(
																'class' => 'control-label',
															);
															if(!empty($typeDetail->type_name)){
																echo form_label($typeDetail->type_name, 'hardware_type', $attributes);
															}
														?>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<?php 
														$attributes = array(
														'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
														);
														echo form_label('Dimensions :', 'hardware_dimensions', $attributes);
													?>
													<div class="col-md-9 col-sm-9 col-xs-12">
													<?php                               
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($hardwareDataById->hardware_dimensions, 'hardware_dimensions', $attributes);
													?>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<?php 
														$attributes = array(
														'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
														);
														echo form_label('Description :', 'hardware_description', $attributes);
													?>
													<div class="col-md-9 col-sm-9 col-xs-12">
														<?php                               
															$attributes = array(
															'class' => 'control-label',
															);
															echo form_label($hardwareDataById->hardware_description, 'hardware_description', $attributes);
														?>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php 
													$attributes = array(
													'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
													);
													echo form_label('MFG Date :', 'hardware_mfg_date', $attributes);
												?>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<?php  
														$mfg_date = date_create($hardwareDataById->hardware_mfg_date);
														$mfgDate    = date_format($mfg_date,"d M Y");
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($mfgDate, 'hardware_mfg_date', $attributes);
													?>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php 
													$attributes = array(
													'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
													);
													echo form_label('EXP Date :', 'hardware_exp_date', $attributes);
												?>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<?php  
														$exp_date = date_create($hardwareDataById->hardware_exp_date);
														$expDate    = date_format($exp_date,"d M Y");
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($expDate, 'hardware_exp_date', $attributes);
													?>
												</div>
											</div>
										</div>
										<div class="row mt-5">
											<div class="col-md-12 col-xs-12 bottom-buffer">
												<h3>Maintenance Cycle Details</h3>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php 
													$attributes = array(
													'class' => 'control-label col-md-4 col-sm-4 col-xs-12',
													);
													echo form_label('Frequency Count :', 'service_frequency_count', $attributes);
												?>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<?php                               
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($hardwareDataById->service_frequency_count, 'service_frequency_count', $attributes);
													?>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php 
													$attributes = array(
													'class' => 'control-label col-md-4 col-sm-4 col-xs-12',
													);
													echo form_label('Frequency Cycle :', 'service_frequency_cycle', $attributes);
												?>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<?php 
														$cycle = $hardwareDataById->service_frequency_cycle;
														$cycleName = ""; 
														switch($cycle){
														case 'D':
														$cycleName = 'Day';
														break;
														case 'W':
														$cycleName = 'Week';
														break;
														case 'M':
														$cycleName = 'Month';
														break;
														case 'Y':
														$cycleName = 'Year';
														break;
														}                            
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($cycleName, 'service_frequency_cycle', $attributes);
													?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php 
													$attributes = array(
														'class' => 'control-label col-md-4 col-sm-4 col-xs-12',
													);
													echo form_label('Service Date :', 'service_date', $attributes);
												?>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<?php  
														$service_date   = date_create($hardwareDataById->service_date);
														$service_date   = date_format($service_date,"d M Y");
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($service_date, 'service_date', $attributes);
													?>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php 
													$attributes = array(
													'class' => 'control-label col-md-4 col-sm-4 col-xs-12',
													);
													echo form_label('Next Service Date :', 'service_date_next', $attributes);
												?>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<?php   
														$service_date_next   = date_create($hardwareDataById->service_date_next);
														$service_date_next   = date_format($service_date_next,"d M Y");
														$attributes = array(
														'class' => 'control-label',
														);
														echo form_label($service_date_next, 'service_date_next', $attributes);
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12 bottom-buffer">
						<h3>Maintenance Log</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12 bottom-buffer">
						<div class="x_panel">
							<div class="x_content">
								<?php 
									if(!empty($maintenanceLogData)){
								?>
								<table id="maintenancelogdatatable" class="table table-striped table-bordered">
								  <thead>
									<tr>
									  <th>S.No.</th>
									  <th>Ticket Raised By</th>
									  <th>Ticket Raised Date</th>
									  <th>Completed By</th>
									  <th>Completed Date</th>
									</tr>
								  </thead>
								  <tbody>
									<?php 
										$counter = 1; 
										foreach($maintenanceLogData as $singleLog){
									?>
										<tr>
											<td><?php echo $counter; ?></td>
											<td>
												<?php                               
													$attributes = array(
														'class' => 'control-label',
													);
													$fname = $singleLog->user_f_name;
													$lname = $singleLog->user_l_name;
													$ticket_raised_by = $fname.' '.$lname;
													echo form_label($ticket_raised_by, 'ticket_raised_by', $attributes);
												?>
											</td>
											<td>
												<?php 
													$log_add_date   	= date_create($singleLog->log_add_date);
													$ticket_raised_date = date_format($log_add_date,"d M Y");
													echo form_label($ticket_raised_date, 'ticket_raised_date', $attributes);
												?>
											</td>
											<td>
												<?php
													$maintainby = array('user_id'=>$singleLog->maintenance_user_id);
													$userData 		= $this->Users_model->getUserBy($maintainby);
													if(!empty($userData)){
														$maintenceUserDetail = $userData[0];
														$m_fname = $maintenceUserDetail->user_f_name;
														$m_lname = $maintenceUserDetail->user_l_name;
														$maintenanceUserName = $m_fname.' '.$m_lname; 
														$attributes = array(
															'class' => 'control-label',
														);
														echo form_label($maintenanceUserName, 'completed_by', $attributes);
													}
												?>
											</td>
											<td>
												<?php   
													$maintain_ticket_date   = date_create($singleLog->maintain_ticket_date);
													$completedDate   = date_format($maintain_ticket_date,"d M Y");
													$attributes = array(
													'class' => 'control-label',
													);
													echo form_label($completedDate, 'completed_date', $attributes);
												?>
											</td>
										</tr>
									<?php $counter++; } ?>
								  </tbody>
								</table>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->