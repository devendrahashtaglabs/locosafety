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