<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php if(!empty($this->session->flashdata('loginSuccess'))){ ?>
			  <h5 class="text-success"><?php echo $this->session->flashdata('loginSuccess'); ?></h5>
			<?php } ?>
		</div>
	</div>
	<div class="row top_tiles"> 
		 <?php if($user_role != '1' ){ ?>
			  <div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12 dashboard_icon">
				<div class="tile-stats">
					<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/shop.png'); ?>" class="maintenance-icon"/></div>
					<div class="count"><a href="<?php echo base_url().'shops'; ?>"><?php echo isset($shopCount)?$shopCount:'0'; ?></a></div>
					<h3><a href="<?php echo base_url().'shops'; ?>">Active Shops</a></h3>
				</div>
			  </div>
			  <div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12 dashboard_icon">
				<div class="tile-stats">
					<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/section.png'); ?>" class="maintenance-icon"/></div>
					<div class="count"><a href="<?php echo base_url().'sections'; ?>"><?php echo isset($sectionCount)?$sectionCount:'0'; ?></a></div>
					<h3><a href="<?php echo base_url().'sections'; ?>">Active Sections</a></h3>
				</div>
			  </div>
			  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
				<div class="tile-stats">
					<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/mainshop.png'); ?>" class="maintenance-icon"/></div>
					<div class="count"><a href="<?php echo base_url().'maintenance_shops'; ?>"><?php echo isset($mshopCount)?$mshopCount:'0'; ?></a></div>
					<h3><a href="<?php echo base_url().'maintenance_shops'; ?>">Active Maintenance Shops</a></h3>
				</div> 
			  </div>
			  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
				<div class="tile-stats">
					<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/main section.png'); ?>" class="maintenance-icon"/></div>
					<div class="count"><a href="<?php echo base_url().'maintenance_sections'; ?>"><?php echo isset($mSectionCount)?$mSectionCount:'0'; ?></a></div>
					<h3><a href="<?php echo base_url().'maintenance_sections'; ?>">Active Maintenance Sections</a></h3>
				</div> 
			  </div>
		<?php } ?>
		<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12 dashboard_icon">
			<div class="tile-stats">
				<div class="icon"><i class="fa fa-user"></i></div>
				<?php if($user_role == '1' ){ ?>
					<div class="count"><a href="<?php echo base_url().'users/alladmin'; ?>"><?php echo isset($userCount)?$userCount:'0'; ?></a></div>
					<h3><a href="<?php echo base_url().'users/alladmin'; ?>">Active Users</a></h3>
				<?php }else{ ?>
					<div class="count"><a href="<?php echo base_url().'users'; ?>"><?php echo isset($userCount)?$userCount:'0'; ?></a></div>
					<h3><a href="<?php echo base_url().'users'; ?>">Active Users</a></h3>
				<?php } ?>
			</div>
		</div>
		 <?php if($user_role != '1' ){ ?>
		 <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
			<div class="tile-stats">
				<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/hardware-icon.png'); ?>" class="hardware-icon"/></div>
				<div class="count"><a href="<?php echo base_url().'hardwares'; ?>"><?php echo isset($hardwareCount)?$hardwareCount:'0'; ?></a></div>
				<h3><a href="<?php echo base_url().'hardwares'; ?>">Hardwares</a></h3>
			</div>
		  </div>
		  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
			<div class="tile-stats">
				<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/maintenance-icon.png'); ?>" class="maintenance-icon"/></div>
				<div class="count"><a href="<?php echo base_url().'hardwares?searchByStatus=60'; ?>"><?php echo isset($hmCount)?$hmCount:'0'; ?></a></div>
				<h3><a href="<?php echo base_url().'hardwares?searchByStatus=60'; ?>">Under Maintenance</a></h3> 
			</div> 
		  </div>
		  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
			<div class="tile-stats">
				<div class="icon"><img src="<?php echo base_url('assets/dashboard/images/maintenance-icon.png'); ?>" class="maintenance-icon"/></div>
				<div class="count"><a href="<?php echo base_url().'tickets'; ?>"><?php echo isset($closedTicket)?$closedTicket:'0'; ?>/<?php echo isset($allticket)?$allticket:'0'; ?></a></div>
				<h3><a href="<?php echo base_url().'tickets'; ?>">Tickets (Closed/Total)</a></h3> 
			</div> 
		  </div>
		 <?php } ?>
	</div>
	<?php if($user_role != '1' ){ ?>
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
	
	<div class="row">
		<?php
			$AllCat = array(1,2,3,4);
			foreach($AllCat as $CatID){
				
			$cat_ids 			= $CatID;
			$categoryData	= $this->Categories_model->getCatById($cat_ids);
			$allTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebycategory($cat_ids));
			$allHardwares		= count($this->Dashboard_model->getallhardwarebycategory($cat_ids));
			//echo "<pre>";print_r($allHardwares);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			if($allHardwares > 0){
				$cranePercentage	= ($allTicketHardwares * 100) / $allHardwares;
				$cranePercentage	= number_format((float)$cranePercentage, 2, '.', '');
				$totalNoNTicket 	= 100 - $cranePercentage;
				$labelName 			= "% Healthy";
			}else{
				$cranePercentage	= 0;
				$totalNoNTicket 	= "NA";
				$labelName 			= " ";
			}
			//$cranePercentage	= 0;
			
		?>		
		<div class="col-md-3" style="padding: 20px;">
			<div class="row BoxDiv">
				<label> <?php echo $categoryData->category_name; ?> <span><?php echo isset($allHardwares)?$allHardwares:''; ?></span> </label>
				<div class="col-md-12">
					<div class="widget_summary">
	                    
	                    <div class=" col-md-12">
	                      <div class="progress">
	                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo isset($cranePercentage)?$cranePercentage:''; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo isset($totalNoNTicket)?$totalNoNTicket:''; ?>%;">
	                          <span class="sr-only"><?php echo isset($totalNoNTicket)?$totalNoNTicket:''; ?><?php echo $labelName ; ?></span>
	                        </div>
	                      </div>
	                    </div>
	                    <div class=" col-md-12">
	                      <span><?php echo isset($totalNoNTicket)?$totalNoNTicket:''; ?><?php echo $labelName ; ?></span>
	                    </div>
	                    <div class="clearfix"></div>
	                </div>
				</div>
				
				
			</div>			
		</div>
		<?php 
			}			
		?>	
	</div>
	

	<!-- ================= Section Box Start here ================= -->
	
	<div class="row">
		<div class="col-md-12 " >
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="" >All</button>			
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="JIB" >JIB Crane</button>
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="EOT" >EOT Crane</button>
			<!-- <button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="C1" >Crane</button> -->
			<button class="btn btn-success" onclick="ChangeStatus(this.value);" value="S2" >Slings & Hooks</button>
			<button class="btn btn-defult" onclick="ChangeStatus(this.value);" value="T3" >Tools & Guages</button>
			<button class="btn btn-info" onclick="ChangeStatus(this.value);" value="O4" >Crane Attached SnH</button>
			<button class="btn btn-danger" onclick="ChangeStatus(this.value);" value="B90" >Breakdown </button>
		</div>
		<div class="col-md-12 col-xs-12 mt-5">
			<label><span class="managecolr Crane-color"></span> Cranes </label>
			<label><span class="managecolr sling-color"></span> Slings & Hooks </label>
			<label><span class="managecolr tool-color"></span> Tools & Guages</label>
			<label><span class="managecolr CAS-color"></span> Crane Attached SnH </label>
		</div>
		<div class="BoxMap">
			<div class="workshop-layout mt-5">
				<?php 				
				$MapImage = $this->Dashboard_model->GetMapImageByID();
		
				if(!empty($MapImage)){
					$row = 	$MapImage->row;
					$column = 	$MapImage->column;
					$BoxCount = $row*$column;
					$boxWidth = 100/$column;
				 
				?>
				<style>
					.col-loco-1{
						width:<?php echo $boxWidth; ?>%;
						float:left;
					}
				</style>
				<?php
					
					$j = 1;
					for ($j=1; $j <= $BoxCount; $j++) { 
					
						$GetAllSectionData  = $this->Dashboard_model->GetMappingSection($j);
						
						$GetAllShopData  = $this->Dashboard_model->GetMappingShop($j);
						//echo "<pre>";print_r($GetAllShopData);echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ ;
						if(!empty($GetAllShopData)){	
						if(count($GetAllShopData) > 0){	
						$colorShop = 'background:'.$GetAllShopData[0]->shop_color.';';
						}else{
						$colorShop = "";
						}
						}else{
						$colorShop = "";
						}

						if(!empty($GetAllSectionData)){
							//echo "<pre>";print_r($allSectionData);echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
							if(count($GetAllSectionData) > 0){
								$color = 'background:'.$GetAllSectionData[0]->section_color.';';
							}else{
								$color = "";
							}
						}
						else{
							$color = "";
						}
						
						$HTML = '';
						/* ===========Catagory by count============ */
						if(count($GetAllSectionData) > 0){
							$SectionData  			= $this->Dashboard_model->getSectionByID($GetAllSectionData[0]->section_id);
							$ShopData  				= $this->Dashboard_model->getShopByID($SectionData->shop_id);
							$breakdownstatus		= '90';
							$schedulestatus			= '60';
							$ticketstatus			= '20';
							
							/* ============= Breakdown Count By Catagory ============ */
							
							$breakdownSectionData_first_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division,1));
							
							$breakdownSectionData_second_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division,2));
							
							$breakdownSectionData_third_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division,3));
							
							$breakdownSectionData_fourth_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division,4));
							
							/* ============= Breakdown Count By Catagory ============ */
							
							
							
							/* ============= Due To Schedule Count By Catagory ============ */
							
							$ScheduleSectionData_first_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,1));
							
							$ScheduleSectionData_second_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,2));
							
							$ScheduleSectionData_third_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,3));
							
							$ScheduleSectionData_fourth_cat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,4));
							
							/* ============= Due To Schedule Count By Catagory ============ */
							
							$breakdownSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division));
							
							$scheduleSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division));
							
							//echo "<pre>";print_r($scheduleSectionData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
							//$cat_id 			= array(6,8);
							$Crane_cat_id 		= array(1);
							$CraneTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Crane_cat_id,$GetAllSectionData[0]->section_id));
							
							$Hooks_cat_id 		= array(2);
							$HooksTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Hooks_cat_id,$GetAllSectionData[0]->section_id));
							
							$Tool_cat_id 		= array(3);
							$ToolTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Tool_cat_id,$GetAllSectionData[0]->section_id));
							//print_r($this->db->last_query());
							//exit;
							
							$Other_cat_id 			= array(4);
							$OtherTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Other_cat_id,$GetAllSectionData[0]->section_id));
							
							
							if($SectionData){
								/* crane **/
								$cat_ids 			= array(1);
								$section_id 		= $SectionData->section_id;
								$allcraneTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($cat_ids,$section_id));
								//echo "<pre>";print_r($this->db->last_query());echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
								$allHardwaresbysectioncrane		= count($this->Dashboard_model->getallhardwarebySection($cat_ids,$section_id));
								if($allHardwaresbysectioncrane > 0){
									$cranePercentage	= ($allcraneTicketHardwares * 100) / $allHardwaresbysectioncrane;
									$cranePercentage	= number_format((float)$cranePercentage, 2, '.', '');
									$totalNoNTicket 	= 100 - $cranePercentage;
								}else{
									$cranePercentage	= 0;
									$totalNoNTicket 	= "NA";
								}
								$craneprogress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$cranePercentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
								/* crane */
								/* sling */
									$cat_ids 			= array(2);
									$section_id 		= $SectionData->section_id;
									$allslingTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($cat_ids,$section_id));
									//echo "<pre>";print_r($this->db->last_query());echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
									$allHardwaresbysectionsling		= count($this->Dashboard_model->getallhardwarebySection($cat_ids,$section_id));
									if($allHardwaresbysectionsling > 0){
										$cranePercentage	= ($allslingTicketHardwares * 100) / $allHardwaresbysectionsling;
										$cranePercentage	= number_format((float)$cranePercentage, 2, '.', '');
										$totalNoNTicket 	= 100 - $cranePercentage;
									}else{
										$cranePercentage	= 0;
										$totalNoNTicket 	= "NA";
									}
									$slingprogress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$cranePercentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
								/* sling */
								/* T&G */
									$cat_ids 			= array(3);
									$section_id 		= $SectionData->section_id;
									$allTGTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($cat_ids,$section_id));
									//echo "<pre>";print_r($this->db->last_query());echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
									$allHardwaresbysectiontg		= count($this->Dashboard_model->getallhardwarebySection($cat_ids,$section_id));
									if($allHardwaresbysectiontg > 0){
										$cranePercentage	= ($allTGTicketHardwares * 100) / $allHardwaresbysectiontg;
										$cranePercentage	= number_format((float)$cranePercentage, 2, '.', '');
										$totalNoNTicket 	= 100 - $cranePercentage;
									}else{
										$cranePercentage	= 0;
										$totalNoNTicket 	= "NA";
									}
									$tgprogress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$cranePercentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
								/* T&G */
								/* CAS */
									$cat_ids 			= array(4);
									$section_id 		= $SectionData->section_id;
									$allCASTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($cat_ids,$section_id));
									//echo "<pre>";print_r($this->db->last_query());echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
									$allHardwaresbysectioncas		= count($this->Dashboard_model->getallhardwarebySection($cat_ids,$section_id));
									if($allHardwaresbysectioncas > 0){
										$cranePercentage	= ($allCASTicketHardwares * 100) / $allHardwaresbysectioncas;
										$cranePercentage	= number_format((float)$cranePercentage, 2, '.', '');
										$totalNoNTicket 	= 100 - $cranePercentage;
									}else{
										$cranePercentage	= 0;
										$totalNoNTicket 	= "NA";
									}
									$casprogress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$cranePercentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
								/* CAS */
								$HTML .=  "Section : ".$SectionData->section_name ." </br>";
								$HTML .=  "Shop : ".$ShopData->shop_name ." <br>";
								$HTML .=  "<div class='row'><span class='tooltipmanagecolr Crane-color'></span> <span class='flt' > Crane : ".$CraneTypeHwdCount."  </span> ".$craneprogress."</br> </div>";
								$HTML .=  "<div class='row'><span class='tooltipmanagecolr sling-color'></span> <span class='flt' > Sling & Hooks : ".$HooksTypeHwdCount."  </span>".$slingprogress."</br> </div>";
								$HTML .=  "<div class='row'><span class='tooltipmanagecolr tool-color'></span> <span class='flt' >Tools & Gauges : ".$ToolTypeHwdCount."  </span>".$tgprogress."</br> </div>";
								$HTML .=  "<div class='row'><span class='tooltipmanagecolr CAS-color'></span> <span class='flt' >Crane Attached SnH : ".$OtherTypeHwdCount."  </span>".$casprogress."</br> </div>";
								$HTML .=  "Total Breakdown : ".$breakdownSectionData."  </br>";
								$HTML .=  "Due For Service : ".$scheduleSectionData."  </br>";
								$HTML .=  "";
							}
							//print_r($GetAllSectionData);
						}
						
					?>		
						<div class="col-loco-1 tooltip"  > 
								<div class="sectionBox" style="<?php echo $color; ?>" >
							<?php 
								if($HTML != "") {
							?>
									<?php
										if($breakdownSectionData_first_cat > 0){
											echo '<div class="col-xs-6 Crane-color blinkboxX"><i class="fa fa-times " aria-hidden="true"></i></div>';
										}elseif($ScheduleSectionData_first_cat  > 0){
											echo '<div class="col-xs-6 Crane-color blinkboxi"><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
										}else{
									?>
										<div class="col-xs-6 Crane-color"><?php echo isset($CraneTypeHwdCount)?$CraneTypeHwdCount:'';?></div>
									<?php } ?>
									
									<?php
										if($breakdownSectionData_second_cat > 0){
											echo '<div class="col-xs-6 sling-color blinkboxX"><i class="fa fa-times " aria-hidden="true"></i></div>';
										}elseif($ScheduleSectionData_second_cat  > 0){
											echo '<div class="col-xs-6 sling-color blinkboxi"><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
										}else{
									?>
										<div class="col-xs-6 sling-color"><?php echo isset($HooksTypeHwdCount)?$HooksTypeHwdCount:'';?></div>
									<?php } ?>
									
									<?php
										if($breakdownSectionData_third_cat > 0){
											echo '<div class="col-xs-6 tool-color blinkboxX"><i class="fa fa-times " aria-hidden="true"></i></div>';
										}elseif($ScheduleSectionData_third_cat  > 0){
											echo '<div class="col-xs-6 tool-color blinkboxi"><i class="fa fa-exclamation blinkboxi" aria-hidden="true"></i></div>';
										}else{
									?>
										<div class="col-xs-6 tool-color"><?php echo isset($ToolTypeHwdCount)?$ToolTypeHwdCount:'';?></div>
									<?php } ?>
									
									<?php
										if($breakdownSectionData_fourth_cat > 0){
											echo '<div class="col-xs-6 CAS-color blinkboxX"><i class="fa fa-times" aria-hidden="true"></i></div>';
										}elseif($ScheduleSectionData_fourth_cat  > 0){
											echo '<div class="col-xs-6 CAS-color blinkboxi"><i class="fa fa-exclamation" aria-hidden="true"></i></div>';
										}else{
									?>
										<div class="col-xs-6 CAS-color"><?php echo isset($OtherTypeHwdCount)?$OtherTypeHwdCount:'';?></div>
									<?php } ?>									
									
									
									<div class="col-xs-12 black_color SectionName"><?php echo isset($SectionData->section_name)?$SectionData->section_name:'';?></div>
									
								
								<div class="tooltiptext"><?php echo $HTML; ?></div>
							<?php 
								}
							?>
							<?php // echo $j; ?>
							</div>
						</div>
				<?php 
					}
				?>
				
				<?php 
					}else{
						echo "<center>Map not found.</center>";
					}
				?>
			</div>
		</div>
	</div>

	<!-- ================= Section Box end here ================= -->
	<?php } ?>
	
