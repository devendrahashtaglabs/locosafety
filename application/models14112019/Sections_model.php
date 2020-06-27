<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Sections_model extends CI_Model{
    public function insertSection($data){
        $shop_id            = $data['shop_id'];
        $section_name       = $data['section_name'];
        $section_stored_proc    = "CALL insert_section_sp('$shop_id','$section_name');";
        $sectIondata            = array('shop_id'=>$shop_id,'section_name'=>$section_name); 
        $query              = $this->db->query($section_stored_proc, $sectIondata);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('sectionSuccess', 'Section Added successful');
            redirect('sections');
        }else{
            $this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
            redirect('sections');
        }
    }
    public function updateSection($data){
        $section_id             = $data['id'];
        $shop_id                = $data['shop_id'];
        $section_name           = $data['section_name'];
        $section_stored_proc    = "CALL update_section_sp('$section_id', '$shop_id','$section_name');";
        $sectIondata            = array('section_id'=> $section_id,'shop_id'=> $shop_id,'section_name'=>$section_name);
        $query              = $this->db->query($section_stored_proc, $sectIondata);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('updateSection', 'Updated successful');
            redirect('sections/editSection/'.$section_id);
        }else{
            $this->session->set_flashdata('errorSection', 'Somthing went worng. Error!!');
            redirect('sections/editSection/'.$section_id);
        }
    }
    public function deleteSection($data){
        $id                     = $data['id'];
        $section_stored_proc    = "CALL delete_section_sp('$id');";
        $sectIondata            = array('section_id'=> $id); 
        $query                  = $this->db->query($section_stored_proc, $sectIondata);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('deleteSection', 'Deleted successfully');
            redirect('sections');
        }else{
            $this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
            redirect('sections');
        }
    }
    public function getSection(){
        $section_stored_proc    = "CALL select_all_section_sp()";
        $query              = $this->db->query($section_stored_proc);
        $result             = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getSectionBy($data){
        $section_stored_proc    = "CALL select_section_sp('$data');";
        $sectIondata            = array('section_id'=> $data); 
        $query              = $this->db->query($section_stored_proc, $sectIondata);
        $result             = $query->row();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
}