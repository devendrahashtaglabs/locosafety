<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Shops_model extends CI_Model{
    public function insertShop($data){
        //echo "<pre>";print_r($data);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
        $shop_name          = $data['shop_name'];
        $shop_stored_proc   = "CALL insert_shop_sp('$shop_name');";
        $shopData           = array('shop_name'=>$shop_name); 
        $query              = $this->db->query($shop_stored_proc, $shopData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('shopSuccess', 'Shop Added successful');
            redirect('shops');
        }else{
            $this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
            redirect('shops');
        }
    }
    public function updateShop($data){
        $id                 = $data['id'];
        $shop_name          = $data['shop_name'];
        $shop_stored_proc   = "CALL update_shop_sp('$id', '$shop_name');";
        $shopData           = array('shop_id'=> $id,'shop_name'=>$shop_name);
        $query              = $this->db->query($shop_stored_proc, $shopData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('updateShop', 'Update successful');
            redirect('shops/editShop/'.$id);
        }else{
            $this->session->set_flashdata('errorShop', 'Somthing went worng. Error!!');
            redirect('shops/editShop/'.$id);
        }
    }
    public function deleteShop($data){
        $id                 = $data['id'];
        $shop_stored_proc   = "CALL delete_shop_sp('$id');";
        $shopData           = array('shop_id'=> $id); 
        $query              = $this->db->query($shop_stored_proc, $shopData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('deleteShop', 'Deleted successfully');
            redirect('shops');
        }else{
            $this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
            redirect('shops');
        }
    }
    public function getShop(){
        $shop_stored_proc   = "CALL select_all_shop_sp()";
        $query              = $this->db->query($shop_stored_proc);
        $result             = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getShopBy($data){
        $shop_stored_proc   = "CALL select_shop_sp('$data');";
        $shopData           = array('shop_id'=> $data); 
        $query              = $this->db->query($shop_stored_proc, $shopData);
        $result             = $query->row();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
}