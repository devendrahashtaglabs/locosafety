<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Categories_model extends CI_Model{
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getAllCategory(){
		$this->db->select('*');
		$this->db->from('master_hardware_category_tbl');
		$this->db->where('category_status', '10');
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getCategory($zone_id,$division_id){
		$this->db->where('zone_id',$zone_id);
		$this->db->where('division_id',$division_id);
		$this->db->where('category_status','10');
		$query = $this->db->get('master_hardware_category_tbl');
		return $query->result();
	}
	public function insertCategory($data){
		$parent_category_id = $data['parent_category_id'];
		$category_code 		= $data['category_code'];
		$category_name 		= $data['category_name'];
		$cat_stored_proc 	= "CALL insert_category_sp('$parent_category_id', '$category_code', '$category_name');";
		$catData			= array('parent_category_id'=> $parent_category_id,'category_code'=>$category_code,'category_name' => $category_name); 
        $query 				= $this->db->query($cat_stored_proc, $catData);
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
		$id 				= $data['id'];
		$parent_category_id = $data['parent_category_id'];
		if($parent_category_id != $id){
			$category_code 		= $data['category_code'];
			$category_name 		= $data['category_name'];
			$cat_stored_proc 	= "CALL update_category_sp('$id', '$parent_category_id', '$category_code','$category_name');";
			$catData			= array('id'=> $id,'parent_category_id'=> $parent_category_id,'category_code'=>$category_code,'category_name' => $category_name); 
	        $query 				= $this->db->query($cat_stored_proc, $catData);
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
		$id 				= $data['id'];
		$cat_stored_proc 	= "CALL delete_category_sp('$id');";
		$catData			= array('id'=> $id); 
        $query 				= $this->db->query($cat_stored_proc, $catData);
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
	/* public function getCategory(){
		$user_stored_proc 	= "CALL select_all_category_sp()";
        $query 				= $this->db->query($user_stored_proc);
        $result				= $query->result();
        $query->next_result(); 
		$query->free_result(); 
		return $result; 
	} */
	public function getCategoryBy($parent){
		$this->db->select('*');
		$this->db->from('master_hardware_category_tbl');
		$this->db->where('parent_category_id', $parent);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result; 
	}
	public function getCatById($id){
		$this->db->select('*');
		$this->db->from('master_hardware_category_tbl');
		$this->db->where('id', $id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result; 
	}
}