<style>
.progress {
    margin: 0px;
}
    .ui-corner-all{
    border-radius : 0px;
}
.progress .progress-bar{
    position: unset;
}

.progress-bar-warning {
    background-color: #f0ad4e;
}

.progress-bar-danger{
    background-color: #d9534f;
}
.progress-bar-success{
    background-color: #5cb85c;
}
.ui-corner-all{
    border-radius : 0px;
}
.progress .progress-bar{
    position: unset;
}

.SmText{
	font-size:20px;
}
.SmText1{
	font-size:15px;
	font-weight: bold;
}

.TopBox1 {
	background: #920707;
}
.TopBox1  i, .TopBox1  a, .TopBox1  h3{
	color:#FFF;
}
.TopBox1  h3{
	margin-top:10px;
}

.TopBox2 {
	background: #b9b906;
}
.TopBox2  i, .TopBox2  a, .TopBox2  h3{
	color:#FFF;
}
.TopBox2  h3{
	margin-top:10px;
}

.TopBox3 {
	background: #4a864c;
}
.TopBox3  i, .TopBox3  a, .TopBox3  h3{
	color:#FFF;
}
.TopBox3  h3{
	margin-top:10px;
}

.TopBox4 {
	background: #2f2f73;
}
.TopBox4  i, .TopBox4  a, .TopBox4  h3{
	color:#FFF;
}
.TopBox4  h3{
	margin-top:10px;
}

.TopBox5 {
	background: #b36c03;
}
.TopBox5  i, .TopBox5  a, .TopBox5  h3{
	color:#FFF;
}
.TopBox5  h3{
	margin-top:10px;
}

