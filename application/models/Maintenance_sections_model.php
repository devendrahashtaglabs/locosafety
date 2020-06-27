<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Maintenance_sections_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		define("MSECTIONTBL","master_maintenance_section_tbl");		
	}
	public function insertSection($data){
		$insertedId = $this->db->insert(MSECTIONTBL, $data);
		return $insertedId;
	}
	public function updateSection($id,$data){
		$this->db->where('maintenance_section_id', $id);
		$query = $this->db->update(MSECTIONTBL, $data);
		return $query;
	}
	/* public function deleteSection($id,$data){
		$this->db->where('maintenance_section_id', $id);
		$query = $this->db->update(MSECTIONTBL, $data);  
		if($query){
			$this->session->set_flashdata('deleteSection', 'Deleted successfully');
			redirect('sections');
		}else{
			$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
			redirect('sections');
		}
	} */
	public function activateSection($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'section_status' 		=> '10',
				'section_update_date' 	=> $currentDate,
				'section_updated_by' 	=> $loggedinUser
		);
		$this->db->where('maintenance_section_id', $id);
		$query = $this->db->update(MSECTIONTBL, $data); 
		if($query){
			$this->session->set_flashdata('deleteSection', 'Activated successfully');
			redirect('sections');
		}else{
			$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
			redirect('sections');
		}
	}
	public function getMSection(){
		$this->db->select('*');
		$this->db->from(MSECTIONTBL);
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;
	}
	public function getMSectionBy($data){
		$this->db->select('*');
		$this->db->from(MSECTIONTBL);
		$this->db->where('maintenance_section_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function getMSectionByMshopId($shop_id){
		$this->db->select('*');
		$this->db->from(MSECTIONTBL);
		$this->db->where('maintenance_shop_id', $shop_id);
		$this->db->where('maintenance_section_status','10');
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function getMSectionCount($mShopIdArray){
		$this->db->select('*');
		$this->db->from(MSECTIONTBL);
		$this->db->where_in('maintenance_shop_id', $mShopIdArray);
		$this->db->where('maintenance_section_status', '10');
		$query 	= $this->db->get();
		$result = $query->num_rows();
        return $result;
	}
	public function getMSectionALL($mShopIdArray,$type=NULL){
		$this->db->select('*');
		$this->db->from(MSECTIONTBL);
		$this->db->where_in('maintenance_shop_id', $mShopIdArray);
		if($type != 'all'){
			$this->db->where('maintenance_section_status', '10');
		}
		$query 	= $this->db->get();
		$result = $query->result();
        return $result;
	}
	public function checkMSectionExist($mshop_id,$msection_code){
		$this->db->select('maintenance_section_code');
		$this->db->from(MSECTIONTBL);
		$this->db->where('maintenance_section_code', $msection_code);
		$this->db->where('maintenance_shop_id', $mshop_id);
		$query 	= $this->db->get();
		$result = $query->num_rows();
		return $result; 
	}
}