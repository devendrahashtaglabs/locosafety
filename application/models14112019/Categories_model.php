<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Categories_model extends CI_Model{
    public function insertCategory($data){
        $parent_category_id = $data['parent_category_id'];
        $category_code      = $data['category_code'];
        $category_name      = $data['category_name'];
        $cat_stored_proc    = "CALL insert_category_sp('$parent_category_id', '$category_code', '$category_name');";
        $catData            = array('parent_category_id'=> $parent_category_id,'category_code'=>$category_code,'category_name' => $category_name); 
        $query              = $this->db->query($cat_stored_proc, $catData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('success', 'Registration successful');
            redirect('categories');
        }else{
            $this->session->set_flashdata('error', 'Somthing went worng. Error!!');
            redirect('categories');
        }
    }
    public function updateCategory($data){
        $id                 = $data['id'];
        $parent_category_id = $data['parent_category_id'];
        if($parent_category_id != $id){
            $category_code      = $data['category_code'];
            $category_name      = $data['category_name'];
            $cat_stored_proc    = "CALL update_category_sp('$id', '$parent_category_id', '$category_code','$category_name');";
            $catData            = array('id'=> $id,'parent_category_id'=> $parent_category_id,'category_code'=>$category_code,'category_name' => $category_name); 
            $query              = $this->db->query($cat_stored_proc, $catData);
            $query->next_result(); 
            $query->free_result();  
            if($query){
                $this->session->set_flashdata('updateCategory', 'Update successful');
                redirect('categories/editCat/'.$id);
            }else{
                $this->session->set_flashdata('error', 'Somthing went worng. Error!!');
                redirect('categories/editCat/'.$id);
            }
        }else{
            $this->session->set_flashdata('error', 'Somthing went worng. Error!!');
            redirect('categories/editCat/'.$id);
        }
    }
    public function deleteCategory($data){
        $id                 = $data['id'];
        $cat_stored_proc    = "CALL delete_category_sp('$id');";
        $catData            = array('id'=> $id); 
        $query              = $this->db->query($cat_stored_proc, $catData);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('deleteCategory', 'Deleted successfully');
            redirect('categories');
        }else{
            $this->session->set_flashdata('error', 'Somthing went worng. Error!!');
            redirect('categories');
        }
    }
    public function getCategory(){
        $user_stored_proc   = "CALL select_all_category_sp()";
        $query              = $this->db->query($user_stored_proc);
        $result             = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getCategoryBy($parent){
        $cat_stored_proc    = "CALL get_category_by('$parent');";
        $getCatBy           = array('parent'=> $parent); 
        $query              = $this->db->query($cat_stored_proc, $getCatBy);
        $result             = $query->row();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
}