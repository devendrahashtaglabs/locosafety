<style>
.modal-dialog {
    width: 70%;
  }
</style>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 ">
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="add-new btn btn-primary" href="<?php echo base_url().'meeting/add'; ?>" title="Add New">Add New Safety Meeting</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="x_panel">
				<?php
					if ($this->session->flashdata('successMsg')) {
				?>
				<div class="alert alert-success alert-dismissible" id="msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> <?= $this->session->flashdata('successMsg') ?>
				</div>
				<?php
					}
					if ($this->session->flashdata('erroMsg')) {
				?>
				<div class="alert alert-danger alert-dismissible" id="msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Warning!</strong> <?= $this->session->flashdata('erroMsg') ?>
				</div>
				<?php
					}
				?>
				<div class="x_title">
					<h2><?php echo $title; ?></h2>
					<ul class="nav navbar-right panel_toolbox">
						<?php  $booking_id = $_SESSION['loggedInUserDetail']->user_division ; ?>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">  
					<table id="meetingListTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<!-- <th>Location</th>-->
								<th>Title</th>
								<th>Description</th>
								<th>Meeting Date</th>
								<th>Start Time</th>
								<th>End Time</th>	
								<th>User Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php if (!empty($meetingData)) { ?>
						<?php
							$i = 1;
							foreach ($meetingData as $data) { 
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td>
								<div>
									<strong><?php echo ucfirst($data['title']);?></strong></span><br>
								</div>
							</td>
							<td><?php echo $data['description'];?></td>
							<td><?php echo $data['meeting_date'];?></td>
							<td><?php echo $data['meeting_in_time']; ?></td>
							<td><?php echo $data['meeting_out_time']; ?></td>
							<?php 
								$user_ids =$data['user_ids'];
								$user_arr= explode(",",$user_ids);
								$managernamearr 		= [];
								$shopusernamearr 		= [];
								$sectionusernamearr 	= [];
								$mshopusernamearr 		= [];
								$msectionusernamearr 	= [];
								foreach ($user_arr as $userids){
									$userdata = $this->Users_model->getUserById($userids);
									$user_role = $userdata->user_role;
									if($user_role == '3'){
										$userdetail = $this->Meeting_model->get_user($userids);
										if(!empty($userdetail)){
											$managernamearr[] = $userdetail->user_f_name . ' ' . $userdetail->user_l_name;
										}
									}
									if($user_role == '4'){
										$userdetail = $this->Meeting_model->get_user($userids);
										if(!empty($userdetail)){
											$shopusernamearr[] = $userdetail->user_f_name . ' ' . $userdetail->user_l_name;
										}
									}
									if($user_role == '5'){
										$userdetail = $this->Meeting_model->get_user($userids);
										if(!empty($userdetail)){
											$sectionusernamearr[] = $userdetail->user_f_name . ' ' . $userdetail->user_l_name;
										}
									}
									if($user_role == '6'){
										$userdetail = $this->Meeting_model->get_user($userids);
										if(!empty($userdetail)){
											$mshopusernamearr[] = $userdetail->user_f_name . ' ' . $userdetail->user_l_name;
										}
									}
									if($user_role == '7'){
										$userdetail = $this->Meeting_model->get_user($userids);
										if(!empty($userdetail)){
											$msectionusernamearr[] = $userdetail->user_f_name . ' ' . $userdetail->user_l_name;
										}
									} 
								}
							?>
							<td>
								<?php if(!empty($managernamearr)){ ?>
									<b> Manager : </b><?php echo implode (', ',$managernamearr ); ?> <br/>	
								<?php } if(!empty($shopusernamearr)){ ?>
									<b> Shop : </b><?php echo implode (', ',$shopusernamearr ); ?> <br/>
								<?php } if(!empty($sectionusernamearr)){ ?>
									<b> Section : </b><?php echo implode (', ',$sectionusernamearr ); ?> <br/>
								<?php }if(!empty($mshopusernamearr)){ ?>
									<b> Maintenance Shop : </b><?php echo implode (', ',$mshopusernamearr ); ?> <br/>
								<?php }if(!empty($msectionusernamearr)){ ?>
									<b> Maintenance Section : </b><?php echo implode (', ',$msectionusernamearr ); ?> <br/>
								<?php } ?>
							</td>
							<td class="action">										
								<button type="button"  id="submit" name="subxcmit" onclick="modal_btn_click( <?php echo $data['id']; ?> );" class="btn btn-success" tabindex="27" >View</button>
							</td>
							<!-- Modal -->
							
						</tr> 
						<?php
							$i++;

							}
						?>                 
						<?php } ?>       

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Agenda List</h4>
	  </div>
	  <div class="modal-body DataAgenda ">
		<table width="100%" id="agendaListTable" class="table table-striped table-bordered">
                            <tr>
                                <th>S.No.</th>
                               <!-- <th>Location</th>-->
                                <th>Title</th>
								<th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
								<th>User Name</th>
                            </tr>
                        </thead>
                        <tbody id="dataAgenda">
						</tbody>
                    </table>
	  </div>
	</div>

  </div>
</div>
<!-- /page content -->
<script>	
$(function(){
	$('#meetingListTable').DataTable({	
		//responsive: true,
		scrollX: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3,4,5,6]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3,4,5,6]
			}
		}]
	});
	$('#agendaListTable').DataTable({
		
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3,4,5]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3,4,5]
			}
		}]
	});
});
function modal_btn_click(id){ 
		$.ajax({
			url: '<?php echo base_url()."meeting/get_agenda_list/"; ?>',
			method: "Post",
			data : { meeting_id : id },  
			//cache:false,
			dataType: "html",
			success: function(data){
				if(data != ''){
					$('#myModal').modal('show');
					$('#dataAgenda').html(data);
				}
			},
			error: function(data){
				console.log(data);	
			}
		}); 
	}
</script>