<style type="text/css">
  .modal-dialog {
   width: 950px;
}

</style>
<div class="row table-responsive">
	<table id="ticketLogdatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Ticket No</th>
                  <th>Shop</th>
                  <th>Section</th>
                  <th>Remarks</th>
                  <th>Replacement Remarks</th>
                  <th>Replacement Hardware Serial</th>
                  <th>Replacement Hardware By</th>
                  <th>Update by</th>
                  <th>Update Date</th>
                  <th>Ticket Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					
					$counter = 1; 
					foreach($ticketDataLog as $Ticket){	
						if(!empty($Ticket->assigned_shop_id)){
							$shop_name =  $this->Shops_model->getShopBy($Ticket->assigned_shop_id)->shop_name;
						}else{
							$shop_name = '';
						}

						if(!empty($Ticket->assigned_section_id)){
							$section_name =  $this->Sections_model->getSectionByID($Ticket->assigned_section_id);
							if($section_name){
								$section_name = $section_name->section_name;
							}else{
								$section_name = '';
							}
						}else{
							$section_name = '';
						}
						if(isset($Ticket)){
							$log_update_date = date_create($Ticket->log_update_date);
							$update_date = date_format($log_update_date,'d M Y');
							
						}
						
					$userData1 =	$this->Users_model->getUserById($Ticket->log_updated_by);
					
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <th><?php echo $Ticket->ticket_no ?></th>
                    <td><?php echo $shop_name; ?></td>
                    <td><?php echo $section_name; ?></td> 
                    <td><?php echo $Ticket->remarks; ?></td> 
                    <td><?php echo $Ticket->replacement_remarks; ?></td> 
                    <td><?php echo $Ticket->replacement_hardware_serial; ?></td> 
                     <td><?php echo $Ticket->replaced_by_hardware_serial; ?></td>                      
                     <td><?php  echo $this->Users_model->getUserById($Ticket->log_updated_by)->user_f_name; ?></td> 
                     <td><?php echo isset($update_date)?$update_date:''; ?></td>                      
                     <td>                     	
                     	<?php 
							switch ($Ticket->ticket_status) {
							  case '10':
								echo "Active";
								break;
							  case '20':
								echo "Open";
								break;
							  case '30':
								echo "Assigned";
								break;
							  case '40':
								echo "On Hold";
								break;
							  case '50':
								echo "Closed";
								break;
							  case '60':
								echo "Under Maintenance";
								break;
							  case '70':
								echo "Condemn";
								break;
							  case '80':
								echo "Not Active";
								break;
							}
						?>
                     </td> 
                  </tr>
                <?php $counter++; } ?>
              </tbody>
            </table>
          </div>