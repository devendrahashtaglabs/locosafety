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
        <li><a class="add-new btn btn-primary" href="<?php echo base_url().'types';?>">Add New</a>
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
                <?php if(!empty($this->session->flashdata('updateType'))){ ?>
                  <h5 class="text-success"><?php echo $this->session->flashdata('updateType'); ?></h5>
                <?php } ?>
                <?php if(!empty($this->session->flashdata('typeError'))){ ?>
                  <h5 class="text-danger"><?php echo $this->session->flashdata('typeError'); ?></h5>
                <?php } ?>
                <?php if(!empty($this->session->flashdata('errorType'))){ ?>
                  <h5 class="text-danger"><?php echo $this->session->flashdata('errorType'); ?></h5>
                <?php } ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-xs-12 bottom-buffer">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <?php 
                $allParent      = [];
                $allParent['0']   = 'Select Parent';
                foreach($typeData as $singleTypeData){
                  $allParent[$singleTypeData->type_id] = $singleTypeData->type_name;
                }
                $parentId = '';
                
                echo form_dropdown('parent_type_id', $allParent, set_value('parent_type_id',$typeDataById->parent_type_id), 'class="form-control col-md-7 col-xs-12" id="parent_type_id"');
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-xs-12 bottom-buffer">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <?php                 
                $data = array(
                    'name'        => 'type_code',
                    'id'          => 'type_code',
                    'value'       => set_value('type_code',$typeDataById->type_code),
                    'class'       => 'form-control col-md-7 col-xs-12',
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
                    'name'        => 'type_name',
                    'id'          => 'type_name',
                    'value'       => set_value('type_name',$typeDataById->type_name),
                    'class'       => 'form-control col-md-7 col-xs-12',
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
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
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
                  <th>Parent</th>
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
                    $parent     = (int)$singleTypeData->parent_type_id;
                    $parentName = "";
                    if($parent == 0){
                      $parentName ="";
                    }else{
                      $parentNameBy = $this->Types_model->getTypeBy($parent);
                      $parentName   = $parentNameBy->type_name;
                    }
                    $code       = $singleTypeData->type_code;
                    $name       = $singleTypeData->type_name;
                    $status     = $singleTypeData->type_status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $parentName; ?></td>
                    <td><?php echo $code; ?></td>
                    <td><?php echo $name; ?></td>
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
            <a href="<?php echo base_url('types/editType/'.$singleTypeData->type_id); ?>" class="edit"> Edit</a>
            <a href="<?php echo base_url('types/deleteType/'.$singleTypeData->type_id); ?>" onClick="return doconfirm();"class="inactive"> Inactivate </a>
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