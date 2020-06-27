<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Cronjob_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}
	
	public function GetSchuduleMap($ID){
		$query = $this->db->query('SELECT * FROM  hardware_schedule_mapping_tbl WHERE hardware_section_map_id = "'.$ID.'" ');
		$results = $query->row();
		return $results;
	}
	public function GetAllDueToSchuleData($date){
	
		$query = $this->db->query('SELECT * FROM hardware_schedule_config_tbl WHERE  schedule_status = 10');
		$results =$query->result();
		return $results;
		
	}	 
	public function GetAllDueToSchuleDataOLd($date){
	
		$query = $this->db->query('SELECT * FROM hardware_schedule_config_tbl WHERE  next_schedule_date < "'.$date.'" AND schedule_status = 10');
		$results =$query->result();
		return $results;
		
	}	 
	public function GetShopAndSectionByMapID($ID){
	
		$query = $this->db->query('SELECT * FROM  hardware_mapping_section_tbl WHERE map_id = "'.$ID.'" ');
		$results = $query->result();
		return $results;
		
	}
	
	public function CheckTicketAble($ID){	
		$query = $this->db->query('SELECT * FROM  tickets_tbl WHERE hardware_map_section_id = "'.$ID.'" ');
		$results = $query->result();
		return $results;		
	}
	
	public function GetShopUserDeviceID($ShopID){		
		$query = $this->db->query('SELECT user_device_tbl.* FROM user_mapping_tbl LEFT JOIN user_device_tbl ON user_mapping_tbl.user_info_id = user_device_tbl.user_info_id WHERE user_mapping_tbl.shop_id = '.$ShopID.' AND user_mapping_tbl.section_id IS NULL');
		$results =$query->row();
		return $results;
		
	}
	public function GetSectionUserDeviceID($ShopID,$SectionID){		
		$query = $this->db->query('SELECT user_device_tbl.* FROM user_mapping_tbl LEFT JOIN user_device_tbl ON user_mapping_tbl.user_info_id = user_device_tbl.user_info_id WHERE user_mapping_tbl.shop_id = '.$ShopID.' AND user_mapping_tbl.section_id = '.$SectionID.' ');
		$results =$query->row();
		return $results;
		
	}
	
	public function GetMsgData($MapID){
		
		$query = $this->db->query('SELECT hardware_mapping_section_tbl.*, hardware_basic_tbl.*,master_hardware_category_tbl.category_name AS category_name FROM hardware_mapping_section_tbl
LEFT JOIN hardware_basic_tbl ON hardware_basic_tbl.hardware_id =  hardware_mapping_section_tbl.hardware_id
LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id =  hardware_basic_tbl.hardware_category
WHERE hardware_mapping_section_tbl.map_id = '.$MapID.' ');
		$results = $query->row();
		return $results;
	
		
	}
	
	public function getShopBy($data){
		$this->db->select('*');
		$this->db->from('master_shop_tbl');
		$this->db->where('shop_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	
	public function getSectionBy($data){
		$this->db->select('*');
		$this->db->from('master_section_tbl');
		$this->db->where('section_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	
	public function checkMapID($ID){
		$this->db->select('*');
		$this->db->from('hardware_schedule_mapping_tbl');
		$this->db->where('hardware_section_map_id', $ID);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	
	public function updateJob($id,$arrschedule){
		
		$this->db->where('id',$id);
		$resutl = $this->db->update('hardware_schedule_mapping_tbl',$arrschedule);
		return $resutl;
	}
    
	public function updateJobConfig($id,$arrschedule){
		
		$this->db->where('map_id',$id);
		$resutl = $this->db->update('hardware_schedule_config_tbl',$arrschedule);
		return $resutl;
	}
    
	public function addJob($arrschedule){		
		$resutl = $this->db->insert('hardware_schedule_config_tbl',$arrschedule);
		return $resutl;
	}
	
        public function GetCronSetting(){
            
            $this->db->select('*');
            $this->db->where('status','10');
            $result = $this->db->get('cron_schedule_settings_tbl')->result();
            return $result;           
            
        }
        
        public  function GetAllDueData(){
            $today = date('Y-m-d');
            $SQL = "SELECT user_device_tbl.user_device_id,user_device_tbl.user_info_id,hardware_mapping_section_tbl.hardware_serial_no,hardware_mapping_section_tbl.map_id,hardware_basic_tbl.hardware_name,hardware_schedule_config_tbl.* FROM hardware_schedule_config_tbl
LEFT JOIN hardware_mapping_section_tbl ON  hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id
LEFT JOIN hardware_basic_tbl ON  hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id
LEFT JOIN user_mapping_tbl ON  hardware_mapping_section_tbl.section_id = user_mapping_tbl.section_id
LEFT JOIN user_device_tbl ON  user_device_tbl.user_info_id = user_mapping_tbl.user_info_id
WHERE hardware_schedule_config_tbl.next_schedule_date < '".$today."'";
            $result = $this->db->query($SQL)->result();
            return $result;           
        }
        
}