</style>
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
				<div class="tile-stats TopBox1">
					<div class="icon"><!--<img src="<?php echo base_url('assets/dashboard/images/shop.png'); ?>" class="maintenance-icon"/> -->    
						<i class="fa fa-building" ></i>
					</div>
					<div class="count"><a href="<?php echo base_url().'shops'; ?>"><?php echo isset($sectionCount)?$sectionCount:'0'; ?>/<span class="SmText"><?php echo isset($shopCount)?$shopCount:'0'; ?></span></a></div>
                                        <h3><a href="<?php echo base_url().'sections'; ?>">Section</a>/<a href="<?php echo base_url().'shops'; ?>"><span class="SmText1">Shops</span></a></h3>
				</div>
			  </div>
			  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
				<div class="tile-stats TopBox2">
					<div class="icon"><!--<img src="<?php //echo base_url('assets/dashboard/images/mainshop.png'); ?>" class="maintenance-icon"/> 
					-->
					<i class="fa fa-paint-brush" ></i>
					</div>
					<div class="count"><a href="<?php echo base_url().'maintenance_shops'; ?>"><?php echo isset($mSectionCount)?$mSectionCount:'0'; ?>/<span class="SmText"><?php echo isset($mshopCount)?$mshopCount:'0'; ?></span></a></div>
                                        <h3><a href="<?php echo base_url().'maintenance_sections'; ?>">Maintenance Sections</a>/<a href="<?php echo base_url().'maintenance_shops'; ?>"><span class="SmText1">Shops</span></a></h3>
				</div> 
			  </div>
		<?php } ?>
		<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12 dashboard_icon">
			<div class="tile-stats TopBox3">
				<div class="icon"><i class="fa fa-users"></i></div>
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
			<div class="tile-stats TopBox4">
				<div class="icon"><i class="fa fa-gavel"></i></div>
				<div class="count"><a href="<?php echo base_url().'hardwares'; ?>"><?php echo isset($hardwareCount)?$hardwareCount:'0'; ?></a></div>
				<h3><a href="<?php echo base_url().'hardwares'; ?>">Active Hardwares</a></h3>
			</div>
		  </div>
		  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 dashboard_icon">
			<div class="tile-stats TopBox5">
				<div class="icon"><i class="fa fa-recycle"></i></div>
				<div class="count"><a href="<?php echo base_url().'tickets?searchByStatus=20'; ?>"><?php echo isset($hmCount)?$hmCount:'0'; ?></a></div>
				<h3><a href="<?php echo base_url().'tickets?searchByStatus=20'; ?>">Under Maintenance</a></h3> 
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
		.tooltipsstext .progress {
			height: 10px;
		}
		.sectionBox .col-xs-6{
			font-size:10px;
			padding:0px;
		}
		.SectionName{
			font-size:7px;
		}
	</style>
	
        <div class="col-md-12 BoxDiv" style="padding-top:20px;">
            <div class="col-md-4 ">
                <div class="col-md-5">
                    <label>Active : </label>
                </div>  
                <div class="col-md-7">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40"
                        aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        </div>
                    </div>    
                </div> 
            </div> 
            <div class="col-md-4">
                <div class="col-md-5">
                    <label>Active But Due to Schedule : </label>
                </div>  
                <div class="col-md-7">
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40"
                        aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        </div>
                    </div>    
                </div> 
            </div>
            <div class="col-md-4">
                <div class="col-md-5">
                    <label>Inactive Or Breakdown : </label>
                </div>  
                <div class="col-md-7">
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40"
                        aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        </div>
                    </div>    
                </div> 
            </div>
        </div>
	<div class="row">
		<?php
		
			$dataAllCat = $this->Dashboard_model->GetCatByZone();
			$AllCat =array();
			$i=0;
			foreach($dataAllCat as $cat){
//				if($i == 5){
//					break;
//				}
				array_push($AllCat,$cat->id);
				$i++;
			}
			
			//$AllCat = array(1,2,3);
			
			foreach($AllCat as $CatID){

                                $cat_ids               = $CatID;
                                $categoryData	       = $this->Categories_model->getCatById($cat_ids);
                               // $allTicketHardwares    = count($this->Dashboard_model->getalltickethardwarebycategorySection($cat_ids,$sectionid));
                                
                               // $allHardwares		= count($this->Dashboard_model->getallhardwarebycategorysectiontype($cat_ids,$sectionid));
                                
                               // $allHardwaresNotTicket = count($this->Dashboard_model->getallhardwarebycategorysectiontypeNotTicket($cat_ids,$sectionid));
                               //print_r($this->db->last_query());
                               // exit;
                                
                                /*SELECT hardware_schedule_config_tbl.* FROM hardware_schedule_config_tbl WHERE hardware_schedule_config_tbl.next_schedule_date < '2020-01-23' AND hardware_schedule_config_tbl.map_id NOT IN (SELECT DISTINCT hardware_map_section_id FROM tickets_tbl WHERE ticket_status = 20 GROUP BY hardware_map_section_id )
GROUP BY hardware_schedule_config_tbl.map_id */
                                
                                $allSchedule	       = count($this->Dashboard_model->GetAllHwdDueWithOutSection($cat_ids));
                            
                                $allTicketHardwares    = count($this->Dashboard_model->GetAllTicketHWDWithOutSection($cat_ids));
                                $allHardwares          = count($this->Dashboard_model->GetAllHWDWithOutSection($cat_ids));
                                
                              //  print_r($this->db->last_query());
                              //  exit;
                                if($allHardwares > 0){
                                    
                                   $SchedulePer = round(($allSchedule / $allHardwares)* 100);
                                   $TicketPer = round(($allTicketHardwares / $allHardwares)* 100);
                                   $TotalGood = round(100 - ($TicketPer + $SchedulePer)); 
                                    
//                                        $cranePercentage	= ($allTicketHardwares * 100) / $allHardwares;
//                                        $cranePercentage	= round(number_format((float)$cranePercentage, 2, '.', ''));
//                                        $totalNoNTicket 	= 100 - $cranePercentage;
                                    $labelName 		= "% Active";
                                }else{
                                    $SchedulePer = 0;
                                    $TicketPer = 0;
                                    $TotalGood = 0;
                                        $cranePercentage	= 0;
                                        $TicketPer 	= 0;
                                        $TotalGood 		= 0;
                                        
                                }			
                                  //Unhealthy  
                                //$due_cat_count  		= count($this->Dashboard_model->getTicketByCat(20,60,$user_zone,$user_division,$CatID));
                                $duestatus 			= 60;
                                $breakdown_cat_count  	= count($this->Dashboard_model->getTicketByCat(20,90,$user_zone,$user_division,$CatID));

                                $due_cat_count  		= count($this->Dashboard_model->getallscheduleTicketBySectionIdAndCat($user_zone,$user_division,$CatID,$duestatus));		
                                $totalNoNTicket = 25;
                                $totalNoNTicket1 = 25;
                       
                            ?>		

                                    <div class="col-md-3" style="padding: 20px;">
                                        
                                            <div class="row BoxDiv" >
                                            </br>
                                                    <label> <?php echo $categoryData->category_name; ?> <span>(<?php echo isset($allHardwares)?$allHardwares:''; ?></span>)</label>

                                                    <div class="col-md-12">
                                                            <div class="widget_summary">	                    
                                                                <div class=" col-md-12" style="">
                                                                            <div class="progress dashboard-bar">
                                                                                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo isset($TotalGood)?$TotalGood:''; ?>"
                                                                                    aria-valuemin="0" aria-valuemax="100" style="text-align:center;width:<?php echo isset($TotalGood)?$TotalGood:''; ?>%">
                                                                                        <?php echo isset($TotalGood)?$TotalGood:''; ?>%
                                                                                    </div>
                                                                                    <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo isset($SchedulePer)?$SchedulePer:''; ?>"
                                                                                    aria-valuemin="0" aria-valuemax="100" style="text-align:center;width:<?php echo isset($SchedulePer)?$SchedulePer:''; ?>%">
                                                                                        <?php echo isset($SchedulePer)?$SchedulePer:''; ?>%
                                                                                    </div>
                                                                                    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo isset($TicketPer)?$TicketPer:''; ?>"
                                                                                    aria-valuemin="0" aria-valuemax="100" style="text-align:center;width:<?php echo isset($TicketPer)?$TicketPer:''; ?>%">
                                                                                        <?php echo isset($TicketPer)?$TicketPer:''; ?>%   
                                                                                    </div>
                                                                                    
                                                                            </div>
                                                                    </div>					
                                                                    <div class="clearfix"></div>						
                                                            </div>

                                                            <div class="row" >
                                                                    <div class="col-md-6 ">
                                                                            <?php 
                                                                                    $blinkX = '' ;
                                                                                    $blinkI = '' ;
                                                                                    if($breakdown_cat_count>0){
                                                                                            $blinkX = 'blinkboxX';
                                                                                    }
                                                                                    if($due_cat_count>0){
                                                                                            $blinkI = 'blinkboxi';
                                                                                    }
                                                                            ?>
                                                                            <div class="col-md-3 Crane-color <?php echo $blinkX; ?>">
                                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                    <?php echo $breakdown_cat_count;  ?>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-6 ">
                                                                            <div class="col-md-3  Crane-color <?php echo $blinkI; ?>">
                                                                                    <i class="fa fa-exclamation" aria-hidden="true"></i>						
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                    <?php echo $due_cat_count;  ?>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                            </br>
                                                    </div>
                                            </div>			
                                    </div>
                    <?php }	?>	
	</div>
	

	<!-- ================= Section Box Start here ================= -->
	
	<div class="row sectionfilter">
		<div class="col-md-12 " >
			<button class="btn btn-primary" onclick="ChangeStatusAll(this.value);" value="" >All</button>	
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="B90" >Breakdown </button>			
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="B60" >Due To Schedule </button>
<!--			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="JIB" >JIB Crane</button>
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="EOT" >EOT Crane</button>-->
			<!-- <button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="C1" >Crane</button> -->
			<!--
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="S2" >Slings & Hooks</button>
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="T3" >Tools & Guages</button>
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="O4" >Crane Attached SnH</button>-->
			
			<?php 
			foreach($AllCat as $CatID){
				$categoryData 	= 	$this->Categories_model->getCatById($CatID);				
			?>
			<button class="btn btn-primary" onclick="ChangeStatus(this.value);" value="<?php echo $categoryData->id; ?>" >
				<?php echo $categoryData->category_name; ?>
			</button>
			<?php 
			}
			?>
			<input type="hidden" name="IDBox" id="IDBox" value="" />

		</div>
		<div class="col-md-12">
		<button class="btn btn-info export" style="float:right;" onclick="ExportMapData(this.value);" >Export data in excel</button>
		</div>
                <!--		
                <div class="col-md-12 col-xs-12 mt-5">
			<label><span class="managecolr Crane-color"></span> Cranes </label>
			<label><span class="managecolr sling-color"></span> Slings & Hooks </label>
			<label><span class="managecolr tool-color"></span> Tools & Guages</label>
			<label><span class="managecolr CAS-color"></span> Crane Attached SnH </label>
		</div>
                -->
		<style>
			.btn_red{
				background-color:#e50000;
			}
			.btn_yellow{
				background-color:#b9b906;
			}
		</style>
		
		<div class="BoxMap">
			<div class="workshop-layout mt-5-0">
				<?php 				
				$MapImage = $this->Dashboard_model->GetMapImageByID();
		
				if(!empty($MapImage)){
					$row = 	$MapImage->row;
					$column = 	$MapImage->column;
					$BoxCount = $row*$column;
					$boxWidth = 100/$column;
					$HTML = '';
				 
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
						
						/*if(!empty($GetAllShopData)){	
						if(count($GetAllShopData) > 0){	
						$colorShop = 'background:'.$GetAllShopData[0]->shop_color.';';
						}else{
						$colorShop = "";
						}
						}else{
						$colorShop = "";
						}*/

						/*
 						if(!empty($GetAllSectionData)){
							if(count($GetAllSectionData) > 0){
								$color = 'background:'.$GetAllSectionData[0]->section_color.';';
							}else{
								$color = "";
							}
						}
						else{
							$color = "";
						} 
						*/
						
						$color = "";
						$HTML = '';
						$HTML2 = '';
						$HTML3 = '';
						$HTML4 = '';
						?>
						<div class="col-loco-1 tooltipss"  > 
							<div class="sectionBox  <?php echo $j; ?> " style="<?php echo $color; ?>" >
									
										<?php 
											// print_r($j);
										?>
						<?php
						/* ===========Catagory by count============ */
						if(count($GetAllSectionData) > 0){
							// echo $GetAllSectionData[0]->section_id; 
							$SectionData  			= $this->Dashboard_model->getSectionByID($GetAllSectionData[0]->section_id);
							$ShopData  				= $this->Dashboard_model->getShopByID($SectionData->shop_id);
							$breakdownstatus		= '90';
							$schedulestatus			= '60';
							$ticketstatus			= '20';
							
							
							$breakdownSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division));
							
							$scheduleSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division));
							
							/* ============= Breakdown Count By Catagory ============ */
							$i = 1;
							foreach($AllCat as $CatID){
														
								
								$categoryData		= $this->Categories_model->getCatById($CatID);
								
								$breakdownSectionDataCat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division,$CatID));
								
								
								$ScheduleSectionDataCat 	= 	count($this->Dashboard_model->getscheduleTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,$CatID));
								
								$cat_id 		= array($CatID);
								//$TypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($cat_id,$GetAllSectionData[0]->section_id));
                                                                $TypeHwdCount	= count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($cat_id,$GetAllSectionData[0]->section_id));
