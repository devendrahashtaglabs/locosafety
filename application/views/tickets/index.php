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
			<div class="row" style="margin-bottom:20px; ">
				<div class="col-md-2 FilterCustom4">
                </div>
                <div class="col-md-2 FilterCustom1">
                </div>
                <div class="col-md-2 FilterCustom2">
                </div> 
                <div class="col-md-2 FilterCustom3">
                </div>
            </div>
			<div class="table-responsive">
				<table id="ticketdatatable" class="table table-striped table-bordered">
				  <thead>
					<tr>
					  <th>S.No.</th>
					  <th>Ticket No</th>
					  <th>Serial No</th>
					  <th>Shop</th>
					  <th>Section</th>
					  <th>Hardware</th>
					  <th>Hardware Category</th>
					  <th>Raised Date</th>
					  <th>Raised By</th>
					  <th>Assign To</th>
					  <th>Issue Type</th>
					  <th>Ticket Status</th>
					  <th>Action</th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					 if(!empty($ticketData)){
						$counter = 1; 
						foreach($ticketData as $singleTicketData){
							$shop_name 			= $singleTicketData->shop_name;            
							$section_name 		= $singleTicketData->section_name;         
							$hardware_name 		= $singleTicketData->hardware_name;        
							$ticket_no 			= $singleTicketData->ticket_no;        
							$hardware_serial_no	= $singleTicketData->hardware_serial_no;        
							$hardware_category_id	= $singleTicketData->hardware_category; 
							$categoryData 		= $this->Categories_model->getCatById($hardware_category_id);
							$hardware_category	= '';
							if(isset($categoryData)){
								$hardware_category = $categoryData->category_name;
							}					
							$ticket_raise_date 	= '';
							if(!empty($singleTicketData->tickets_created_date)){
								$date 				= date_create($singleTicketData->tickets_created_date);
								$ticket_raise_date 	= date_format($date,"d M Y");
							}
							$fname 	= $singleTicketData->user_f_name;               
							$lname 	= $singleTicketData->user_l_name;
							$userName = $fname.' '.$lname;
							$maintenance_shop_id 	= $singleTicketData->maintenance_shop_id;        
							$maintenance_section_id = $singleTicketData->maintenance_section_id;        
							$assignToData 	= $this->Tickets_model->getmaintenanceuser($maintenance_shop_id,$maintenance_section_id);
							$assignToUser  	= '';
							if(isset($assignToData)){
								$assignToUser = $assignToData->user_f_name . ' ' . $assignToData->user_l_name;
							}              
							
					?>
					  <tr>
						<td><?php echo $counter; ?></td>
						<td><?php echo isset($ticket_no)?$ticket_no:''; ?></td>
						<td><?php echo isset($hardware_serial_no)?$hardware_serial_no:''; ?></td>
						<td><?php echo isset($shop_name)?$shop_name:''; ?></td>
						<td><?php echo isset($section_name)?$section_name:''; ?></td> 
						<td><?php echo isset($hardware_name)?$hardware_name:''; ?></td> 
						<td><?php echo isset($hardware_category)?$hardware_category:''; ?></td> 
						<td><?php echo isset($ticket_raise_date)?$ticket_raise_date:''; ?></td> 
						<td><?php echo isset($userName)?$userName:''; ?></td> 
						<td><?php echo isset($assignToUser)?$assignToUser:''; ?></td> 
						<td>
							<?php 
								if(isset($singleTicketData->case_type)){
									$case_type 	= $singleTicketData->case_type;								
									switch($case_type){
										case '60':
											echo "Under Maintenance";
										break;
										case '70':
											echo "Condem";
										break;
										case '90':
											echo "Break Down";
										break;
									}
								}
							?>
						</td> 
						<td>
							<?php 
								if(isset($singleTicketData->ticket_status)){
									$ticket_status 	= $singleTicketData->ticket_status; 
									switch($ticket_status){
										case '20':
											echo "Open";
										break;
										case '50':
											echo "Closed";
										break;
									}
								}
							?>
						</td> 
						<td><a href="javascript:void(0)" onclick="GetTicketLogData('<?php echo  $singleTicketData->ticket_no;  ?>');" class="btn-sm btn-info">View</a></td>
					  </tr>
					<?php $counter++; } ?>					
					<?php } ?>
				  </tbody>
				</table>
			</div>
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->


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
<script type="text/javascript">
  
    $(document).ready(function() {
    $('#ticketdatatable').DataTable( {
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		order: [[ 11, 'desc' ]],
		responsive: false,
        initComplete: function () {
			
			/****** Shop Filter Start******/
            this.api().columns(3).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Select Shop-</option></select>')
                    .appendTo( $('.FilterCustom1').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        ); 
                        column.search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );				
								
                column.data().unique().sort().each( function ( d, j ) {
					if(d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			/****** Shop Filter End******/
			
			/****** Section Filter Start******/
            this.api().columns(4).every( function () {
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
					if(d != ''){
                    select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			/****** Section Filter End******/	
			
			/****** Category Filter Start******/
            this.api().columns(6).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Select Category-</option></select>')
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
					if(d != ''){
                    select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			/****** Category Filter End******/
			
			/****** Status Filter Start******/
			this.api().columns(11).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Select Status-</option><option value="">All</option></select>')
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
					if(d != ''){
						if(d == 'Open'){
							select.append( '<option value="'+d+'" selected>'+d+'</option>' )
						}else{
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					}
                } );
            } );
			/****** Status Filter End******/
        }
    } );
} );
  function GetTicketLogData(Id){
      $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>tickets/getticketlog/'+Id,
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