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
				<li><a class="add-new btn btn-primary" href="<?php echo base_url().'categories';?>">Add New</a>
				</li>
			</ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
				$attributes = array('class' => 'form-horizontal form-label-left','id' => 'category-form');
				echo form_open('categories/editCat/'.$editedId, $attributes); 
			?>
            <div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
                <?php if(!empty($this->session->flashdata('updateCategory'))){ ?>
                  <h5 class="text-success"><?php echo $this->session->flashdata('updateCategory'); ?></h5>
                <?php } ?>
                <?php if(!empty($this->session->flashdata('error'))){ ?>
                  <h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
                <?php } ?>
              </div>
            </div>
            <div class="row">
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								$parent_category_id = $catDataById->parent_category_id;
								if(empty($parent_category_id)){
									$parent_category_id = "";
								}
								$allParent 			= [];
								$allParent['0'] 	= 'Select Parent';
								foreach($catData as $singleCatData){
									$allParent[$singleCatData->id] = $singleCatData->category_name;
								}
								echo form_dropdown('parent_category_id', $allParent, set_value('parent_category_id',$parent_category_id), 'class="form-control col-md-7 col-xs-12" id="parent_category_id"');
							?>
						</div>
					</div>
				</div>	
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 
								$category_code = $catDataById->category_code;
								if(empty($category_code)){
									$category_code = "";
								}
								$data = array(
										'name'  			=> 'category_code',
										'id'    			=> 'category_code',
										'value' 			=> set_value('category_code',$category_code),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' => 'Category Code *',
								);
								echo form_input($data);
								echo form_error('category_code', '<div class="text-danger">', '</div>');
							?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-12 bottom-buffer">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php 								
								$data = array(
										'name'  			=> 'category_name',
										'id'    			=> 'category_name',
										'value' 			=> set_value('category_name',$catDataById->category_name),
										'class' 			=> 'form-control col-md-7 col-xs-12',
										'placeholder' => 'Category Name *',
								);
								echo form_input($data);
								echo form_error('category_name', '<div class="text-danger">', '</div>');
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
            <h2><?php echo 'Categories'; ?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($catData)){
            ?>
            <table id="categorydatatable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Parent</th>
						<th>Category Code</th>
						<th>Category Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
                <?php 
                	$counter = 1; 
                  foreach($catData as $singleCatData){
                  	$parent   	= (int)$singleCatData->parent_category_id;
                  	$parentName = "";
                  	if($parent == 0){
                  		$parentName ="";
                  	}else{
                  		$parentNameBy = $this->Categories_model->getCategoryBy($parent);
                  		$parentName 	= $parentNameBy->category_name;
                  	}
                    $code   		= $singleCatData->category_code;
                    $name   		=	$singleCatData->category_name;
                    $status   	= $singleCatData->category_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($parentName)?$parentName:''; ?></td>
                    <td><?php echo isset($code)?$code:''; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
                    <td>
						<?php 
							switch ($status) {
							  case '1':
								echo "Active";
								break;
							   case '0':
								echo "Not Active";
								break;
							}
						?>
					</td>
                    <td class="action">
						<a href="<?php echo base_url('categories/editCat/'.$singleCatData->id); ?>" class="edit"> Edit </a>
						<a href="<?php echo base_url('categories/deleteCat/'.$singleCatData->id); ?>" onClick="return doconfirm();"class="inactive"> Inactivate </a>
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