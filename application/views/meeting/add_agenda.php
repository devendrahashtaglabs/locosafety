<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<style>
.m-top-20{
	margin-top: 20px;
}
#myTable {
	padding:20px 0px;
}
#myTable td {
	padding :0 5px;
	vertical-align:top;
}
#myTable th {
    text-align: left;
    padding-top: 20px;
    position: relative;
    left: 5px;
}
.select2-container{
	    width: 350px !important;
}
span.select2.select2-container.select2-container--default.select2-container--below.select2-container--focus {
    width: 350px !important;
}
.input-group.date.dateget{
	margin:0;
}
.select2-container--default .select2-selection--multiple {
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 0px;
    cursor: text;
    min-height: 34px;
	line-height:15px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 2px;
    margin-top: 1px;
    padding: 0 5px;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    padding: 0 2px;
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
			
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
			<form action="<?php echo base_url('meeting/addAgenda'); ?>" id="AddTime" name="AddTime" method="POST" >
				
				<input type="hidden" name="meeting_id" id="meeting_id" value="<?php echo $mapID; ?>" />
			
				<div class="col-md-12" style="border: 1px solid black">
					<table id="myTable" width="100%">
						<tr>
							<th style="">
								<label>Title</label>
							</th>
							<th>
								<label>Description</label>
							</th>
							<!--<th>
								<label>Start Time</label>
							</th>
							<th>
								<label>End Time</label>
							</th>
							<th>
								<label>Start Date</label>
							</th> -->
							<th>
								<label>End Date</label>
							</th>
							<th>
								<label>Users</label>
							</th>	
						</tr>
						<tr>
							<td style="width:170px">
								<input type="text" placeholder="Title" class="form-control" required="required" name="title"  />
							</td>
							<td style="width:38%;">
								<input type="text" required="required" name="description" placeholder="Description" class="form-control" />
							</td>
							<!--
							<td>
								<div class="col-md-12" >
								<div class='input-group date starttime' id='starttime'>
									<input type='text' name="intime" id="intime" class="form-control" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
								</div>
							</td>
							<td>
								<div class="col-md-12" >
								<div class='input-group date starttime' id='starttime'>
									<input type='text' name="outtime" id="outtime" class="form-control" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
								</div>
							</td>
							<td>
								<div class="col-md-12" >
								<div class='input-group date dateget' id='starttime'>
									<input type='text' name="startdate" id="startdate" class="form-control" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
								</div>
							</td>
							-->
							<input type="hidden"  name="startdate"  id="startdate" value="<?php echo $MapDate; ?>" />
							<td style="width:170px">
								
								<div class='input-group date dateget' id='starttime'>
									<input type='text' name="enddate"  onkeydown="return false" id="enddate" class="form-control" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div> <!-- onkeydown="return false" -->
								
							</td>
							<td>
								<select name="users[]" multiple="multiple" class="form-control js-example-basic-multiple">
									<?php 
										foreach($users as $row){
									?>
									<option value="<?php echo $row->user_info_id; ?>" ><?php echo $row->user_f_name.' '.$row->user_l_name.' ('.$row->role_name.')'; ?></option>
									<?php 
										}
									?>
								</select>
								<span id="procedure_error_message_tools" >
								</span>
							</td>
							<!--
							<td>
								<input type="button" value="Delete" class="btn btn-info"  />
							</td>
							-->
						</tr>
						
					</table>
					<div class="col-md-12">
						</br>
						<!--
						<input type="button" class="btn btn-primary  insertRow" value="Insert row">
						-->
						<input type="hidden" value="<?php echo $MapDate; ?>" name="MapDate" id="MapDate" />
						<input type="hidden" value="<?php echo $mapID; ?>" name="mapID" id="mapID" />
						<input type="submit" class="btn btn-success" name="save" id="save" value="Save">
						<input type="submit" name="addmore" id="addmore" class="btn btn-primary" value="Add More">
					</div>
				</div>
			</form>
		  </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Meeting Agenda List :</h2>
			
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
			<?php				
				$MapData =   $this->Meeting_model->CheckMapid($mapID);	
			?>
			<table id="hardwaredatatable1" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Description</th>				  
				  <th>End Date</th>
                  <th>Users</th>                  
                </tr>
              </thead>
              <tbody>
				<?php 
					foreach($MapData as $row){	
						$HTML = '';
						$UsersArr = explode(',',$row->user_ids);
						foreach($UsersArr as $row1){
							$UserData =  $this->Users_model->GetAllUserForAgendabyID($row1);
							$HTML .= $UserData->user_f_name.' '.$UserData->user_l_name.', ';			
						}
						
				?>	
					<tr>
						<td><?php echo $row->title; ?></td>
						<td><?php echo $row->description; ?></td>
						<td><?php echo $row->end_date; ?></td>
						<td><?php echo $HTML; ?></td>
					</tr>
				<?php 
					}
				?>
				</tbody>
				</table>
		  
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$('#myTable').on('click', 'input[type="button"]', function () {
    $(this).closest('tr').remove();
})
$('.insertRow').click(function () {
    $('#myTable').append('<tr><td><input name="title[]" required="required" type="text" placeholder="Title" class="form-control"/></td><td><input required="required" name="description[]" type="text" placeholder="Description"   class="form-control"/></td><td><select name="users[]" multiple="multiple" class="form-control js-example-basic-multiple"><?php foreach($users as $row){?><option value="<?php echo $row->user_info_id; ?>" ><?php echo $row->user_email; ?></option><?php } ?></select></td><td><input type="button" value="Delete" class="btn btn-info"/></td></tr>');
	 $('.js-example-basic-multiple').select2();
});

</script>
<script>
  $(function() {

	 $('.js-example-basic-multiple').select2();
	$("#AddTime").validate({
		rules: {
			'title[]': {
					required : true,
				},
			'description[]': {
					required : true,
				},
			'users[]': {
					required : true,
				},	
		},
		messages:{
			
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "users[]") {
				error.appendTo("#procedure_error_message_tools");
			}else{
				error.insertAfter(element);
			}
			element.click(function(){                                    
				jQuery(this).next('label.error').hide();      
			});
		}
	});
	
	
	
	$('#hardwaredatatable1').DataTable();
	
		$('.dateget').datetimepicker({
			format: 'YYYY-MM-DD',	
			//minDate: '<?php echo $MapDate; ?>',
			minDate: moment('<?php echo $MapDate; ?>', 'DD-MM-YYYY'),
			
		});
		$('.starttime').datetimepicker({
			format: 'LT'
		});
	
		$('#enddate').val('');
	
  });
  
</script>
