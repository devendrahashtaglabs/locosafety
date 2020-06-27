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
											<?php /*
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
											<?php } */?>
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

									</div>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php 
											$hardwareMapData = $this->Hardwares_model->getHardwareMappingById($hardwareDataById->hardware_id);
										?>
										<div class="row">
											<div class="col-md-12 col-xs-12 bottom-buffer">
												<h3>Hardware Map Details</h3>
											</div>
										</div>
										<div class="row">
											<table id="hardwaredatatable" class="table table-striped table-bordered">
											  <thead>
												<tr>
												  <th>S.No.</th>
												  <th>Hardware Serial No.</th>
												  <th>Shop </th>
												  <th>Section</th>
												  <th>Schedule Date</th>
												  <th>Schedule Next Date</th>
												  <th>Action</th>
												</tr>
											  </thead>
											  <tbody>
												<?php 
												  if(!empty($hardwareMapData)){
													$counter = 1; 
													foreach($hardwareMapData as $singleMapData){
														//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
														$serial_no 		= $singleMapData->hardware_serial_no;
														$shop_name 		= '';
														$shop_id 		= $singleMapData->shop_id;
														if(!empty($shop_id)){
															$shopData		= $this->Shops_model->getShopBy($shop_id);
															if(!empty($shopData)){
																$shop_name 	= $shopData->shop_name;
															}
														}
														$section_name 	= '';
														$section_id 	= $singleMapData->section_id;
														if(!empty($shop_id)){
															$sectionData	= $this->Sections_model->getSectionBy($section_id);
															if(!empty($sectionData)){
																$section_name 	= $sectionData->section_name;
															}
														}
														$map_id 		= $singleMapData->map_id;
														$scheduleData	= $this->Hardwares_model->getHardwareScheduleById($map_id);
														$schedule_date 		= "";
														$next_schedule_date = "";
														if(isset($scheduleData->schedule_start_date)){
															$start_date 		= $scheduleData->schedule_start_date;
															$schedule_new_date  = date_create($start_date);
															$schedule_date 		= date_format($schedule_new_date,"d M Y");
														}
														if(isset($scheduleData->next_schedule_date)){
															$next_date 				= $scheduleData->next_schedule_date;
															$schedule_next_date  	= date_create($next_date);
															$next_schedule_date 	= date_format($schedule_next_date,"d M Y");
														}
												?>
												  <tr>
													<td><?php echo $counter; ?></td>
													<td><?php echo isset($serial_no)?$serial_no:''; ?></td>
													<td><?php echo isset($shop_name)?$shop_name:''; ?></td>
													<td><?php echo isset($section_name)?$section_name:''; ?></td>
													<td><?php echo isset($schedule_date)?$schedule_date:''; ?></td>
													<td><?php echo isset($next_schedule_date)?$next_schedule_date:''; ?></td>
													<td>
														<a href="<?php echo base_url('hardwares/editHardware/'.$singleMapData->map_id); ?>" class="edit"> Edit </a>
													</td>
													
												  </tr>
												<?php 
													$counter++; }  
													} ?> 
											  </tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php /* ?>
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
				</div> <?php */?>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->