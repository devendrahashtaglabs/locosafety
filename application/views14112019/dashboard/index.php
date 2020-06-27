<div class="right_col" role="main">
    <div class="row top_tiles">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php if(!empty($this->session->flashdata('loginSuccess'))){ ?>
              <h5 class="text-success"><?php echo $this->session->flashdata('loginSuccess'); ?></h5>
            <?php } ?>
        </div>
    </div>
    <div class="row top_tiles"> 
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user"></i></div>
           <?php if(!empty($userCount)){ ?>
            <div class="count"><a href="<?php echo base_url().'users'; ?>"><?php echo $userCount; ?></a></div>
           <?php } ?>
          <h3><a href="<?php echo base_url().'users'; ?>">Total Users</a></h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><img src="<?php echo base_url('assets/dashboard/images/hardware-icon.png'); ?>" class="hardware-icon"/></div>
            <?php if(!empty($hardwareCount)){ ?>
                <div class="count"><a href="<?php echo base_url().'hardwares'; ?>"><?php echo $hardwareCount; ?></a></div>
            <?php } ?>
            <h3><a href="<?php echo base_url().'hardwares'; ?>">Total Hardwares</a></h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="glyphicon glyphicon-shopping-cart"></i></div>
            <?php if(!empty($shopCount)){ ?>
                <div class="count"><a href="<?php echo base_url().'shops'; ?>"><?php echo $shopCount; ?></a></div>
            <?php } ?>
            <h3><a href="<?php echo base_url().'shops'; ?>">Total Shops</a></h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-bars"></i></div>
            <?php if(!empty($sectionCount)){ ?>
                <div class="count"><a href="<?php echo base_url().'sections'; ?>"><?php echo $sectionCount; ?></a></div>
            <?php } ?>
            <h3><a href="<?php echo base_url().'sections'; ?>">Total Sections</a></h3>
        </div>
      </div>
    </div>
    <div class="row top_tiles"> 
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><img src="<?php echo base_url('assets/dashboard/images/maintenance-icon.png'); ?>" class="maintenance-icon"/></div>
            <?php if(!empty($hmCount)){ ?> 
                <div class="count"><a href="<?php echo base_url().'hardwares'; ?>"><?php echo $hmCount; ?></a></div>
            <?php } ?>
            <h3><a href="<?php echo base_url().'hardwares?searchByStatus=20'; ?>">Hardware In Maintenance</a></h3>
        </div> 
      </div>
    </div>
</div>

