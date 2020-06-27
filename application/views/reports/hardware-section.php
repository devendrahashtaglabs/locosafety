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
          	<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('success'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
              	<?php }if(!empty($this->session->flashdata('error'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
              	<?php } ?>
              </div>
            </div>
            <div class="row" style="margin-bottom:20px; ">
                <div class="col-md-2 FilterCustom1">
                </div>
                <div class="col-md-2 FilterCustom2">
                </div> 
                <div class="col-md-2 FilterCustom3">
                </div>
				<div class="col-md-2 FilterCustom4">
                </div>
            </div>
			<div class="table-responsive">
            <table id="UserSectionTable" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Shop Name</th>
                  <th>Section Name</th>				  
				  <th>Section In charge</th>  
                  <th>Serial No. / Hardware Model / Hardware Name</th>
                  <th>Hardware Category</th>				  
                  <th>Hardware Type</th>  				  
                  <th>Service Date</th>               
                  <th>Status</th>
                  <th style="display:none;">Statushide</th>
                  <th style="display:none;">Statushide</th>
				  <th>Hardware Age</th>
                </tr>
              </thead>
              <tbody>
				<?php 
				  if(!empty($UserSectionData)){ 
				  
					
					$UserData = '';
					$hardwareDataFull = '';
					$counter = 1;	
					foreach ($UserSectionData as $key => $value) {
						if(isset($value->mapping_created_by)){
							$UserData = $this->Users_model->getAdmin($value->mapping_created_by);
							if(isset($UserData)){
								$UserData = $UserData[0];
							}else{
								$UserData = '';
							}
						}
					if(isset($value->hardware_id)){
						$hardwareDataFull = $this->Hardwares_model->getHardwareDataByHardwareIDSECOND($value->hardware_id);
						//echo '<br>';
						//print_r($this->db->last_query());echo '<br>';
						//print_r($hardwareDataFull);
					}
					//$hardwareDataFull = $this->Hardwares_model->getHardwareDataByHardwareID(261);
					
					if(!empty($hardwareDataFull) && count($hardwareDataFull) > 0){
						//print_r($hardwareDataFull);			
						$hardwareDataFull = $hardwareDataFull;
						//echo "<pre>";print_r($hardwareDataFull);die('line'. __LINE__ );
					}else{
						$hardwareDataFull = '';
					}
					$hardwareType = '';
					if(isset($hardwareDataFull->hardware_type)){
						$hardwareType = $this->Hardwares_model->getHardwareTypeNameByID($hardwareDataFull->hardware_type);
					}else{
						$hardwareType = '';
					}
					$TicketData =  $this->Tickets_model->CheckHardwareTicket($value->map_id);
					$TicketCount = count($TicketData);
					$ServiceDays = "";
					$Status1 = '';
					/* ============ Get Next Service Date ============== */
					$Status3 ='';						
					$ServiceDate =  $this->Reports_model->GetNextServiceDate($value->map_id);		
					if(isset($ServiceDate)){
						$ServiceDate = $ServiceDate->next_schedule_date; 
					}else{
						$ServiceDate = "";
					}	
					/* ============ Get Next Service Date ============== */
					
					if($ServiceDate != ''){
						$today 		= strtotime(date('y-m-d'));
						$ServiceD 	= strtotime($ServiceDate);
						
						$date1 	= date('y-m-d');
						$date2 	= $ServiceDate;
						/* $diff 	= abs(strtotime($date1) - strtotime($date2));
						$years 	= floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$ServiceDays = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); */
						
						$date1		= date_create($date1);
						$date2		= date_create($date2);
						$diff		= date_diff($date1,$date2);
						$daycount 	= $diff->format("%R%a days");
						//$ServiceDays = $diff->format("%R%a days");
						if($daycount > 0){
							$ServiceDays = abs($daycount);
						}else{
							$ServiceDays = abs($daycount);
						}
						
						if($ServiceD < $today  ){
							$day = ($ServiceDays > 0)?'Days':'Day';
							$Status1 = '<span class="label label-info">Overdue ( '.$ServiceDays.' '.$day.' )</span>';
							$Status3 = "Due";
						}	
						if($ServiceD == $today  ){
							$Status1 = '<span class="label label-info">Due Today</span>';
							$Status3 = "Due";
						}
						if($ServiceD > $today  ){
							$day = ($ServiceDays > 0)?'Days':'Day';
							$Status1 = '<span class="label label-info">Due in  '.$ServiceDays.' '.$day.' </span>';
							$Status3 = "Due";
						}
					}
					$daycount = 0 ;
					
					if($TicketCount > 0){
					  $ticket_no = $TicketData[0]->ticket_no;
					  $case_type = $TicketData[0]->case_type;
					  //echo "<pre>";print_r($case_type);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
					  switch($case_type){
						case '60':
							$Status = '<span class="label label-danger">Schedule</span>'.' <span class="label label-primary" title="Ticket Number">'.$ticket_no.'</span>';
							
							$Status2 = "Schedule";
						break;
						case '70':
							$Status = '<span class="label label-danger">Condem</span>'.' <span class="label label-primary" title="Ticket Number">'.$ticket_no.'</span>';
							$Status2 = "Condem";
						break;	
						case '90':
							$Status = '<span class="label label-danger">Breakdown</span>'.' <span class="label label-danger" title="Ticket Number">'.$ticket_no.'</span>';
							$Status2 = "Breakdown";
						break;						  
					  }
					}else{
						if($daycount == 0 || $daycount < 0){
							$Status = '<span class="label label-success">Active</span>';
							$Status2 = "Due for service";
						}else{
							$Status = '<span class="label label-success">Active</span>';		$Status2 = "Active";
						}
					}
					$UserDataNew =  $this->Shops_model->GetShopUserName($value->shop_id);
					if(isset($UserDataNew)){
					$UserInfoData =  $this->Users_model->GetUserDataByID($UserDataNew->user_info_id);
					$UserShopName = $UserInfoData[0]->user_f_name.' '.$UserInfoData[0]->user_l_name; 
					}else{
					  $UserShopName = "";
					}
					/* ======Section Name===== */
					$UserDataNewS =  $this->Reports_model->GetSectionUserName($value->section_id);
					if(isset($UserDataNewS)){
					$UserDataNewS =  $this->Users_model->GetUserDataByID($UserDataNewS->user_info_id);
					if($UserDataNewS){
					$UserSectionName = $UserDataNewS[0]->user_f_name.' '.$UserDataNewS[0]->user_l_name; 
					}
					}else{
					  $UserSectionName = "";
					}					
					/* ======Section Name===== */
					
					$shopData = $this->Shops_model->getShopBy($value->shop_id);
					$shopname = '';
					if(isset($shopData)){
						$shopname = $shopData->shop_name;
					}
					
					/* ==========Get Age ========== */
					if(!empty($value->start_date)){	
						$date3 = date('y-m-d');
						$date4 = $value->start_date;

						$diff1 = abs(strtotime($date3) - strtotime($date4));
						$years1 = floor($diff1 / (365*60*60*24));
						$months1 = floor(($diff1 - $years1 * 365*60*60*24) / (30*60*60*24));
						$ageDays = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24)/ (60*60*24));					
					}
					/* ==========Get Age ========== */
				?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td  ><?php echo isset($shopname)?$shopname:''; ?></td>
					<td><?php if($value->section_id != 0) { echo $this->Sections_model->getSectionByID($value->section_id)->section_name; }  ?></td>
					
					<td><?php echo isset($UserSectionName)?$UserSectionName:''; ?></td>
					<td><?php echo isset($value->hardware_serial_no)?$value->hardware_serial_no:''; ?><?php echo isset($hardwareDataFull->hardware_model)? ' / '.$hardwareDataFull->hardware_model:''; ?><?php echo isset($hardwareDataFull->hardware_name)? ' / '.$hardwareDataFull->hardware_name:''; ?></td>
					<td>
						<?php 
							$hardware_category = isset($hardwareDataFull->hardware_category)?$hardwareDataFull->hardware_category:'';
							$categoryname = '';
							if(!empty($hardware_category)){
								$catdetail = $this->Categories_model->getCatById($hardware_category);	
								if(!empty($catdetail)){
									$categoryname = $catdetail->category_name;
								}
							}	
						echo $categoryname; ?>
					</td>
					<td><?php echo isset($hardwareType->hardware_type_name)?$hardwareType->hardware_type_name:''; ?></td>
					<td><?php echo $ServiceDate; ?></td>
					<td><?php echo $Status.' '.$Status1 ; ?></td>
					<td style="display:none;"><?php echo $Status2; ?></td>
					<td style="display:none;"><?php echo $Status3; ?></td>
					<td><?php 
						if($ageDays < 1 ){
							echo "> 1 yr";
						}else{
							echo $years1." yr";	
						}
					 ?></td>
				</tr>
				<?php 
					$counter++; } 
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
</div>

<!-- Modal for Ticket Log -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ticket Log </h4>
      </div>
      <div class="modal-body TicketData">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- /page content -->
<script type="text/javascript">
  
    $(document).ready(function() {
    $('#UserSectionTable').DataTable( {
		
		dom: 'Bfrtip',
        buttons: [
             'csv', 'excel'
        ],
		
        initComplete: function () {
            this.api().columns(2).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Select Section-</option></select>')
                    .appendTo( $('.FilterCustom2').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );


            this.api().columns(5).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Category-</option></select>')
                    .appendTo( $('.FilterCustom3').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );


            this.api().columns(1).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Shop Name-</option></select>')
                    .appendTo( $('.FilterCustom1').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            this.api().columns(9).every( function () {
                var column = this;
               
                var select = $('<select class="form-control"><option value="">- Status -</option></select>')
                    .appendTo( $('.FilterCustom4').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );			

        }
    } );
} );


  function GetHardwareData(Id){
      $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>report/gethardwaredata/'+Id,
            contentType: "application/x-www-form-urlencoded",
            dataType: "html",
            success: function (data) {
                //console.log(data.res_data);
                $('.TicketData').html(data);
                $('#myModal').modal('show');
                $('#ticketLogdatatable').DataTable();
       // location.reload();               
            },
            error: function (data) {
                console.log(data);
            }
        });
  }

</script>