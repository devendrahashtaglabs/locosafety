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
            	<li><a class="add-new btn btn-primary" href="<?php echo base_url().'users/addUser'; ?>">Add New</a></li> 
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          	<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('success'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
              	<?php }if(!empty($this->session->flashdata('error'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
              	<?php } ?>
              </div>
            </div>
			<div class="row">
				<div class="col-md-offset-10 col-md-2 col-xs-12 bottom-buffer">
					<form action="<?php echo base_url('users');?>" id="statusChnage" method="GET">
						
					</form>
				</div>
			</div>
            <table id="userdatatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Zone</th>
                  <th>Division</th>
                  <th>User Type</th>
                  <th>User Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				<?php 
				$i = 1;
				  foreach($userData as $alluser){
				  	$status = isset($alluser->user_status)?$alluser->user_status:'';			  
                ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $alluser->user_f_name." ".$alluser->user_l_name; ?></td>
					<td><?php echo $alluser->newzonename; ?></td>
					<td><?php echo $alluser->newdivisionname; ?></td>
					<td><?php echo $alluser->newrolename; ?></td>
					<td>
						<?php 
							switch ($status) {
								case '10':
									echo "Active";
								break;
								case '1':
									echo "Inactive";
								break;
								case '90':
									echo "Deleted";
								break;
							}
						?>
					</td>
					<td class="action">
					<a href="<?php echo base_url('users/editUser/'.$alluser->user_info_id); ?>" class="edit"> Edit </a>						
						<?php if($status != '10'){ ?>
							<a href="JavaScript:Void(0);" class="edit userinactive" > Active </a>
							<input type="hidden" class="inact" value="<?php echo $alluser->user_info_id ?>">
						<?php }else{ ?>
								<a href="JavaScript:Void(0);" class="inactive useractive" onclick="confirmbox()" id="<?php echo $alluser->user_info_id ?>"> Inactive </a>
						<?php } ?>
						<a href="<?php echo base_url('users/assignUser/'.$alluser->user_info_id); ?>" class="edit"> Assign </a>
					</td>
				</tr>
				<?php $i++; } ?> 
				
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('.useractive').click(function() {
  var txt;
  var r = confirm("Are you sure you want to deactivate this user");
  if (r) {
  	//alert('ok');
  	 var user_status = 1;
  	 var user_ids = (this.id);
		  	 $.ajax({
		        url: "<?php echo base_url(); ?>Users/index",
		        type : "POST",
		        dataType : "json",
		        data : {"user_status" : user_status,"user_ids" : user_ids },
		        success : function(data) {
		          //alert(data);
		        },
		        error : function(data) {
		            //alert(data);
		        }
		    });
		location.reload();
  } else {
  	//alert('cancel');
  }

});
});
</script>
<script>
$(document).ready(function(){
$('.userinactive').click(function(el) {
  var txt;
  var r = confirm("Are you sure you want to activate this user");
  if (r) {
  	//alert('okk');
  	 var user_status = 10;
  	 var user_ids = $(".inact").val();
     //alert(user_ids);
		  	 $.ajax({
		        url: "<?php echo base_url(); ?>Users/index",
		        type : "POST",
		        dataType : "json",
		        data : {"user_status" : user_status,"user_ids" : user_ids },
		        success : function(data) {
		          //alert(data);
		        },
		        error : function(data) {
		            //alert(data);
		        }
		    });
		location.reload();
  } else {
  	//alert('cancell');
  }

});
});
</script>

<!-- /page content -->