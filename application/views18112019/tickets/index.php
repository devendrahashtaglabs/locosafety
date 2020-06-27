<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
			//echo "<pre>";print_r($ticketData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
              if(!empty($ticketData)){
            ?>
            <table id="ticketdatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Shop</th>
                  <th>Section</th>
                  <th>Hardware</th>
                  <th>Raised Date</th>
                  <th>Raised By</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					$counter = 1; 
					foreach($ticketData as $singleTicketData){
						$shop_name 			= $singleTicketData->shop_name;            
						$section_name 		= $singleTicketData->section_name;         
						$hardware_name 		= $singleTicketData->hardware_name;        
						$ticket_raise_date 	= '';
						if(!empty($singleTicketData->ticket_add_date)){
							$date 				= date_create($singleTicketData->ticket_add_date);
							$ticket_raise_date 	= date_format($date,"d M Y");
						}
						$fname 	= $singleTicketData->user_f_name;               
						$lname 	= $singleTicketData->user_l_name;
						$userName = $fname.' '.$lname;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($shop_name)?$shop_name:''; ?></td>
                    <td><?php echo isset($section_name)?$section_name:''; ?></td> 
                    <td><?php echo isset($hardware_name)?$hardware_name:''; ?></td> 
                    <td><?php echo isset($ticket_raise_date)?$ticket_raise_date:''; ?></td> 
                    <td><?php echo isset($userName)?$userName:''; ?></td> 
                  </tr>
                <?php $counter++; } ?>
              </tbody>
            </table>
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->