		<?php		
			$dataAllCat = $this->Dashboard_model->GetCatByZone();
			$AllCat =array();
			$i=0;
			foreach($dataAllCat as $cat){
				if($i == 5){
					break;
				}
				array_push($AllCat,$cat->id);
				$i++;
			}
			
			?>		
			<div class="workshop-layout mt-5-0">
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
						/*if(!empty($GetAllShopData)){	
						if(count($GetAllShopData) > 0){	
						$colorShop = 'background:'.$GetAllShopData[0]->shop_color.';';
						}else{
						$colorShop = "";
						}
						}else{
						$colorShop = "";
						}*/

/* 						if(!empty($GetAllSectionData)){
							if(count($GetAllSectionData) > 0){
								$color = 'background:'.$GetAllSectionData[0]->section_color.';';
							}else{
								$color = "";
							}
						}
						else{
							$color = "";
						} */
						$color = "";
						$HTML = '';
						$HTML = '';
						$HTML2 = '';
						$HTML3 = '';
						$HTML4 = '';
						?>
						<div class="col-loco-1 tooltipss"  > 
							<div class="sectionBox" style="<?php echo $color; ?>" >
									
										<?php 
											// print_r($j);
										?>
						<?php
						/* ===========Catagory by count============ */
						if(count($GetAllSectionData) > 0){
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
								$TypeHwdCount	= count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($cat_id,$GetAllSectionData[0]->section_id));
								
								
								
								
								/* ======== Progress Bar ====== */
								$section_id  = $GetAllSectionData[0]->section_id;
								$allTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($cat_id,$section_id));
                                                                $allDueHardwares	= count($this->Dashboard_model->getscheduleTicketBySectionId($cat_id,$section_id));
								$allHardwaresbysection	
								= count($this->Dashboard_model->getallhardwarebySection($cat_id,$section_id));
								
								
								
								if($allHardwaresbysection > 0){
									$Percentage	= (($allTicketHardwares+$allDueHardwares) * 100) / $allHardwaresbysection;
									$Percentage	= number_format((float)$Percentage, 2, '.', '');
									$totalNoNTicket 	= 100 - $Percentage;
								}else{
									$Percentage	= 0;
									$totalNoNTicket 	= "NA";
								}
								$progress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$Percentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
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
						if($TypeHwdCount > 0 ){	
						?>
						<div class="tooltipsstext"><?php echo $HTML; ?></div>
						
                                                <?php 
                                                }                                                
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
