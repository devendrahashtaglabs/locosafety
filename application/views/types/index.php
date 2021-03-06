<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="x_panel">
		<?php 
			$loggedInUserDetail = $this->session->userdata('loggedInUserDetail'); 
			if($loggedInUserDetail->user_role != '3'){ ?>
          <div class="x_title">
          	<h2><?php echo "Add New Type"; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'type-form');
				echo form_open('types', $attributes); 
			?>
			<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('typeSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('typeSuccess'); ?></h5>
              	<?php } if(!empty($this->session->flashdata('deleteType'))){ ?>
              		<h5 class="text-success"><?php echo $this->session->flashdata('deleteType'); ?></h5>
              	<?php } if(!empty($this->session->flashdata('typeError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('typeError'); ?></h5>
              	<?php } ?>
              </div>
            </div>
            <div class="row">
           <!--
            	<div class="col-md-3 col-xs-12 bottom-buffer">
    				<div class="form-group">
    					<div class="col-md-12 col-sm-12 col-xs-12">
    						<?php 
    						/*	$allParent 			  = [];
    							$allParent['0'] 	= 'Select Parent';
    							foreach($typeData as $singleTypeData){

    								$allParent[$singleTypeData->hardware_type_id] = $singleTypeData->hardware_type_name;
    							}
    							echo form_dropdown('parent_type_id', $allParent, set_value('parent_type_id'), 'class="form-control col-md-7 col-xs-12" id="parent_type_id"');
                  */
    						?>
    					</div>
    				</div>
    			</div> -->
    			<div class="col-md-3 col-xs-12 bottom-buffer">
    				<div class="form-group">
    					<div class="col-md-12 col-sm-12 col-xs-12">
    						<?php 								
    							$data = array(
    									'name'  			=> 'type_code',
    									'id'    			=> 'type_code',
    									'value' 			=> set_value('type_code'),
    									'class' 			=> 'form-control col-md-7 col-xs-12',
    									'placeholder' 		=> 'Type Code *',
    							);
    							echo form_input($data);
    							echo form_error('type_code', '<div class="text-danger">', '</div>');
    						?>
    					</div>
    				</div>
    				</div>
    				<div class="col-md-3 col-xs-12 bottom-buffer">
    				<div class="form-group">
    					<div class="col-md-12 col-sm-12 col-xs-12">
    						<?php 								
    							$data = array(
    									'name'  			=> 'type_name',
    									'id'    			=> 'type_name',
    									'value' 			=> set_value('type_name'),
    									'class' 			=> 'form-control col-md-7 col-xs-12',
    									'placeholder' => 'Type Name *',
    							);
    							echo form_input($data);
    							echo form_error('type_name', '<div class="text-danger">', '</div>');
    						?>
    					</div>
    				</div>
    				</div>
    				<div class="col-md-3 col-xs-12 bottom-buffer">
    					<div class="form-group">
    						<div class="col-md-12 col-sm-12 col-xs-12">
	                  <?php 
	                      echo form_submit('submit', 'Submit', "class='btn btn-success'");
	                      echo form_reset(array('class'=>'btn btn-danger','id'=>'reset','value'=>"Reset"));
	                  ?>
    						</div>
    					</div>
    				</div>
    			</div>
            </form>
          </div>
			<?php } ?>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            
            <table id="typedatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
					<th>S.No.</th>
					<th>Type Code</th>
					<th>Type Name</th>
					<th>Status</th>
					<?php if($loggedInUserDetail->user_role != '3'){ ?>
						<th>Action</th>
					<?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php 
              if(!empty($typeData)){
            ?>
                <?php 
                	$counter = 1; 
                  foreach($typeData as $singleTypeData){
                  	$parent   	= (int)$singleTypeData->parent_type_id;
                  	$parentName = "";
                  	if($parent == 0){
                  		$parentName ="";
                  	}else{
                  		//$parentNameBy = $this->Types_model->getTypeBy($parent);
                      $parentNameBy = $this->Types_model->getType($parent);
                      if(!empty($parentNameBy->type_name)){
                        $parentName   = $parentNameBy->type_name;
                      }else{
                        $parentName   = '';
                      }
                  		
                  	}

                    if(!empty($singleTypeData->hardware_type_code)){
                      $code       = $singleTypeData->hardware_type_code;
                    }else{
                      $code       = '';
                    }
                    
                    if(!empty($singleTypeData->hardware_type_name)){
                      $name       = $singleTypeData->hardware_type_name;
                    }else{
                      $name       = '';
                    }

                    if(!empty($singleTypeData->hardware_type_status)){
                      $status       = $singleTypeData->hardware_type_status;
                    }else{
                      $status       = '';
                    }
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                   
                    <td><?php echo $code; ?></td>
                    <td><?php echo $name; ?></td>
                    <td>
						<?php 
							switch ($status) {
							  case '10':
								echo "Active";
								break;
							   case '80':
								echo "Inactive";
								break;
							}
						?>
					</td>	
					<?php if($loggedInUserDetail->user_role != '3'){ ?>
					<td class="action">
						<?php 
						  if($status == "10"){
						?>
									  <a href="<?php echo base_url('types/editType/'.$singleTypeData->hardware_type_id); ?>" class="edit" title="Edit"> Edit</a>
									  <a href="<?php echo base_url('types/deleteType/'.$singleTypeData->hardware_type_id); ?>" onClick="return doconfirmMsg('Are you sure to inactive this item?');" class="inactive" title="Inactivate"> Inactivate </a>
						<?php 
						  }else{
						?>
						  <a href="<?php echo base_url('types/activeType/'.$singleTypeData->hardware_type_id); ?>"  class="edit" class="Active"> Active </a>
						<?php
						  }
						?>
					</td>
					<?php } ?>
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
<!-- /page content -->