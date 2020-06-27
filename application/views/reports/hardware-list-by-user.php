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
                  <th>Name</th>
                  <th>Model</th>
                  <th>Code</th>
                  <th>Company</th>
                  <th>Serial No</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					         $counter = 1; 
					         foreach($HardwareData as $Ticket){	
                   
                 /*  echo "<pre>";
                   print_r($Ticket->assigned_section_id);
                   print_r($section_name );
                   exit;
                  */
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <th><?php echo $Ticket->hardware_name ?></th>
                    <td><?php echo  $Ticket->hardware_model; ?></td>
                    <td><?php echo $Ticket->hardware_code; ?></td> 
                    <td><?php echo $Ticket->hardware_company; ?></td> 
                    <td><?php echo $Ticket->hardware_serial_no; ?></td> 
                  </tr>
                <?php $counter++; } ?>
              </tbody>
            </table>
          </div>