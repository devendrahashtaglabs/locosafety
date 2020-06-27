<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sections extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Sections_model'); 
		$this->load->model('Shops_model'); 
		$this->load->model('Users_model'); 
                 
		$this->load->model('Dashboard_model'); 
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
		$data['title'] 			= 'Sections';
		$data['sectionData'] 	= $this->Sections_model->getSection('all');
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		//$data['shopData'] 		= $this->Shops_model->getShop();
		$data['shopData'] 		= $this->Shops_model->getShopCount($user_zone,$user_division);
		if($this->input->post('submit')){
			//$this->form_validation->set_rules('section_code','Section Code','is_unique[master_section_tbl.section_code]');
			$existresponse 		= $this->Sections_model->checkSectionExist($this->input->post('shop_id'),$this->input->post('section_code'));
			if($existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['submit']);
				$this->Sections_model->insertSection($postData);
			}else{
				$this->session->set_flashdata('sectionError', 'This section is already exist.');
				$this->load->view('header',$data);
				$this->load->view('sections/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('sections/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editSection($id)
	{
		$data['title'] 				= 'Edit Section';
		$loggedInUserDetail 		= $this->session->userdata('loggedInUserDetail');
		$user_zone 					= $loggedInUserDetail->user_zone;
		$user_division 				= $loggedInUserDetail->user_division;
		$data['sectionData'] 		= $this->Sections_model->getSection('all');
		$data['shopData'] 			= $this->Shops_model->getShopCount($user_zone,$user_division);
		$data['sectionDataById'] 	= $this->Sections_model->getSectionBy($id);
		$data['editedId'] 			= $id;
		if($this->input->post('update')){
            $sectionDataById    = $data['sectionDataById'];
            $section_code       = $sectionDataById->section_code;
            if($section_code != $this->input->post('section_code')){
              $existresponse 		= $this->Sections_model->checkSectionExist($this->input->post('shop_id'),$this->input->post('section_code'));
            }else{
                $this->form_validation->set_rules('section_code','Section Code','required');
            }
			if($this->form_validation->run() || $existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['update']);
				$postData['id'] = $id;
				$this->Sections_model->updateSection($postData);
			}else{
				$this->session->set_flashdata('sectionError', 'This section is already exist.');
				$this->load->view('header',$data);
				$this->load->view('sections/edit_section',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('sections/edit_section',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteSection($id)
	{
		$data['title'] 			= 'Delete Section';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Sections_model->deleteSection($postData);
	}
	public function activateSection($id)
	{
		$data['title'] 			= 'Activate Section';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Sections_model->activateSection($postData);
	}
        
        public function sectiondata($id){
            
            $data['title'] 				= 'Section Data';
            $data['sectionid']     =  $id;
            $loggedInUserDetail                         = $this->session->userdata('loggedInUserDetail');
            $user_zone 		= $data['user_zone']	= $loggedInUserDetail->user_zone;
            $user_division      = $data['user_division']= $loggedInUserDetail->user_division;
            $data['sectionDataById'] 	= $this->Sections_model->getSectionBy($id);
            $this->load->view('header',$data);
            $this->load->view('sections/sectiondata',$data);
            $this->load->view('footer',$data);
            
        }
        
}