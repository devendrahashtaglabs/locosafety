
                            <?php  
                            if (!empty($agendaData)) {
                                ?>
                                <?php
                                $i = 1;
                                foreach ($agendaData as $data) { 
                                   //echo '<pre>';print_r($data);exit;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                       
                                        <td>
                                            <div>
                                                <strong><?php echo ucfirst($data->title);?></strong></span><br>
                                                
                                                                                            
                                            </div>
                                        </td>
										<td><?php echo $data->description;?></td>
										<td><?php echo $data->start_date;?></td>
                                        <td><?php echo $data->end_date; ?></td>
                                        
									
										<?php 
											 //echo "<pre>";print_r($data);die();
											$user_ids = $data->user_ids;
										    $user_arr = explode(",",$user_ids);
											
											 $usernamearr = [];
											 foreach ($user_arr as $userids){
												 if(!empty($user_ids)){
												$usernamearr[] = $this->Meeting_model->get_user($userids)->user_f_name; 
												 }
											 }
											 $userarr= implode (',',$usernamearr );
											 //echo "<pre>";print_r($usernamearr);
										  ?>
									      
										<td><?php echo $userarr;?></td>					
															

                                    </tr> 
									 <?php
                                    $i++;
									
                                }
                                ?>                 
                            <?php } ?>       
                                  
                     
                    