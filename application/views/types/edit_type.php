<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="x_panel">
          <div class="x_title">
          	 <h2><?php echo $title; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
					<li><a class="add-new btn btn-primary" href="<?php echo base_url().'types';?>" title="Add New">Add New</a> 
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'type-form');
				echo form_open('types/editType/'.$editedId, $attributes); 
			?>
			<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('typeSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('typeSuccess'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('typeError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('typeError'); ?></h5>
              	<?php } ?>
              </div>
            </div>
            <div class="row">
           <!-- 	<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
							/*	$allParent 			= [];
								$allParent['0'] 	= 'Select Parent';
								foreach($typeData as $singleTypeData){
									$allParent[$singleTypeData->hardware_type_id] = $singleTypeData->hardware_type_name;
								}
								$parentId = '';
								
								echo form_dropdown('parent_type_id', $allParent, set_value('parent_type_id',$typeDataById->parent_type_id), 'class="form-control col-md-7 col-xs-12" id="parent_type_id"');
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
										'value' 			=> set_value('type_code',$typeDataById->hardware_type_code),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' => 'Type Code *',
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
										'value' 			=> set_value('type_name',$typeDataById->hardware_type_name),
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
									echo form_submit('update', 'Update', "class='btn btn-success'");
								?>
							</div>
						</div>
					</div>
				</div>
            </form>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Types'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($typeData)){
            ?>
            <table id="typedatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                	<th>S.No.</th>
                	
                  <th>Type Code</th>
                  <th>Type Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                	$counter = 1; 
                  foreach($typeData as $singleTypeData){
                  	$parent   	= (int)$singleTypeData->parent_type_id;
                  	$parentName = "";
                  	if($parent == 0){
                  		$parentName ="";
                  	}else{
                  		$parentNameBy = $this->Types_model->getTypeById($parent);
                  		$parentName 	= $parentNameBy->hardware_type_name;
                  	}
                    $code   		= $singleTypeData->hardware_type_code;
                    $name   		=	$singleTypeData->hardware_type_name;
                    $status   	= $singleTypeData->hardware_type_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $code; ?></td>
                    <td><?php echo $name; ?></td>
                    <td>
						<?php 
							switch ($status) {
							  case '1':
								echo "Active";
								break;
							   case '0':
								echo "Inactive";
								break;
							}
						?>
					</td>
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