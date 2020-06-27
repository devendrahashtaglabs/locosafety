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
			<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('hardwareSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('hardwareSuccess'); ?></h5>
              	<?php }if(!empty($this->session->flashdata('hardwareError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('hardwareError'); ?></h5>
              	<?php } ?>
              </div>
            </div>
			<div class="row">
				<div class="col-md-1">
				<label>Filter : </label>
				</div>
				<div class="col-md-2 FilterCustom1">
				</div>
				<div class="col-md-offset-10 col-md-2 col-xs-12 bottom-buffer">
					
				
					<form action="<?php echo base_url('hardwares');?>" id="statusChnage" method="GET">
						<?php 
							/* $allStatus		= array(
								'all' 	=> 'All',
								'10' 	=> 'Active',
								'20' 	=> 'In Maintenance',
								'90' 	=> 'Inactive',
							);
							if($status === NULL){
								$status  = '10';
							}
							echo form_dropdown('searchByStatus', $allStatus,set_value('searchByStatus', $status), 'class="form-control pull-right" id="searchByStatus"'); */
						?>
					</form>
				</div>
			</div>
			<div class="table-responsive">
            <table id="hardwaredatatable1" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Hardware Name</th>
                  <th>Category / Type</th>
                  <th>Shop / Section</th>
                  <th>Serial No.</th>
                  <th>Model</th>
                  <th>Hardware Company</th>
                  <th>Hardware Age</th>
                  <th>Hardware Start Year</th>
                  <th>Status</th>
				  <?php if($loggedInUserDetail->user_role != '3'){ ?>
					<th>Action</th>
				  <?php } ?>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(!empty($hardwareData)){
					$counter = 1; 
					foreach($hardwareData as $singleHardwareData){
						$hardware_name 		= $singleHardwareData->hardware_name;
						$hardware_model 	= $singleHardwareData->hardware_model;
						$hardware_company 	= $singleHardwareData->hardware_company;
						$shop_name 			= $singleHardwareData->shop_name;
						$catId 				= $singleHardwareData->hardware_category;
						$catDetail	 		= $this->Categories_model->getCatById($catId);
						$hardware_category 	= $catDetail->category_name;
						$typeId 			= $singleHardwareData->hardware_type;
						$typeDetail	 		= $this->Types_model->getTypeById($typeId);
						$hardware_type 		= $typeDetail->hardware_type_name;
						$Status 			= $singleHardwareData->hardware_status;
						$mappingData		= $this->Hardwares_model->getHardwareMappingById($singleHardwareData->hardware_id);
						$sectionData		= $this->Sections_model->getSectionByID($singleHardwareData->section_id);
						$section_name 		= $sectionData->section_name;
						$mapping			= '';
						if(!empty($mappingData)){
							$mapping			= count($mappingData);
						}
						//$hwstatus 				= "";
						$hardware_status 		= $singleHardwareData->map_status;
						if(!empty($hardware_status)){
							$hardware_status	= $this->Hardwares_model->getHardwareStatus($hardware_status);
							//echo "<pre>";print_r($hardware_status);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
							if(isset($hardware_status)){
								$hwstatus 		= $hardware_status->status;
							}
						}
						$hw_start_date = '' ;
						if(isset($singleHardwareData->start_date)){
							$start_date = $singleHardwareData->start_date;
							$start_date = date_create($start_date);
							$hw_start_date = date_format($start_date,'Y');
						}
						$hardware_serial_no = '' ;
						if(isset($singleHardwareData->hardware_serial_no)){
							$hardware_serial_no = $singleHardwareData->hardware_serial_no;
						}
						//echo "<pre>";print_r($singleHardwareData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						$date1 = strtotime($singleHardwareData->start_date);  
						$date2 = strtotime(date("Y-m-d"));  
						  
						// Formulate the Difference between two dates 
						$diff = abs($date2 - $date1);  
						  
						  
						// To get the year divide the resultant date into 
						// total seconds in a year (365*60*60*24) 
						$years = floor($diff / (365*60*60*24));  	
						if($years == 0){
							$years = " >1 yr"; 
						}else{
							$years = $years.' yr';
						}
						
						
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($hardware_name)?$hardware_name:''; ?></td>
					<td><?php echo isset($hardware_category)?$hardware_category:'';echo ' / '; echo isset($hardware_type)?$hardware_type:''; ?></td>
					<td><?php echo isset($shop_name)?$shop_name:'';echo ' / '; echo isset($section_name)?$section_name:''; ?></td>
                    <td><?php echo isset($hardware_serial_no)?$hardware_serial_no:''; ?></td>
                    <td><?php echo isset($hardware_model)?$hardware_model:''; ?></td>
                    <td><?php echo isset($hardware_company)?$hardware_company:''; ?></td>
                    <td><?php echo isset($years)?$years:''; ?></td>
                    <td><?php echo isset($hw_start_date)?$hw_start_date:''; ?></td>
                    <td><?php echo isset($hwstatus)?$hwstatus:''; ?></td>
					<?php if($loggedInUserDetail->user_role != '3'){ ?>
					<td class="division-action">
						<?php //if($Status == '10'){ ?>
							<a href="<?php echo base_url('hardwares/viewHardwareMap/'.$singleHardwareData->map_id); ?>" class="view" title="View"> View </a>
							<?php if($loggedInUserDetail->user_role != '3'){ ?>
								<a href="<?php echo base_url('hardwares/editHardwareMap/'.$singleHardwareData->map_id); ?>" class="edit" title="Edit"> Edit </a> 
							<?php } ?>
							<?php /*<a href="<?php echo base_url('hardwares/deleteHardware/'.$singleHardwareData->hardware_id); ?>" onClick="return doconfirm();" class="inactive" title="Inactive"> Inactive </a> */?>
						<?php //}else{ ?>
							<?php /*<a href="<?php echo base_url('hardwares/viewHardware/'.$singleHardwareData->hardware_id); ?>" class="edit" title="Active"> Active </a>*/?>
						<?php //} ?>
					</td>
					<?php } ?>
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
<!-- /page content -->
<script>
	
$(function(){
	$('#hardwaredatatable1').DataTable({				
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
		}],
		initComplete: function () {
            this.api().columns(9).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Status-</option></select>')
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
					if(d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
		}
	});
});
</script>