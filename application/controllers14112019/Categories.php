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
        $loggedInAdmin  = $this->session->userdata('loggedInAdmin');
        if(empty($loggedInAdmin)){
            redirect('login');
        } 
    }
    public function index()
    {
        $data['title']      = 'Categories';
        $data['catData']    = $this->Categories_model->getCategory();
        if($this->input->post('submit')){
            $this->form_validation->set_rules('category_code','Category Code','is_unique[master_category_tbl.category_code]');
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['submit']);
                $this->Categories_model->insertCategory($postData);
            }else{
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
        $data['title']          = 'Edit Category';
        $data['catData']        = $this->Categories_model->getCategory();
        $data['catDataById']    = $this->Categories_model->getCategoryBy($id);
        $data['editedId']           = $id;
        if($this->input->post('update')){
            $catDataById   = $data['catDataById'];
            $category_code    = $catDataById->category_code;
            if($category_code != $this->input->post('category_code')){
               $this->form_validation->set_rules('category_code','Category Code','required|is_unique[master_category_tbl.category_code]');
            }else{
                $this->form_validation->set_rules('category_code','Category Code','required');
            }
            $this->form_validation->set_rules('category_name','Category Name','required');
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['update']);
                $postData['id'] = $id;
                $this->Categories_model->updateCategory($postData);
            }else{
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
        $data['title']          = 'Delete Category';
        $data['catData']        = $this->Categories_model->getCategory();
        $data['catDataById']    = $this->Categories_model->getCategoryBy($id);
        $postData['id']         = $id; 
        $deletedStatus          = $this->Categories_model->deleteCategory($postData);
    }
}