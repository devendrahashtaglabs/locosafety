<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Zones_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		define("ZONETBL","master_zone_tbl");		
	}
	public function insertZone($data){
		$zone_code 			= $data['zone_code'];
		$zone_name 			= $data['zone_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$postData = array(
				'zone_code' 		=> $zone_code,
				'zone_name' 		=> $zone_name,
				'zone_status' 		=> '10',
				'zone_created_date' => $currentDate,
				'zone_created_by' 	=> $loggedinUser,
		);
		$insertedId = $this->db->insert(ZONETBL, $postData);
		if($insertedId){
			$this->session->set_flashdata('zoneSuccess', 'Zone Added successful');
			redirect('zones');
		}else{
			$this->session->set_flashdata('zoneError', 'Somthing went worng. Error!!');
			redirect('zones');
		}
	}
	public function updateZone($data){
		$id 				= $data['id'];
		$zone_code 			= $data['zone_code'];
		$zone_name 			= $data['zone_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'zone_code' 		=> $zone_code,
				'zone_name' 		=> $zone_name,
				'zone_updated_date' => $currentDate,
				'zone_updated_by' 	=> $loggedinUser
		);
		$this->db->where('zone_id', $id);
		$query = $this->db->update(ZONETBL, $data);		
		if($query){
			$this->session->set_flashdata('updateZone', 'Update successfull');
			redirect('zones/editZone/'.$id);
		}else{
			$this->session->set_flashdata('errorZone', 'Somthing went worng. Error!!');
			redirect('zones/editZone/'.$id);
		}
	}
	public function deleteZone($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'zone_status' 		=> '90',
				'zone_updated_date' => $currentDate,
				'zone_updated_by' 	=> $loggedinUser
		);
		$this->db->where('zone_id', $id);
		$query = $this->db->update(ZONETBL, $data);
		if($query){
			$this->session->set_flashdata('deleteType', 'Inactivated successfully');
			redirect('zones');
		}else{
			$this->session->set_flashdata('typeError', 'Somthing went worng. Error!!');
			redirect('zones');
		}
	}
	public function activateZone($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'zone_status' 		=> '10',
				'zone_updated_date' => $currentDate,
				'zone_updated_by' 	=> $loggedinUser
		);
		$this->db->where('zone_id', $id);
		$query = $this->db->update(ZONETBL, $data);
		if($query){
			$this->session->set_flashdata('activateZone', 'Activated successfully');
			redirect('zones');
		}else{
			$this->session->set_flashdata('errorZone', 'Somthing went worng. Error!!');
			redirect('zones');
		}
	}
	public function getZone(){
		$this->db->select('*');
		$this->db->from(ZONETBL);
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getZoneBy($data){
		$this->db->select('*');
		$this->db->from(ZONETBL);
		$this->db->where('zone_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	/**** Neha Code *****/
	public function getZonebyadmin($loggedInAdmin){
		$this->db->select('master_zone_tbl.zone_name,master_zone_tbl.zone_id');
        $this->db->join('master_zone_tbl', 'user_info_tbl.user_zone = master_zone_tbl.zone_id', 'left');
        $this->db->where(array('user_info_tbl.user_info_id'=>$loggedInAdmin));
        $query = $this->db->get('user_info_tbl')->row();
        return $query;
	}
	/**** Neha Code *****/
}