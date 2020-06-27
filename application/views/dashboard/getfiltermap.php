
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
		
	

	<!-- ================= Section Box Start here ================= -->
		
		<div class="BoxMap">
			<div class="workshop-layout mt-5-0">
				<?php 				
				$MapImage = $this->Dashboard_model->GetMapImageByID();
		
				if(!empty($MapImage)){
					$row = 	$MapImage->row;
					$column = 	$MapImage->column;
					$BoxCount = $row*$column;
					$boxWidth = 100/$column;	
					$breakdownstatus		= '90';
					$schedulestatus			= '60';
					$ticketstatus			= '20';					
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
						$color = "";
						$HTML = '';
                                                $HTML1 = '';
                                                $HTML2 = '';
						$HTML3 = '';
						$HTML4 = '';
						
					?>
						<div class="col-loco-1 tooltipss"  > 
							<div class="sectionBox" style="<?php echo $color; ?>" >
							<?php 
								if(count($GetAllSectionData) > 0){
								    $SectionData  =  $this->Dashboard_model->getSectionByID($GetAllSectionData[0]->section_id);								
                                                                        
                                                                    $ShopData = $this->Dashboard_model->getShopByID($SectionData->shop_id);
                                                                    
                                                                    $breakdownstatus		= '90';
                                                                    $schedulestatus			= '60';
                                                                    $ticketstatus			= '20';


                                                                    $breakdownSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division));

                                                                    $scheduleSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division));
                                                                    
                                                                         /* ======== Progress Bar ====== */
                                                                        $i = 1; 
                                                                        foreach($dataAllCat as $CatID){ 
                                                                                        
                                                                            $CatID = $CatID->id;
                                                                            $categoryData		= $this->Categories_model->getCatById($CatID);
                                                                            // $TypeHwdCount = count($this->Dashboard_model->getalltickethardwarebycategorySection($CatID,$GetAllSectionData[0]->section_id));             
                                                                             $TypeHwdCount = count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($CatID,$GetAllSectionData[0]->section_id));          
                                                                            
                                                                             
                                                                            $section_id  = $GetAllSectionData[0]->section_id;
                                                                            $allTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($CatID,$section_id));
                                                                            $allDueHardwares	= count($this->Dashboard_model->getscheduleTicketBySectionId($CatID,$section_id));

                                                                            $allHardwaresbysection	
                                                                            = count($this->Dashboard_model->getallhardwarebySection($CatID,$section_id));


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
                                                                            $i++;
                                                                        }
                                                                                        /* ======== Progress Bar ====== */
                                                                    
									if(!empty($status)){
										if($status == "JIB" || $status == "EOT"){
											/* ==Crane Cat== */
											$ID_crane = $this->Dashboard_model->setting_meta_tbl('JIB_EOT_CAT_ID');
										
											if(count($ID_crane) > 0 && !empty($ID_crane->meta_value)){
											$AllCat = $ID_crane->meta_value;
											$cat_id = $ID_crane->meta_value;
                                                                                        
                                                                                        $categoryData		= $this->Categories_model->getCatById($cat_id);
                                                                                       
                                                                                        
											
											/* ==Crane Cat== */		
											$breakdownSectionDataCat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,20,90,$user_zone,$user_division,$cat_id));
																			
											$ScheduleSectionDataCat 	= 	count($this->Dashboard_model->getscheduleTicketBySectionIdAndCat($SectionData->section_id,20,60,$user_zone,$user_division,$cat_id));
											
											$TypeHwdCount = count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($cat_id,$GetAllSectionData[0]->section_id,$status));
											if($TypeHwdCount > 0){
												
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
												<?php } ?>
												
												<div class="col-xs-12 black_color SectionName"><?php echo isset($SectionData->section_code)?$SectionData->section_code:'';?></div>
                                                                                               
											<?php 	
											}
											}
										}
                                                                                elseif($status == "B90"){
											
                                                                                    $breakdownSectionData  	= count($this->Dashboard_model->getTicketBySectionID($SectionData->section_id,20,90,$user_zone,$user_division));
                                                                                    
                                                                                    

                                                                                    $k = 1;
                                                                                    if($breakdownSectionData > 0){
                                                                                      
                                                                                    foreach($AllCat as $CatID){

                                                                                            if($k > 4){
                                                                                                    break;
                                                                                            }
                                                                                    $CheckFlag = 0;	

                                                                                    $breakdownSectionDataCat  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,20,90,$user_zone,$user_division,$CatID));
                                                                                    
                                                                                    $TypeHwdCount	= count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($CatID,$SectionData->section_id));
                                                                                            if(count($AllCat) >= 4){
                                                                                                    if($breakdownSectionDataCat > 0){
                                                                                                            $CheckFlag = 1;
                                                                                                            echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
                                                                                                            <div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                    <?php }else{ ?>			
                                                                                                            <div class="col-xs-6 Crane-color cat-count1" ><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                    <?php } ?>													

                                                                                            <?php 	
                                                                                            }elseif(count($AllCat) == 3){
                                                                                                    if($k < 3){	
                                                                                                            if($breakdownSectionDataCat > 0){
                                                                                                                    $CheckFlag = 1;
                                                                                                                    echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
                                                                                                                    <div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                            <?php }else{ ?>			
                                                                                                                    <div class="col-xs-6 Crane-color cat-count1" ><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                            <?php } ?>								
                                                                                                    <?php 
                                                                                                    }else{
                                                                                                            if($breakdownSectionDataCat > 0){
                                                                                                                    $CheckFlag = 1;
                                                                                                                    echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
                                                                                                                    <div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                            <?php }else{ ?>			
                                                                                                                    <div class="col-xs-12 Crane-color cat-count1" ><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                            <?php } ?>	

                                                                                                    <?php 	
                                                                                                    }
                                                                                            }elseif(count($AllCat) == 2){
                                                                                                    if($breakdownSectionDataCat > 0){
                                                                                                            $CheckFlag = 1;
                                                                                                            echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
                                                                                                            <div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                    <?php }else{ ?>			
                                                                                                            <div class="col-xs-12 Crane-color cat-count1" ><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                    <?php } ?>
                                                                                            <?php												
                                                                                            }if(count($AllCat) == 1){
                                                                                                    if($breakdownSectionDataCat > 0){
                                                                                                            $CheckFlag = 1;
                                                                                                            echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-times" aria-hidden="true"></i></div>'; ?>
                                                                                                            <div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                    <?php }else{ ?>			
                                                                                                            <div class="col-xs-12 Crane-color cat-count1" ><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
                                                                                                    <?php } ?>													
                                                                                            <?php } 
                                                                                            $k++;
											}
											?>
											<div class="col-xs-12 black_color SectionName"><?php echo isset($SectionData->section_code)?$SectionData->section_code:'';?></div>
                                                                                        
                                                                                        
                                                                                    <?php 
                                                                                        /* =========Tooltip Box=========== */
