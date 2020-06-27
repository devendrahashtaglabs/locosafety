

	<!-- ================= Section Box Start here ================= -->
	
	
		<div class="workshop-layout mt-5">
			<?php 
				$j = 1;
				for ($j=1; $j <= 384; $j++) { 
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
					$SectionData  = $this->Dashboard_model->getSectionByID($GetAllSectionData[0]->section_id);
					$ShopData  = $this->Dashboard_model->getShopByID($SectionData->shop_id);
					
				//$cat_id 			= array(6,8);
				$Crane_cat_id 			= array(1);
				$CraneTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Crane_cat_id,$GetAllSectionData[0]->section_id));
				
				$Hooks_cat_id 			= array(2);
				$HooksTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Hooks_cat_id,$GetAllSectionData[0]->section_id));
				
				$Tool_cat_id 			= array(3);
				$ToolTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($Tool_cat_id,$GetAllSectionData[0]->section_id));
				
				$Other_cat_id 			= array(4);
				$OtherTypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySectionNOT($Other_cat_id,$GetAllSectionData[0]->section_id));
				if(isset($status)){
					if(($status == "C1" && $CraneTypeHwdCount != 0) || ($status == "S2" && $HooksTypeHwdCount != 0) || ($status == "T3" && $ToolTypeHwdCount != 0) || ($status == "O4" && $OtherTypeHwdCount != 0)){
						if($SectionData){
							$HTML .=  "Section : ".$SectionData->section_name." </br>";
							$HTML .=  "Shop : ".$ShopData->shop_name." <br>";
							$HTML .=  "Crane : ".$CraneTypeHwdCount."  </br>";
							$HTML .=  "Sling & Hooks : ".$HooksTypeHwdCount."  </br>";
							$HTML .=  "Tools & Gauges : ".$ToolTypeHwdCount."  </br>";
							$HTML .=  "Others : ".$OtherTypeHwdCount."  </br>";
							$HTML .=  "";
						}
					}					
				}else{
					if($SectionData){
						$HTML .=  "Section : ".$SectionData->section_name." </br>";
						$HTML .=  "Shop : ".$ShopData->shop_name." <br>";
						$HTML .=  "Crane : ".$CraneTypeHwdCount."  </br>";
						$HTML .=  "Sling & Hooks : ".$HooksTypeHwdCount."  </br>";
						$HTML .=  "Tools & Gauges : ".$ToolTypeHwdCount."  </br>";
						$HTML .=  "Others : ".$OtherTypeHwdCount."  </br>";
						$HTML .=  "";
					}		
				}
			//	print_r($GetAllSectionData);
				}
				
			?>		
				<div class="col-loco-1 tooltip"  style="<?php echo $colorShop; ?>" > 
						<div class="sectionBox" style="<?php echo $color; ?>" >
					<?php 
						if($HTML != "") {
					?>
						
							<div class="col-xs-6 <?php echo !empty($color)?'Crane-color':'';?>">1</div>
							<div class="col-xs-6 <?php echo !empty($color)?'sling-color':'';?>">2</div>
							<div class="col-xs-6 <?php echo !empty($color)?'tool-color':'';?>">3</div>
							<div class="col-xs-6 <?php echo !empty($color)?'CAS-color':'';?>">4</div>
							<div class="col-xs-12 black_color">5</div>
							<?php //echo $j; ?>
						
						<span class="tooltiptext"><?php echo $HTML; ?></span>
					<?php 
						}
					?>
					</div>
				</div>
			<?php 
				}
			?>
			</div>

	<!-- ================= Section Box end here ================= -->
