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
		$query = $this->db->query("Select * From section_map_mapping_tbl where FIND_IN_SET($ID,section_position) AND user_division = ".$_SESSION['loggedInUserDetail']->user_division." AND user_zone = ".$_SESSION['loggedInUserDetail']->user_zone." ");
		$result = $query->result();
		return $result;
		
	}
	
	public function insertTableDate($table,$data){
		$query = $this->db->insert($table,$data);
		return $query;
	}
	
	public function updateTableDate($table,$data,$id){
		$this->db->where('id',$id);
		$query = $this->db->update($table,$data);
		return $query;
	}
	public function GetMapImageByID(){
		$query = $this->db->query("Select * From map_image_dashboard_tbl where user_division = ".$_SESSION['loggedInUserDetail']->user_division." AND user_zone = ".$_SESSION['loggedInUserDetail']->user_zone." ");
		$result = $query->row();
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
		//$this->db->group_by("hardware_mapping_section_tbl.map_id");
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
	
	public function getalltickethardwarebycategorySectionModelType($cat_ids, $SecID,$type){
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
		$this->db->where('hardware_basic_tbl.hardware_model', $type);
			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function GetAllTicketHardwareByCategorySectionNew($cat_ids, $SecID){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);			
		//$this->db->where('tickets_tbl.ticket_status',20);
                $this->db->group_by('hardware_mapping_section_tbl.map_id'); 
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function getalltickethardwarebycategorySection($cat_ids, $SecID){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);			
		$this->db->where('tickets_tbl.ticket_status',20);
                $this->db->group_by('hardware_mapping_section_tbl.map_id'); 
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
		$this->db->group_by('hardware_map_section_id');
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
	
	/* public function getTicketByCat($status,$casetype,$zone_id,$division_id,$cat){
		$this->db->select('*');
		$this->db->from('tickets_tbl');
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
	} */
	public function getTicketByCat($status,$casetype,$zone_id,$division_id,$cat){
		$this->db->select('*');
		$this->db->from('tickets_tbl');
		$this->db->where('tickets_tbl.ticket_status', $status);
		$this->db->where('tickets_tbl.case_type', $casetype);
		$this->db->where('tickets_tbl.zone_id', $zone_id);
		$this->db->where('tickets_tbl.division_id', $division_id);
		$this->db->join('hardware_mapping_section_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');		
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$this->db->group_by("tickets_tbl.hardware_map_section_id");
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function getTicketByCatSection($status,$casetype,$zone_id,$division_id,$cat,$section){
		$this->db->select('*');
		$this->db->from('tickets_tbl');
		$this->db->where('tickets_tbl.ticket_status', $status);
		$this->db->where('tickets_tbl.case_type', $casetype);
		$this->db->where('tickets_tbl.zone_id', $zone_id);
		$this->db->where('tickets_tbl.division_id', $division_id);
		$this->db->where('tickets_tbl.section_id', $section);
		$this->db->join('hardware_mapping_section_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');		
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$this->db->group_by("tickets_tbl.hardware_map_section_id");
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function getUnderMaintenance($status,$zone_id,$division_id){
		$this->db->select('*');
		$this->db->from('tickets_tbl');
		$this->db->where('tickets_tbl.ticket_status', $status);
		$this->db->where('tickets_tbl.zone_id', $zone_id);
		$this->db->where('tickets_tbl.division_id', $division_id);		
		$this->db->group_by("tickets_tbl.hardware_map_section_id");
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function getscheduleTicketBySectionIdAndCatId($ID,$status,$casetype,$zone_id,$division_id,$cat){
		$today = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('tickets_tbl');
		$this->db->where('tickets_tbl.section_id', $ID);
		$this->db->where('tickets_tbl.ticket_status', $status);
		$this->db->where('tickets_tbl.case_type', $casetype);
		$this->db->where('tickets_tbl.zone_id', $zone_id);
		$this->db->where('tickets_tbl.division_id', $division_id);
		$this->db->join('hardware_mapping_section_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');		
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');		
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date >=', $today);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	
	public function getscheduleTicketBySection($ID,$status,$casetype,$zone_id,$division_id,$cat=NULL){
		$today = date('Y-m-d');
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*,hardware_schedule_config_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where('user_info_tbl.user_zone', $zone_id);
		$this->db->where('user_info_tbl.user_division', $division_id);
		$this->db->where('hardware_mapping_section_tbl.section_id', $ID);
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date <=', $today);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function getscheduleTicketBySectionIdAndCat($ID,$status,$casetype,$zone_id,$division_id,$cat){
		$today = date('Y-m-d');
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*,hardware_schedule_config_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$this->db->where('user_info_tbl.user_zone', $zone_id);
		$this->db->where('user_info_tbl.user_division', $division_id);
		$this->db->where('hardware_mapping_section_tbl.section_id', $ID);
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date <=', $today);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	public function getDueMaintenanceBySectionId($ID,$status,$zone_id,$division_id){
		$today = date('Y-m-d');
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*,hardware_schedule_config_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where('user_info_tbl.user_zone', $zone_id);
		$this->db->where('user_info_tbl.user_division', $division_id);
		$this->db->where('hardware_mapping_section_tbl.section_id', $ID);
		$this->db->where('hardware_mapping_section_tbl.map_status', $status);
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date <=', $today);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
        
        
	public function getallscheduleTicketBySectionId($zone_id,$division_id,$cat,$status,$section =NULL){
		$today = date('Y-m-d');
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*,hardware_schedule_config_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$this->db->where('user_info_tbl.user_zone', $zone_id);
		$this->db->where('user_info_tbl.user_division', $division_id);
		$this->db->where('hardware_mapping_section_tbl.section_id', $section);
		//$this->db->where('hardware_mapping_section_tbl.map_status', $status);
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date <=', $today);
		$query 	= $this->db->get();
		$result = $query->result();
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		return $result;	
	}
        
	public function getallscheduleTicketBySectionIdAndCat($zone_id,$division_id,$cat,$status){
		$today = date('Y-m-d');
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*,hardware_schedule_config_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');
		//$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where('hardware_basic_tbl.hardware_category', $cat);
		$this->db->where('user_info_tbl.user_zone', $zone_id);
		$this->db->where('user_info_tbl.user_division', $division_id);
		//$this->db->where('hardware_mapping_section_tbl.map_status', $status);
		$this->db->where('hardware_schedule_config_tbl.next_schedule_date <=', $today);
		$query 	= $this->db->get();
		$result = $query->result();
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		return $result;	
	}
	
	public function deleteSection($id){		
		$result = $this->db->delete('section_map_mapping_tbl', array('section_id' => $id));
		return $result;		
	}
	public function getSectionOnDash(){
		$this->db->select('section_id');
		$this->db->from('section_map_mapping_tbl');
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
         public function getallHardwareScheduleByCategorySectiontypeNew($cat_ids, $SecID,$type=NULL){
                $today = date('Y-m-d');
		$user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
                $sql = "SELECT hardware_schedule_config_tbl.* FROM hardware_schedule_config_tbl WHERE hardware_schedule_config_tbl.next_schedule_date < '".$today."' AND hardware_schedule_config_tbl.map_id NOT IN (SELECT DISTINCT hardware_map_section_id FROM tickets_tbl WHERE ticket_status = 20 GROUP BY hardware_map_section_id )
            GROUP BY hardware_schedule_config_tbl.map_id";
		$query 	= $this->db->query($sql);
		$result = $query->result();
		return $result;	
	}
        public function getallHardwareScheduleByCategorySectiontype($cat_ids, $SecID,$type=NULL){
                $today = date('Y-m-d');
		$user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('hardware_schedule_config_tbl', 'hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id','left');
		
                $this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
                $this->db->where('hardware_schedule_config_tbl.next_schedule_date >=', $today);
		if(!empty($type)){
			$this->db->where('hardware_basic_tbl.hardware_model', $type);
		}
			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	
        
	public function getallhardwarebycategorysectiontypeNotTicket($cat_ids, $SecID,$type=NULL){
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$this->db->select('hardware_mapping_section_tbl.*,hardware_basic_tbl.*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = hardware_basic_tbl.hardware_created_by','left');
		$this->db->join('tickets_tbl', 'tickets_tbl.hardware_map_section_id = hardware_mapping_section_tbl.map_id','left');
		$this->db->where_in('hardware_basic_tbl.hardware_category', $cat_ids);
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$this->db->where('tickets_tbl.ticket_status!=','20');
		if(!empty($type)){
			$this->db->where('hardware_basic_tbl.hardware_model', $type);
		}			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
        
	public function getallhardwarebycategorysectiontype($cat_ids, $SecID,$type=NULL){
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
		if(!empty($type)){
			$this->db->where('hardware_basic_tbl.hardware_model', $type);
		}
			
		$this->db->where('hardware_mapping_section_tbl.section_id', $SecID);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;	
	}
	
	public function GetCatByZone(){
		
		$user_zone 	 	= $_SESSION['loggedInUserDetail']->user_zone;
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;		
		$this->db->select('*');
		$this->db->from('master_hardware_category_tbl');
		$this->db->where('zone_id',$user_zone);
		$this->db->where('division_id',$user_division);
                $this->db->order_by("priority", "asc");
                $this->db->order_by("category_name", "asc");
		$this->db->where('category_status','10');
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;
	
	}
	
	public function setting_meta_tbl($key){
		
                $loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$this->db->select('*');
                $this->db->where('zone',$loggedInUserDetail->user_zone);
                $this->db->where('division',$loggedInUserDetail->user_division);
		$this->db->where('meta_key',$key);
		$this->db->where('meta_status',10);
		$result = $this->db->get('setting_meta_tbl')->row();
		return $result;
		
	}
	public  function insertmeta($data){
            
            $result = $this->db->insert('setting_meta_tbl',$data);
            return $result;
            
        }
	public  function updatemeta($id,$data){
            
            $this->db->where('meta_id',$id);
            $result = $this->db->update('setting_meta_tbl',$data);
            return $result;
            
        }
        
        /********* Dashboard query ***********/        
        
        
        public function GetAllHWD($cat_ids,$sectionid){
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT hardware_mapping_section_tbl.* FROM hardware_mapping_section_tbl LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.`hardware_id` = `hardware_mapping_section_tbl`.`hardware_id` 
WHERE hardware_mapping_section_tbl.section_id = '".$sectionid."' AND hardware_basic_tbl.hardware_category  = '".$cat_ids."' ";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
        
        
        public function GetAllTicketHWD($cat_ids,$sectionid){
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT `hardware_mapping_section_tbl`.*, `hardware_basic_tbl`.*
FROM `hardware_mapping_section_tbl`
LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.`hardware_id` = `hardware_mapping_section_tbl`.`hardware_id`
LEFT JOIN `user_info_tbl` ON `user_info_tbl`.`user_info_id` = `hardware_basic_tbl`.`hardware_created_by`
INNER JOIN `tickets_tbl` ON `tickets_tbl`.`hardware_map_section_id` = `hardware_mapping_section_tbl`.`map_id`
WHERE 
`tickets_tbl`.`ticket_status` = '20'
AND `hardware_mapping_section_tbl`.`section_id` = '".$sectionid."'
 AND hardware_basic_tbl.hardware_category  = '".$cat_ids."' 
GROUP BY `hardware_mapping_section_tbl`.`map_id`";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
        
        
        
        public function GetAllHwdDue($cat_ids,$sectionid){
            $today = date('Y-m-d');
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT hardware_schedule_config_tbl.* FROM hardware_schedule_config_tbl
LEFT JOIN `hardware_mapping_section_tbl` ON `hardware_mapping_section_tbl`.`map_id` = `hardware_schedule_config_tbl`.`map_id` 
LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.hardware_id = `hardware_mapping_section_tbl`.`hardware_id` 
WHERE hardware_schedule_config_tbl.next_schedule_date < '".$today."' 
AND hardware_mapping_section_tbl.section_id = '".$sectionid."'
AND hardware_schedule_config_tbl.map_id 
NOT IN (SELECT DISTINCT hardware_map_section_id FROM tickets_tbl WHERE ticket_status = 20 GROUP BY hardware_map_section_id )
 AND hardware_basic_tbl.hardware_category  = '".$cat_ids."' 
GROUP BY hardware_schedule_config_tbl.map_id";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
        
        
        public function GetAllHWDWithOutSection($cat_ids){
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT hardware_mapping_section_tbl.* FROM hardware_mapping_section_tbl LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.`hardware_id` = `hardware_mapping_section_tbl`.`hardware_id` 
WHERE hardware_basic_tbl.hardware_category  = '".$cat_ids."' ";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
        
        
        public function GetAllTicketHWDWithOutSection($cat_ids){
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT `hardware_mapping_section_tbl`.*, `hardware_basic_tbl`.*
FROM `hardware_mapping_section_tbl`
LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.`hardware_id` = `hardware_mapping_section_tbl`.`hardware_id`
LEFT JOIN `user_info_tbl` ON `user_info_tbl`.`user_info_id` = `hardware_basic_tbl`.`hardware_created_by`
INNER JOIN `tickets_tbl` ON `tickets_tbl`.`hardware_map_section_id` = `hardware_mapping_section_tbl`.`map_id`
WHERE 
`tickets_tbl`.`ticket_status` = '20'
 AND hardware_basic_tbl.hardware_category  = '".$cat_ids."' 
GROUP BY `hardware_mapping_section_tbl`.`map_id`";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
        
        
        
        public function GetAllHwdDueWithOutSection($cat_ids){
            $today = date('Y-m-d');
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT hardware_schedule_config_tbl.* FROM hardware_schedule_config_tbl
LEFT JOIN `hardware_mapping_section_tbl` ON `hardware_mapping_section_tbl`.`map_id` = `hardware_schedule_config_tbl`.`map_id` 
LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.hardware_id = `hardware_mapping_section_tbl`.`hardware_id` 
WHERE hardware_schedule_config_tbl.next_schedule_date < '".$today."' 
AND hardware_schedule_config_tbl.map_id 
NOT IN (SELECT DISTINCT hardware_map_section_id FROM tickets_tbl WHERE ticket_status = 20 GROUP BY hardware_map_section_id )
 AND hardware_basic_tbl.hardware_category  = '".$cat_ids."' 
GROUP BY hardware_schedule_config_tbl.map_id";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
        
	 public function getscheduleTicketBySectionId($cat_ids,$sectionid){
            $today = date('Y-m-d');
            $user_zone 	= $_SESSION['loggedInUserDetail']->user_zone;
            $user_division 	= $_SESSION['loggedInUserDetail']->user_division;
            $sql = "SELECT hardware_schedule_config_tbl.* FROM hardware_schedule_config_tbl
LEFT JOIN `hardware_mapping_section_tbl` ON `hardware_mapping_section_tbl`.`map_id` = `hardware_schedule_config_tbl`.`map_id` 
LEFT JOIN `hardware_basic_tbl` ON `hardware_basic_tbl`.hardware_id = `hardware_mapping_section_tbl`.`hardware_id` 
WHERE hardware_schedule_config_tbl.next_schedule_date < '".$today."' 
AND hardware_mapping_section_tbl.section_id = '".$sectionid."'
AND hardware_schedule_config_tbl.map_id 
NOT IN (SELECT DISTINCT hardware_map_section_id FROM tickets_tbl WHERE ticket_status = 20 GROUP BY hardware_map_section_id ) 
GROUP BY hardware_schedule_config_tbl.map_id";
            $query 	= $this->db->query($sql);
            $result = $query->result();
            return $result;	
        }
	
        /********* Dashboard query ***********/        
        
}