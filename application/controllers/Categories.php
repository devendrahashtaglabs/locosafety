<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Categories extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
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
		$data['title'] 		= 'Categories';
		$session_data 		= $this->session->userdata('loggedInUserDetail');
		$zone_id 			= $session_data->user_zone;
		$division_id 		= $session_data->user_division;
		$data['catData'] 	= $this->Categories_model->getCategoryByZoneDivision($zone_id,$division_id);
		if($this->input->post('submit')){ 
			$existresponse = $this->Categories_model->checkCategoryExist($this->input->post('category_code'),$zone_id,$division_id);
			if($existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['submit']);
				$this->Categories_model->insertCategory($postData);
			}else{
				$this->session->set_flashdata('error', 'This category is already exist.');
				$this->load->view('header',$data);
				$this->load->view('categories/index',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('categories/index',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editCat($id)
	{
		$data['title'] 			= 'Edit Category';
		$session_data 			= $this->session->userdata('loggedInUserDetail');
		$zone_id 				= $session_data->user_zone;
		$division_id 			= $session_data->user_division;
		$data['catData'] 		= $this->Categories_model->getCategoryByZoneDivision($zone_id,$division_id);
		$data['catDataById'] 	= $this->Categories_model->getCategoryBy($id);
		$data['editedId'] 		= $id;
		if($this->input->post('update')){
            $catDataById   = $data['catDataById'];
            $category_code    = $catDataById->category_code;
            if($category_code != $this->input->post('category_code')){
				$existresponse = $this->Categories_model->checkCategoryExist($this->input->post('category_code'),$zone_id,$division_id);
            }else{
                $this->form_validation->set_rules('category_code','Category Code','required');
            }
			if($this->form_validation->run() || $existresponse == '0'){
				$postData = $this->input->post();
				unset($postData['update']);
				$postData['id'] = $id;
				$this->Categories_model->updateCategory($postData);
			}else{
				$this->session->set_flashdata('error', 'This category is already exist.');
				$this->load->view('header',$data);
				$this->load->view('categories/edit_category',$data);
				$this->load->view('footer',$data);
			}
		}else{
			$this->load->view('header',$data);
			$this->load->view('categories/edit_category',$data);
			$this->load->view('footer',$data);
		}
	}
	public function deleteCat($id)
	{
		$data['title'] 			= 'Delete Category';
		$data['catData'] 		= $this->Categories_model->getCategory();
		$data['catDataById'] 	= $this->Categories_model->getCategoryBy($id);
		//$postData['id']			= $id; 
		$deletedStatus 			= $this->Categories_model->deleteCategory($id);
	}

	public function activeCat($id)
	{
		$data['title'] 			= 'Delete Category';
		$data['catData'] 		= $this->Categories_model->getCategory();
		$data['catDataById'] 	= $this->Categories_model->getCategoryBy($id);
		//$postData['id']			= $id; 
		$deletedStatus 			= $this->Categories_model->activeCategory($id);
	}
}