<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Divisions_model extends CI_Model{
    public function insertDivision($data){
        $division_code          = $data['division_code'];
        $division_name          = $data['division_name'];
        $division_stored_proc   = "CALL insert_division_sp('$division_code', '$division_name');";
        $divisionData           = array('division_code'=> $division_code,'division_name'=>$division_name); 
        $query                  = $this->db->query($division_stored_proc, $divisionData);
        $query->next_result(); 
        $query->free_result();  
        //echo "<pre>";print_r($this->input->post());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
        if($query){
            $this->session->set_flashdata('divisionSuccess', 'Division Added successful');
            redirect('divisions');
        }else{
            $this->session->set_flashdata('divisionError', 'Somthing went worng. Error!!');
            redirect('divisions');
        }
    }
    public function updateDivision($data){
        $id                     = $data['id'];
        $division_code          = $data['division_code'];
        $division_name          = $data['division_name'];
        $division_stored_proc   = "CALL update_division_sp('$id', '$division_code', '$division_name');";
        $divisionData           = array('division_id'=> $id, 'division_code'=> $division_code,'division_name'=>$division_name);
        $query              = $this->db->query($division_stored_proc, $divisionData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('updateDivision', 'Update successful');
            redirect('divisions/editDivision/'.$id);
        }else{
            $this->session->set_flashdata('errorDivision', 'Somthing went worng. Error!!');
            redirect('divisions/editDivision/'.$id);
        }
    }
    public function deleteDivision($data){
        $id                     = $data['id'];
        $division_stored_proc   = "CALL delete_division_sp('$id');";
        $divisionData           = array('zone_id'=> $id); 
        $query                  = $this->db->query($division_stored_proc, $divisionData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('deleteType', 'Deleted successfully');
            redirect('divisions');
        }else{
            $this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
            redirect('divisions');
        }
    }
    public function getDivision(){
        $division_stored_proc   = "CALL select_all_division_sp()";
        $query                  = $this->db->query($division_stored_proc);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getDivisionBy($data){
        $division_stored_proc   = "CALL select_division_sp('$data');";
        $divisionData           = array('division_id'=> $data); 
        $query                  = $this->db->query($division_stored_proc, $divisionData);
        $result                 = $query->row();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
}