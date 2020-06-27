<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Notifications_model extends CI_Model{
	public function insertNotification($table,$data){
		$this->db->insert($table, $data);
		$insertedId = $this->db->insert_id();
		return $insertedId;
    }
	public function getUserByShopId($shop_id){
		$this->db->select('um.user_info_id,ud.*,ui.user_role');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id=ud.user_info_id', 'right');
		$this->db->join('user_info_tbl ui', 'ui.user_info_id=ud.user_info_id', 'left');
		$this->db->where('um.shop_id', $shop_id);
		$this->db->where('ui.user_role', '4');
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getUserBymShopId($m_shop_id){
		$this->db->select('um.user_info_id,ud.*,ui.user_role');
		$this->db->from('user_mapping_tbl um');
		$this->db->join('user_details_tbl ud', 'um.user_info_id=ud.user_info_id', 'right');
		$this->db->join('user_info_tbl ui', 'ui.user_info_id=ud.user_info_id', 'left');
		$this->db->where('um.maintenance_shop_id', $m_shop_id);
		$this->db->where('ui.user_role', '6');
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getUserByRoleId($role_id,$user_zone,$user_division){
		$this->db->select('user_details_tbl.user_info_id,user_details_tbl.user_f_name,user_details_tbl.user_l_name');
		$this->db->from('user_details_tbl');
		$this->db->join('user_info_tbl', 'user_info_tbl.user_info_id = user_details_tbl.user_info_id');
		$this->db->where('user_info_tbl.user_role',$role_id);
		$this->db->where('user_info_tbl.user_zone',$user_zone);
		$this->db->where('user_info_tbl.user_division',$user_division);
		$this->db->where('user_info_tbl.user_status','10');
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getUserDeviceId($user_ids){
		$this->db->select('*');
		$this->db->from('user_device_tbl');
		$this->db->where_in('user_info_id',$user_ids);
		$query  = $this->db->get()->result();
		return $query;
	}
	public function getAllUserData($user_zone,$user_division,$type=NULL){
		$this->db->select('user_info_tbl.*,user_details_tbl.*');
		$this->db->from('user_info_tbl');
		$this->db->join('user_details_tbl', 'user_info_tbl.user_info_id = user_details_tbl.user_info_id');
		$this->db->where_not_in('user_info_tbl.user_role', '1');
		$this->db->where_not_in('user_info_tbl.user_role', '2');
		$this->db->where_not_in('user_info_tbl.user_role', '3');
		$this->db->where('user_info_tbl.user_zone', $user_zone);
		$this->db->where('user_info_tbl.user_division', $user_division);
		if($type != 'all'){
			$this->db->where('user_info_tbl.user_status', '10');		
		}
		if($_SESSION['loggedInUserDetail']->user_role != '3'){
			$this->db->where('user_info_tbl.user_created_by', $_SESSION['loggedInUserDetail']->user_info_id);
		}
		$query  = $this->db->get()->result();
		return $query;
    }
}