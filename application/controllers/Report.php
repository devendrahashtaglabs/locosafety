<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Tickets_model'); 
		$this->load->model('Users_model');
		$this->load->model('Sections_model'); 
		$this->load->model('Shops_model');		
		$this->load->model('Reports_model');	
		$this->load->model('Maintenance_sections_model');	
		$this->load->model('Maintenance_shops_model');	
		$this->load->model('Hardwares_model');	
		$this->load->model('Categories_model');				
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role == '1'){
			redirect('login');
		}
	}

	public function index()
	{
		redirect('report/usersection');
	}

	public function usersection(){
		$data['title'] 				= 'User Section Report';
		$data['UserSectionData'] 	= $this->Reports_model->GetUserSection();
		$this->load->view('header',$data);
		$this->load->view('reports/user-section',$data);
		$this->load->view('footer',$data);
	}

	public function gethardwaredata($ID){
		$idtype 				= $this->input->post('idType');
		$data['title'] 			= 'Tickets Logs';
		//$data['HardwareData'] 	= $this->Hardwares_model->getHardwareDataBySectionID($ID,$idtype);				
		$data['HardwareData'] 	= $this->Hardwares_model->getHardwareDataByShopID($ID,$idtype);
		$this->load->view('reports/hardware-list-by-user.php',$data);
	}

	public function hardwaresection(){
		$filterID 					= $this->input->get('filterId');
		$data['title'] 				= 'Hardware Section Report';
		//$data['UserSectionData'] 	= $this->Hardwares_model->GetALLMappingData();
		
		if(isset($filterID)){
			if($filterID == 'B90'){
				$filterID = '90';				
				$data['UserSectionData'] 	= $this->Reports_model->FilterHardwareSectionByStatus($filterID);
				
				
			}elseif($filterID == 'B60'){
				$filterID = '60';
				$data['UserSectionData'] 	= $this->Reports_model->FilterHardwareSectionByDueStatus($filterID);
			}else{
				$data['UserSectionData'] 	= $this->Reports_model->FilterHardwareSection($filterID);
			}
		}else{
			$data['UserSectionData'] 	= $this->Reports_model->GetHardwareSection();
		}
		$this->load->view('header',$data);
		$this->load->view('reports/hardware-section',$data);
		$this->load->view('footer',$data);
	}

}