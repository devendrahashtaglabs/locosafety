<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Dashboard_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}
	public function GetMappingSection($ID){
		//$this->db->select('*');
		//$query = $this->db->get('section_map_mapping_tbl');
		
		$query = $this->db->query("Select * From section_map_mapping_tbl where FIND_IN_SET($ID,section_position)");
		$result = $query->result();
		return $result;
		
	}
	
	public function GetMappingShop($ID){
		
		$query = $this->db->query("Select * From shop_map_mapping_tbl where FIND_IN_SET($ID,section_position)");
		$result = $query->result();
		return $result;
		
	}
	
public function getalltickethardwarebycategoryNot($cat_ids){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('tickets_tbl.*,hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','right');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->result();
				return $result;	
}

public function getallhardwarebycategoryNot($cat_ids){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->result();
				return $result;	
}
	
	
	
	public function getalltickethardwarebycategory($cat_ids){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('tickets_tbl.*,hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','right');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->result();
				return $result;	
	}

	public function getallhardwarebycategory($cat_ids){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function getHardwareByCat($user_zone,$user_division,$cat_ids){
		$this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->join('user_info_tbl', 'hardware_basic_tbl.hardware_created_by = user_info_tbl.user_info_id');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('hardware_basic_tbl.hardware_status', '10');
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->num_rows();
        return $result;
	}
	
	public function getalltickethardwarebycategorySection($cat_ids, $SecID){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function getalltickethardwarebycategorySectionNOT($cat_ids, $SecID){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);					
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);
		$query 	= $this->db->get();
		$result = $query->result();
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
	public function getShopByID($ID){
		$this->db->select('*');
		$this->db->from('master_shop_tbl');
		$this->db->where('shop_id', $ID);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function getTicketBySectionIdAndCat($ID,$status,$casetype,$zone_id,$division_id,$cat){
		$this->db->select('*');
		$this->db->from('tickets_tbl');
		$this->db->where('tickets_tbl.section_id', $ID);
		$this->db->where('tickets_tbl.ticket_status', $status);
		$this->db->where('tickets_tbl.case_type', $casetype);
		$this->db->where('tickets_tbl.zone_id', $zone_id);
		$this->db->where('tickets_tbl.division_id', $division_id);
		$this->db->join('hardware_mapping_section_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');		
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function getTicketBySectionID($ID,$status,$casetype,$zone_id,$division_id){
		$this->db->select('*');
		$this->db->from('tickets_tbl');
		$this->db->where('section_id', $ID);
		$this->db->where('ticket_status', $status);
		$this->db->where('case_type', $casetype);
		$this->db->where('zone_id', $zone_id);
		$this->db->where('division_id', $division_id);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function getalltickethardwarebysection($cat_ids,$section_id){ 
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('tickets_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->where('tickets_tbl.section_id', $section_id);
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);		
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function getallhardwarebySection($cat_ids,$section_id){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$this->db->where('hardware_mapping_section_tbl.section_id', $section_id);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
}