<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Divisions_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		define("DIVISIONTBL","master_division_tbl");		
	}
	public function insertDivision($data){
		$zone_id 			= $data['zone_id'];
		$division_code 		= $data['division_code'];
		$division_name 		= $data['division_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$postData = array(
				'zone_id' 				=> $zone_id,
				'division_code' 		=> $division_code,
				'division_name' 		=> $division_name,
				'division_status' 		=> '10',
				'division_created_date' => $currentDate,
				'division_created_by' 	=> $loggedinUser,
		);
		$insertedId = $this->db->insert(DIVISIONTBL, $postData);		
		if($insertedId){
			$this->session->set_flashdata('divisionSuccess', 'Division Added successful');
			redirect('divisions');
		}else{
			$this->session->set_flashdata('divisionError', 'Somthing went worng. Error!!');
			redirect('divisions');
		}
	}
	public function updateDivision($data){
		$id 				= $data['id'];
		$division_code 		= $data['division_code'];
		$division_name 		= $data['division_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'division_code' 		=> $division_code,
				'division_name' 		=> $division_name,
				'division_updated_date' => $currentDate,
				'division_updated_by' 	=> $loggedinUser
		);
		$this->db->where('division_id', $id);
		$query = $this->db->update(DIVISIONTBL, $data);		  
		if($query){
			$this->session->set_flashdata('updateDivision', 'Update successful');
			redirect('divisions/editDivision/'.$id);
		}else{
			$this->session->set_flashdata('errorDivision', 'Somthing went worng. Error!!');
			redirect('divisions/editDivision/'.$id);
		}
	}
	public function deleteDivision($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'division_status' 		=> '90',
				'division_updated_date' => $currentDate,
				'division_updated_by' 	=> $loggedinUser
		);
		$this->db->where('division_id', $id);
		$query = $this->db->update(DIVISIONTBL, $data); 
		if($query){
			$this->session->set_flashdata('deleteDivision', 'Inactivated successfully');
			redirect('divisions');
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('divisions');
		}
	}
	public function activateDivision($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'division_status' 		=> '10',
				'division_updated_date' => $currentDate,
				'division_updated_by' 	=> $loggedinUser
		);
		$this->db->where('division_id', $id);
		$query = $this->db->update(DIVISIONTBL, $data); 
		if($query){
			$this->session->set_flashdata('activateDivision', 'Division Activated successfully');
			redirect('divisions');
		}else{
			$this->session->set_flashdata('errorDivision', 'Somthing went worng. Error!!');
			redirect('divisions');
		}
	}
	public function getDivision(){
		$this->db->select('*');
		$this->db->from(DIVISIONTBL);
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getDivisionBy($data){
		$this->db->select('*');
		$this->db->from(DIVISIONTBL);
		$this->db->where('division_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function getDivisionByZone($data){
		$this->db->select('*');
		$this->db->from(DIVISIONTBL);
		$this->db->where('zone_id', $data);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	/**** Neha Code ******/
	public function getDivisionByadmin($loggedInAdmin){
		$this->db->select('master_division_tbl.division_name,master_division_tbl.division_id');
        $this->db->join('master_division_tbl', 'user_info_tbl.user_division = master_division_tbl.division_id', 'left');
        $this->db->where(array('user_info_tbl.user_info_id'=>$loggedInAdmin));
        $query = $this->db->get('user_info_tbl')->row();
        return $query;
	}
	/**** Neha Code ******/
}