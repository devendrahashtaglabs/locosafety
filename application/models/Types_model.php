<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Types_model extends CI_Model{
	public function insertType($data){		
		$parent_type_id		= '';
		$type_code 			= $data['type_code'];
		$type_name 			= $data['type_name'];
		$session_data 		= $this->session->userdata('loggedInUserDetail');
		$zone_id 			= $session_data->user_zone;
		$division_id 		= $session_data->user_division;
		$currentDate 		= date('Y-m-d H:i:s');
		$loggedInId 		= $session_data->user_info_id;		
		$typeData			= array(
								'zone_id'					=> 	$zone_id,
								'division_id'				=> 	$division_id,
								'parent_type_id'			=> 	$parent_type_id,
								'hardware_type_code'		=> 	$type_code,
								'hardware_type_name'		=>	$type_name,
								'hardware_type_status'		=> 	"10",
								'hardware_type_add_date'	=> 	$currentDate,
								'type_created_by'			=> 	$loggedInId
							);         
		$query = $this->db->insert('master_hardware_type_tbl',$typeData);
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
			///$type_stored_proc 	= "CALL update_type_sp('$id', '$parent_type_id', '$type_code', '$type_name');";
			$typeData			= array(
									//'type_id'=> $id,
									 'parent_type_id'=> $parent_type_id,
									 'hardware_type_code'=> $type_code,
									 'hardware_type_name'=>$type_name
									); 
	       // $query 				= $this->db->query($type_stored_proc, $typeData);
	      //  $query->next_result(); 
			//$query->free_result(); 

			$this->db->where('hardware_type_id',$id);
			$query = $this->db->update('master_hardware_type_tbl',$typeData); 
			if($query){
				$this->session->set_flashdata('typeSuccess', 'Type updated successfully.');
				redirect('types');
			}else{
				$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
				redirect('types/editType/'.$id);
			}
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('types/editType/'.$id);
		}
	}
	public function deleteType($data){
		$this->db->set('hardware_type_status','80');
		$this->db->where('hardware_type_id',$data['id']);
		$query = $this->db->update('master_hardware_type_tbl');

		if($query){
			$this->session->set_flashdata('typeSuccess', 'Inactive successfully');
			redirect('types');
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('types');
		}
	}

	public function activeType($data){
		$this->db->set('hardware_type_status','10');
		$this->db->where('hardware_type_id',$data['id']);
		$query = $this->db->update('master_hardware_type_tbl');

		if($query){
			$this->session->set_flashdata('typeSuccess', 'Active successfully');
			redirect('types');
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('types');
		}
	}
	public function getType(){
		$this->db->select('*');
		$this->db->from('master_hardware_type_tbl');
	//	$this->db->where('hardware_type_status', '10');
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;  
	}
	public function getTypeByZoneDivision($zone_id,$division_id,$status = NULL){
		//$this->db->where('zone_id',$zone_id);
		//$this->db->where('division_id',$division_id);
		if($status != ""){
			$this->db->where('hardware_type_status','10');
		}
		$query = $this->db->get('master_hardware_type_tbl');
		return $query->result();
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
	public function checkTypeExist($hardware_type_code,$zone_id,$division_id){
		$this->db->select('hardware_type_code');
		$this->db->from('master_hardware_type_tbl');
		$this->db->where('hardware_type_code', $hardware_type_code);
		//$this->db->where('zone_id', $zone_id);
		//$this->db->where('division_id', $division_id);
		$query 	= $this->db->get();
		$result = $query->num_rows();
		return $result; 
	}
}