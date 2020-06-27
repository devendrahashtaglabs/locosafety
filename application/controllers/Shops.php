<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shops extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Shops_model'); 
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
		$data['title'] 			= 'Shops';
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;	
		//$data['shopData'] 	= $this->Shops_model->getShop();
		$data['shopData'] 		= $this->Shops_model->getShopCount($user_zone,$user_division,'all');
		if($this->input->post('submit')){
			//$this->form_validation->set_rules('shop_name','Shop Name','is_unique[master_shop_tbl.shop_name]');
			$existresponse = $this->Shops_model->checkShopExist($this->input->post('shop_name'),$user_zone,$user_division);
			//echo "<pre>";print_r($existresponse);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			if($existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['submit']);
				$loggedInUserDetail 		= $this->session->userdata('loggedInUserDetail');
				$postData['zone_id'] 		= $loggedInUserDetail->user_zone; 
				$postData['division_id'] 	= $loggedInUserDetail->user_division; 
				$postData['user_role'] 		= $loggedInUserDetail->user_role; 
				$this->Shops_model->insertShop($postData);
			}else{
				$this->session->set_flashdata('shopError', 'Shop name already exist.');
				$this->load->view('header',$data);
				$this->load->view('shops/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('shops/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editShop($id)
	{
		$data['title'] 			= 'Edit Shop';
		$loggedInUserDetail 	= $this->session->userdata('loggedInUserDetail');
		$user_zone 				= $loggedInUserDetail->user_zone;
		$user_division 			= $loggedInUserDetail->user_division;	
		$data['shopData'] 		= $this->Shops_model->getShopCount($user_zone,$user_division,'all');
		$data['shopDataById'] 	= $this->Shops_model->getShopBy($id);
		$data['editedId'] 		= $id;
		if($this->input->post('update')){
            $shopDataById    = $data['shopDataById'];
            $shop_name       = $shopDataById->shop_name;
            if($shop_name != $this->input->post('shop_name')){
              $existresponse = $this->Shops_model->checkShopExist($this->input->post('shop_name'),$user_zone,$user_division);
            }else{
                $this->form_validation->set_rules('shop_name','Shop Name','required');
            }
			//echo "<pre>";print_r($existresponse);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
			if($this->form_validation->run() || $existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['update']);
				$postData['id'] = $id;
				$this->Shops_model->updateShop($postData);
			}else{
				$this->load->view('header',$data);
				$this->load->view('shops/edit_shop',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('shops/edit_shop',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteShop($id)
	{
		$data['title'] 			= 'Delete Shop';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Shops_model->deleteShop($postData);
	}
	public function activateShop($id)
	{
		$data['title'] 			= 'Activate Shop';
		$postData['id']			= $id; 
		$deletedStatus 			= $this->Shops_model->activateShop($postData);
	}
}