<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Zones extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Zones_model'); 
		$this->load->model('Users_model'); 
		$loggedInAdmin 	= $this->session->userdata('loggedInAdmin');
		if(empty($loggedInAdmin)){
			redirect('login');
		}
	}
	public function index()
	{
		$data['title'] 		= 'Zones';
		$data['zoneData'] 	= $this->Zones_model->getZone();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('zone_code','Zone Code','is_unique[master_zone_tbl.zone_code]');
			if($this->form_validation->run()){
				$postData = $this->input->post();
				unset($postData['submit']);
				$this->Zones_model->insertZone($postData);
			}else{
				$this->load->view('header',$data);
				$this->load->view('zones/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('zones/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editZone($id)
	{
		$data['title'] 			= 'Edit Zone';
		$data['zoneData'] 		= $this->Zones_model->getZone();
		$data['zoneDataById'] 	= $this->Zones_model->getZoneBy($id);
		$data['editedId'] 		= $id;
		if($this->input->post('update')){
            $zoneDataById    = $data['zoneDataById'];
            $zone_code       = $zoneDataById->zone_code;
            if($zone_code != $this->input->post('zone_code')){
                $this->form_validation->set_rules('zone_code','Zone Code','is_unique[master_zone_tbl.zone_code]');
            }else{
                $this->form_validation->set_rules('zone_code','Zone Code','required');
            }
			if($this->form_validation->run()){
				$postData = $this->input->post();
				unset($postData['update']);
				$postData['id'] = $id;
				$this->Zones_model->updateZone($postData);
			}else{
				$this->load->view('header',$data);
				$this->load->view('zones/edit_zone',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('zones/edit_zone',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteZone($id)
	{
		$data['title'] 			= 'Delete Zone';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Zones_model->deleteZone($postData);
	}
	public function activateZone($id)
	{
		$data['title'] 			= 'Activate Zone';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Zones_model->activateZone($postData);
	}
}