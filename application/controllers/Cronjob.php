<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cronjob extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Cronjob_model');
		
		$this->load->model('Notifications_model'); 
		$this->load->model('Firebase_model');
	}
	




        public function index(){
				
		$FiveDayDate = date('Y-m-d',strtotime("+30 day", strtotime(date('Y-m-d'))));				
		$dataAll = $this->Cronjob_model->GetAllDueToSchuleData($FiveDayDate);
		$deviceIDs = array();
		$ShopUserID = '';
		$responseNotificationData =  '';
		$todayDate = strtotime(date('Y-M-d'));
		foreach ($dataAll as $row){
		$nextScheduleDate = strtotime($row->next_schedule_date);
		if($nextScheduleDate > $todayDate){	
			$MapData = $this->Cronjob_model->GetSchuduleMap($row->map_id);
			if($MapData->hardware_cycle == 3){				
				if($MapData->monthly_name == 1){
					$Days3 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 3 days')));
					$Days = date('Y-m-d', strtotime(date('Y-M-d') .' + 3 days'));
					$daysCount = $this->datediff($Days,$row->next_schedule_date);						
					$msgDays = " due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." (in ".$daysCount." days)";
				    $title = "due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." ";			
					
					if($nextScheduleDate <= $Days3){
						$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$msgDays,$title);						
					}
					
				}elseif($MapData->monthly_name <= 3){
					$Days5 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 5 days')));
					$Days = date('Y-m-d', strtotime(date('Y-M-d') .' + 5 days'));
					$daysCount = $this->datediff($Days,$row->next_schedule_date);					
					$msgDays = " due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." (in ".$daysCount." days)";
				    $title = "due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." ";
					
					
					if($nextScheduleDate <= $Days5){
						$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$title);
					}
				}elseif($MapData->monthly_name > 3){
					$Days30 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 30 days')));
					$Days = date('Y-m-d', strtotime(date('Y-M-d') .' + 30 days'));
					$daysCount = $this->datediff($Days,$row->next_schedule_date);
					$msgDays = " due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." (in ".$daysCount." days)";
				    $title = "due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." ";
					
					if($nextScheduleDate <= $Days30){
						$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$daysCount,$title);
					}
				}
				
			}elseif($MapData->hardware_cycle == 1){
				
				if($MapData->daily_every_day <= 30){
					$Days3 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 3 days')));
					$Days = date('Y-m-d', strtotime(date('Y-M-d') .' + 3 days'));
					$daysCount = $this->datediff($Days,$row->next_schedule_date);	
					$msgDays = " due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." (in ".$daysCount." days)";
				    $title = "due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." ";
					
					if($nextScheduleDate <= $Days3){
						$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$msgDays,$title);
					}
				}elseif($MapData->daily_every_day > 30){
					$Days5 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 5 days')));
					$Days = date('Y-m-d', strtotime(date('Y-M-d') .' + 5 days'));
					$daysCount = $this->datediff($Days,$row->next_schedule_date);				
					
					$msgDays = " due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." (in ".$daysCount." days)";
				    $title = "due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." ";
					
					
					if($nextScheduleDate <= $Days5){
						$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$msgDays,$title);
					}
				}elseif($MapData->daily_every_day >= 90){
					$Days30 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 30 days')));
					$Days = date('Y-m-d', strtotime(date('Y-M-d') .' + 30 days'));
					$daysCount = $this->datediff($Days,$row->next_schedule_date);				
					
					$msgDays = " due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." (in ".$daysCount." days)";
				 //   $title = "due in ".$daysCount." days";
					$title = "due for maintenance on ".date("d-M-Y",strtotime($row->next_schedule_date))." ";
					
					if($nextScheduleDate <= $Days30){
						$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$msgDays,$title);
					}
				}
			
			}
		}else{			
			$daysCount = $this->datediff(date('Y-m-d'),$row->next_schedule_date);
			
			
			if($daysCount == 0){
				$msgDays = "due for maintenance on ".date("d-M-Y")." (today)";
				$title = " due for maintenance on ".date("d-M-Y")." (today)";
			}else{
				$msgDays = "over due for maintenance on ".$row->next_schedule_date." (in ".$daysCount." days)";
				$title = "over due for maintenance on ".date("d-M-Y")." ";
			}
			
			$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date,$msgDays,$title);	
		}		
				
		}
		
		echo "<pre>";
		print_r(json_decode($responseNotificationData));
		exit;
	}
	
	function datediff($date2,$date1){
		$diff = strtotime($date2) - strtotime($date1); 
      
		// 1 day = 24 hours 
		// 24 * 60 * 60 = 86400 seconds 
		return abs(round($diff / 86400)); 
	}
	
	function sendMsg($map_id ,$next_schedule_date, $msgDays,$title){
		
		
			$deviceIDs = array();
			$ShopUserID = '';
			$ShopAndSection = $this->Cronjob_model->GetShopAndSectionByMapID($map_id);
			$nextDate = $next_schedule_date;
			foreach($ShopAndSection as $row){
				$TicketDate = $this->Cronjob_model->CheckTicketAble($row->map_id);	
			
				if(isset($TicketDate)){			
					foreach($TicketDate as $ticket){
						if($ticket->ticket_status == 50){
							$GetShopUserDeviceID = $this->Cronjob_model->GetShopUserDeviceID($row->shop_id);	
							if(isset($GetShopUserDeviceID)){
								if(isset($GetShopUserDeviceID->user_device_id)){
									$ShopDeviceID = $GetShopUserDeviceID->user_device_id;
									array_push($deviceIDs,$ShopDeviceID);
								}
								
								if(isset($row->shop_id)){
									$SectionUserID = $this->Cronjob_model->GetSectionUserDeviceID($row->shop_id, $row->section_id);
									if(isset($SectionUserID->user_device_id)){
										$SectionDeviceID = $SectionUserID->user_device_id;
										array_push($deviceIDs,$SectionDeviceID);
									}
								}
								
							}
							$ShopData = $this->Cronjob_model->getShopBy($row->shop_id);	
							$SectionData = $this->Cronjob_model->getSectionBy($row->section_id);	
							
							$MsgData = $this->Cronjob_model->GetMsgData($row->map_id);
							
							
							$res = array();
							$res['data']['title'] 		= $MsgData->category_name." ".$title." ";
							$res['data']['image'] 		= base_url()."uploads/hardware/".$MsgData->hardware_image;
							$res['data']['message'] 	= $MsgData->category_name." with serial no #".$MsgData->hardware_serial_no." assigned in ".$SectionData->section_name." (".$ShopData->shop_name.") will be ".$msgDays.". Please take necessary action for safety.";
							//print_r($res['data']['image']);
							$responseNotificationData 	= $this->Firebase_model->sendMultiple($deviceIDs,$res);
							return $responseNotificationData;
		
						}	
					}
				}else{
					
					$GetShopUserDeviceID = $this->Cronjob_model->GetShopUserDeviceID($row->shop_id);	
							if(isset($GetShopUserDeviceID)){
								if(isset($GetShopUserDeviceID->user_device_id)){
									$ShopDeviceID = $GetShopUserDeviceID->user_device_id;
									array_push($deviceIDs,$ShopDeviceID);
								}
								
								if(isset($row->shop_id)){
									$SectionUserID = $this->Cronjob_model->GetSectionUserDeviceID($row->shop_id, $row->section_id);
									if(isset($SectionUserID->user_device_id)){
										$SectionDeviceID = $SectionUserID->user_device_id;
										array_push($deviceIDs,$SectionDeviceID);
									}
								}
								
							}
							$ShopData = $this->Cronjob_model->getShopBy($row->shop_id);	
							$SectionData = $this->Cronjob_model->getSectionBy($row->section_id);	
							
							$MsgData = $this->Cronjob_model->GetMsgData($row->map_id);
							$res = array();
							$res['data']['title'] 		= $MsgData->category_name." ".$title." ";													
							$res['data']['image'] 		= base_url()."uploads/hardware/".$MsgData->hardware_image;
							$res['data']['message'] 	= $MsgData->category_name." with serial no #".$MsgData->hardware_serial_no." assigned in ".$SectionData->section_name." (".$ShopData->shop_name.") will be ".$msgDays.". Please take necessary action for safety.";
		
							$responseNotificationData 	= $this->Firebase_model->sendMultiple($deviceIDs,$res);
							return $responseNotificationData;
					
				}
				
			}
			
		
		
	}
	
	
