<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Maintenance_shops extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Maintenance_shops_model');  
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
		$data['title'] 		= 'Maintenance Shops';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$user_zone 			= $loggedInUserDetail->user_zone;
		$user_division 		= $loggedInUserDetail->user_division;	
		$data['mShopData'] 	= $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division,'all');
		//$data['mShopData'] 	= $this->Maintenance_shops_model->getMShop();
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		if($this->input->post('submit')){
			$existresponse = $this->Maintenance_shops_model->checkMShopExist($this->input->post('maintenance_shop_name'),$user_zone,$user_division);
			//echo "<pre>";print_r($existresponse);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			if($existresponse == '0'){
				$user_role 			= $loggedInUserDetail->user_role;
				$currentDate		= date('Y-m-d h:i:s a', time());
				$insertData			= array(
										'zone_id' 					=> $user_zone,
										'division_id'				=> $user_division,
										'maintenance_shop_name'		=> $this->input->post('maintenance_shop_name'),
										'maintenance_shop_status'	=> '10',
										'maintenance_shop_add_date'	=> $currentDate,
										'shop_created_by'			=> $user_role,
										
									);
				$insertResponse = $this->Maintenance_shops_model->insertShop($insertData);
				if($insertResponse){
					$this->session->set_flashdata('shopSuccess', 'Maintenance shop added successfully');
					redirect('maintenance_shops');
				}else{
					$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
					redirect('maintenance_shops');
				}
			}else{
				$this->session->set_flashdata('shopError', 'This maintenance shop is already exist.');
				$this->load->view('header',$data);
				$this->load->view('maintenance_shops/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('maintenance_shops/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editMshop($id)
	{
		$data['title'] 			= 'Edit Maintenance Shop';
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;	
		$data['mShopData'] 		= $this->Maintenance_shops_model->getMShopCount($user_zone,$user_division,'all');
		//$data['mShopData'] 		= $this->Maintenance_shops_model->getMShop();
		$data['mShopDataById'] 	= $this->Maintenance_shops_model->getMShopBy($id);
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$currentDate			= date('Y-m-d h:i:s a', time());
		$data['editedId'] 		= $id;
		if($this->input->post('update')){
            $mShopDataById    	= $data['mShopDataById'];
            $shop_name       	= $mShopDataById->maintenance_shop_name;
            if($shop_name != $this->input->post('maintenance_shop_name')){
			  $existresponse = $this->Maintenance_shops_model->checkMShopExist($this->input->post('maintenance_shop_name'),$user_zone,$user_division);
            }else{
                $this->form_validation->set_rules('maintenance_shop_name','Maintenance Shop Name','required');
            }
			if($this->form_validation->run() || $existresponse == '0'){
				$user_role 			= $loggedInUserDetail->user_role;
				$updateData			= array(
										'maintenance_shop_name'			=> $this->input->post('maintenance_shop_name'),
										'maintenance_shop_update_date'	=> $currentDate,
										'shop_updated_by'				=> $user_role,										
									);
				$updateResponse = $this->Maintenance_shops_model->updateMShop($id,$updateData);
				//echo "<pre>";print_r($updateResponse);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
				if($updateResponse){
					$this->session->set_flashdata('shopSuccess', 'Update successful');
					redirect('maintenance_shops/editMshop/'.$id);
				}else{
					$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
					redirect('maintenance_shops/editMshop/'.$id);
				}
			}else{
				$this->session->set_flashdata('shopError', 'This maintenance shop is already exist.');
				$this->load->view('header',$data);
				$this->load->view('maintenance_shops/edit_shop',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('maintenance_shops/edit_shop',$data);
			$this->load->view('footer',$data);
		}
	}
	
	public function deleteMshop($id)
	{
		$data['title'] 		= 'Inactive Maintenance Shop';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$currentDate		= date('Y-m-d h:i:s a', time());
		$user_role 			= $loggedInUserDetail->user_role;
		$updateData			= array(
								'maintenance_shop_status'		=> '80',
								'maintenance_shop_update_date'	=> $currentDate,
								'shop_updated_by'				=> $user_role
							); 
		$deletedStatus 			= $this->Maintenance_shops_model->deleteMShop($id,$updateData);
		if($deletedStatus){
			$this->session->set_flashdata('shopSuccess', 'Inactivated maintenance shop successfully');
			redirect('maintenance_shops');
		}else{
			$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
			redirect('maintenance_shops');
		}
	}
	public function activateMshop($id)
	{
		$data['title'] 		= 'Active Maintenance Shop';
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$currentDate		= date('Y-m-d h:i:s a', time());
		$user_role 			= $loggedInUserDetail->user_role;
		$updateData			= array(
								'maintenance_shop_status'		=> '10',
								'maintenance_shop_update_date'	=> $currentDate,
								'shop_updated_by'				=> $user_role
							); 
		$deletedStatus 			= $this->Maintenance_shops_model->activateMShop($id,$updateData);
		if($deletedStatus){
			$this->session->set_flashdata('shopSuccess', 'Activated maintenance shop successfully');
			redirect('maintenance_shops');
		}else{
			$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
			redirect('maintenance_shops');
		}
	}
}