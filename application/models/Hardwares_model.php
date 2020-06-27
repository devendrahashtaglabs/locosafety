<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Hardwares_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insertHardware($table,$data){
        $this->db->insert($table,$data);
		$insertedId = $this->db->insert_id();
        return $insertedId;
    }
	public function updateHardware($id,$data,$table){
        $this->db->where('hardware_id', $id);
		$query = $this->db->update($table, $data);
		return $query;
    }
	public function updateMapHardware($data,$id,$table){
        $this->db->where('map_id', $id);
		$query = $this->db->update($table, $data);
		return $query;
    }
	public function updateScheduleHardware($data,$id,$table){
        $this->db->where('hardware_section_map_id', $id);
		$query = $this->db->update($table, $data);
		return $query;
    }
	public function getHardware(){
		$this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->where('hardware_status', '10');
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;  
    }
	public function getHardwareCount($user_zone,$user_division){
		$this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->join('user_info_tbl', 'hardware_basic_tbl.hardware_created_by = user_info_tbl.user_info_id');
		$this->db->where('hardware_basic_tbl.hardware_status', '10');
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->result();
        return $result;
    }
	public function getHardwareBasicDetailById($id)
	{
		$this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->where('hardware_id', $id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result;  
	}
	public function getHardwareMappingById($hardware_id)
	{
		$this->db->select('*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->where('hardware_id', $hardware_id);
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;  
	}
	public function getHardwareMapDataById($map_id)
	{
		$this->db->select('*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->where('map_id', $map_id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result;  
	}
	public function getHardwareScheduleById($map_id)
	{
		$this->db->select('*');
		$this->db->from('hardware_schedule_config_tbl');
		$this->db->where('map_id', $map_id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result;  
	}
	public function getHardwareStatus($status_id)
	{
		$this->db->select('status');
		$this->db->from('master_status_tbl');
		$this->db->where('status_code', $status_id);
		$query 	= $this->db->get();
		$result = $query->row(); 
		return $result;  
	}
	public function getStatusFilter($status){
        /* $this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->where('hardware_status', $status);
		$query 	= $this->db->get();
		$result = $query->result();  */
		
		$session_data 	= $this->session->userdata('loggedInUserDetail');
		$zone_id 		= $session_data->user_zone;
		$division_id 	= $session_data->user_division; 
		$this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->join('user_info_tbl', 'hardware_basic_tbl.hardware_created_by = user_info_tbl.user_info_id');
		$this->db->where('hardware_basic_tbl.hardware_status', $status);
		$this->db->where('user_info_tbl.user_zone', $zone_id);
		$this->db->where('user_info_tbl.user_division', $division_id);
		$query 	= $this->db->get();
		$result = $query->result();
		return $result;
    }

    public function getHardwareDataByShopID($id,$idtype)
    {
        $this->db->select('*');
        $this->db->from('hardware_mapping_section_tbl as mapping');
		if($idtype == 'section_id'){
			$this->db->where('mapping.section_id', $id);  
		}elseif($idtype == 'shop_id'){
			$this->db->where('mapping.shop_id', $id);  
		}
        $this->db->join('hardware_basic_tbl as hardware', 'mapping.hardware_id = hardware.hardware_id', 'left');
		if($idtype == 'maintenance_section_id'){
			$this->db->where('hardware.default_maintenance_section', $id);  
		}elseif($idtype == 'maintenance_shop_id'){
			$this->db->where('hardware.default_maintenance_shop', $id);  
		}
        $query  = $this->db->get();
        $result = $query->result(); 
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
        return $result;  
    }

    public function GetALLMappingData(){
        $this->db->select('*');
        $this->db->from('hardware_mapping_section_tbl');
        $query  = $this->db->get();
        $result = $query->result(); 
        return $result;          
    }


    public function getHardwareDataByHardwareID($id)
    {
		//$id = '125469';
        $this->db->select('*');
        $this->db->from('hardware_basic_tbl');
        $this->db->where('hardware_id', $id);        
        $query  = $this->db->get();
        $result = $query->row();
		
        return $result;  
    }
	
	public function getHardwareDataByHardwareIDSECOND($id)
    {
		//$id = '125469';
        $this->db->select('*');
        $this->db->from('hardware_basic_tbl');
        $this->db->where('hardware_id', $id);        
        $query  = $this->db->get();
        $result = $query->row();
		
		//$result = $this->db->query("SELECT * FROM hardware_basic_tbl WHERE hardware_id = '$id'");
		//$result = $query->row();
        return $result;  
    }

    public function getHardwareTypeNameByID($id)
    {
        $this->db->select('*');
        $this->db->from('master_hardware_type_tbl');
        $this->db->where('hardware_type_id', $id);        
        $query  = $this->db->get();
        $result = $query->row(); 
        return $result;  
    }
	public function getHMCount($user_zone,$user_division){
        $this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->join('user_info_tbl', 'hardware_basic_tbl.hardware_created_by = user_info_tbl.user_info_id');
		$this->db->where('hardware_basic_tbl.hardware_status', '60');
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->num_rows();
        return $result; 
    }
	public function getScheduleDataByMapId($map_id){
        $this->db->select('*');
		$this->db->from('hardware_schedule_mapping_tbl');
		$this->db->where('hardware_section_map_id', $map_id);
		$query 	= $this->db->get();
		$result = $query->row();
        return $result; 
    }
	public function getallhwcount($user_zone,$user_division){		
		$this->db->select('*');
		$this->db->from('hardware_mapping_section_tbl');
		$this->db->join('hardware_basic_tbl', 'hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id');
		$this->db->join('user_info_tbl', 'hardware_basic_tbl.hardware_created_by = user_info_tbl.user_info_id');
		//$this->db->where('hardware_basic_tbl.hardware_status', '10');
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		$query 	= $this->db->get();
		$result = $query->result();
        return $result;		
    }
	public function getallMhwcount($user_zone,$user_division){	
		//SELECT COUNT(DISTINCT(hardware_map_section_id)) FROM `tickets_tbl` WHERE ticket_status = 20
		$this->db->select('DISTINCT(hardware_map_section_id)');
		$this->db->from('tickets_tbl');
		$this->db->where('ticket_status', '20');
		$this->db->where('zone_id', $user_zone);
		$this->db->where('division_id', $user_division);
		$query 	= $this->db->get();
		$result = $query->num_rows();
        return $result;		
    }
	public function Getallhardwarelist($user_zone,$user_division,$status=NULL){	
		$this->db->select('*');
		$this->db->from('master_shop_tbl');
		$this->db->join('hardware_mapping_section_tbl', 'master_shop_tbl.shop_id = hardware_mapping_section_tbl.shop_id');
		$this->db->join('hardware_basic_tbl', 'hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id');
		$this->db->join('user_info_tbl', 'hardware_basic_tbl.hardware_created_by = user_info_tbl.user_info_id');
		//$this->db->where('hardware_basic_tbl.hardware_status', '10');
		$this->db->where('master_shop_tbl.zone_id', $user_zone);
		$this->db->where('master_shop_tbl.division_id', $user_division);
		$this->db->where('master_shop_tbl.shop_status', '10');
		if($status == '60' || $status == '10'){
			$this->db->where('hardware_mapping_section_tbl.map_status', $status);
		}
		$query 	= $this->db->get();
		$result = $query->result();
        return $result;

	}

}