<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Shops_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		define("SHOPTBL","master_shop_tbl");		
	}
	public function insertShop($data){
		$shop_name 			= $data['shop_name'];
		$zone_id 			= $data['zone_id'];
		$division_id 		= $data['division_id'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser 		= $data['user_role'];
		$postData = array(
				'zone_id' 			=> $zone_id,
				'division_id' 		=> $division_id,
				'shop_name' 		=> $shop_name,
				'shop_status' 		=> '10',
				'shop_add_date' 	=> $currentDate,
				'shop_created_by' 	=> $loggedinUser,
		);
		$insertedId = $this->db->insert(SHOPTBL, $postData);
		if($insertedId){
			$this->session->set_flashdata('shopSuccess', 'Shop Added successful');
			redirect('shops');
		}else{
			$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
			redirect('shops');
		}
	}
	public function updateShop($data){
		$id 				= $data['id'];
		$shop_name 			= $data['shop_name'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'shop_name' 		=> $shop_name,
				'shop_update_date' 	=> $currentDate,
				'shop_updated_by' 	=> $loggedinUser
		);
		$this->db->where('shop_id', $id);
		$query = $this->db->update(SHOPTBL, $data);	 
		if($query){
			$this->session->set_flashdata('shopSuccess', 'Shop Name Updated successfully');
			redirect('shops');
		}else{
			$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
			redirect('shops/editShop/'.$id);
		}
	}
	public function deleteShop($data){
		$id 				= $data['id'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'shop_status' 		=> '80',
				'shop_update_date' 	=> $currentDate,
				'shop_updated_by' 	=> $loggedinUser
		);
		$this->db->where('shop_id', $id);
		$query = $this->db->update(SHOPTBL, $data);	 
		if($query){
			$this->session->set_flashdata('shopSuccess', 'Shop Inactive Successfully');
			redirect('shops');
		}else{
			$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
			redirect('shops');
		}
	}
	public function activateShop($data){
		$id 				= $data['id'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'shop_status' 		=> '10',
				'shop_update_date' 	=> $currentDate,
				'shop_updated_by' 	=> $loggedinUser
		);
		$this->db->where('shop_id', $id);
		$query = $this->db->update(SHOPTBL, $data);	 
		if($query){
			$this->session->set_flashdata('shopSuccess', 'Activated successfully');
			redirect('shops');
		}else{
			$this->session->set_flashdata('shopError', 'Somthing went worng. Error!!');
			redirect('shops');
		}
	}
	public function getShop(){
		$this->db->select('*');
		$this->db->from(SHOPTBL);
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getShopCount($user_zone,$user_division,$type=NULL){
		$this->db->select('*');
		$this->db->from(SHOPTBL);
		$this->db->where('zone_id',$user_zone);
		$this->db->where('division_id',$user_division);
		if($type != 'all'){
			$this->db->where('shop_status','10');
		}
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
	public function getShopBy($data){
		$this->db->select('*');
		$this->db->from(SHOPTBL);
		$this->db->where('shop_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
	public function checkShopExist($shopname,$zone_id,$division_id){
		$this->db->select('shop_id');
		$this->db->from(SHOPTBL);
		$this->db->where('shop_name', $shopname);
		$this->db->where('zone_id', $zone_id);
		$this->db->where('division_id', $division_id);
		$query 	= $this->db->get();
		$result = $query->num_rows();
		return $result; 
	}
	
	public function GetShopUserName($shopID){		
		$this->db->select('*');
		$this->db->from('user_mapping_tbl');
		$this->db->where('shop_id', $shopID);
		$this->db->where('section_id IS NULL');
		$this->db->where('maintenance_shop_id IS NULL');
		$this->db->where('maintenance_section_id IS NULL');
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 		
	}
	public function getShopActive($user_zone,$user_division){
		$this->db->select('*');
		$this->db->from(SHOPTBL);
		$this->db->where('zone_id',$user_zone);
		$this->db->where('division_id',$user_division);
		$this->db->where('shop_status','10');		
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result; 
	}
}