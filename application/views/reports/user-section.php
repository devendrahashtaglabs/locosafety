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
            </div>

            <table id="UserSectionTable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>User Detail</th>
                  <th>Shop Name</th>
                  <th>Section Name</th>
                  <th>Maintenance Shop</th>
                  <th>Maintenance Section</th>                  
                  <th>Hardware Count</th>
                  <th>User Status</th>
                </tr>
              </thead>
              <tbody>
				<?php 
					if(!empty($UserSectionData)){ 
                                                                                        
						$counter = 1;	
						foreach ($UserSectionData as $key => $value) {
						//$UserData 	= $this->Users_model->getAdmin($value->user_info_id)[0];
						$UserData 	= $this->Users_model->GetUserDataByID($value->user_info_id)[0];
						$shop_name 	= ''; 
						if(!empty($value->shop_id)){
							$shopDetail = $this->Shops_model->getShopBy($value->shop_id);
							if(!empty($shopDetail)){
								$shop_name = $shopDetail->shop_name;
							}
						}
						$maintenance_shop_name 	= ''; 
						if(!empty($value->maintenance_shop_id)){
							$mShopDetail = $this->Maintenance_shops_model->getMShopBy($value->maintenance_shop_id);
							if(!empty($mShopDetail)){
								$maintenance_shop_name = $mShopDetail->maintenance_shop_name;
							}
						}
						$maintenance_section_name = '';
                                                
						if(!empty($value->maintenance_section_id)){
                                                    
							$maintenance_section = $this->Maintenance_sections_model->getMSectionBy($value->maintenance_section_id);
							if(!empty($maintenance_section)){
								$maintenance_section_name = $maintenance_section->maintenance_section_name;
							}
						}
						$section_name = '';
						if($value->section_id != 0) { 
							$sectionDetail = $this->Sections_model->getSectionByID($value->section_id);
							if(!empty($sectionDetail)){
								$section_name = $sectionDetail->section_name;
							}
						} 
						
						$allMapping = $this->Users_model->getAssignSectionInfo($value->user_info_id);					
						/* ============ */
						$UserD = $this->Users_model->getUserByIdUSerID($UserData->user_info_id);
						
						$section_name = '';
							/* print_r($UserD->user_role);
							exit; */
						if($UserD->user_role == 5){	
						$sectionArry =array();
						foreach($allMapping as $row){
							$sectionID 		=  $row->section_id;
							$section 		= $this->Sections_model->getSectionByID($sectionID);
						
							$section_name 	= $section->section_name;
							array_push($sectionArry,$section_name);
						}
						$sectionArry = implode(', ',$sectionArry);
						if(count($sectionArry) > 0){
							$section_name = $sectionArry;
						}
						/* ============ */
						}
						
						
						$name 	= $UserData->user_f_name.' '.$UserData->user_l_name;
						$mobile = $value->user_mobile;
						$email 	= $value->user_email;
						
				?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td><?php echo isset($name)?$name:'';echo ' : [';echo isset($mobile)?$mobile:''; echo ']'; echo '<br/>';echo isset($email)?$email:'';?></td>
					<td><?php echo isset($shop_name)?$shop_name:''; ?></td>
					<td><?php echo isset($section_name)?$section_name:''; ?></td>
					<td><?php echo isset($maintenance_shop_name)?$maintenance_shop_name:''; ?></td>
					<td><?php echo isset($maintenance_section_name)?$maintenance_section_name:''; ?></td>
					<?php /*
					<td>      
					<?php if(count($this->Hardwares_model->getHardwareDataBySectionID($value->section_id)) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->section_id; ?>' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataBySectionID($value->section_id)); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataBySectionID($value->section_id)); ?></a>
					<?php } ?>
					</td>
					*/ ?>
					<?php if(!empty($value->section_id)){ ?>
					<td>      
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->section_id,'section_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->section_id; ?>','section_id');"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->section_id,'section_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->section_id,'section_id')); ?></a>
					<?php } ?>
					</td>
					<?php }elseif(!empty($value->shop_id)){ ?>
					<td> 
                                            
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->shop_id,'shop_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->shop_id; ?>','shop_id' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->shop_id,'shop_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->shop_id,'shop_id')); ?></a>
					<?php } ?>
					</td>
					<?php } if(!empty($value->maintenance_section_id)){ ?>
					<td> 
                                            
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_section_id,'maintenance_section_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->maintenance_section_id; ?>','maintenance_section_id' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_section_id,'maintenance_section_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_section_id,'maintenance_section_id')); ?></a>
					<?php } ?>
					</td>
					<?php }elseif(!empty($value->maintenance_shop_id)){ ?>
					<td>      
					<?php if(count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_shop_id,'maintenance_shop_id')) > 0){ ?>      
					  <a href="#" onclick="GetHardwareData('<?php echo $value->maintenance_shop_id; ?>','maintenance_shop_id' );"  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_shop_id,'maintenance_shop_id')); ?></a>
					<?php  } else { ?>
						<a href="#" onclick=""  class="badge badge-info" ><?php echo count($this->Hardwares_model->getHardwareDataByShopID($value->maintenance_shop_id,'maintenance_shop_id')); ?></a>
					<?php } ?>
					</td>
					<?php } ?>
					<td>
						<?php 
							$status = $value->user_status;
							if(isset($status)){
								switch ($status) {
									case '10':
										echo "Active";
									break;
									case '80':
										echo "Inactive";
									break;
								}
							}
						?>
					</td>					
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
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3,4,5,6,7]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3,4,5,6,7]
			}
		}],
        initComplete: function () {
            this.api().columns(2).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Select Shop-</option></select>')
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


            this.api().columns(3).every( function () {
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
/*

            this.api().columns(1).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Select Name-</option></select>')
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
            } );*/

        }
    } );
} );


  function GetHardwareData(Id,idType){	
      $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>report/gethardwaredata/'+Id,
            contentType: "application/x-www-form-urlencoded",
            dataType: "html",
            data: {'idType':idType},
            success: function (data) {
                //console.log(data.res_data);
                $('.TicketData').html(data);
                $('#myModal').modal('show');
                $('#ticketLogdatatable').DataTable();            
            },
            error: function (data) {
                console.log(data);
            }
        });
  }

</script>