/*	public function indexOLd()
	{
		$FiveDayDate = date('Y-m-d',strtotime("+6 day", strtotime(date('Y-m-d'))));		
		$dataAll = $this->Cronjob_model->GetAllDueToSchuleData($FiveDayDate);
		$deviceIDs = array();
		$ShopUserID = '';
		foreach ($dataAll as $row){
			$todayDate = strtotime(date('Y-M-d'));
			$nextScheduleDate = strtotime($row->next_schedule_date);
			$Days30 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 30 days')));
			$Days90 = strtotime(date('Y-m-d', strtotime(date('Y-M-d') .' + 90 days')));
			$Days365 = strtotime(date('Y-m-d', strtotime(date('Y-M-d'). ' + 180 days')));
			if($todayDate <= $nextScheduleDate){			
				$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date);			
			}else if($nextScheduleDate <= $Days30){
				$Days3 = strtotime(date('Y-m-d', strtotime($row->next_schedule_date .' - 3 days')));
				if($nextScheduleDate >=  $Days3){
					$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date);
				}
			}else if($nextScheduleDate <= $Days90){
				$Days5 = strtotime(date('Y-m-d', strtotime($row->next_schedule_date .' - 5 days')));
				if($nextScheduleDate <=  $Days5){
					$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date);
				}
			}else if($nextScheduleDate <= $Days365){
				$Days365 = strtotime(date('Y-m-d', strtotime($row->next_schedule_date .' - 180 days')));
				if($nextScheduleDate <=  $Days365){
					$responseNotificationData = $this->SendMsg($row->map_id,$row->next_schedule_date);
				}
			}
			
		}	

		echo $responseNotificationData;	
	}
	function CheckTicketAble($mapID,$ShopID,$SectionID){
		
		$TicketDate = $this->Cronjob_model->CheckTicketAble($mapID);				
		if(isset($TicketDate)){			
			foreach($TicketDate as $ticket){
				if($ticket->ticket_status == 50){
					$GetShopUserDeviceID = $this->Cronjob_model->GetShopUserDeviceID($ShopID);	
					if(isset($GetShopUserDeviceID)){
						if(isset($GetShopUserDeviceID->user_device_id)){
							$ShopDeviceID = $GetShopUserDeviceID->user_device_id;
							array_push($deviceIDs,$ShopDeviceID);
						}
						
						if(isset($ShopID)){
							$SectionUserID = $this->Cronjob_model->GetSectionUserDeviceID($ShopID, $SectionID);
							if(isset($SectionUserID->user_device_id)){
								$SectionDeviceID = $SectionUserID->user_device_id;
								array_push($deviceIDs,$SectionDeviceID);
							}
						}
						
					}
					$ShopData = $this->Cronjob_model->getShopBy($ShopID);	
					$SectionData = $this->Cronjob_model->getSectionBy($SectionID);	
					
					$MsgData = $this->Cronjob_model->GetMsgData($mapID);
					$res = array();
					$res['data']['title'] 		= $MsgData->category_name."due in 23 days";
					$res['data']['message'] 	= $MsgData->category_name." with serial no #".$MsgData->hardware_serial_no." assigned in ".$SectionData->section_name." (".$ShopData->shop_name.") will be due (in 23 days). Please take necessary action for safety.";

					$responseNotificationData 	= $this->Firebase_model->sendMultiple($deviceIDs,$res);
					return $responseNotificationData;
				}
			}
		}else{
			$GetShopUserDeviceID = $this->Cronjob_model->GetShopUserDeviceID($ShopID);	
			if(isset($GetShopUserDeviceID)){
				if(isset($GetShopUserDeviceID->user_device_id)){
					$ShopDeviceID = $GetShopUserDeviceID->user_device_id;
					array_push($deviceIDs,$ShopDeviceID);
				}
				
				if(isset($ShopID)){
					$SectionUserID = $this->Cronjob_model->GetSectionUserDeviceID($ShopID, $SectionID);
					if(isset($SectionUserID->user_device_id)){
						$SectionDeviceID = $SectionUserID->user_device_id;
						array_push($deviceIDs,$SectionDeviceID);
					}
				}
				
			}
			$ShopData = $this->Cronjob_model->getShopBy($ShopID);	
			$SectionData = $this->Cronjob_model->getSectionBy($SectionID);	
			
			$MsgData = $this->Cronjob_model->GetMsgData($mapID);
			$res = array();
			$res['data']['title'] 		= $MsgData->category_name."due in 23 days";
			$res['data']['message'] 	= $MsgData->category_name." with serial no #".$MsgData->hardware_serial_no." assigned in ".$SectionData->section_name." (".$ShopData->shop_name.") will be due (in 23 days). Please take necessary action for safety.";

			$responseNotificationData 	= $this->Firebase_model->sendMultiple($deviceIDs,$res);
			return $responseNotificationData;
		}
		
	}
	*/
	
	public function UpdateConfig(){				
		
		$todayDate = strtotime(date('Y-M-d'));		
		$Ids = array(18 ,156 ,184 ,19 ,157 ,20 ,158 ,167 ,21 ,22 ,23 ,24 ,25 ,182 ,26 ,27 ,1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11 ,12 ,13 ,14 ,15 ,16 ,17 ,147 ,151);	
		$hwdID = array(1 ,1 ,1 ,2 ,2 ,3 ,3 ,3 ,4 ,5 ,6 ,7 ,8 ,8 ,9 ,10 ,11 ,12 ,13 ,14 ,15 ,16 ,17 ,18 ,19 ,20 ,21 ,22 ,23 ,24 ,25 ,26 ,27 ,92 ,100);		
		$i = 0;
		foreach($Ids as $mapid){
			$dataModel = $this->Cronjob_model->checkMapID($mapid);
			
			$arrschedule = array(
						'hardware_section_map_id'		=>		$mapid,	
						'hardware_id'					=>		$hwdID[$i],	
						'hardware_cycle'				=>		2,	
						'daily_every_day'				=>		'',	
						'weekly_recur_every'			=>		1,	
						'weekly_day'					=>		'Monday',	
						'monthly_type'					=>		'day',	
						'monthly_date'					=>		'',	
						'monthly_name'					=>		'',	
						'monthly_week'					=>		'1',	
						'monthly_week_day'				=>		'',	
						'status'						=>		10,	
						'created'						=>		date('Y-m-d'),	
						'modified'						=>		date('Y-m-d'),
					);
			
			$nextScheduleDate = date('Y-m-d',strtotime('Monday', strtotime('this week +1 week')));
			
			if(count($dataModel) > 0){				
				$id = $dataModel->id;
				$dataModel = $this->Cronjob_model->updateJob($id,$arrschedule);
				
				$scheduleArray['next_schedule_date'] 	= $nextScheduleDate;
				
				$dataModel1 = $this->Cronjob_model->updateJobConfig($mapid,$scheduleArray);
				
				
				print_r($dataModel);
				echo "  ====  ";
				print_r($dataModel1);
				echo "</br>";
			}
			/*else{
				$dataModel = $this->Cronjob_model->addJob($arrschedule);
			}
			*/
			$i++;
		}
		
	}
	