//                                                                                            $HTML .=  "<div class='col-md-12'>";
//                                                                                            $HTML .=  "Shop : ".$ShopData->shop_name ."</br>";
//                                                                                            $HTML .=  "Section : ".$SectionData->section_name ."";
//                                                                                            $HTML .=  "</div>";
//                                                                                            $HTML .=  "<div class='col-md-12'>";
//                                                                                            $HTML .=  "Total : </br>";
//                                                                                            $HTML .=  $HTML2 ."<br>";
//                                                                                            $HTML .=  "</div>";
//                                                                                            $HTML .=  "<div class='col-md-12' >";
//                                                                                            $HTML .=  $HTML3;
//                                                                                            $HTML .=  "</div>";
//                                                                                            $HTML .=  "<div class='col-md-6'>";
//                                                                                            $HTML .=  "Total Breakdown : ".$breakdownSectionData." ";
//                                                                                            $HTML .=  "Scheduled Maintenance : ".$scheduleSectionData." ";
//                                                                                            $HTML .=  "</div>";
//                                                                                            $HTML .=  "<div class='col-md-6'>";
//                                                                                            $HTML .=  "Due Maintenance : ";
//                                                                                            $HTML .=  $HTML4;
//                                                                                            $HTML .=  "</div>";
                                                                                        /* =========Tooltip Box=========== */
                                                                                    
                                                                                    /*
                                                                                    ?>    
                                                                                        
                                                                                    <div class="tooltipsstext"><?php echo $HTML; ?></div>   
											
											<?php	
                                                                                     * */
											}
										}
                                                                                elseif($status == "B60"){											
																						
											$scheduleSectionData  	= count($this->Dashboard_model->getscheduleTicketBySection($SectionData->section_id,20,60,$user_zone,$user_division));
											
											
											if($scheduleSectionData  > 0){
											$k = 1;
											foreach($AllCat as $CatID){											
												
												if($k > 4){
													break;
												}
											
											$ScheduleSectionDataCat 	= 	count($this->Dashboard_model->getscheduleTicketBySectionIdAndCat($SectionData->section_id,20,60,$user_zone,$user_division,$CatID));
											
												if(count($AllCat) >= 4){
													if($ScheduleSectionDataCat > 0){
														echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-exclamation" aria-hidden="true"></i></div>'; ?>
														<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
													<?php }else{ ?>			
														<div class="col-xs-6 Crane-color cat-count1" ><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
													<?php } ?>
																									
												<?php 	
												}else if(count($AllCat) == 3){
													if($k < 3){		
														if($ScheduleSectionDataCat > 0){
															echo '<div class="col-xs-6 Crane-color-danger cat-icon"><i class="fa fa-exclamation" aria-hidden="true"></i></div>'; ?>
															<div class="col-xs-6 Crane-color cat-count" style="display:none;"><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
														<?php }else{ ?>			
															<div class="col-xs-6 Crane-color cat-count1" ><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
														<?php } ?>
													
												<?php 
													}else{
														if($ScheduleSectionDataCat > 0){
															echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-exclamation" aria-hidden="true"></i></div>'; ?>
															<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
														<?php }else{ ?>			
															<div class="col-xs-12 Crane-color cat-count1" ><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
														<?php } ?>
												<?php 
													}
												?>
												<?php 
												} else if(count($AllCat) == 2){
													if($ScheduleSectionDataCat > 0){
														echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-exclamation" aria-hidden="true"></i></div>'; ?>
														<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
													<?php }else{ ?>			
														<div class="col-xs-12 Crane-color cat-count1" ><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
													<?php } ?>									
												<?php } else if(count($AllCat) == 1){
													if($ScheduleSectionDataCat > 0){
														echo '<div class="col-xs-12 Crane-color-danger cat-icon"><i class="fa fa-exclamation" aria-hidden="true"></i></div>'; ?>
														<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
													<?php }else{ ?>			
														<div class="col-xs-12 Crane-color cat-count1" ><?php echo isset($ScheduleSectionDataCat)?$ScheduleSectionDataCat:'';?></div>
													<?php } ?>									
												<?php } ?>												
												<?php	
												$k++;
											}
											?>
											
											<div class="col-xs-12 black_color SectionName"><?php echo isset($SectionData->section_code)?$SectionData->section_code:'';?></div>	
                                                                                    
                                                                                        <?php 
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
											//exit;
											}
										}
										
                                                                                
                                                                                if(!empty($status) && $status != 'EOT' && $status != 'JIB' && $status != 'B60' && $status != 'B90'){
                                                                                   
										//GetAllTicketHardwareByCategorySectionNew
										//	$TypeHwdCount	= count($this->Dashboard_model->getalltickethardwarebycategorySection($status,$GetAllSectionData[0]->section_id));
                                                                                $TypeHwdCount	= count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($status,$GetAllSectionData[0]->section_id));
                                                                                      
											/* ========== Rinki  ========== */
											if($TypeHwdCount > 0 ){
											$i = 1;
								
												$breakdownSectionData  	= 	count($this->Dashboard_model->getTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$breakdownstatus,$user_zone,$user_division,$status));
												
												
												$ScheduleSectionDataCat 	= 	count($this->Dashboard_model->getscheduleTicketBySectionIdAndCat($SectionData->section_id,$ticketstatus,$schedulestatus,$user_zone,$user_division,$status));
												
												//$cat_id 		= 	array($CatID);
												//$TypeHwdCount	= 	count($this->Dashboard_model->GetAllTicketHardwareByCategorySectionNew($status,$GetAllSectionData[0]->section_id));
												
								
												/* crane **/
												//$cat_ids 			= array($CatID);
												$section_id 		= $SectionData->section_id;
												$allTicketHardwares	= count($this->Dashboard_model->getalltickethardwarebysection($status,$section_id));
												
												$allHardwaresbysection	= count($this->Dashboard_model->getallhardwarebySection($status,$section_id));
								
												if($allHardwaresbysection > 0){
													$cranePercentage	= ($allTicketHardwares * 100) / $allHardwaresbysection;
													$cranePercentage	= number_format((float)$cranePercentage, 2, '.', '');
													$totalNoNTicket 	= 100 - $cranePercentage;
												}else{
													$cranePercentage	= 0;
													$totalNoNTicket 	= "NA";
												}
												$progress = ' <div class="progress" style="width:150px; float:right; margin-left:20px;"> <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$cranePercentage.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$totalNoNTicket.'%"></div></div>';
												/* crane */
												
												?>
								
												<?php 
												
												if($i <= 4 ){
													$catCount = 1;
													/* ===============1  category layout============= */
													if($catCount == 1 ){
														if($breakdownSectionData > 0 && $ScheduleSectionDataCat  > 0){
															echo '<div class="col-xs-12 Crane-color-danger MixBox cat-icon"><i class="fa fa-times" aria-hidden="true"></i><i class="fa fa-exclamation " aria-hidden="true"></i></div>';
															?>
															<div class="col-xs-12 Crane-color cat-count" style="display:none;"><?php echo isset($TypeHwdCount)?$TypeHwdCount:'';?></div>
														<?php }elseif($breakdownSectionData > 0){
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
													
												}
												$i++;
							
										?>
										<div class="col-xs-12 black_color SectionName"><?php echo isset($SectionData->section_code)?$SectionData->section_code:'';?></div>
                                                                                  
										<?php 
											
										}	
											/* ========== Rinki  ========== */
											
										}
                                                                                
                                                                        ?>
                                                                                 <?php  
                                                                                 
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
								}
							?>
							
							</div>
						</div>
					<?php 	
						
						
					}
					?>	
				<?php 
				}
				?>
			</div>			
		</div>
		

	<!-- ================= Section Box end here ================= -->
