<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Meeting_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}
	
	public function insertMeeting($data){
		
		$result = $this->db->insert('meeting_tbl',$data);
		return $result;
	}
	public function insertAgend($data){
		
		$result = $this->db->insert('meeting_agenda_tbl',$data);
		return $result;
	}
    public function GetAllMeeting(){
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		$this->db->select('*');
		$this->db->where('status',10);
		$this->db->where('zone',$zone_id);
		$this->db->where('division',$division_id);
		$result = $this->db->get('meeting_tbl')->result();
		return $result;
	} 
    public function CheckMapid($id){		
		$this->db->select('*');
		$this->db->where('meeting_id',$id);
		$result = $this->db->get('meeting_agenda_tbl')->result();
		return $result;
	} 
	public function getUserByShopIdAndSectionID($shop_id,$SectionID){
		$this->db->select('um.user_info_id,ud.*,ui.user_role');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id=ud.user_info_id', 'right');
		$this->db->join('user_info_tbl ui', 'ui.user_info_id=ud.user_info_id', 'left');
		$this->db->where('um.shop_id', $shop_id);
		$this->db->where('um.section_id', $SectionID);
		$this->db->where('ui.user_role', '5');
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getUserByShopId($shop_id=null,$usertype=null){
		$this->db->select('um.user_info_id,ud.*,ui.user_role');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id=ud.user_info_id', 'right');
		$this->db->join('user_info_tbl ui', 'ui.user_info_id=ud.user_info_id', 'left');
		
		if(!empty($shop_id)){
			$this->db->where('um.shop_id', $shop_id);
		}
		if(!empty($usertype)){
			$this->db->where('ui.user_role', '4');
		}
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		$this->db->where('ui.user_status',10);
		$this->db->where('ui.user_zone',$zone_id);
		$this->db->where('ui.user_division',$division_id);
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getUserByMShopId($shop_id){
		$this->db->select('um.user_info_id,ud.*,ui.user_role');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id=ud.user_info_id', 'right');
		$this->db->join('user_info_tbl ui', 'ui.user_info_id=ud.user_info_id', 'left');
		$this->db->where('um.maintenance_shop_id', $shop_id);
		$this->db->where('ui.user_role', '6');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		$this->db->where('ui.user_status',10);
		$this->db->where('ui.user_zone',$zone_id);
		$this->db->where('ui.user_division',$division_id);
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getUserByMShopIdAndSectionID($shop_id,$SectionID){
		$this->db->select('um.user_info_id,ud.*,ui.user_role');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id=ud.user_info_id', 'right');
		$this->db->join('user_info_tbl ui', 'ui.user_info_id=ud.user_info_id', 'left');
		$this->db->where('um.maintenance_shop_id', $shop_id);
		$this->db->where('um.maintenance_section_id', $SectionID);
		$this->db->where('ui.user_role', '7');
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		$this->db->where('ui.user_status',10);
		$this->db->where('ui.user_zone',$zone_id);
		$this->db->where('ui.user_division',$division_id);
		$query  = $this->db->get()->result();
		return $query;
	}
	
	public function GetAllUserByType($Type=null){
		
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		if($Type == 'manager'){
			$SQL= 'SELECT user_details_tbl.* FROM user_info_tbl 
LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id WHERE user_info_tbl.user_role = 3 AND user_info_tbl.user_zone = "'.$zone_id.'" AND user_info_tbl.user_division = "'.$division_id.'" AND user_info_tbl.user_status = 10';
		}elseif($Type == 'shop'){
			$SQL= 'SELECT user_details_tbl.* FROM user_info_tbl 
LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id WHERE user_info_tbl.user_role = 4 AND  user_info_tbl.user_zone = "'.$zone_id.'" AND user_info_tbl.user_division = "'.$division_id.'" AND user_info_tbl.user_status = 10';
		}elseif($Type == 'section'){
			$SQL= 'SELECT user_details_tbl.* FROM user_info_tbl 
LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id WHERE user_info_tbl.user_role = 5 AND  user_info_tbl.user_zone = "'.$zone_id.'" AND user_info_tbl.user_division = "'.$division_id.'" AND user_info_tbl.user_status = 10';
		}elseif($Type == 'm_shop'){
			$SQL= 'SELECT user_details_tbl.* FROM user_info_tbl 
LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id WHERE user_info_tbl.user_role = 6 AND  user_info_tbl.user_zone = "'.$zone_id.'" AND user_info_tbl.user_division = "'.$division_id.'" AND user_info_tbl.user_status = 10';
		}elseif($Type == 'm_section'){
			$SQL= 'SELECT user_details_tbl.* FROM user_info_tbl 
LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id WHERE user_info_tbl.user_role = 7 AND  user_info_tbl.user_zone = "'.$zone_id.'" AND user_info_tbl.user_division = "'.$division_id.'" AND user_info_tbl.user_status = 10';
		}else{
			$SQL= 'SELECT user_details_tbl.* FROM user_info_tbl 
LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id WHERE user_info_tbl.user_zone = "'.$zone_id.'" AND user_info_tbl.user_division = "'.$division_id.'" AND user_info_tbl.user_role NOT IN ("1","2") AND user_info_tbl.user_status = 10';
		}
		$query  = $this->db->query($SQL)->result();
		return $query;
	}
	////**** yash code*****/////
	
	public function get_meeting_list (){
		$loggedInUserDetail = $this->session->userdata('loggedInUserDetail');
		$zone_id = $loggedInUserDetail->user_zone;
		$division_id = $loggedInUserDetail->user_division;
		$this->db->select('meeting_tbl.*,master_shop_tbl.shop_name,master_section_tbl.section_name');
		$this->db->where('status',10);
		$this->db->where('zone',$zone_id);
		$this->db->where('division',$division_id);
		$this->db->from('meeting_tbl');
		$this->db->join('master_shop_tbl',  'meeting_tbl.shop_id = master_shop_tbl.shop_id', 'left');
	    $this->db->join('master_section_tbl', 'meeting_tbl.section_id= master_section_tbl.section_id', 'left');
		
		
        $query = $this->db->get()->result_array();
		
		return $query;
	}
	 public function get_shops ($shop_id){
		
		$this->db->select('*');
		$this->db->where('shop_status',10);
		$this->db->where('shop_id', $shop_id);
		$row = $this->db->get('master_shop_tbl')->row();
		return $row;
	   
	  
		 
	 }
	 public function get_section ($section_id){
		
		$this->db->select('*');
		//$this->db->where('shop_status',10);
		$this->db->where('section_id', $section_id);
		$row = $this->db->get('master_section_tbl')->row();
		return $row;
	   
	  
		 
	 }
	 public function get_user ($user_info_id){
		
		$this->db->select('*');
		//$this->db->where('shop_status',10);
		$this->db->where('user_info_id', $user_info_id);
		$row = $this->db->get('user_details_tbl')->row();
		//$this->db->last_query();
		//echo "<pre>";print_r($row); die();
		return $row;
        		
	 }
	 
	 public function get_msection ($maintenance_section_id){
		
		//echo "<pre>";print_r($maintenance_section_id);echo "</pre>";//die( __LINE__ );
		$this->db->select('*');
		$this->db->where('maintenance_section_status',10);
		$this->db->where('maintenance_section_id', $maintenance_section_id);
		$row = $this->db->get('master_maintenance_section_tbl')->row();
		return $row;	 
	 }
	 public function get_mshop ($maintenance_shop_id){
		
		$this->db->select('*');
		//$this->db->where('shop_status',10);
		$this->db->where('maintenance_shop_id', $maintenance_shop_id);
		$row = $this->db->get('master_maintenance_shop_tbl')->row();
		return $row;	 
	 }
	 public function get_agenda_list ($meeting_id){		
		$this->db->select('*');
		$this->db->where('status',10);
		$this->db->where('meeting_id', $meeting_id);
		$row = $this->db->get('meeting_agenda_tbl')->result();
		return $row;	 
	 }
	
}