</div>
<?php 
	if(!empty($MapImage)){
		$MapImgUrl = base_url().'uploads/dashboard/'.$MapImage->image;
	}else{
		$MapImgUrl = base_url().'assets/dashboard/images/layout.png';
	}

?>

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
		display: block;
	position: relative;
	z-index: 1
	}
	.shopBox {
		border: red 1px solid;	
		padding:0px; 	
	}
	.sectionBox {
		height: 50px;
		color:#fff;
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
	
	height: 50px;
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
	display: block;
	position: relative;
	z-index: 1
}
.sling-color {
    background-color: #a52a2a;
	display: block;
	position: relative;
	z-index: 1
}
.tool-color {
    background-color: #808080;
	display: block;
	position: relative;
	z-index: 1
}
.CAS-color {
    background-color: #2a3f54;
	display: block;
	position: relative;
	z-index: 1
}


.Crane-color.blinkboxX{
	
	-webkit-animation: Crane 1s infinite; /* Safari 4+ */
  -moz-animation:    Crane 1s infinite; /* Fx 5+ */
  -o-animation:      Crane 1s infinite; /* Opera 12+ */
  animation:         Crane 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    Crane 1s infinite; /* Fx 5+ */
  -o-animation:     Crane 1s infinite; /* Opera 12+ */
  animation:         Crane 1s infinite; /* IE 10+, Fx 29+ */
}


