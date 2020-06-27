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
		$loggedinUser	 	= '1';
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
			$this->session->set_flashdata('updateShop', 'Update successful');
			redirect('shops/editShop/'.$id);
		}else{
			$this->session->set_flashdata('errorShop', 'Somthing went worng. Error!!');
			redirect('shops/editShop/'.$id);
		}
	}
	public function deleteShop($data){
		$id 				= $data['id'];
		$currentDate	 	= date('Y-m-d H:i:s');
		$loggedinUser	 	= '1';
		$data = array(
				'shop_status' 		=> '90',
				'shop_update_date' 	=> $currentDate,
				'shop_updated_by' 	=> $loggedinUser
		);
		$this->db->where('shop_id', $id);
		$query = $this->db->update(SHOPTBL, $data);	 
		if($query){
			$this->session->set_flashdata('deleteShop', 'Deleted successfully');
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
			$this->session->set_flashdata('activeShop', 'Activated successfully');
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
	public function getShopBy($data){
		$this->db->select('*');
		$this->db->from(SHOPTBL);
		$this->db->where('shop_id', $data);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result; 
	}
}