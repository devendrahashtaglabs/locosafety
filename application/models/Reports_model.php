<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Reports_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}

	function GetUserSection(){		

		$query = $this->db->query('SELECT user_details_tbl.*,user_info_tbl.*,user_mapping_tbl.* FROM user_mapping_tbl 
LEFT JOIN user_info_tbl ON user_mapping_tbl.user_info_id = user_info_tbl.user_info_id
LEFT JOIN user_details_tbl ON user_info_tbl.user_info_id = user_details_tbl.user_info_id
WHERE user_info_tbl.user_zone = '.$_SESSION['loggedInUserDetail']->user_zone.' AND user_info_tbl.user_division = '.$_SESSION['loggedInUserDetail']->user_division.' AND user_mapping_tbl.map_status = 10 GROUP BY user_mapping_tbl.user_info_id')->result();

		return $query;

	}
	
	function GetUserSectionByID($ID){		
		
		$query = $this->db->query('SELECT user_details_tbl.*,user_info_tbl.*,user_mapping_tbl.* FROM user_mapping_tbl 
LEFT JOIN user_info_tbl ON user_mapping_tbl.user_info_id = user_info_tbl.user_info_id
LEFT JOIN user_details_tbl ON user_info_tbl.user_info_id = user_details_tbl.user_info_id
WHERE user_info_tbl.user_zone = '.$_SESSION['loggedInUserDetail']->user_zone.' AND user_info_tbl.user_division = '.$_SESSION['loggedInUserDetail']->user_division.' AND user_info_tbl.user_info_id = '.$ID.' AND user_mapping_tbl.map_status = "10" ')->result();
		return $query;

	}
	
	public function GetHardwareSection(){	

		$query = $this->db->query('SELECT * FROM hardware_mapping_section_tbl WHERE shop_id IN (SELECT master_shop_tbl.shop_id FROM master_shop_tbl WHERE zone_id='.$_SESSION['loggedInUserDetail']->user_zone.' AND division_id='.$_SESSION['loggedInUserDetail']->user_division.' AND shop_status=10)')->result();
		return $query;

	}
	public function FilterHardwareSection($filterID){	
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('master_shop_tbl', 'hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id', 'left');
		$this->db->join('hardware_basic_tbl', 'hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id', 'left');
		$this->db->where('master_shop_tbl.zone_id', $_SESSION['loggedInUserDetail']->user_zone);
		$this->db->where('master_shop_tbl.division_id', $_SESSION['loggedInUserDetail']->user_division);
		$this->db->where('master_shop_tbl.shop_status', '10');
		if($filterID == 'JIB' || $filterID == 'EOT'){
			$this->db->where('hardware_basic_tbl.hardware_model', $filterID);
		}
		if($filterID == 'S2'){
			$filterID = 2;
			$this->db->where('hardware_basic_tbl.hardware_category', $filterID);
		}
		if($filterID == 'T3'){
			$filterID = 3;
			$this->db->where('hardware_basic_tbl.hardware_category', $filterID);
		}
		if($filterID == 'O4'){
			$filterID = 4;
			$this->db->where('hardware_basic_tbl.hardware_category', $filterID);
		}
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	public function FilterHardwareSectionByStatus($filterID){	
		$this->db->select('hardware_mapping_section_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('master_shop_tbl', 'hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id', 'left');
		$this->db->join('tickets_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id', 'left');
		$this->db->where('master_shop_tbl.zone_id', $_SESSION['loggedInUserDetail']->user_zone);
		$this->db->where('master_shop_tbl.division_id', $_SESSION['loggedInUserDetail']->user_division);
		$this->db->where('master_shop_tbl.shop_status', '10');
		$this->db->where('tickets_tbl.ticket_status', '20');
		$this->db->where('tickets_tbl.case_type', $filterID);
		$this->db->group_by('tickets_tbl.hardware_map_section_id');
		$query 	= $this->db->get();
		$result = $query->result();
		//print_r($this->db->last_query());
		//exit;
		return $result;
	}
	public function FilterHardwareSectionByDueStatus($filterID){	
		$today = date('Y-m-d');
		$this->db->select('hardware_mapping_section_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('master_shop_tbl', 'hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id', 'left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id', 'left');
		$this->db->where('master_shop_tbl.zone_id', $_SESSION['loggedInUserDetail']->user_zone);
		$this->db->where('master_shop_tbl.division_id', $_SESSION['loggedInUserDetail']->user_division);
		$this->db->where('master_shop_tbl.shop_status', '10');
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date <=', $today);
		$this->db->group_by('hardware_schedule_config_tbl.map_id');
		$query 	= $this->db->get();
		$result = $query->result();
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		return $result;
	}	
	
	public function GetNextServiceDate($shopID){		
		$this->db->select('*');
		$this->db->from('hardware_schedule_config_tbl');
		$this->db->where('map_id', $shopID);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 		
	}
	
	public function GetSectionUserName($shopID){		
		$this->db->select('*');
		$this->db->from('user_mapping_tbl');
		$this->db->where('section_id', $shopID);
		$this->db->where('maintenance_shop_id IS NULL');
		$this->db->where('maintenance_section_id IS NULL');
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 		
	}

}