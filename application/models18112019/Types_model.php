<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Types_model extends CI_Model{
	public function insertType($data){
		$parent_type_id		= $data['parent_type_id'];
		$type_code 			= $data['type_code'];
		$type_name 			= $data['type_name'];
		$type_stored_proc 	= "CALL insert_type_sp('$parent_type_id', '$type_code', '$type_name');";
		$typeData			= array('parent_type_id'=> $parent_type_id,'type_code'=> $type_code,'type_name'=>$type_name); 
        $query 				= $this->db->query($type_stored_proc, $typeData);
        $query->next_result(); 
		$query->free_result();  
		if($query){
			$this->session->set_flashdata('typeSuccess', 'Type Added successful');
			redirect('types');
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('types');
		}
	}
	public function updateType($data){
		$id 				= $data['id'];
		$parent_type_id		= $data['parent_type_id'];
		if($parent_type_id != $id){
			$type_code 			= $data['type_code'];
			$type_name 			= $data['type_name'];
			$type_stored_proc 	= "CALL update_type_sp('$id', '$parent_type_id', '$type_code', '$type_name');";
			$typeData			= array('type_id'=> $id,'parent_type_id'=> $parent_type_id, 'type_code'=> $type_code,'type_name'=>$type_name); 
	        $query 				= $this->db->query($type_stored_proc, $typeData);
	        $query->next_result(); 
			$query->free_result();  
			if($query){
				$this->session->set_flashdata('updateType', 'Update successful');
				redirect('types/editType/'.$id);
			}else{
				$this->session->set_flashdata('errorType', 'Somthing went worng. Error!!');
				redirect('types/editType/'.$id);
			}
		}else{
			$this->session->set_flashdata('errorType', 'Somthing went worng. Error!!');
			redirect('types/editType/'.$id);
		}
	}
	public function deleteType($data){
		$id 				= $data['id'];
		$type_stored_proc 	= "CALL delete_type_sp('$id');";
		$typeData			= array('type_id'=> $id); 
        $query 				= $this->db->query($type_stored_proc, $typeData);
        $query->next_result(); 
		$query->free_result();  
		if($query){
			$this->session->set_flashdata('deleteType', 'Deleted successfully');
			redirect('types');
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('types');
		}
	}
	public function getType(){
		$this->db->select('*');
		$this->db->from('master_hardware_type_tbl');
		$this->db->where('hardware_type_status', '10');
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;  
	}
	public function getTypeBy($data){
		$cat_stored_proc 	= "CALL select_type_details_sp(?);";
		$getCatBy			= array('type_id'=> $data); 
        $query 				= $this->db->query($cat_stored_proc, $getCatBy);
        $result				= $query->row();
        $query->next_result(); 
		$query->free_result();
		return $result; 
	}
	public function getTypeById($id){
		$this->db->select('*');
		$this->db->from('master_hardware_type_tbl');
		$this->db->where('hardware_type_id', $id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result; 
	}
}