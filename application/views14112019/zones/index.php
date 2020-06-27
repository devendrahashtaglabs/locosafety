<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
             <h2><?php echo "Add New Zone"; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 
        $attributes = array('class' => 'form-horizontal form-label-left','id' => 'zone-form');
        echo form_open('zones', $attributes); 
      ?>
      <div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
                <?php if(!empty($this->session->flashdata('zoneSuccess'))){ ?>
                  <h5 class="text-success"><?php echo $this->session->flashdata('zoneSuccess'); ?></h5>
                <?php } ?>
                <?php if(!empty($this->session->flashdata('deleteType'))){ ?>
                  <h5 class="text-success"><?php echo $this->session->flashdata('deleteType'); ?></h5>
                <?php } ?>
                <?php if(!empty($this->session->flashdata('zoneError'))){ ?>
                  <h5 class="text-danger"><?php echo $this->session->flashdata('zoneError'); ?></h5>
                <?php } ?>
              </div>
            </div>
            <div class="row">
        <div class="col-md-4 col-xs-12 bottom-buffer">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <?php                 
                $data = array(
                    'name'        => 'zone_code',
                    'id'          => 'zone_code',
                    'value'       => set_value('zone_code'),
                    'class'       => 'form-control col-md-7 col-xs-12',
                    'placeholder' => 'Zone Code *',
                );
                echo form_input($data);
                echo form_error('zone_code', '<div class="error">', '</div>');
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-xs-12 bottom-buffer">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <?php                 
                $data = array(
                    'name'        => 'zone_name',
                    'id'          => 'zone_name',
                    'value'       => set_value('zone_name'),
                    'class'       => 'form-control col-md-7 col-xs-12',
                    'placeholder' => 'Zone Name *',
                );
                echo form_input($data);
                echo form_error('zone_name', '<div class="error">', '</div>');
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-xs-12 bottom-buffer">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <?php 
                echo form_submit('submit', 'Submit', "class='btn btn-success'");
                echo form_reset(array('class'=>'btn btn-danger','id'=>'reset','value'=>"Reset"));
              ?>
              <input type="button" class="btn btn-primary" value="Cancel" onclick="location.href='<?php echo base_url();?>zones'">
            </div>
          </div>
        </div>
      </div>
            </form>
          </div>
        </div>
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $title; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php 
              if(!empty($zoneData)){
            ?>
            <table id="zonedatatable" class="table table-striped table-bordered">
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
                  foreach($zoneData as $singleZoneData){
                    $code       = $singleZoneData->zone_code;
                    $name       = $singleZoneData->zone_name;
                    $status     = $singleZoneData->status;
                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $code; ?></td>
                    <td><?php echo $name; ?></td>
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
                     <td><a href="<?php echo base_url('zones/editZone/'.$singleZoneData->zone_id); ?>"><i class="fa fa-pencil-square-o"></i></a>   <a href="<?php echo base_url('zones/deleteZone/'.$singleZoneData->zone_id); ?>" onClick="return doconfirm();"><i class="fa fa-trash-o"></i></a></td>
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