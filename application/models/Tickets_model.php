<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Tickets_model extends CI_Model{
	public function getRaiseTicket(){
		
		$user_division 	= $_SESSION['loggedInUserDetail']->user_division;
		$user_zone 		= $_SESSION['loggedInUserDetail']->user_zone;
		//echo "<pre>";print_r($user_zone);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		$this->db->select('hardware_basic_tbl.hardware_name,hardware_basic_tbl.hardware_category,user_details_tbl.user_f_name,user_details_tbl.user_l_name,hardware_mapping_section_tbl.hardware_serial_no,master_section_tbl.section_name,master_shop_tbl.shop_name,
		master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,tickets_tbl.*');
		$this->db->from('tickets_tbl');
		$this->db->join('master_maintenance_shop_tbl', 'master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id ','left');
		$this->db->join('master_maintenance_section_tbl', 'master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id','left');
		$this->db->join('master_shop_tbl', 'master_shop_tbl.shop_id = tickets_tbl.shop_id','left');
		$this->db->join('master_section_tbl', 'master_section_tbl.section_id = tickets_tbl.section_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = tickets_tbl.tickets_created_by','left');
		$this->db->join('user_details_tbl', 'user_details_tbl.user_info_id = user_info_tbl.user_info_id','left');
		$this->db->join('hardware_mapping_section_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->where('tickets_tbl.division_id',$user_division);
		$this->db->where('tickets_tbl.zone_id',$user_zone);
		$this->db->order_by("tickets_tbl.tickets_created_date DESC");
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}
	public function Getallhardwarebystatus($user_zone,$user_division,$status=NULL){
		$this->db->select('hardware_basic_tbl.hardware_name,hardware_basic_tbl.hardware_category,user_details_tbl.user_f_name,user_details_tbl.user_l_name,hardware_mapping_section_tbl.hardware_serial_no,master_section_tbl.section_name,master_shop_tbl.shop_name,
		master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,tickets_tbl.*');
		$this->db->from('tickets_tbl');
		$this->db->join('master_maintenance_shop_tbl', 'master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id ','left');
		$this->db->join('master_maintenance_section_tbl', 'master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id','left');
		$this->db->join('master_shop_tbl', 'master_shop_tbl.shop_id = tickets_tbl.shop_id','left');
		$this->db->join('master_section_tbl', 'master_section_tbl.section_id = tickets_tbl.section_id','left');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = tickets_tbl.tickets_created_by','left');
		$this->db->join('user_details_tbl', 'user_details_tbl.user_info_id = user_info_tbl.user_info_id','left');
		$this->db->join('hardware_mapping_section_tbl', 'hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id','left');
		$this->db->join('hardware_basic_tbl', 'hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id','left');
		$this->db->where('tickets_tbl.division_id',$user_division);
		$this->db->where('tickets_tbl.zone_id',$user_zone);
		if($status != NULL){
			$this->db->where('tickets_tbl.ticket_status',$status);
		}
		$this->db->order_by("tickets_tbl.tickets_created_date DESC");
		$query 	= $this->db->get();
		$result = $query->result();
		return $result; 
	}

	function getTicketLog($TicketNo){
		$this->db->select('*');
		$this->db->where('ticket_no',$TicketNo);
		$query =$this->db->get('tickets_log_tbl');
		$results = $query->result();
		return $results;
	}

	function CheckHardwareTicket($MapID){
		$this->db->select('*');
		$this->db->where('hardware_map_section_id',$MapID);
		$query =$this->db->get('tickets_tbl');
		$results = $query->result();
		return $results;
	}
	
	public function getmaintenanceuser($mshopid,$msectionid){
		$this->db->select('um.user_info_id,ud.user_f_name,ud.user_l_name');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id = ud.user_info_id');
		$this->db->where('um.shop_id IS NULL');
		$this->db->where('um.section_id IS NULL');
		$this->db->where('um.maintenance_shop_id', $mshopid);
		$this->db->where('um.maintenance_section_id', $msectionid);
		$query 		= $this->db->get();
		$results 	= $query->row();
		return $results;
	}

}