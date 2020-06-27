<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Zones_model extends CI_Model{
    public function insertZone($data){
        $zone_code          = $data['zone_code'];
        $zone_name          = $data['zone_name'];
        $zone_stored_proc   = "CALL insert_zone_sp('$zone_code', '$zone_name');";
        $zoneData           = array('zone_code'=> $zone_code,'zone_name'=>$zone_name); 
        $query              = $this->db->query($zone_stored_proc, $zoneData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('zoneSuccess', 'Zone Added successful');
            redirect('zones');
        }else{
            $this->session->set_flashdata('zoneError', 'Somthing went worng. Error!!');
            redirect('zones');
        }
    }
    public function updateZone($data){
        $id                 = $data['id'];
        $zone_code          = $data['zone_code'];
        $zone_name          = $data['zone_name'];
        $zone_stored_proc   = "CALL update_zone_sp('$id', '$zone_code', '$zone_name');";
        $zoneData           = array('zone_id'=> $id, 'zone_code'=> $zone_code,'zone_name'=>$zone_name);
        $query              = $this->db->query($zone_stored_proc, $zoneData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('updateZone', 'Update successfull');
            redirect('zones/editZone/'.$id);
        }else{
            $this->session->set_flashdata('errorZone', 'Somthing went worng. Error!!');
            redirect('zones/editZone/'.$id);
        }
    }
    public function deleteZone($data){
        $id                 = $data['id'];
        $zone_stored_proc   = "CALL delete_zone_sp('$id');";
        $zoneData           = array('zone_id'=> $id); 
        $query              = $this->db->query($zone_stored_proc, $zoneData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('deleteType', 'Deleted successfully');
            redirect('zones');
        }else{
            $this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
            redirect('zones');
        }
    }
    public function getZone(){
        $zone_stored_proc   = "CALL select_all_zone_sp()";
        $query              = $this->db->query($zone_stored_proc);
        $result             = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getZoneBy($data){
        $zone_stored_proc   = "CALL select_zone_sp('$data');";
        $zoneData           = array('zone_id'=> $data); 
        $query              = $this->db->query($zone_stored_proc, $zoneData);
        $result             = $query->row();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
}