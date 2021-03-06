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
        $loggedInAdmin  = $this->session->userdata('loggedInAdmin');
        if(empty($loggedInAdmin)){
            redirect('login');
        }
    }
    public function index()
    {
        $data['title']      = 'Types';
        $data['typeData']   = $this->Types_model->getType();
        if($this->input->post('submit')){
            $this->form_validation->set_rules('type_code','Type Code','is_unique[master_type_tbl.type_code]');
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['submit']);
                $this->Types_model->insertType($postData);
            }else{
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
        $data['title']          = 'Edit Type';
        $data['typeData']       = $this->Types_model->getType();
        $data['typeDataById']   = $this->Types_model->getTypeBy($id);
        $data['editedId']       = $id;
        if($this->input->post('update')){
            $typeDataById   = $data['typeDataById'];
            $type_code    = $typeDataById->type_code;
            if($type_code != $this->input->post('type_code')){
               $this->form_validation->set_rules('type_code','Type Code','required|is_unique[master_type_tbl.type_code]');
            }else{
                $this->form_validation->set_rules('type_code','Type Code','required');
            }
            $this->form_validation->set_rules('type_name','Type Name','required');
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['update']);
                $postData['id'] = $id;
                $this->Types_model->updateType($postData);
            }else{
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
        $data['title']          = 'Delete Type';
        $postData['id']         = $id; 
        $deletedStatus          = $this->Types_model->deleteType($postData);
    }
}