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
        $loggedInAdmin  = $this->session->userdata('loggedInAdmin');
        if(empty($loggedInAdmin)){
            redirect('login');
        }
    }
    public function index()
    {
        $data['title']      = 'Shops';
        $data['shopData']   = $this->Shops_model->getShop();
        if($this->input->post('submit')){
            $this->form_validation->set_rules('shop_name','Shop Name','is_unique[master_shop_tbl.shop_name]');
            if($this->form_validation->run()){
                $postData = $this->input->post();
                unset($postData['submit']);
                $this->Shops_model->insertShop($postData);
            }else{
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
        $data['title']          = 'Edit Shop';
        $data['shopData']       = $this->Shops_model->getShop();
        $data['shopDataById']   = $this->Shops_model->getShopBy($id);
        $data['editedId']       = $id;
        if($this->input->post('update')){
            $shopDataById    = $data['shopDataById'];
            $shop_name       = $shopDataById->shop_name;
            if($shop_name != $this->input->post('shop_name')){
              $this->form_validation->set_rules('shop_name','Shop Name','is_unique[master_shop_tbl.shop_name]');
            }else{
                $this->form_validation->set_rules('shop_name','Shop Name','required');
            }
            if($this->form_validation->run()){
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
        $data['title']          = 'Delete Shop';
        $postData['id']         = $id; 
        $deletedStatus          = $this->Shops_model->deleteShop($postData);
    }
}