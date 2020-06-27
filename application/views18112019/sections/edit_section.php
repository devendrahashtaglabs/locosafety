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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'sections';?>">Add New</a>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'section-form');
				echo form_open('sections/editSection/'.$editedId, $attributes); 
			?>
			<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('updateSection'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('updateSection'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('errorSection'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('errorSection'); ?></h5>
              	<?php } ?>
              </div>
            </div>
            <div class="row">
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php
								$allShop         = [];
								$allShop['0']    = 'Select Shop';
								foreach($shopData as $singleShopList){
									$allShop[$singleShopList->shop_id] = $singleShopList->shop_name;
								}                    
								echo form_dropdown('shop_id', $allShop, set_value('shop_id',$sectionDataById->shop_id), 'class="form-control col-md-7 col-xs-12" id="shop_id"');
							?>
						</div>
					</div>
				</div>
			<div class="col-md-3 col-xs-12 bottom-buffer">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php 								
							$data = array(
									'name'  			=> 'section_code',
									'id'    			=> 'section_code',
									'value' 			=> set_value('section_code',$sectionDataById->section_code),
									'class' 			=> 'form-control col-md-7 col-xs-12',
									'placeholder' => 'Section Code *',
							);
							echo form_input($data);
							echo form_error('section_code', '<div class="error">', '</div>');
						?>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-12 bottom-buffer">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php 								
							$data = array(
									'name'  			=> 'section_name',
									'id'    			=> 'section_name',
									'value' 			=> set_value('section_name',$sectionDataById->section_name),
									'class' 			=> 'form-control col-md-7 col-xs-12',
									'placeholder' => 'Section Name *',
							);
							echo form_input($data);
							echo form_error('section_name', '<div class="error">', '</div>');
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
           <?php echo form_close(); ?>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Sections'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($sectionData)){
            ?>
            <table id="sectiondatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
					<th>S.No.</th>
					<th>Shop</th>
					<th>Section Code</th>
					<th>Section Name</th>
					<th>Status</th>
					<th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                	$counter = 1;
                  foreach($sectionData as $singleSectionData){
                  	$shop_id   		= $singleSectionData->shop_id;
                  	$shopDetails 	= $this->Shops_model->getShopBy($shop_id);
					$section_code   = $singleSectionData->section_code;
                    $name   		= $singleSectionData->section_name;
                    $status   		= $singleSectionData->section_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($shopDetails->shop_name)?$shopDetails->shop_name:''; ?></td>
                    <td><?php echo isset($section_code)?$section_code:''; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
                    <td>
						<?php 
							switch ($status) {
							  case '10':
								echo "Active";
								break;
							   case '90':
								echo "Not Active";
								break;
							}
						?>
					</td>
					<td class="action">
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('sections/editSection/'.$singleSectionData->section_id); ?>" class="edit"> Edit </a> 
							<a href="<?php echo base_url('sections/deleteSection/'.$singleSectionData->section_id); ?>" onClick="return doconfirm();" class="inactive"> Inactive </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('sections/activateSection/'.$singleSectionData->section_id); ?>" class="edit"> Active </a>
						<?php } ?>
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