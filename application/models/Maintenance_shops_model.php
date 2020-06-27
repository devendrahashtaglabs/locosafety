<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Maintenance_shops_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		define("MSHOPTBL","master_maintenance_shop_tbl");		
	}
	public function insertShop($data){
		$insertedId = $this->db->insert(MSHOPTBL, $data);
		return $insertedId;
	}
	public function updateMShop($id,$data){
		$this->db->where('maintenance_shop_id', $id);
		$query = $this->db->update(MSHOPTBL, $data);	 
		return $query;
	}
	public function deleteMShop($id,$data){
		$this->db->where('maintenance_shop_id', $id);
		$query = $this->db->update(MSHOPTBL, $data);	 
		return $query;		
	}
	public function activateMShop($id,$data){
		$this->db->where('maintenance_shop_id', $id);
		$query = $this->db->update(MSHOPTBL, $data);	 
		return $query;		
	}
	public function getMShop(){
		$this->db->select('*');
		$this->db->from(MSHOPTBL);
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getMShopCount($user_zone,$user_division,$type=NULL){
		$this->db->select('*');
		$this->db->from(MSHOPTBL);
		$this->db->where('zone_id',$user_zone);
		$this->db->where('division_id',$user_division);
		if($type != 'all'){
			$this->db->where('maintenance_shop_status','10');
		}
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getMShopBy($data){
		$this->db->select('*');
		$this->db->from(MSHOPTBL);
		$this->db->where('maintenance_shop_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function checkMShopExist($mshopname,$zone_id,$division_id){
		$this->db->select('maintenance_shop_name');
		$this->db->from(MSHOPTBL);
		$this->db->where('maintenance_shop_name', $mshopname);
		$this->db->where('zone_id', $zone_id);
		$this->db->where('division_id', $division_id);
		$query 	= $this->db->get();
		$result = $query->num_rows();
		return $result; 
	}
	public function getActiveMShop($user_zone,$user_division){
		$this->db->select('*');
		$this->db->from(MSHOPTBL);
		$this->db->where('zone_id',$user_zone);
		$this->db->where('division_id',$user_division);
		$this->db->where('maintenance_shop_status','10');		
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
}