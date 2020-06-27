<style>
.m-top-20{
	margin-top: 20px;
}
#AddTime .select2-selection--multiple:before {
    content: "";
    position: absolute;
    right: 7px;
    top: 42%;
    border-top: 5px solid #888;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
}
.select2-drop-active{
    margin-top: -25px;
}
.users ul.select2-selection__rendered {
    height: 200px;
    overflow-y: scroll !important;
}

</style>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
		<?php 
			$loggedInUserDetail = $this->session->userdata('loggedInUserDetail'); 
		?>
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
			<?php if($loggedInUserDetail->user_role != '3'){ ?>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="add-new btn btn-primary" href="<?php echo base_url().'hardwares/addHardware'; ?>" title="Add New">Add New</a></li>
				</ul>
			<?php } ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
			<form action="<?php echo base_url('meeting/addAction'); ?>" id="AddTime" name="AddTime" method="POST" >
			<div class="row">
                <div class="col-md-3 m-top-20">
					<label>Title : </label>
					<input type="text" class="form-control" name="title" id="title" value="" />
				</div>
				<div class="col-md-3 m-top-20 ">
					<label>Description : </label>
					<input type="text" class="form-control" name="description" id="description" value="" />
				</div>
				<div class="col-md-3 m-top-20">
					<label>Date : </label>
					<input type="text" class="form-control" name="date" id="datepicker" value="" />
				</div>	
				<div class="col-md-3 m-top-20">
					<label>Start Time : </label>
					<div class="form-group">
						<div class='input-group date' id='datetimepicker3'>
							<input type='text' name="intime" id="intime" class="form-control" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-time"></span>
							</span>
						</div>
					</div>
				</div>	
				<div class="col-md-3 m-top-20">
					<label>End Time : </label>
					<div class="form-group">
						<div class='input-group date' id='datetimepicker2'>
							<input type='text' name="outtime" id="outtime" class="form-control" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-time"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-3 m-top-20">
					<label>Previous Meetings : </label>
					<select class="form-control" id="prevmeeting" name="prevmeeting" >
						<option value="" >-All-</option>
						<?php if(!empty($allmeeting)){ 
							foreach($allmeeting as $meeting){ ?>
							<option value="<?php echo isset($meeting->id)?$meeting->id:'';?>" ><?php echo isset($meeting->title)?$meeting->title:'';?></option>
						<?php }
							} ?>
					</select>					
				</div>
				<div class="col-md-3 m-top-20">
					<label>Location : </label>
					<input type="text" class="form-control" name="location" id="location" value="" />
				</div>
				<div class="col-md-3 m-top-20">
					<label>User Type : </label>
					<select class="form-control" onchange="GetUsersByUserType(this.value);" id="UserType" name="UserType" >
						<option value="" >-All-</option>
						<option value="manager" >Manager</option>
						<option value="shop" >Shop</option>
						<option value="section" >Section</option>
						<option value="m_shop" >Maintenance Shop</option>
						<option value="m_section" >Maintenance Section</option>
					</select>					
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 m-top-20">
					<label>Shop : </label>
					<select class="form-control" onchange="GetSection();" id="ShopID" name="ShopID[]" multiple="multiple" >
						<option></option>
						<?php
							foreach($Shops as $Shop){
						?>
							<option value="<?php echo $Shop->shop_id; ?>" ><?php echo $Shop->shop_name; ?></option>	
						<?php 	
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20">
					<label>Section : </label>
					<select class="form-control"  id="Section" name="Section[]" onchange="GetSection();" multiple="multiple">
					</select>
				</div>
				<div class="col-md-3 m-top-20">
					<label>Maintenance Shop : </label>
					<select class="form-control" id="MShopID" name="M_ShopID[]" onchange="GetSection();" multiple="multiple">						
						<?php
							foreach($M_Shops as $Shop){
						?>
							<option value="<?php echo $Shop->maintenance_shop_id; ?>" ><?php echo $Shop->maintenance_shop_name; ?></option>	
						<?php 	
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20">
					<label>Maintenance Section : </label>
					<select class="form-control" onchange="GetSection();" id="M_SectionID" name="M_SectionID[]" multiple="multiple">
					</select>
				</div>
			</div>
			<div class="row users">
				<div class="col-md-12 m-top-20" id="allusers"> 
					<label>Users : </label>
				</div>
				<div class="col-md-3 m-top-20"> 
					<label>Manager : </label>
					<select class="form-control" multiple id="managerlist" name="managerlist[]">
						<option value="" >-All-</option>
						<?php 
							foreach($Users as $row){
								if($row->user_role == '3'){
									$userData = $this->Users_model->getUserById($row->user_info_id);
									$userfname = !empty($userData)?$userData->user_f_name:'';
									$userlname = !empty($userData)?$userData->user_l_name:'';
									$designation = !empty($userData)?$userData->user_designation:'';
									$username = $userfname.' '.$userlname;
									if(!empty($designation)){
										$username = $userfname.' '.$userlname . ' (' . $designation .') ';
									}
						?>
							<option value="<?php echo $row->user_info_id; ?>" selected="selected"><?php echo $username; ?></option>
						<?php 
								}
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20"> 
					<label>Shop Incharge : </label>
					<select class="form-control" multiple id="shopInlist" name="shopInlist[]">
						<option value="" >-All-</option>
						<?php 
							foreach($Users as $row){
								if($row->user_role == '4'){
									$userData = $this->Users_model->getUserById($row->user_info_id);
									$userfname = !empty($userData)?$userData->user_f_name:'';
									$userlname = !empty($userData)?$userData->user_l_name:'';
									$designation = !empty($userData)?$userData->user_designation:'';
									$username = $userfname.' '.$userlname;
									if(!empty($designation)){
										$username = $userfname.' '.$userlname . ' (' . $designation .') ';
									}
						?>
							<option value="<?php echo $row->user_info_id; ?>" selected="selected"><?php echo $username; ?></option>
						<?php 
								}
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20"> 
					<label>Section Incharge : </label>
					<select class="form-control" multiple id="sectionInlist" name="sectionInlist[]">
						<option value="" >-All-</option>
						<?php 
							foreach($Users as $row){
								if($row->user_role == '5'){
									$userData = $this->Users_model->getUserById($row->user_info_id);
									$userfname = !empty($userData)?$userData->user_f_name:'';
									$userlname = !empty($userData)?$userData->user_l_name:'';
									$designation = !empty($userData)?$userData->user_designation:'';
									$username = $userfname.' '.$userlname;
									if(!empty($designation)){
										$username = $userfname.' '.$userlname . ' (' . $designation .') ';
									}
						?>
							<option value="<?php echo $row->user_info_id; ?>" selected="selected"><?php echo $username; ?></option>
						<?php 
								}
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20"> 
					<label>Maintenance Shop Incharge : </label>
					<select class="form-control" multiple id="mshopInlist" name="mshopInlist[]">
						<option value="" >-All-</option>
						<?php 
							foreach($Users as $row){
								if($row->user_role == '6'){
									$userData = $this->Users_model->getUserById($row->user_info_id);
									$userfname = !empty($userData)?$userData->user_f_name:'';
									$userlname = !empty($userData)?$userData->user_l_name:'';
									$designation = !empty($userData)?$userData->user_designation:'';
									$username = $userfname.' '.$userlname;
									if(!empty($designation)){
										$username = $userfname.' '.$userlname . ' (' . $designation .') ';
									}
						?>
							<option value="<?php echo $row->user_info_id; ?>" selected="selected"><?php echo $username; ?></option>
						<?php 
								}
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20"> 
					<label>Maintenance Section Incharge : </label>
					<select class="form-control" multiple id="msectionInlist" name="msectionInlist[]">
						<option value="" >-All-</option>
						<?php 
							foreach($Users as $row){
								if($row->user_role == '7'){
									$userData = $this->Users_model->getUserById($row->user_info_id);
									$userfname = !empty($userData)?$userData->user_f_name:'';
									$userlname = !empty($userData)?$userData->user_l_name:'';
									$designation = !empty($userData)?$userData->user_designation:'';
									$username = $userfname.' '.$userlname;
									if(!empty($designation)){
										$username = $userfname.' '.$userlname . ' (' . $designation .') ';
									}
						?>
							<option value="<?php echo $row->user_info_id; ?>" selected="selected"><?php echo $username; ?></option>
						<?php 
								}
							}
						?>
					</select>
				</div>
				<div class="col-md-3 m-top-20">
					</br>
					<input type="submit" name="submit" id="submit" class="btn btn-primary" />
				</div>
			  
            </div>
			</form>
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	function GetSection(){
		var ShopID 		= $('#ShopID').val();
		var SectionID 	= $('#Section').val();	
		var M_ShopID 	= $('#MShopID').val();	
		var M_SectionID = $('#M_SectionID').val();	
		if(ShopID == null || M_ShopID == null){
			$('#managerlist').empty();
		}
		if(ShopID == null){
			$('#Section').empty();
		}
		if(M_ShopID == null){
			$('#M_SectionID').empty();
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>meeting/getuserbyshop',
			//contentType: "application/json",
			dataType: "json",
			data: {shop_id: ShopID,section_id:SectionID,m_shop_id: M_ShopID,m_section_id:M_SectionID}, 
			success: function (data) {	
				if(data.shopuserlist != ''){		
					$("#shopInlist").html(data.shopuserlist); 
				}
				if(data.mshopuserlist != ''){		
					$("#mshopInlist").html(data.mshopuserlist); 
				}
				if(data.sectionuserlist != ''){		
					$("#sectionInlist").html(data.sectionuserlist); 
				}
				if(data.msectionuserlist != ''){		
					$("#msectionInlist").html(data.msectionuserlist); 
				}					
				if(data.SectionList != ''){					
					$("#Section").html(data.SectionList);           
				}
				if(data.MSectionList != ''){					
					$("#M_SectionID").html(data.MSectionList);           
				}
			},
			error: function (data) {
				console.log(data);
			}
		});
	}
	function GetMSection(){	
		var M_ShopID = $('#M_ShopID').val();	
		var M_SectionID = $('#M_SectionID').val();	
	
		$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>meeting/getMuserbyshop/'+M_ShopID+'/'+M_SectionID,
				contentType: "application/json",
				dataType: "json",
				//data: "{'shop_id': shop_id}", 
				success: function (data) {					
				/* 	console.log(data);
					console.log(data);
					alert(data.userlist); */
					if(data.UserList != ''){		
						$("#userlist").html(data.UserList); 
					}					
					if(data.SectionList != ''){					
						$("#M_SectionID").html(data.SectionList);           
					}
					$("#ShopID").val("");
					$("#Section").val("");
				},
				error: function (data) {
					console.log(data);
				}
			});
	
	}
	
  $(function() {
	  
	$( "#datepicker" ).datepicker();

	$('#datetimepicker3').datetimepicker({
		format: 'LT'
	});
	$('#datetimepicker2').datetimepicker({
		format: 'LT'
	});
	
	
	$("#AddTime").validate({
		rules: {
			title: {
					required : true,
					maxlength : 250,
				},
			description: {
					required : true,
				},
			date: {
					required : true,
				},
			intime: {
					required : true,
				},
			outtime: {
					required : true,
				},	
		},
		messages:{
			
		}
	});
  });
  
  function GetUsersByUserType(ID){
	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>meeting/getuserbyusertype/'+ID,
		//contentType: "application/json",
		dataType: "json",
		//data: "{'shop_id': shop_id}", 
		success: function (data) {	
			//console.log(data);return false;
			if(data.Usertype === 'manager'){
				var userlist = data.UserList;
				setdata('#managerlist',userlist,'#shopInlist,#sectionInlist,#mshopInlist,#msectionInlist');
			}
			if(data.Usertype === 'shop'){
				var userlist = data.UserList;
				setdata('#shopInlist',userlist,'#managerlist,#sectionInlist,#mshopInlist,#msectionInlist');
			}
			if(data.Usertype === 'section'){
				var userlist = data.UserList;
				setdata('#sectionInlist',userlist,'#managerlist,#shopInlist,#mshopInlist,#msectionInlist');
			}
			if(data.Usertype === 'm_shop'){	
				var userlist = data.UserList;
				setdata('#mshopInlist',userlist,'#managerlist,#shopInlist,#sectionInlist,#msectionInlist');
			}
			if(data.Usertype === 'm_section'){
				var userlist = data.UserList;
				setdata('#msectionInlist',userlist,'#managerlist,#shopInlist,#sectionInlist,#mshopInlist');
			}
		},
		error: function (data) {
			console.log(data);
		}
	});
  }
	function setdata(activediv,data,hidediv){
		$(activediv).html(data); 
		$(hidediv).empty();
	}
	$(document).ready(function() {
		$('#ShopID').select2({
			multiple: true,
			placeholder: "-All-",
		});
		$('#Section').select2({
			multiple: true,
			placeholder: "-All-",
		});
		$('#MShopID').select2({
			multiple: true,
			placeholder: "-All-",
		});
		$('#M_SectionID').select2({
			multiple: true,
			placeholder: "-All-",
		});
		$('#managerlist').select2({
			multiple: true,
			placeholder: "-Select Manager-",
		});
		$('#shopInlist').select2({
			multiple: true,
			placeholder: "-Select Shop User-",
		});
		var sections = $('#sectionInlist').select2({
			multiple: true,
			placeholder: "-Select Section User-",
		});
		$('#mshopInlist').select2({
			multiple: true,
			placeholder: "-Select Maintenance Shop User-",
		});
		$('#msectionInlist').select2({
			multiple: true,
			placeholder: "-Select Maintenance Section User-",
		});
	});

  </script>