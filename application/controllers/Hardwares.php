<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hardwares extends CI_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Hardwares_model'); 
		$this->load->model('Categories_model');
		$this->load->model('Types_model');
		$this->load->model('Shops_model');
		$this->load->model('Sections_model');
		$this->load->model('Maintenance_shops_model');  
		$this->load->model('Maintenance_sections_model');  
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role == '1'){ 
			redirect('login');
		}
	}
	public function index(){
		$data['title'] 	= 'Hardware List';
		$status			= $this->input->get('searchByStatus');
		$session_data 	= $this->session->userdata('loggedInUserDetail');
		$zone_id 		= $session_data->user_zone;
		$division_id 	= $session_data->user_division; 
		if( $status === NULL ){
			$status					= '10';
			//$data['hardwareData'] 	= $this->Hardwares_model->getStatusFilter($status);
			//$data['hardwareData'] 	= $this->Hardwares_model->getallhwcount($zone_id,$division_id);
			$data['hardwareData'] 	= $this->Hardwares_model->Getallhardwarelist($zone_id,$division_id);
			//echo "<pre>";print_r($data['hardwareData']);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		}elseif($status == 'all'){			
			$data['hardwareData'] 	= $this->Hardwares_model->getHardwareCount($zone_id,$division_id);		
		}else{	
			$data['hardwareData'] 	= $this->Hardwares_model->Getallhardwarelist($zone_id,$division_id,$status);
			//$data['hardwareData'] 	= $this->Hardwares_model->getStatusFilter($status);			
		}
		//$data['hardwareData'] 	= $this->Hardwares_model->getHardware();
		$this->load->view('header',$data);
		$this->load->view('hardwares/index',$data);
		$this->load->view('footer',$data);
	}
	public function mapHardware(){
		$data['title'] 			= 'Assign Hardware To Section';
		$session_data 			= $this->session->userdata('loggedInUserDetail');
		$zone_id 				= $session_data->user_zone;
		$division_id 			= $session_data->user_division;
		$data['hardwareData'] 	= $this->Hardwares_model->getHardwareCount($zone_id,$division_id);
		$this->load->view('header',$data);
		$this->load->view('hardwares/map_hardware',$data);
		$this->load->view('footer',$data);
	}
	public function addHardware(){
		$data['title']  = 'Add Hardware';
		$this->load->library('image_lib');
		$session_data 	= $this->session->userdata('loggedInUserDetail');
		$zone_id 		= $session_data->user_zone;
		$division_id 	= $session_data->user_division; 
		$data['hardware_category'] 	= $this->Categories_model->getCategory($zone_id,$division_id);
		$data['catList'] 		= $this->Categories_model->getCategoryByZoneDivision($zone_id,$division_id,10);
		$data['typeList'] 		= $this->Types_model->getTypeByZoneDivision($zone_id,$division_id,10);
		$data['mshopList'] 		= $this->Maintenance_shops_model->getMShopCount($zone_id,$division_id);
		$data['msectionList'] 	= $this->Maintenance_sections_model->getMSection();
		if($this->input->post('submit')){
			$arr = array();
			$arr['hardware_category'] 	= $this->input->post('hardware_category');
			$arr['hardware_type'] 		= $this->input->post('hardware_type');
			$arr['hardware_code'] 		= $this->input->post('hardware_code');
			$arr['hardware_name'] 		= $this->input->post('hardware_name');
			$arr['hardware_model'] 		= $this->input->post('hardware_model');
			$arr['hardware_company'] 	= $this->input->post('hardware_company');
			$arr['hardware_specification'] 	= $this->input->post('hardware_specification');
			$arr['default_maintenance_shop'] 	= $this->input->post('maintenance_shop');
			$arr['default_maintenance_section'] = $this->input->post('maintenance_section');
			$arr['schedule_frequency_count'] = $this->input->post('schedule_frequency_count');
			$arr['schedule_frequency_cycle'] = $this->input->post('schedule_frequency_cycle');
			$arr['hardware_status'] 		= '10';
			$arr['hardware_created_date'] 	= date('Y-m-d');
			$arr['hardware_created_by'] 	= $this->session->userdata('loggedInAdmin');
			$hardware_image 	= time().'-'.$_FILES["hardware_image"]['name'];
			$config 			= array(
									'upload_path' 	=> "./uploads/hardware/",
									'allowed_types' => "jpg|png|jpeg",
									'overwrite' 	=> TRUE,
								//	'max_size'		=> "100",
									'file_name' 	=> $hardware_image,
									//'width'			=> "50",
									//'height'		=> "50"
								);
			

			$this->load->library('upload', $config); 
			$uploadedData 			= [];
			if($this->upload->do_upload('hardware_image'))
			{
				/*========Resize Image =======*/
				$reconfig['image_library'] = 'gd2';
			    $reconfig['source_image'] = './uploads/hardware/'.$hardware_image;
			   // $reconfig['create_thumb'] = TRUE;
			    $reconfig['maintain_ratio'] = TRUE;
			    $reconfig['width']     = 100;  
			    $reconfig['height']   = 100;

				$this->image_lib->clear();
			    $this->image_lib->initialize($reconfig);

				//$this->image_lib->crop();
			    $this->image_lib->resize();
			    /*========Resize Image =======*/
				
				
				$upload_data 	= array('upload_data' => $this->upload->data());
				$uploadedData	= $upload_data['upload_data'];
			}
			/* else
			{
				$error = array('error' => $this->upload->display_errors());
				$data['img_error'] = $error['error'];
				// $this->load->view('header',$data);
				// $this->load->view('hardwares/add_hardware',$data);
				// $this->load->view('footer',$data);
				$this->session->set_flashdata('hardwareError', 'Error! You hardware code is duplicate.');
				redirect('hardwares/addHardware');
			} */
			if(!empty($uploadedData['file_name'])){
				$arr['hardware_image'] = $uploadedData['file_name'];
			}
			$this->form_validation->set_rules('hardware_code','Hardware Code','is_unique[hardware_basic_tbl.hardware_code]');
			if($this->form_validation->run()){
				$table 		= 'hardware_basic_tbl';
				$response 	= $this->Hardwares_model->insertHardware($table,$arr);
				if($response){
					$this->session->set_flashdata('hardwareSuccess', 'Hardware Added successfully');
					redirect('hardwares');
				}else{
					$this->session->set_flashdata('hardwareError', 'Error! Hardware not added.');
					redirect('hardwares/addHardware');
				}
			}else{
				$this->session->set_flashdata('hardwareError',validation_errors());
				redirect('hardwares/addHardware');
				
			}
		}             
		$this->load->view('header',$data);
		$this->load->view('hardwares/add_hardware',$data);
		$this->load->view('footer',$data);
	}

	function getLastMonday($month, $year, $day){

		$number = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
		$date =  date('d', strtotime($day.' last week '.$year.'-'.$month.'-31'));

		$diff = $number - $date; 
		//echo '<br>';
		if(7 < $diff){
			$lastmonday = $date + 7;
		}else{
			$lastmonday = $date;
		}
		
		$dateNew = $year.'-'.$month.'-'.$lastmonday;
		
		return date('d-M-Y',strtotime($dateNew));
	}
	public function assignShop($id){
		$data['title']  		= 'Assign shop and section to hardware.';
		$data['hBasicDetails'] 	= $this->Hardwares_model->getHardwareBasicDetailById($id);
		$data['hardwareId'] 	= $id;
		$session_data 			= $this->session->userdata('loggedInUserDetail');
		$zone_id 				= $session_data->user_zone;
		$division_id 			= $session_data->user_division; 
		$data['sectionList'] 	= $this->Sections_model->getSection();
		$data['shopList'] 		= $this->Shops_model->getShopCount($zone_id,$division_id);
		$loggedInAdminId		= $this->session->userdata('loggedInAdmin');
		if($this->input->post('submit') || $this->input->post('add_more')){
			//echo "<pre>";print_r($this->input->post());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			$arr 							= [];
			$arr['hardware_id'] 			= $id;
			$arr['hardware_serial_no'] 		= $this->input->post('hardware_serial_no');
			$arr['shop_id'] 				= $this->input->post('shop_id');
			$arr['section_id'] 				= $this->input->post('section_id');
			$start_date						= $this->input->post('start_date');
			$startDate 						= date_create($start_date);
			$arr['start_date'] 				= date_format($startDate,"Y-m-d");
			$arr['hardware_remark'] 		= $this->input->post('hardware_remark');
			$arr['map_status'] 				= '10';
			$arr['map_created_date'] 		= date('Y-m-d');
			$arr['mapping_created_by'] 		= $loggedInAdminId;
			$this->form_validation->set_rules('hardware_serial_no','Hardware Serial Numaber','is_unique[hardware_mapping_section_tbl.hardware_serial_no]');

			if($this->form_validation->run()){
			//	if(1 == 1){

				$table 		= 'hardware_mapping_section_tbl';
				$response 	= $this->Hardwares_model->insertHardware($table,$arr);
				 if($response){
			//	if(1 == 1){

					// ================== Next schedule Date functionlity start here ===========================
					$nextScheduleDate						= '';
					$seviceDate = $_POST['service_date'];
					if($_POST['hardware_cycle'] == 1){						
						$Days = $_POST['daily_every_day'];						
						$nextScheduleDate = date('Y-m-d', strtotime($seviceDate. ' + '.$Days.' days'));
					}elseif($_POST['hardware_cycle'] == 2){
						$nextScheduleDate = date('Y-m-d',strtotime($_POST['weekly_day'], strtotime('this week +'.$_POST['weekly_recur_every'].' week')));
					}elseif($_POST['hardware_cycle'] == 3){
						if($_POST['monthly_type'] == 'day'){
							$NextMonthYear = date('M Y', strtotime($seviceDate. ' + 1 month'));
							$nextScheduleDate = date('Y-m-d',strtotime($_POST['monthly_date'].' '.$NextMonthYear));	
					
						}elseif($_POST['monthly_type'] == 'monthly'){
						
							$NextMonthYear = date('M Y', strtotime($seviceDate. ' + '.$_POST['monthly_name'].' month'));					
							if($_POST['monthly_week'] == 1){
								$nextScheduleDate = date('Y-m-d', strtotime("1 ".$NextMonthYear." "."this weeks ".$_POST['monthly_week_day'].""));
							}else if($_POST['monthly_week'] == 5){
								$yearNew = date('Y',strtotime($NextMonthYear));
								$monthNew = date('m',strtotime($NextMonthYear));
								$nextScheduleDate = $this->getLastMonday($monthNew,$yearNew,$_POST['monthly_week_day']);
							}else{
								$weekDays = $_POST['monthly_week'] - 1;
								$nextScheduleDate = date('Y-m-d', strtotime("1 ".$NextMonthYear." "."+ ".$weekDays." weeks ".$_POST['monthly_week_day'].""));
							}
						}

					}


					$arrschedule = array(
						'hardware_section_map_id'		=>		$response,	
						'hardware_id'					=>		$id,	
						'hardware_cycle'				=>		$_POST['hardware_cycle'],	
						'daily_every_day'				=>		$_POST['daily_every_day'],	
						'weekly_recur_every'			=>		$_POST['weekly_recur_every'],	
						'weekly_day'					=>		$_POST['weekly_day'],	
						'monthly_type'					=>		$_POST['monthly_type'],	
						'monthly_date'					=>		$_POST['monthly_date'],	
						'monthly_name'					=>		$_POST['monthly_name'],	
						'monthly_week'					=>		$_POST['monthly_week'],	
						'monthly_week_day'				=>		$_POST['monthly_week_day'],	
						'status'						=>		10,	
						'created'						=>		date('Y-m-d'),	
						'modified'						=>		date('Y-m-d'),
					);


					$tableschedule 		= 'hardware_schedule_mapping_tbl';
				    $responseSchedule 	= $this->Hardwares_model->insertHardware($tableschedule,$arrschedule);	


					// ================== Next schedule Date functionlity end here ===========================

					$scheduleArray 							= [];
					$scheduleArray['map_id'] 				= $response;
					$service_date                			= date_create($this->input->post('service_date'));
					$scheduleArray['schedule_start_date'] 	= date_format($service_date,"Y-m-d");
					$schedule_start_date 					= $scheduleArray['schedule_start_date'];
					$hBasicDetails 							= $data['hBasicDetails'];
					//$nextScheduleDate						= '';
					if(!empty($hBasicDetails)){
						$schedule_frequency_count			= $hBasicDetails->schedule_frequency_count;
						$schedule_frequency_cycle			= $hBasicDetails->schedule_frequency_cycle;
						//$nextScheduleDate					= $this->nextScheduleDate($schedule_frequency_count,$schedule_frequency_cycle,$schedule_start_date);
						$nextScheduleDate					= $nextScheduleDate;
					}
					/***** Dev code 14122019****/
					$today 			= date('Y-m-d');
					$seviceDateObj 	= date_create($seviceDate);
					$seviceDate 	= date_format($seviceDateObj,'Y-m-d');
					if(strtotime($seviceDate) > strtotime($today)){
						$scheduleArray['next_schedule_date'] 	= $seviceDate;
					}else{
						$scheduleArray['next_schedule_date'] 	= $nextScheduleDate;						
					}
					/***** Dev code 14122019****/
					
					//$scheduleArray['next_schedule_date'] 	= $nextScheduleDate;
					$scheduleArray['schedule_status'] 		= '10';
					$scheduleArray['schedule_created_date'] = date('Y-m-d');
					$scheduleArray['schedule_created_by']	= $loggedInAdminId;
					$schedule_table 			= 'hardware_schedule_config_tbl';
					//echo "<pre>";print_r($scheduleArray);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
					$schedule_response 			= $this->Hardwares_model->insertHardware($schedule_table,$scheduleArray);
					
					if($schedule_response){
						$this->session->set_flashdata('hardwareSuccess', 'Hardware mapped successfully');
						if($this->input->post('add_more') === 'Add More'){
							redirect('hardwares/assignShop/'.$id);
						}else{
							redirect('hardwares');							
						}
					}else{
						$this->session->set_flashdata('hardwareError', 'Error! Hardware not added.');
						redirect('hardwares/assign_shop/'.$id);
					}
				}else{
					$this->session->set_flashdata('hardwareError', 'Error! Hardware not added.');
					redirect('hardwares/assign_shop/'.$id);
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('hardwares/assign_shop',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('hardwares/assign_shop',$data);
			$this->load->view('footer',$data);
		}
	}
	public function getSectionByShop()
	{
		$postData 		= $this->input->post();
		$shopId 		= $postData['shop_id'];
		$sections 		= $this->Users_model->getShopSection($shopId);
		$html = "";
        foreach($sections as $res){
            $html .= '<option value="'.$res->section_id.'">'.$res->section_name.'</option>'; 
        }
		print_r($html);
	}
	public function editHardware($id)
	{
		$data['title'] 			= 'Edit Hardware';
		$hardwareData 			= $this->Hardwares_model->getHardwareBasicDetailById($id);
		$data['sectionList'] 	= $this->Sections_model->getSection();
		$data['shopList'] 		= $this->Shops_model->getShop();
		$session_data 			= $this->session->userdata('loggedInUserDetail');
		$zone_id 				= $session_data->user_zone;
		$division_id 			= $session_data->user_division; 
		$data['mshopList'] 		= $this->Maintenance_shops_model->getMShopCount($zone_id,$division_id);
		if(!empty($hardwareData)){
			$data['hardwareDataById'] 	= $hardwareData;
			$data['catList'] 			= $this->Categories_model->getCategoryByZoneDivision($zone_id,$division_id);
			$data['typeList'] 			= $this->Types_model->getTypeByZoneDivision($zone_id,$division_id);
			$data['editedId'] 			= $id;
			if($this->input->post('update')){
				$hardwareDataById 	= $data['hardwareDataById'];
				$hardware_code		= $hardwareDataById->hardware_code;
				if($hardware_code != $this->input->post('hardware_code')){
					$this->form_validation->set_rules('hardware_code','Hardware Numaber','is_unique[hardware_basic_tbl.hardware_code]');
				}else{
					$this->form_validation->set_rules('hardware_code','Hardware Numaber','required');
				}
				if($this->form_validation->run()){
					$postData = $this->input->post();
					$arr = array();
					$arr['hardware_category'] 			= $postData['hardware_category'];
					$arr['hardware_type'] 				= $postData['hardware_type'];
					$arr['hardware_code'] 				= $postData['hardware_code'];
					$arr['hardware_name'] 				= $postData['hardware_name'];
					$arr['hardware_model'] 				= $postData['hardware_model'];
					$arr['hardware_company'] 			= $postData['hardware_company'];
					$start_date 						= $postData['start_date'];
					$startDate 							= date_create($start_date);
					$arr['start_date'] 					= date_format($startDate,"Y-m-d");
					$arr['hardware_specification'] 		= $postData['hardware_specification'];
					$arr['default_maintenance_shop'] 	= $postData['maintenance_shop'];
					$arr['default_maintenance_section'] = $postData['maintenance_section'];
					$arr['schedule_frequency_count'] 	= $postData['schedule_frequency_count'];
					$arr['schedule_frequency_cycle'] 	= $postData['schedule_frequency_cycle'];
					$arr['hardware_updated_date'] 		= date('Y-m-d');
					$arr['hardware_updated_by'] 		= $this->session->userdata('loggedInAdmin');
					$hardware_image 	= time().'-'.$_FILES["hardware_image"]['name'];
					$config 			= array(
												'upload_path' 	=> "./uploads/hardware/",
												'allowed_types' => "jpg|png|jpeg",
												'overwrite' 	=> TRUE,
												'max_size'		=> "100",
												'file_name' 	=> $hardware_image
										);
					$this->load->library('upload', $config); 
					$uploadedData 			= [];
					if($this->upload->do_upload('hardware_image'))
					{
						/*========Resize Image =======*/
						$this->load->library('image_lib');
						$reconfig['image_library'] = 'gd2';
					    $reconfig['source_image'] = './uploads/hardware/'.$hardware_image;
					   // $reconfig['create_thumb'] = TRUE;
					    $reconfig['maintain_ratio'] = TRUE;
					    $reconfig['width']     = 100;  
					    $reconfig['height']   = 100;

						$this->image_lib->clear();
					    $this->image_lib->initialize($reconfig);

						//$this->image_lib->crop();
					    $this->image_lib->resize();
					    /*========Resize Image =======*/

						$upload_data 	= array('upload_data' => $this->upload->data());
						$uploadedData	= $upload_data['upload_data'];
					}else{
						$uploadedData['file_name']	= $hardwareDataById->hardware_image;
					}
					if(!empty($uploadedData['file_name'])){
						$arr['hardware_image'] = $uploadedData['file_name'];
					}
					$table = 'hardware_basic_tbl';
					//echo "<pre>";print_r($arr);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
					$response = $this->Hardwares_model->updateHardware($id,$arr,$table);
					if($response){
						$this->session->set_flashdata('hardwareSuccess', 'Hardware Updated successfully');
						redirect('hardwares');
					}else{
						$this->session->set_flashdata('hardwareError', 'Error! Hardware not updated.');
						redirect('hardwares/editHardware/'.$id);
					}
				}else{
					$this->load->view('header',$data);
					$this->load->view('hardwares/edit_hardware',$data);
					$this->load->view('footer',$data);
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('hardwares/edit_hardware',$data);
				$this->load->view('footer',$data);
			}
		}else{
			redirect('hardwares');
		}
	}
	
	public function editHardwareMap($id)
	{
		$data['title']  			= 'Edit hardware mapping';		
		$hwMapDetails 				= $this->Hardwares_model->getHardwareMapDataById($id);
		$hardware_id 				= $hwMapDetails->hardware_id;
		$hBasicDetails 				= $this->Hardwares_model->getHardwareBasicDetailById($hardware_id);
		$data['mapId'] 				= $id;
		$data['sectionList'] 		= $this->Sections_model->getSection();
		$data['shopList'] 			= $this->Shops_model->getShop();
		$loggedInAdminId			= $this->session->userdata('loggedInAdmin');
		if(!empty($hBasicDetails)){
			$data['hBasicDetails'] 	= $hBasicDetails;
			$data['hwMapDetails'] 	= $hwMapDetails;
			$data['editedId'] 		= $id;
			if($this->input->post('update')){
				$hardwareDataById 	= $data['hBasicDetails'];
				$hardware_code	= $hardwareDataById->hardware_code;
				if($hardware_code != $this->input->post('hardware_code')){
					$this->form_validation->set_rules('hardware_code','Hardware Numaber','is_unique[hardware_basic_tbl.hardware_code]');
				}else{
					$this->form_validation->set_rules('hardware_code','Hardware Numaber','required');
				}
				if($this->form_validation->run()){
					$postData = $this->input->post();
					unset($postData['update']);
					$start_date 						= date_create($postData['start_date']);
					$start_date 						= date_format($start_date,"Y-m-d");
					$postData['start_date'] 			= $start_date;
					$schedule_date 						= date_create($postData['service_date']);
					$schedule_date 						= date_format($schedule_date,"Y-m-d");
					$postData['schedule_start_date'] 	= $schedule_date;
					$schedule_count 					= $hBasicDetails->schedule_frequency_count;
					$schedule_cycle 					= $hBasicDetails->schedule_frequency_cycle;
					$schedule_next_date 				= $this->nextScheduleDate($schedule_count,$schedule_cycle,$postData['schedule_start_date'] );
					$postData['next_schedule_date'] 	= $schedule_next_date;
					$updateMapHardware					= [];
					$updateMapHardware					= array(
															'hardware_serial_no' 	=> $postData['hardware_serial_no'],
															'shop_id' 				=> $postData['shop_id'],
															'section_id' 			=> $postData['section_id'],
															'start_date' 			=> $postData['start_date'],
															'hardware_remark' 		=> $postData['hardware_remark'],
															'map_updated_date' 		=> date('Y-m-d'),
															'mapping_updated_by' 	=> $loggedInAdminId,
															);
					$table 								= 'hardware_mapping_section_tbl';
					$response 							= $this->Hardwares_model->updateMapHardware($updateMapHardware,$id,$table);
					/* if(isset($response)){
						$updateScheduleHardware			= array(
							'schedule_start_date' 	=> $postData['schedule_start_date'],
							'next_schedule_date' 	=> $postData['next_schedule_date'],
						);
						$table 				= 'hardware_schedule_config_tbl';
						$scheduleResponse 	= $this->Hardwares_model->updateMapHardware($updateScheduleHardware,$id,$table);
						if(isset($scheduleResponse)){
							$this->session->set_flashdata('hardwareSuccess', 'Hardware update successfully');
							redirect('hardwares/viewHardware/'.$hardware_id);
						}else{
							$this->session->set_flashdata('hardwareError', 'Error! Hardware not updated.');
							redirect('hardwares/editHardwareMap/'.$id);
						}
					}else{
						$this->session->set_flashdata('hardwareError', 'Error! Hardware not updated.');
						redirect('hardwares/editHardwareMap/'.$id);
					} */
					if($response){

						// ================== Next schedule Date functionlity start here ===========================
						/*$nextScheduleDate						= '';
						$seviceDate = $_POST['service_date'];
						if($_POST['hardware_cycle'] == 1){						
							$Days = $_POST['daily_every_day'];						
							$nextScheduleDate = date('Y-m-d', strtotime($seviceDate. ' + '.$Days.' days'));
						}elseif($_POST['hardware_cycle'] == 2){
							$nextScheduleDate = date('Y-m-d',strtotime($_POST['weekly_day'], strtotime('this week +'.$_POST['weekly_recur_every'].' week')));
						}elseif($_POST['hardware_cycle'] == 3){
							if($_POST['monthly_type'] == 'day'){
								$NextMonthYear = date('M Y', strtotime($seviceDate. ' + 1 month'));
								$nextScheduleDate = date('Y-m-d',strtotime($_POST['monthly_date'].' '.$NextMonthYear));	
						
							}elseif($_POST['monthly_type'] == 'monthly'){
							
								$NextMonthYear = date('M Y', strtotime($seviceDate. ' + '.$_POST['monthly_name'].' month'));					
								if($_POST['monthly_week'] == 1){
									$nextScheduleDate = date('Y-m-d', strtotime("1 ".$NextMonthYear." "."this weeks ".$_POST['monthly_week_day'].""));
								}else if($_POST['monthly_week'] == 5){
									$yearNew = date('Y',strtotime($NextMonthYear));
									$monthNew = date('m',strtotime($NextMonthYear));
									$nextScheduleDate = $this->getLastMonday($monthNew,$yearNew,$_POST['monthly_week_day']);
								}else{
									$weekDays = $_POST['monthly_week'] - 1;
									$nextScheduleDate = date('Y-m-d', strtotime("1 ".$NextMonthYear." "."+ ".$weekDays." weeks ".$_POST['monthly_week_day'].""));
								}
							}

						}


						$arrschedule = array(
							'hardware_cycle'				=>		$_POST['hardware_cycle'],	
							'daily_every_day'				=>		$_POST['daily_every_day'],	
							'weekly_recur_every'			=>		$_POST['weekly_recur_every'],	
							'weekly_day'					=>		$_POST['weekly_day'],	
							'monthly_type'					=>		$_POST['monthly_type'],	
							'monthly_date'					=>		$_POST['monthly_date'],	
							'monthly_name'					=>		$_POST['monthly_name'],	
							'monthly_week'					=>		$_POST['monthly_week'],	
							'monthly_week_day'				=>		$_POST['monthly_week_day'],	
							'modified'						=>		date('Y-m-d'),
						);
						//echo "<pre>";print_r($arrschedule);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						$tableschedule 		= 'hardware_schedule_mapping_tbl';
						$responseSchedule 	= $this->Hardwares_model->updateScheduleHardware($arrschedule,$id,$tableschedule);
						*/


						// ================== Next schedule Date functionlity end here ===========================

						$scheduleArray 							= [];
						$scheduleArray['map_id'] 				= $response;
						$service_date                			= date_create($this->input->post('service_date'));
						$scheduleArray['schedule_start_date'] 	= date_format($service_date,"Y-m-d");
						$schedule_start_date 					= $scheduleArray['schedule_start_date'];
						$hBasicDetails 							= $data['hBasicDetails'];
						//$nextScheduleDate						= '';
						if(!empty($hBasicDetails)){
							$schedule_frequency_count			= $hBasicDetails->schedule_frequency_count;
							$schedule_frequency_cycle			= $hBasicDetails->schedule_frequency_cycle;
							//$nextScheduleDate					= $this->nextScheduleDate($schedule_frequency_count,$schedule_frequency_cycle,$schedule_start_date);
							$nextScheduleDate					= $nextScheduleDate;
						}
						$scheduleArray['next_schedule_date'] 	= $nextScheduleDate;
						$scheduleArray['schedule_status'] 		= '10';
						$scheduleArray['schedule_created_date'] = date('Y-m-d');
						$scheduleArray['schedule_created_by']	= $loggedInAdminId;
						$schedule_table 			= 'hardware_schedule_config_tbl';
						//$schedule_response 			= $this->Hardwares_model->insertHardware($schedule_table,$scheduleArray);


						if($response){
							$this->session->set_flashdata('hardwareSuccess', 'Hardware mapped successfully');
							if($this->input->post('add_more') === 'Add More'){
								redirect('hardwares/editHardwareMap/'.$id);
							}else{
								redirect('hardwares');							
							}
						}else{
							$this->session->set_flashdata('hardwareError', 'Error! Hardware not added.');
							redirect('hardwares/editHardwareMap/'.$id);
						}
					}else{
						$this->session->set_flashdata('hardwareError', 'Error! Hardware not added.');
						redirect('hardwares/editHardwareMap/'.$id);
					}
				}else{
					$this->load->view('header',$data);
					$this->load->view('hardwares/edit_hardware_map',$data);
					$this->load->view('footer',$data);
				}
			}else{
				$this->load->view('header',$data);
				$this->load->view('hardwares/edit_hardware_map',$data);
				$this->load->view('footer',$data);
			}
		}else{
			redirect('hardwares');
		}
	}
	public function viewHardware($id)
	{
		$data['title'] 		= 'View Hardware';
		$hardwareData 		= $this->Hardwares_model->getHardwareBasicDetailById($id);
		//$maintenanceLogData	= $this->Hardwares_model->getMaintenanceLog($id);
		if(!empty($hardwareData)){
			$data['hardwareDataById'] 	= $hardwareData;
			/* if(!empty($maintenanceLogData)){
				$this->load->model('Users_model');
				$data['maintenanceLogData'] = $maintenanceLogData;
			} */
			$data['editedId'] 			= $id;
			$this->load->view('header',$data);
			$this->load->view('hardwares/view_hardware',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('hardwares');
		}
	}
	public function viewHardwareMap($id)
	{
		$data['title'] 				= 'View Hardware';
		$hardwareMapData 			= $this->Hardwares_model->getHardwareMapDataById($id);
		$hardwareData 				= $this->Hardwares_model->getHardwareBasicDetailById($hardwareMapData->hardware_id);
		if(!empty($hardwareData)){
			$data['hardwareDataByMapId'] 	= $hardwareMapData;
			$data['hardwareDataById'] 		= $hardwareData;
			/* if(!empty($maintenanceLogData)){
				$this->load->model('Users_model');
				$data['maintenanceLogData'] = $maintenanceLogData;
			} */
			$data['editedId'] 			= $id;
			$this->load->view('header',$data);
			$this->load->view('hardwares/view_hardware',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('hardwares');
		}
	}
	public function nextScheduleDate($schedule_count,$schedule_cycle,$schedule_date)
	{
		switch($schedule_cycle){
			case 'D':
			$schedule_cycle = 'day';
			break;
			case 'W':
			$schedule_cycle = 'week';
			break;
			case 'M':
			$schedule_cycle = 'month';
			break;
			case 'Y':
			$schedule_cycle = 'year';
			break;
		}
		$nextScheduleDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($schedule_date)) . " + ".$schedule_count." ".$schedule_cycle));
		return $nextScheduleDate;
	}
	/* public function deleteHardware($id)
	{
		$data['title'] 		= 'Delete Hardware';
		$postData['id']		= $id; 
		$deletedStatus 		= $this->Hardwares_model->deleteHardware($postData);
	} */
	
	public function getmSectionByMshop()
	{
		$shopId 		= $this->input->post('shop_id');
		$html = "";
		$sections 		= $this->Maintenance_sections_model->getMSectionByMshopId($shopId);
		//echo "<pre>";print_r($sections);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		if(!empty($sections)){
			foreach($sections as $res){
				$html .= '<option value="'.$res->maintenance_section_id.'">'.$res->maintenance_section_name.'</option>'; 
			}
		}else{
			$html .= '<option value=" ">No Section Mapped.</option>'; 
		}
		print_r($html);
	}
	
}