//  ==============  Cron Job Settings =====================
    public  function duemsgsend(){
        date_default_timezone_set("Asia/Kolkata");
        $today =  date('H');
        
       // if(1 == 1){
        if( $today == '10'){                  
            
        $DueData = $this->Cronjob_model->GetAllDueData(); 
        $CronSetting  = $this->Cronjob_model->GetCronSetting();
        foreach ($DueData as $row){
            
//      Date Diff
            $date1 = date('Y-m-d',strtotime($row->schedule_start_date));
            $date2 = date('Y-m-d',strtotime($row->next_schedule_date));
            $today = date('Y-m-d');
            $diff = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            
            $diff1 = abs(strtotime($today) - strtotime($date2));
            $years1 = floor($diff1 / (365*60*60*24));
            $months1 = floor(($diff1 - $years1 * 365*60*60*24) / (30*60*60*24));
            $days1 = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24)/ (60*60*24));
//      Date Diff  

            if(!empty($row->user_device_id)){
            foreach($CronSetting as $setting){
                
                    if($days >= $setting->to_day && $days < $setting->from_day && $days1 <= $setting->days ){
                        $res = array();
                        $deviceIDs = array();
                        //$deviceIDs = $row->user_device_id;
                        array_push($deviceIDs,$row->user_device_id);
                        $res['data']['title']       =   "Reminder : ".$row->hardware_name." Due To schedule";
                        $res['data']['image']       =   '';
                        $res['data']['message']     =   "Hardware ".$row->hardware_name." ".$row->hardware_serial_no." is up for service maintance on  ".$date2.", This is reminder to plan your maintance. ";
                        $responseNotificationData   =   $this->Firebase_model->sendMultiple($deviceIDs,$res);
                        //return $responseNotificationData;  
                        echo "</br>";
                        print_r($responseNotificationData);
//                        exit;
                    }
            }    
//             echo "<pre>";
//            print_r($row);
//            exit;
            }
            
           
            
        }
//        
//        echo "helllo";  
//        exit;
     }
    }
//  ==============  Cron Job Settings =====================        
}