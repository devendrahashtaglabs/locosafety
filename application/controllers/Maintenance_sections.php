<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Maintenance_sections extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Maintenance_sections_model'); 
		$this->load->model('Maintenance_shops_model'); 
		$this->load->model('Categories_model'); 
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
		$data['title'] 			= 'Maintenance Sections';
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		//$data['msectionData'] 	= $this->Maintenance_sections_model->getMSection();
		//$data['mShopData'] 		= $this->Maintenance_shops_model->getMShop();
			
		$data['mShopData'] = $allMShop =  $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division);
		
		$data['msectionData'] = '';
		$mshopIdArray = [];
		foreach($allMShop as $singleMShop){
			$mshopIdArray[] = $singleMShop->maintenance_shop_id;			
		}
		if(!empty($mshopIdArray)){
			$allMSection		= $this->Maintenance_sections_model->getMSectionALL($mshopIdArray,'all');
			if(!empty($allMSection)){
				$data['msectionData'] = $allMSection;
			}
		}
		$data['hCatData'] 		= $this->Categories_model->getAllCategory();
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_role 				= $loggedInUserDetail->user_role;
		$currentDate			= date('Y-m-d h:i:s a', time());
		if($this->input->post('submit')){
			$existresponse 		= $this->Maintenance_sections_model->checkMSectionExist($this->input->post('maintenance_shop_id'),$this->input->post('maintenance_section_code'));
			if($existresponse == '0'){
				$hwcat			= '';
				$hardware_cat 	= $this->input->post('hardware_cat');
				if(isset($hardware_cat)){
					$hwcat = $this->input->post('hardware_cat');
				}
				$insertData			= array(
										'maintenance_shop_id' 			=> $this->input->post('maintenance_shop_id'),
										'default_hardware_cat'			=> $hwcat,
										'maintenance_section_code'		=> $this->input->post('maintenance_section_code'),
										'maintenance_section_name'		=> $this->input->post('maintenance_section_name'),
										'maintenance_section_status'	=> '10',
										'maintenance_section_add_date'	=> $currentDate,
										'section_created_by'			=> $user_role,
										
									);
				$insertResponse = $this->Maintenance_sections_model->insertSection($insertData);
				if($insertResponse){
					$this->session->set_flashdata('sectionSuccess', 'Maintenance section added successfully');
					redirect('maintenance_sections');
				}else{
					$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
					redirect('maintenance_sections');
				}
			}else{
				$this->session->set_flashdata('sectionError', 'This maintenance section is already exist.');
				$this->load->view('header',$data);
				$this->load->view('maintenance_sections/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('maintenance_sections/index',$data);
			$this->load->view('footer',$data);
		}
	}
	 public function editMSection($id)
	{
		$data['title'] 			= 'Edit Maintenance Section';
		
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;
		$data['mShopData']  	= $allMShop =  $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division);
		
		$data['msectionData'] 	= '';
		$mshopIdArray = [];
		foreach($allMShop as $singleMShop){
			$mshopIdArray[] = $singleMShop->maintenance_shop_id;			
		}
		if(!empty($mshopIdArray)){
			$allMSection		= $this->Maintenance_sections_model->getMSectionALL($mshopIdArray,'all');
			if(!empty($allMSection)){
				$data['msectionData'] = $allMSection;
			}
		}
		
		//$data['msectionData'] 		= $this->Maintenance_sections_model->getMSection();
		//$data['mshopData'] 			= $this->Maintenance_shops_model->getMShop();
		$data['msectionDataById'] 	= $this->Maintenance_sections_model->getMSectionBy($id);
		$data['hCatData'] 			= $this->Categories_model->getAllCategory();
		$data['editedId'] 			= $id;
		$loggedInUserDetail 		= $this->session->userdata('loggedInUserDetail');
		$user_role 					= $loggedInUserDetail->user_role;
		$currentDate				= date('Y-m-d h:i:s a', time());
		if($this->input->post('update')){
            $sectionDataById    = $data['msectionDataById'];
            $section_code       = $sectionDataById->maintenance_section_code;
			$existresponse		= '0';
            if($section_code != $this->input->post('maintenance_section_code')){
              $existresponse 		= $this->Maintenance_sections_model->checkMSectionExist($this->input->post('maintenance_shop_id'),$this->input->post('maintenance_section_code'));
            }else{
                $this->form_validation->set_rules('maintenance_section_code','Maintenance Section Code','required');
            }
			if($this->form_validation->run() || $existresponse == '0'){
				$hwcat			= '';
				$hardware_cat 	= $this->input->post('hardware_cat');
				if(isset($hardware_cat)){
					$hwcat = $this->input->post('hardware_cat');
				}
				$updatedData			= array(
											'maintenance_shop_id' 				=> $this->input->post('maintenance_shop_id'),
											'default_hardware_cat'				=> $hwcat,
											'maintenance_section_code'			=> $this->input->post('maintenance_section_code'),
											'maintenance_section_name'			=> $this->input->post('maintenance_section_name'),
											'maintenance_section_update_date'	=> $currentDate,
											'section_updated_by'				=> $user_role,								
										);
				$updateresponse = $this->Maintenance_sections_model->updateSection($id,$updatedData);
				if($updateresponse){
					$this->session->set_flashdata('sectionSuccess', 'Updated successful');
					redirect('maintenance_sections/editMSection/'.$id);
				}else{
					$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
					redirect('maintenance_sections/editMSection/'.$id);
				}
			}else{
				$this->session->set_flashdata('sectionError', 'This maintenance section is already exist.');
				$this->load->view('header',$data);
				$this->load->view('maintenance_sections/edit_section',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('maintenance_sections/edit_section',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteMSection($id)
	{
		$data['title'] 			= 'Inactive Maintenance Section';
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_role 				= $loggedInUserDetail->user_role;
		$currentDate			= date('Y-m-d h:i:s a', time());
		$updatedData			= array(
									'maintenance_section_status'		=> '80',
									'maintenance_section_update_date'	=> $currentDate,
									'section_updated_by'				=> $user_role,								
								);
		$updateresponse 		= $this->Maintenance_sections_model->updateSection($id,$updatedData);
		if($updateresponse){
			$this->session->set_flashdata('success', 'Inactivated Maintenance Section successfully');
			redirect('maintenance_sections');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('maintenance_sections');
		}
	}
	public function activateMSection($id)
	{
		$data['title'] 			= 'Activate Maintenance Section';
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_role 				= $loggedInUserDetail->user_role;
		$currentDate			= date('Y-m-d h:i:s a', time());
		$updatedData			= array(
									'maintenance_section_status'		=> '10',
									'maintenance_section_update_date'	=> $currentDate,
									'section_updated_by'				=> $user_role,								
								);
		$updateresponse 		= $this->Maintenance_sections_model->updateSection($id,$updatedData);
		if($updateresponse){
			$this->session->set_flashdata('success', 'Activated Maintenance Section successfully');
			redirect('maintenance_sections');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('maintenance_sections');
		}
	}
}