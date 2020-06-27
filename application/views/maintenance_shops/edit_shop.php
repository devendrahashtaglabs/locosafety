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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'maintenance_shops';?>" title="Add New" title="Add New">Add New</a>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'shop-form');
				echo form_open('maintenance_shops/editMshop/'.$editedId, $attributes);  
			?>
						<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('shopSuccess'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('shopSuccess'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('shopError'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('shopError'); ?></h5>
              	<?php } ?>
              </div>
            </div>
            <div class="row">
				<div class="col-md-4 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								$maintenance_shop_name = ''; 
								if(!empty($mShopDataById)){
									$maintenance_shop_name = $mShopDataById->maintenance_shop_name;
								}
								$data = array(
										'name'  			=> 'maintenance_shop_name',
										'id'    			=> 'maintenance_shop_name',
										'value' 			=> set_value('maintenance_shop_name',$maintenance_shop_name),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' 		=> 'Maintenance Shop Name *',
								);
								echo form_input($data);
								echo form_error('maintenance_shop_name', '<div class="error">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								echo form_submit('update', 'Update', "class='btn btn-success'");
							?>
                                                        <a href="<?php echo base_url().'maintenance_shops/editMshop/'.$editedId.'/'; ?>" class="btn btn-danger"  >Reset</a>
						</div>
					</div>
				</div>
			</div>
           <?php form_close(); ?>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Maintenance Shops'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="shopdatatable" class="table table-striped table-bordered">
              <thead>
				<tr>
					<th>S.No.</th>
					<th>Maintenance Shop Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
              </thead>
              <tbody>
				<?php 
					if(!empty($mShopData)){ 
						$counter = 1;
						foreach($mShopData as $singleMshopData){
							$name   = $singleMshopData->maintenance_shop_name;
							$status = $singleMshopData->maintenance_shop_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
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
					<td class="action">
						<?php if($status == '10'){ ?>
							<a href="<?php echo base_url('maintenance_shops/editMshop/'.$singleMshopData->maintenance_shop_id); ?>" class="edit" title="Edit"> Edit </a> 
							<a href="<?php echo base_url('maintenance_shops/deleteMshop/'.$singleMshopData->maintenance_shop_id); ?>" onClick="return doconfirmMsg('Are you sure to inactive this item?');" class="inactive" title="Inactive"> Inactive </a>
						<?php }else{ ?>
							<a href="<?php echo base_url('maintenance_shops/activateMshop/'.$singleMshopData->maintenance_shop_id); ?>" class="edit" title="Active" onClick="return doconfirmMsg('Are you sure to active this item?');"> Active </a>
						<?php } ?>
					</td>
                  </tr>
                <?php $counter++; } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->