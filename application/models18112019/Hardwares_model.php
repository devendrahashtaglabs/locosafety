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
	public function getHardware(){
       $this->db->select('*');
		$this->db->from('hardware_basic_tbl');
		$this->db->where('hardware_status', '10');
		$query 	= $this->db->get();
		$result = $query->result(); 
		return $result;  
    }
	/* public function getStatusFilter($status){
        $hardware_stored_proc   = "CALL get_all_hardware_by_status_sp(?);";
        $query                  = $this->db->query($hardware_stored_proc,$hardwareData);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    } */
}