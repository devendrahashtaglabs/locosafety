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
                <li><a class="add-new btn btn-primary" href="<?php echo base_url().'divisions';?>">Add New</a> 
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
                $attributes = array('class' => 'form-horizontal form-label-left','id' => 'division-form');
                echo form_open('divisions/editDivision/'.$editedId, $attributes); 
            ?>
            <div class="row">
                <div class="col-md-12 col-xs-12 bottom-buffer">
                    <?php if(!empty($this->session->flashdata('updateDivision'))){ ?>
                        <h5 class="text-success"><?php echo $this->session->flashdata('updateDivision'); ?></h5>
                    <?php } ?>
                    <?php if(!empty($this->session->flashdata('errorDivision'))){ ?>
                        <h5 class="text-danger"><?php echo $this->session->flashdata('errorDivision'); ?></h5>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-12 bottom-buffer">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php 
                                $division_code = $divisionDataById->division_code;
                                if(empty($division_code)){
                                    $division_code ="";
                                }
                                $data = array(
                                        'name'              => 'division_code',
                                        'id'                => 'division_code',
                                        'value'             => set_value('division_code',$division_code),
                                        'class'             => 'form-control col-md-7 col-xs-12',
                                        'placeholder'       => 'Division Code *',
                                );
                                echo form_input($data);
                                echo form_error('division_code', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 bottom-buffer">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php 
                                $division_name = $divisionDataById->division_name;
                                if(empty($division_name)){
                                    $division_name ="";
                                }
                                $data = array(
                                        'name'              => 'division_name',
                                        'id'                => 'division_name',
                                        'value'             => set_value('division_name',$division_name),
                                        'class'             => 'form-control col-md-7 col-xs-12',
                                        'placeholder'       => 'Division Name *',
                                );
                                echo form_input($data);
                                echo form_error('division_name', '<div class="error">', '</div>');
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
            </form>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo 'Divisions'; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($divisionData)){
            ?>
            <table id="divisiondatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                    <th>S.No.</th>
                  <th>Zone Code</th>
                  <th>Zone Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    $counter = 1; 
                  foreach($divisionData as $singleDivisionData){
                    $code           = $singleDivisionData->division_code;
                    $name           =   $singleDivisionData->division_name;
                    $status     = $singleDivisionData->status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo isset($code)?$code:''; ?></td>
                    <td><?php echo isset($name)?$name:''; ?></td>
                    <td><?php 
                        switch ($status) {
                          case '1':
                            echo "Active";
                            break;
                           case '0':
                            echo "Not Active";
                            break;
                        }
                    ?></td>
                    <td><a href="<?php echo base_url('divisions/editDivision/'.$singleDivisionData->division_id); ?>"><i class="fa fa-pencil-square-o"></i></a>   <a href="<?php echo base_url('divisions/deleteDivision/'.$singleDivisionData->division_id); ?>" onClick="return doconfirm();"><i class="fa fa-trash-o"></i></a></td>
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