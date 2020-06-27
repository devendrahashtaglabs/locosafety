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
        $loggedInAdmin  = $this->session->userdata('loggedInAdmin');
        if(empty($loggedInAdmin)){
            redirect('login');
        }
    }
    public function index()
    {
        $data['title']          = 'Sections';
        $data['sectionData']    = $this->Sections_model->getSection();
        $data['shopData']       = $this->Shops_model->getShop();
        if($this->input->post('submit')){
            $this->form_validation->set_rules('section_name','Section Name','is_unique[master_section_tbl.section_name]');
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['submit']);
                $this->Sections_model->insertSection($postData);
            }else{
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
        $data['title']              = 'Edit Section';
        $data['sectionData']        = $this->Sections_model->getSection();
        $data['shopData']           = $this->Shops_model->getShop();
        $data['sectionDataById']    = $this->Sections_model->getSectionBy($id);
        $data['editedId']           = $id;
        if($this->input->post('update')){
            $sectionDataById    = $data['sectionDataById'];
            $section_name       = $sectionDataById->section_name;
            if($section_name != $this->input->post('section_name')){
              $this->form_validation->set_rules('section_name','Section Name','is_unique[master_section_tbl.section_name]');
            }else{
                $this->form_validation->set_rules('section_name','Section Name','required');
            }
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['update']);
                $postData['id'] = $id;
                $this->Sections_model->updateSection($postData);
            }else{
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
        $data['title']          = 'Delete Section';
        $postData['id']         = $id; 
        $deletedStatus          = $this->Sections_model->deleteSection($postData);
    }
}