@-webkit-keyframes Crane {
0%, 49% {
    background-color: #b9b906;
  //  border: 3px solid #e50000;
}
50%, 100% {
    background-color: #e50000;
  //  border: 3px solid rgb(117,209,63);
}
}

.Crane-color.blinkboxi{
	-webkit-animation: Crane 1s infinite; /* Safari 4+ */
  -moz-animation:    Crane 1s infinite; /* Fx 5+ */
  -o-animation:      Crane 1s infinite; /* Opera 12+ */
  animation:         Crane 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    Crane 1s infinite; /* Fx 5+ */
  -o-animation:     Crane 1s infinite; /* Opera 12+ */
  animation:         Crane 1s infinite; /* IE 10+, Fx 29+ */
}


.sling-color.blinkboxX{
	
	-webkit-animation: sling 1s infinite; /* Safari 4+ */
  -moz-animation:    sling 1s infinite; /* Fx 5+ */
  -o-animation:      sling 1s infinite; /* Opera 12+ */
  animation:         sling 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    sling 1s infinite; /* Fx 5+ */
  -o-animation:     sling 1s infinite; /* Opera 12+ */
  animation:         sling 1s infinite; /* IE 10+, Fx 29+ */
}


@-webkit-keyframes sling {
0%, 49% {
    background-color: #a52a2a;
  //  border: 3px solid #a52a2a;
}
50%, 100% {
    background-color: #e50000;
  //  border: 3px solid rgb(117,209,63);
}
}

