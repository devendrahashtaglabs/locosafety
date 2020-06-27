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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'shops';?>" title="Add New">Add New</a>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'shop-form');
				echo form_open('shops/editShop/'.$editedId, $attributes);  
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
								$data = array(
										'name'  			=> 'shop_name',
										'id'    			=> 'shop_name',
										'value' 			=> set_value('shop_name',$shopDataById->shop_name),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' => 'Shop Name *',
								);
								echo form_input($data);
								echo form_error('shop_name', '<div class="error">', '</div>');
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
						</div>
					</div>
				</div>
			</div>
           <?php form_close(); ?>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Shops'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($shopData)){
            ?>
            <table id="datatable_shop" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Shop Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$counter = 1;
					  foreach($shopData as $singleShopData){
						$name   	= $singleShopData->shop_name;
						$status   	= $singleShopData->shop_status;
					?>
					<tr>
						<td><?php echo $counter; ?></td>
						<td><?php echo $name; ?></td>
						<td>
							<?php 
								switch ($status) {
									case '10':
										echo "Active";
									break;
									case '80':
										echo "Inctive";
									break;
								}
							?>
						</td>
						<td class="action">
							<?php if($status == '10'){ ?>
								<a href="<?php echo base_url('shops/editShop/'.$singleShopData->shop_id); ?>" class="edit" title="Edit"> Edit </a> 
								<a href="<?php echo base_url('shops/deleteShop/'.$singleShopData->shop_id); ?>" onClick="return doconfirmMsg('Are you sure to inactive this item?');" class="inactive" title="Inactive"> Inactive </a>
							<?php }else{ ?>
								<a href="<?php echo base_url('shops/activateShop/'.$singleShopData->shop_id); ?>" class="edit" title="Active" onClick="return doconfirmMsg('Are you sure to active this item?');"> Active </a>
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
<script>
	$(function(){
		$('#datatable_shop').DataTable({				
			dom: 'Bfrtip',
			buttons: [{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2]
				}
			},{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,2]
				}
			}],
			responsive: false
		});
	});
</script>