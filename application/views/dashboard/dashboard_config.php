<div class="right_col" role="main">

	
	<div class="x_panel">
	
		<div class="row">
              <div class="col-md-12 col-xs-12 bottom-buffer">
              	<?php if(!empty($this->session->flashdata('success'))){ ?>
                	<h5 class="text-success"><?php echo $this->session->flashdata('success'); ?></h5>
              	<?php } ?>
              	<?php if(!empty($this->session->flashdata('error'))){ ?>
              		<h5 class="text-danger"><?php echo $this->session->flashdata('error'); ?></h5>
              	<?php } ?>
            </div>
        </div>
		
	
		<div class="x_title">
			<h2>Dashboard Map</h2>
			<ul class="nav navbar-right panel_toolbox">
                            
<!--                            <a href="#" class="btn btn-info" type="button" data-toggle="modal" data-target="#MetaData" > JIB And EOT </a>
                            -->
			<?php 
				$MapImage = $this->Dashboard_model->GetMapImageByID();
				if(count($MapImage)== 0){
			?>
				<li><a class="add-new btn btn-primary" href="#"  type="button" data-toggle="modal" data-target="#InsertData" title="Map Image Upload">Insert Map Image</a></li> 

			<?php 
				}else{
			?>
				<li><a class="add-new btn btn-primary" href="#"  type="button" data-toggle="modal" data-target="#UpdateData" title="Map Image Upload">Update Map Data</a></li> 
			<?php
				}
			?>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
		<?php
                    if(!empty($MapImage)){
                    $row = 	$MapImage->row;
                    $column = $MapImage->column;
                    $BoxCount = $row*$column;
                    $boxWidth = 100/$column;
		?>		
		<style>
		.col-loco-1{
			width:<?php echo $boxWidth; ?>%;
			float:left;
		}
		.SelectedBox {
			background:#981212;
			color:#FFF;
		}
		.SelectedBox i {			
			margin-top: 5px;
			font-size: 25px;
		}
		</style>
		<div class="workshop-layout">
			<?php 
				$j = 1;
				for($j=1; $j <= $BoxCount; $j++) { 				
					$GetAllSectionData  = $this->Dashboard_model->GetMappingSection($j);
					if($GetAllSectionData){
						$SelectedClass 		= "SelectedBox";
						$SectionData  		= $this->Dashboard_model->getSectionByID($GetAllSectionData[0]->section_id);
						$Section_name		= "title= '".$SectionData->section_name."'";						
					}else{
						$SelectedClass = "";
						$Section_name = "";
					}
			?>
				<div class="col-loco-1 tooltip <?php echo $SelectedClass; ?>"  <?php echo $Section_name; ?> style="" <?php if($SelectedClass == ""){ ?> onclick="SetSectionOnMap('<?php echo $j ?>');"  <?php }else{ ?>  onclick="SetSectionOnMapDelete(<?php echo $GetAllSectionData[0]->section_id ?>)" <?php } ?> > 
					<div class="sectionBox" style=""  >
					
						<?php 						
							if($SelectedClass != ""){
								echo "<i class='fa fa-times'></i>";
							}
						?>
					
					</div>
				</div>				
			<?php 
				}
			?>
		</div>
		<?php 
			}else{
				echo "<center>No map found.</center>";
			}
		?>
		</div>
	</div>
</div>


<!----  Model Section Select Box  ---->

<!-- Modal -->
<div id="SelectSection" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form action="<?php echo base_url(); ?>dashboard/insertmapsection" method="Post" id="SetConfigDashboard" enctype="multipart/form-data" >
	<input type="hidden" name="section_pos" id="section_pos" value="" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Set Section </h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<label>
					Select Shop : 
				</label>
				<select class="form-control" id="hardware_shop_id" name="hardware_shop_id" >
					<option value=""> - Select shop - </option>
					<?php 
					if($shopData){
						foreach($shopData as $shopData){
					?>	
						<option value="<?php echo $shopData->shop_id; ?>"><?php echo $shopData->shop_name; ?></option>						
					<?php 
						}
					}
					?>
				</select>
			</div>	
			<div class="col-md-6">
				<label>
					Select Section : 
				</label>
				<select class="form-control" id="hardware_section_id" name="hardware_section_id" >
					<option value=""> - Select Section - </option>
					
				</select>
			</div>
		</div>	
      </div>
      <div class="modal-footer">
		<input type="submit" name="submit" class="btn btn-primary" id="submit" value="submit" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>

  </div>
</div>


<!----  Model Inser Box  ---->

<!-- Modal -->
<div id="InsertData" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form action="<?php echo base_url(); ?>dashboard/insertmapdata" method="Post" id="InsertSectionFrom" enctype="multipart/form-data" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Image Upload</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<label>
					Row : 
				</label>
				<input type="text" name="row" class="form-control" id="row" value="" />
			</div>	
			<div class="col-md-6">
				<label>
					Column : 
				</label>
				<input type="text" name="column" class="form-control" id="column" value="" />
			</div>	
			<div class="col-md-6">
				<label>
					Image :
				</label>
				<input type="file" name="imageN" class="form-control" id="imageN" value="" />
			</div>	
			<div class="col-md-6">
				
			</div>	
		</div>	
      </div>
      <div class="modal-footer">
		<input type="submit" name="submit" class="btn btn-primary" id="submit" value="submit" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>

  </div>
</div>


