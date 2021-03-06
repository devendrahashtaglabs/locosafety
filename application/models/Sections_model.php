<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Sections_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		define("SECTIONTBL","master_section_tbl");		
	}
	public function insertSection($data){
		$shop_id 			= $data['shop_id'];
		$section_code 		= $data['section_code'];
		$section_name 		= $data['section_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$postData = array(
				'shop_id' 				=> $shop_id,
				'section_code' 			=> $section_code,
				'section_name' 			=> $section_name,
				'section_status' 		=> '10',
				'section_add_date' 		=> $currentDate,
				'section_created_by' 	=> $loggedinUser,
		);
		$insertedId = $this->db->insert(SECTIONTBL, $postData); 
		if($insertedId){
			$this->session->set_flashdata('sectionSuccess', 'Section added successfully');
			redirect('sections');
		}else{
			$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
			redirect('sections');
		}
	}
	public function updateSection($data){
		$section_id 		= $data['id'];
		$shop_id 			= $data['shop_id'];
		$section_code 		= $data['section_code'];
		$section_name 		= $data['section_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'shop_id' 				=> $shop_id,
				'section_code' 			=> $section_code,
				'section_name' 			=> $section_name,
				'section_update_date' 	=> $currentDate,
				'section_updated_by' 	=> $loggedinUser
		);
		$this->db->where('section_id', $section_id);
		$query = $this->db->update(SECTIONTBL, $data);
		if($query){
			$this->session->set_flashdata('sectionSuccess', 'Section data updated successfully');
			redirect('sections');
		}else{
			$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
			redirect('sections/editSection/'.$section_id);
		}
	}
	public function deleteSection($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'section_status' 		=> '80',
				'section_update_date' 	=> $currentDate,
				'section_updated_by' 	=> $loggedinUser
		);
		$this->db->where('section_id', $id);
		$query = $this->db->update(SECTIONTBL, $data);  
		if($query){
			$this->session->set_flashdata('deleteSection', 'Deleted successfully');
			redirect('sections');
		}else{
			$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
			redirect('sections');
		}
	}
	public function activateSection($data){
		$id 				= $data['id'];
		$loggedinUser	 	= '1';
		$currentDate	 	= date('Y-m-d H:i:s');
		$data = array(
				'section_status' 		=> '10',
				'section_update_date' 	=> $currentDate,
				'section_updated_by' 	=> $loggedinUser
		);
		$this->db->where('section_id', $id);
		$query = $this->db->update(SECTIONTBL, $data); 
		if($query){
			$this->session->set_flashdata('deleteSection', 'Activated successfully');
			redirect('sections');
		}else{
			$this->session->set_flashdata('sectionError', 'Somthing went worng. Error!!');
			redirect('sections');
		}
	}
	public function getSection($type=NULL){
		$this->db->select('*');
		$this->db->from('master_section_tbl');		
		$this->db->join('master_shop_tbl', 'master_shop_tbl.shop_id = master_section_tbl.shop_id');
		$this->db->where('master_shop_tbl.zone_id', $_SESSION['loggedInUserDetail']->user_zone);
		$this->db->where('master_shop_tbl.division_id', $_SESSION['loggedInUserDetail']->user_division);
		if($type != 'all'){
			$this->db->where('master_section_tbl.section_status', '10');
		}
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;
	}
	public function getSectionBy($data){
		$this->db->select('*');
		$this->db->from(SECTIONTBL);
		$this->db->where('section_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function getSectionByID($ID){
		$this->db->select('*');
		$this->db->from('master_section_tbl');
		$this->db->where('section_id', $ID);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function getSectionCount($shopIdArray){
		$this->db->select('*');
		$this->db->from('master_section_tbl');
		$this->db->where_in('shop_id', $shopIdArray);
		$this->db->where('section_status', '10');
		$query 	= $this->db->get();
		$result = $query->num_rows();
        return $result;
	}
	public function checkSectionExist($shop_id,$section_code){
		$this->db->select('section_code');
		$this->db->from(SECTIONTBL);
		$this->db->where('section_code', $section_code);
		$this->db->where('shop_id', $shop_id);
		$query 	= $this->db->get();
		$result = $query->num_rows();
		return $result; 
	}
	public function getSectionByShopID($shopIdArray){
		$this->db->select('*');
		$this->db->from('master_section_tbl');
		$this->db->where_in('shop_id', $shopIdArray);
		$this->db->where('section_status', '10');
		$query 	= $this->db->get();
		$result = $query->result();
        return $result;
	}
}