<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Types extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Types_model'); 
		$this->load->model('Users_model'); 
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role == '1'){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 		= 'Types';
		$session_data 		= $this->session->userdata('loggedInUserDetail');
		$zone_id 			= $session_data->user_zone;
		$division_id 		= $session_data->user_division;
		$data['typeData'] 	= $this->Types_model->getTypeByZoneDivision($zone_id,$division_id);
		if($this->input->post('submit')){
			$existresponse = $this->Types_model->checkTypeExist($this->input->post('type_code'),$zone_id,$division_id);
			if($existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['submit']);
				$this->Types_model->insertType($postData);
			}else{
				$this->session->set_flashdata('typeError', 'This type is already exist.');
				$this->load->view('header',$data);
				$this->load->view('types/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('types/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editType($id)
	{
		$data['title'] 			= 'Edit Type';
		$session_data 			= $this->session->userdata('loggedInUserDetail');
		$zone_id 				= $session_data->user_zone;
		$division_id 			= $session_data->user_division;
		$data['typeData'] 		= $this->Types_model->getTypeByZoneDivision($zone_id,$division_id);
		$data['typeDataById'] 	= $this->Types_model->getTypeByID($id);
		$data['editedId'] 		= $id;
		if($this->input->post('update')){
            $typeDataById   = $data['typeDataById'];
            $type_code   	= $typeDataById->hardware_type_code;
			$existresponse 	= '0';
            if($type_code != $this->input->post('type_code')){
               $existresponse = $this->Types_model->checkTypeExist($this->input->post('type_code'),$zone_id,$division_id);
            }else{
               $this->form_validation->set_rules('type_code','Type Code','required');
            }
			if($this->form_validation->run() || $existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['update']);
				$postData['id'] = $id;
				$this->Types_model->updateType($postData);
			}else{
				$this->session->set_flashdata('typeError', 'This type is already exist.');
				$this->load->view('header',$data);
				$this->load->view('types/edit_type',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('types/edit_type',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteType($id)
	{
		$data['title'] 			= 'Delete Type';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Types_model->deleteType($postData);
	}

	public function activeType($id)
	{
		$data['title'] 			= 'Delete Type';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Types_model->activeType($postData);
	}
}