<!-- Modal -->
<div id="MetaData" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form action="<?php echo base_url(); ?>dashboard/updatemeta" id="UpdateSectionFrom" method="Post" enctype="multipart/form-data" >
            <?php
                 $metaData = $this->Dashboard_model->setting_meta_tbl('JIB_EOT_CAT_ID');
              
            ?>
	<input type="hidden" name="id" id="id" value="<?php echo $MapImage->id;?>" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Map Data</h4>
      </div>
      <div class="modal-body">
		<div class="row">
                    <div class="col-md-5">
                        <label>
                            Category (JIB And EOT) : 
                        </label>
                    </div>
                    <input type="hidden" name="meta_key" id="meta_key" value="JIB_EOT_CAT_ID" />
                    <input type="hidden" name="meta_id" id="meta_id" value="<?php if(!empty($metaData->meta_value)){ echo $metaData->meta_id;  } ?>" />
                    <div class="col-md-7">
                        <select class="form-control" name="meta_value" id="meta_value" >
                            <option>-Select Category-</option>
                            <?php
                                $catAll = $this->Categories_model->getAllCategory();
                                foreach($catAll as $cat){
                                    ?>
                                    <option <?php if(!empty($metaData->meta_value) &&  $metaData->meta_value == $cat->id ){ echo 'selected = "selected"';  } ?> value="<?php echo $cat->id ?>" > <?php echo $cat->category_name; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>	
			
		</div>	
      </div>
      <div class="modal-footer">
		<input type="submit" name="submit" class="btn btn-primary" id="submit" value="Update" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>

  </div>
</div>
<!----  Model Update Box  ---->

<!-- Modal -->
<div id="UpdateData" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form action="<?php echo base_url(); ?>dashboard/updatemeta" id="UpdateSectionFrom" method="Post" enctype="multipart/form-data" >
	<input type="hidden" name="id" id="id" value="<?php echo $MapImage->id;?>" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Map Data</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<label>
					Row : 
				</label>
				<input type="text" name="row" class="form-control" id="row" value="<?php echo $MapImage->row; ?>" />
			</div>	
			<div class="col-md-6">
				<label>
					Column : 
				</label>
				<input type="text" name="column" class="form-control" id="column" value="<?php echo $MapImage->column; ?>" />
			</div>	
			<div class="col-md-6">
				<label>
					Image :
				</label>
				<input type="file" name="image" class="form-control" id="image" value="" />
			</div>	
			<div class="col-md-6">
				</br>
				<img src="<?php echo base_url(); ?>uploads/dashboard/<?php echo $MapImage->image; ?>"  height="100px" />
			</div>	
		</div>	
      </div>
      <div class="modal-footer">
		<input type="submit" name="submit" class="btn btn-primary" id="submit" value="Update" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>

  </div>
</div>
<?php 
	if(!empty($MapImage)){
		$MapImgUrl = base_url().'uploads/dashboard/'.$MapImage->image;
	}else{
		$MapImgUrl = base_url().'assets/dashboard/images/layout.png';
	}

?>
	<style>
	.BoxDiv {
	border: solid 2px #999;
	text-align: center;
	}
	.BoxDiv > label {
	font-size: 16px;
	}
	.BoxDiv > h2 {
	padding-top:10px;
	font-size: 22px;
	}
	.tooltiptext .progress {
	height: 10px;
	}
	</style>
	<style type="text/css">	
	.SectionName{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.flt{
		float:left;
	}
	.black_color{
		background:rgba(0,0,0,0.9);
	}
	.shopBox {
		border: red 1px solid;	
		padding:0px; 	
	}
	.sectionBox {
		height: 36px;
		//color:#fff;
		/*opacity: 0.6;*/
		text-align: center;
	}
	.workshop-layout {	
	background: #fff url(<?php echo $MapImgUrl; ?>) no-repeat;
	background-size: 100% 100%;
	width: 100%;
	/* height: auto; */
	padding: 0 15px;
	display: block;
	float: left;
}
.col-loco-1{
	opacity: 0.9;
	
	height: 36px;
}
span.managecolr {
    float: left;
    width: 15px;
    border: 1px solid #ccc;
    height: 15px;
    margin-right: 5px;
	margin-top: 2px;
}
span.tooltipmanagecolr {
    float: left;
    width: 15px;
    border: 1px solid #ccc;
    height: 15px;
    margin-right: 5px;
}	
.Crane-color {
    background-color: #b9b906;
}
.sling-color {
    background-color: #a52a2a;
}
.tool-color {
    background-color: #808080;
}
.CAS-color {
    background-color: #2a3f54;
}
/* ============== ToolsTip ============== */
.tooltip {
  position: relative;
  display: inline-block;
z-index: 1;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 350px;
  background-color: black;
  opacity:0.9;
  color: #fff;
  padding:5px 15px;
  text-align: left;
  border-radius: 6px;

  /* Position the tooltip */
  position: absolute;
  z-index: 9999;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
.tooltip .tooltiptext {
  top: -5px;
  right: 105%;
}
/* ============== ToolsTip ============== */
</style>

<script>
	function SetSectionOnMap(MapID){		
		$('#section_pos').val(MapID);
		$('#SelectSection').modal('show');		
	}
	
	function SetSectionOnMapDelete(MapID){		
		//alert(MapID);	
		if (confirm('Do you want to detete this section ?')) {			
			$.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>dashboard/deletesection',
            contentType: "application/x-www-form-urlencoded",
            dataType: "json",
            data: {"map_id": MapID },
            success: function (data) {
				if(data == 1){
					location.reload();
				}
			}
			
			});
			
		}else{
			return false;
		}
	}
</script>