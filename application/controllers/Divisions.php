<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Divisions extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Divisions_model'); 
		$this->load->model('Zones_model'); 
		$this->load->model('Users_model'); 
		$loggedInAdmin 		= $this->session->userdata('loggedInAdmin');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_role 			= $loggedInUserDetail->user_role;
		if(empty($loggedInAdmin) || $user_role != '1'){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 			= 'Offices/Divisions';
		$data['divisionData'] 	= $this->Divisions_model->getDivision();
		$data['zoneData'] 		= $this->Zones_model->getZone();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('division_code','Division Code','is_unique[master_division_tbl.division_code]');
			$this->form_validation->set_rules('division_name','Division Name','is_unique[master_division_tbl.division_name]');
			if($this->form_validation->run()){
				$postData = $this->input->post();
				unset($postData['submit']);
				$this->Divisions_model->insertDivision($postData);
			}else{
				$this->load->view('header',$data);
				$this->load->view('divisions/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('divisions/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editDivision($id)
	{
		$data['title'] 				= 'Edit Office/Division';
		$data['divisionData'] 		= $this->Divisions_model->getDivision();
		$data['divisionDataById'] 	= $this->Divisions_model->getDivisionBy($id);
		$data['zoneData'] 			= $this->Zones_model->getZone();
		$data['editedId'] 			= $id;
		if($this->input->post('update')){
            $divisionDataById    = $data['divisionDataById'];
            $division_code       = $divisionDataById->division_code;
            $division_name       = $divisionDataById->division_name;
            if($division_code != $this->input->post('division_code')){
                $this->form_validation->set_rules('division_code','Division Code','is_unique[master_division_tbl.division_code]');
            }else{
                $this->form_validation->set_rules('division_code','Division Code','required');
            }
			 if($division_name != $this->input->post('division_name')){
                $this->form_validation->set_rules('division_name','Division Name','is_unique[master_division_tbl.division_name]');
            }else{
                $this->form_validation->set_rules('division_name','Division Name','required');
            }
			if($this->form_validation->run()){
				$postData = $this->input->post();
				unset($postData['update']);
				$postData['id'] = $id;
				$this->Divisions_model->updateDivision($postData);
			}else{
				$this->load->view('header',$data);
				$this->load->view('divisions/edit_division',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('divisions/edit_division',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteDivision($id)
	{
		$data['title'] 			= 'Delete Division';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Divisions_model->deleteDivision($postData);
	}
	public function activateDivision($id)
	{
		$data['title'] 			= 'Activate Division';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Divisions_model->activateDivision($postData);
	}
}