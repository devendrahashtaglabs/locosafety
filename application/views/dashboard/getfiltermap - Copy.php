<div class="workshop-layout mt-5">
	<?php 				
	$MapImage = $this->Dashboard_model->GetMapImageByID();
	if(!empty($MapImage)){
		$row 		= $MapImage->row;
		$column 	= $MapImage->column;
		$BoxCount 	= $row*$column;
		$boxWidth 	= 100/$column;
	 
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
				
				
					if(isset($status)){
		/* ========== Type Of Crane =========== */
			$CraneTypeHwdALL = 0;
			if($status == "JIB" || $status == "EOT"){	
				$CraneTypeHwdALL = count($this->Dashboard_model->getalltickethardwarebycategorySectionModelType($Crane_cat_id,$GetAllSectionData[0]->section_id, $status));
			}
		/* ========== Type Of Crane =========== */
		
		if(($status == "C1" && $CraneTypeHwdCount != 0) || ($status == "S2" && $HooksTypeHwdCount != 0) || ($status == "T3" && $ToolTypeHwdCount != 0) || ($status == "O4" && $OtherTypeHwdCount != 0)|| ($status == "B90" && $breakdownSectionData != 0) || ($status == "B60" && $scheduleSectionData != 0) || (($status == "JIB" || $status == "EOT") && $CraneTypeHwdALL != 0)){
			if($SectionData){
				
			//	print_r("rinki");
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
		}	
		
	}else{
		if($SectionData){
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
	}
				}
				//print_r($GetAllSectionData);
			}
			
		?>		
			<div class="col-loco-1 tooltipss"  > 
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
						
					
					<div class="tooltipsstext"><?php echo $HTML; ?></div>
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