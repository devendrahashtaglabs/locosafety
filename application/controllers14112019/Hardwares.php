<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hardwares extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Hardwares_model'); 
		$this->load->model('Categories_model');
		$this->load->model('Types_model');
		$this->load->model('Shops_model');
		$this->load->model('Sections_model');
		$config = array(
			'upload_path' 		=> "./uploads/hardware/", 
			'allowed_types' 	=> "jpg|png|jpeg",
			'overwrite' 		=> TRUE,
			'max_size'			=> "2048000",
		);
		$this->load->library('upload', $config); 
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 			= 'Hardwares';
		$status			=  $this->input->get('searchByStatus');
		if( $status === NULL ){
			$status					= '10';
			$data['hardwareData'] 	= $this->Hardwares_model->getStatusFilter($status);
		}elseif($status == 'all'){			
			$data['hardwareData'] 	= $this->Hardwares_model->getHardware();		
		}else{			
			$data['hardwareData'] 	= $this->Hardwares_model->getStatusFilter($status);			
		}
		//echo "<pre>";print_r($data['hardwareData']);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ ); 
		$data['status'] 			= $status;
		$this->load->view('header',$data);
		$this->load->view('hardwares/index',$data);
		$this->load->view('footer',$data);
	}
	public function addHardware()
	{
		$data['title'] 			= 'Add Hardwares';
		$data['catList'] 		= $this->Categories_model->getCategory();
		$data['typeList'] 		= $this->Types_model->getType();
		$data['sectionList'] 	= $this->Sections_model->getSection();
		$data['shopList'] 		= $this->Shops_model->getShop();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('hardware_number','Hardware Numaber','is_unique[hardware_tbl.hardware_number]');
			if($this->form_validation->run()){
				$postData = $this->input->post();
				unset($postData['submit']);
				$postData['user_id'] 			= 'admin';
				$mfgDate 						= date_create($postData['hardware_mfg_date']);
				$postData['hardware_mfg_date'] 	= date_format($mfgDate,"Y-m-d");
				$expDate 						= date_create($postData['hardware_exp_date']);
				$postData['hardware_exp_date'] 	= date_format($expDate,"Y-m-d");
				$serviceDate 					= date_create($postData['service_date']);
				$postData['service_date'] 		= date_format($serviceDate,"Y-m-d");
				$service_date					= $postData['service_date'];
				$serviceCount 					= $postData['service_frequency_count'];
				$serviceCycle 					= $postData['service_frequency_cycle'];
				$nextDate 						= $this->nextServiceDate($serviceCount,$serviceCycle,$service_date);
				$postData['service_date_next'] 	= $nextDate;
				$uploadedData 					= [];
				if($this->upload->do_upload('hardware_image'))
				{
					$upload_data 	= array('upload_data' => $this->upload->data());
					$uploadedData	= $upload_data['upload_data'];
				}
				else
				{
					$error = array('error' => $this->upload->display_errors());
				}
				$postData['hardware_image'] = $uploadedData['file_name'];
				$this->Hardwares_model->insertHardware($postData);				
			}else{
				$this->load->view('header',$data);
				$this->load->view('hardwares/add_hardware',$data);
				$this->load->view('footer',$data);	
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('hardwares/add_hardware',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editHardware($id)
	{
		$data['title'] 				= 'Edit Hardware';
		$hardwareData 				= $this->Hardwares_model->getHardwareBy($id);
		$data['sectionList'] 		= $this->Sections_model->getSection();
		$data['shopList'] 			= $this->Shops_model->getShop();
		if(!empty($hardwareData)){
			$data['hardwareDataById'] 	= $hardwareData[0];
			$data['catList'] 			= $this->Categories_model->getCategory();
			$data['typeList'] 			= $this->Types_model->getType();
			$data['editedId'] 			= $id;
			if($this->input->post('update')){
				$hardwareDataById 	= $data['hardwareDataById'];
				$hardware_number	= $hardwareDataById->hardware_number;
				if($hardware_number != $this->input->post('hardware_number')){
					$this->form_validation->set_rules('hardware_number','Hardware Numaber','is_unique[hardware_tbl.hardware_number]');
				}else{
					$this->form_validation->set_rules('hardware_number','Hardware Numaber','required');
				}
				if($this->form_validation->run()){
					$postData = $this->input->post();
					unset($postData['update']);
					$mfgDate 						= date_create($postData['hardware_mfg_date']);
					$postData['hardware_mfg_date'] 	= date_format($mfgDate,"Y-m-d");
					$expDate 						= date_create($postData['hardware_exp_date']);
					$postData['hardware_exp_date'] 	= date_format($expDate,"Y-m-d");
					$service_date					= date_create($postData['service_date']);
					$postData['service_date'] 		= date_format($service_date,"Y-m-d");
					$service_date					= $postData['service_date'];
					$serviceCount 					= $postData['service_frequency_count'];
					$serviceCycle 					= $postData['service_frequency_cycle'];
					$nextDate 						= $this->nextServiceDate($serviceCount,$serviceCycle,$service_date);
					$postData['service_date_next'] 	= $nextDate;
					$uploadedData 					= [];
					if($this->upload->do_upload('hardware_image'))
					{
						$upload_data 	= array('upload_data' => $this->upload->data());
						$uploadedData	= $upload_data['upload_data'];
					}
					else
					{
						$hardwareDataById 			= $data['hardwareDataById'];
						$uploadedData['file_name']	= $hardwareDataById->hardware_image;
					}
					$postData['hardware_image'] = $uploadedData['file_name'];
					$postData['id'] 			= $id;
					$this->Hardwares_model->updateHardware($postData);
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
	public function viewHardware($id)
	{
		$data['title'] 		= 'View Hardware';
		$hardwareData 		= $this->Hardwares_model->getHardwareBy($id);
		$maintenanceLogData	= $this->Hardwares_model->getMaintenanceLog($id);
		if(!empty($hardwareData)){
			$data['hardwareDataById'] 	= $hardwareData[0];
			if(!empty($maintenanceLogData)){
				$this->load->model('Users_model');
				$data['maintenanceLogData'] = $maintenanceLogData;
			}
			$data['editedId'] 			= $id;
			$this->load->view('header',$data);
			$this->load->view('hardwares/view_hardware',$data);
			$this->load->view('footer',$data);
		}else{
			redirect('hardwares');
		}
	}
	public function deleteHardware($id)
	{
		$data['title'] 		= 'Delete Hardware';
		$postData['id']		= $id; 
		$deletedStatus 		= $this->Hardwares_model->deleteHardware($postData);
	}
	public function nextServiceDate($service_count,$service_cycle,$service_date)
	{
		switch($service_cycle){
			case 'D':
			$service_cycle = 'day';
			break;
			case 'W':
			$service_cycle = 'week';
			break;
			case 'M':
			$service_cycle = 'month';
			break;
			case 'Y':
			$service_cycle = 'year';
			break;
		}
		$newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($service_date)) . " + ".$service_count." ".$service_cycle));
		return $newEndingDate;
	}
}