.sling-color.blinkboxi{
	-webkit-animation: sling 1s infinite; /* Safari 4+ */
  -moz-animation:    sling 1s infinite; /* Fx 5+ */
  -o-animation:      sling 1s infinite; /* Opera 12+ */
  animation:         sling 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    sling 1s infinite; /* Fx 5+ */
  -o-animation:     sling 1s infinite; /* Opera 12+ */
  animation:         sling 1s infinite; /* IE 10+, Fx 29+ */
}





.tool-color.blinkboxX{
	
	-webkit-animation: tool 1s infinite; /* Safari 4+ */
  -moz-animation:    tool 1s infinite; /* Fx 5+ */
  -o-animation:      tool 1s infinite; /* Opera 12+ */
  animation:         tool 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    tool 1s infinite; /* Fx 5+ */
  -o-animation:     tool 1s infinite; /* Opera 12+ */
  animation:         tool 1s infinite; /* IE 10+, Fx 29+ */
}


@-webkit-keyframes tool {
0%, 49% {
    background-color: #808080;
  //  border: 3px solid #808080;
}
50%, 100% {
    background-color: #e50000;
  //  border: 3px solid rgb(117,209,63);
}
}

.tool-color.blinkboxi{
	-webkit-animation: tool 1s infinite; /* Safari 4+ */
  -moz-animation:    tool 1s infinite; /* Fx 5+ */
  -o-animation:      tool 1s infinite; /* Opera 12+ */
  animation:         tool 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    tool 1s infinite; /* Fx 5+ */
  -o-animation:     tool 1s infinite; /* Opera 12+ */
  animation:         tool 1s infinite; /* IE 10+, Fx 29+ */
}