//								print_r($this->db->last_query());
//                                                                exit;
								
								/* ======== Progress Bar ====== */
								$section_id  = $GetAllSectionData[0]->section_id;
								$allTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($cat_id,$section_id));
                                                                $allDueHardwares	= count($this->Dashboard_model->getscheduleTicketBySectionId($cat_id,$section_id));
                                                                if($GetAllSectionData[0]->section_id == '69'){
//                                                                    print_r($this->db->last_query());
//                                                                    echo "</br>";
//                                                                    exit;
                                                                }
								$allHardwaresbysection	
								= count($this->Dashboard_model->getallhardwarebySection($cat_id,$section_id));
								
								
								/* print_r($this->db->last_query());
								echo "</br>";
								print_r((int) $allHardwaresbysection); */
								if($allHardwaresbysection > 0){
									$Percentage	= (($allTicketHardwares+$allDueHardwares) * 100) / $allHardwaresbysection;
									$Percentage	= number_format((float)$Percentage, 2, '.', '');
									$totalNoNTicket 	= 100 - $Percentage;
								}else{
									$Percentage	= 0;
									$totalNoNTicket 	= "NA";
								}
                                                                
                                                                
                                                                                        
								$progress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar progress-bar-striped bg-green" role="progressbar" aria-valuenow="'.$Percentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
								if($i <= 4){
									$HTML2 .=  "<div><span class='flt' > ".$categoryData->category_name." : ".$TypeHwdCount."  </span> ".$progress." </br></div>";
								}
								
								$breakdownstatus		= '90';
								$schedulestatus			= '60';
								$ticketstatus			= '20';
								
								$DueData = $this->Dashboard_model->getscheduleTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,$CatID);
																	
								if($i <= 4){
                                                                    $HTML4 .=  "<br/> ".$categoryData->category_name." : ".count($DueData)."";
                                                                    $HTML3 =  "<a class='badge badge-primary' href='".base_url()."sections/sectiondata/".$section_id."'  >More</a>";
								}
								/* ======== Progress Bar ====== */
								?>
								
								<?php 
								if($i <= 4 ){
									$catCount = count($AllCat);
									/* ===============1  category layout============= */
									if($catCount == 1 ){
										if($breakdownSectionDataCat > 0 && $ScheduleSectionDataCat  > 0){
											echo '<div class="col-xs-12 Crane-color-danger MixBox cat-icon"><i class="fa fa-times" aria-hidden="true"></i><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
											?>
											<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }elseif($breakdownSectionDataCat > 0){
											echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
											<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }elseif($ScheduleSectionDataCat  > 0){
											echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-exclamation " aria-hidden="true"></i></div>'; ?>
											<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }else{ ?>
											<div class="col-xs-12 Crane-color"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }
									}
									
									/* =============== 1  category layout============= */
									/* =============== 2  category layout============= */
									if($catCount == 2 ){
										if($breakdownSectionDataCat > 0 && $ScheduleSectionDataCat  > 0){
										echo '<div class="col-xs-6 Crane-color-danger MixBox cat-icon"><i class="fa fa-times" aria-hidden="true"></i><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
										?>
										<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }elseif($breakdownSectionDataCat > 0){
											echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
											<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }elseif($ScheduleSectionDataCat  > 0){
											echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-exclamation " aria-hidden="true"></i></div>'; ?>
											<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }else{ ?>
											<div class="col-xs-6 Crane-color"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
										<?php }
									}
									/* =============== 2  category layout============= */
									/* =============== 3  category layout============= */
									if($catCount == 3 ){
										if($i == 3){
											if($breakdownSectionDataCat > 0 && $ScheduleSectionDataCat  > 0){
											echo '<div class="col-xs-12 Crane-color-danger MixBox cat-icon"><i class="fa fa-times" aria-hidden="true"></i><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
											?>
											<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }elseif($breakdownSectionDataCat > 0){
												echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
												<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }elseif($ScheduleSectionDataCat  > 0){
												echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-exclamation " aria-hidden="true"></i></div>'; ?>
												<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }else{ ?>
												<div class="col-xs-12 Crane-color"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }
										}else{
											if($breakdownSectionDataCat > 0 && $ScheduleSectionDataCat  > 0){
											echo '<div class="col-xs-6 Crane-color-danger MixBox cat-icon"><i class="fa fa-times" aria-hidden="true"></i><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
											?>
											<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }elseif($breakdownSectionDataCat > 0){
												echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
												<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }elseif($ScheduleSectionDataCat  > 0){
												echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-exclamation " aria-hidden="true"></i></div>'; ?>
												<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }else{ ?>
												<div class="col-xs-6 Crane-color"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
											<?php }
										}
									}
									/* =============== 3  category layout============= */
									
									if($catCount >= 4 ){
									/* ===============4  category layout============= */
									if($breakdownSectionDataCat > 0 && $ScheduleSectionDataCat  > 0){
										echo '<div class="col-xs-6 Crane-color-danger MixBox cat-icon"><i class="fa fa-times" aria-hidden="true"></i><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
									?>
										<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
									<?php }elseif($breakdownSectionDataCat > 0){
										echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
										<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
									<?php }elseif($ScheduleSectionDataCat  > 0){
										echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-exclamation " aria-hidden="true"></i></div>'; ?>
										<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
									<?php }else{
								?>
									<div class="col-xs-6 Crane-color"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
								<?php }
								/* =============== 4  category layout============= */
									}
								}
								$i++;
							}
							?>
							<div class="col-xs-12 black_color SectionName"><?php echo isset($SectionData->section_code)?$SectionData->section_code:'';?></div>
							<?php 
							/* ============= Breakdown Count By Catagory ============ */
							/* =========Tooltip Box=========== */
                                                                $HTML .=  "<div class='col-md-12'>";
                                                                $HTML .=  "Shop : ".$ShopData->shop_name ."</br>";
								$HTML .=  "Section : ".$SectionData->section_name ."";
								$HTML .=  "</div>";
								$HTML .=  "<div class='col-md-12'>";
                                                                $HTML .=  "Total : </br>";
								$HTML .=  $HTML2 ."<br>";
								$HTML .=  "</div>";
								$HTML .=  "<div class='col-md-12' >";
								$HTML .=  $HTML3;
								$HTML .=  "</div>";
								$HTML .=  "<div class='col-md-6'>";
								$HTML .=  "Total Breakdown : ".$breakdownSectionData." ";
								$HTML .=  "Scheduled Maintenance : ".$scheduleSectionData." ";
								$HTML .=  "</div>";
								$HTML .=  "<div class='col-md-6'>";
								$HTML .=  "Due Maintenance : ";
								$HTML .=  $HTML4;
								$HTML .=  "</div>";
							/* =========Tooltip Box=========== */
							
						?>
						<div class="tooltipsstext"><?php echo $HTML; ?></div>
				<?php 
					}
				?>
						
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

	}
	.shopBox {
		border: red 1px solid;	
		padding:0px; 	
	}
	.sectionBox {
		height: 38px;
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
	height: 38px;
}
span.managecolr {
    float: left;
    width: 15px;
    border: 1px solid #ccc;
    height: 15px;
    margin-right: 5px;
	margin-top: 2px;
}
span.tooltipssmanagecolr {
    float: left;
    width: 15px;
    border: 1px solid #ccc;
    height: 15px;
    margin-right: 5px;
}
.Crane-color-danger{
	background-color: #f00;
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

.dashboard-bar .progress-bar {
    font-size: 13px;
}
.progress-bar-striped, .progress-striped .progress-bar {
    background-image: -webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent) !important;
    background-image: -o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent) !important;
    background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent) !important;
    background-size: 40px 40px;
}
.ui-widget-content {
	border: 0px !important;
	color: #fff !important;
}
.progress-bar.progress-bar-success.progress-bar-striped.active.ui-progressbar.ui-widget.ui-widget-content.ui-corner-all {
    text-align: center;
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
.tooltipss {
  position: relative;
  display: inline-block;

}

.tooltipss .tooltipsstext {
  visibility: hidden;
  width: 375px;
  background-color: black;
  opacity:0.9;
  color: #fff;
  padding:5px 15px;
  text-align: left;
  border-radius: 6px;

  /* Position the tooltipss */
  position: absolute;
  z-index: 9999;
}

.tooltipss:hover .tooltipsstext {
  visibility: visible;
}
.tooltipss .tooltipsstext {
  top: -5px;
  right: 105%;
}
/* ============== ToolsTip ============== */
.MixBox > .fa {
	display: contents!important;
}
.catcounthardware{
	width: 100%;
	height: 100%;
	font-size: 18px;
    padding-top: 6px;
}
.bg-red{
	background: #e50000;
}
</style>
<script>
	function ExportMapData(){
		var IdData = $('#IDBox').val();
		window.location.replace("<?php echo base_url(); ?>report/hardwaresection/?filterId="+IdData);
	}

	function ChangeStatusAll(status){
		$('#IDBox').val(status);
		$.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>/dashboard/getfiltermapall/',
            contentType: "application/x-www-form-urlencoded",
            dataType: "html",
            success: function (data) {
				console.log(data);
				$('.BoxMap').html(data);
				var $or = $(".cat-icon"),
					$bl = $(".cat-count"),
					changeColor;
					$or.hide();
					$bl.show();					
				changeColor = function() {
					 $or.toggle();
					 $bl.toggle();
				};
				setInterval(changeColor, 600);
			}
		});
	}
	function ChangeStatus(status){
		$('#IDBox').val(status);
		$.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>/dashboard/getfiltermap/'+status,
            contentType: "application/x-www-form-urlencoded",
            dataType: "html",
            success: function (data) {
				console.log(data);
				$('.BoxMap').html(data);
				var $or = $(".cat-icon"),
					$bl = $(".cat-count"),
					changeColor;
					$or.hide();
					$bl.show();					
				changeColor = function() {
					 $or.toggle();
					 $bl.toggle();
				};
				setInterval(changeColor, 600);
			}
		});
	}
</script>
<script>
	jQuery(function($) {
		var $or = $(".cat-icon"),
			$bl = $(".cat-count"),
			changeColor;
			$or.hide();
			$bl.show();
			
		changeColor = function() {
			 $or.toggle();
			 $bl.toggle();
		};
		setInterval(changeColor, 600);
	});
	jQuery(function($) {
		$('.sectionfilter .btn-primary').click(function(){
			if ($('.sectionfilter .btn-primary').hasClass('active')) {
				$('.sectionfilter .btn-primary').removeClass("active");
			}
			$(this).addClass('active');
		});		
	});
</script>