.CAS-color.blinkboxX{
	
	-webkit-animation: CAS 1s infinite; /* Safari 4+ */
  -moz-animation:    CAS 1s infinite; /* Fx 5+ */
  -o-animation:      CAS 1s infinite; /* Opera 12+ */
  animation:         CAS 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    CAS 1s infinite; /* Fx 5+ */
  -o-animation:     CAS 1s infinite; /* Opera 12+ */
  animation:         CAS 1s infinite; /* IE 10+, Fx 29+ */
}


@-webkit-keyframes CAS {
0%, 49% {
    background-color: #e50000;
  //  border: 3px solid #e50000;
}
50%, 100% {
    background-color: #e50000;
  //  border: 3px solid rgb(117,209,63);
}
}

.CAS-color.blinkboxi{
	-webkit-animation: CAS 1s infinite; /* Safari 4+ */
  -moz-animation:    CAS 1s infinite; /* Fx 5+ */
  -o-animation:      CAS 1s infinite; /* Opera 12+ */
  animation:         CAS 1s infinite; /* IE 10+, Fx 29+ */-webkit-animation: NAME-YOUR-ANIMATION 1s infinite; /* Safari 4+ */
  -moz-animation:    CAS 1s infinite; /* Fx 5+ */
  -o-animation:     CAS 1s infinite; /* Opera 12+ */
  animation:         CAS 1s infinite; /* IE 10+, Fx 29+ */
}

/* ============== ToolsTip ============== */
.tooltip {
  position: relative;
  display: inline-block;

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
	function ChangeStatus(status){
		$.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>/dashboard/getfiltermap/'+status,
            contentType: "application/x-www-form-urlencoded",
            dataType: "html",
            success: function (data) {
				console.log(data);
				$('.BoxMap').html(data);
			}
		});
	}
</script>