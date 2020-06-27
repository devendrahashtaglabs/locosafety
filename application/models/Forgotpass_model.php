<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Forgotpass_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function add_token($data){
        $this->db->insert('master_token_tbl',$data);
		$insertedId = $this->db->insert_id();
        return $insertedId;
    }
	public function getUserByEmail($email){
		$this->db->select('*');
		$this->db->from('user_info_tbl');
		$this->db->where('user_email',$email);
		$query 	= $this->db->get();
		$result = $query->row();
		return $result;
	}
	public function update_token($token) {
        $data = array(
                'status' => 1
                );
        $this->db->where('token', $token);
        $results = $this->db->update('master_token_tbl', $data);
        return $results;
    }
	public function get_token($token)
    {
        $result = $this->db->get_where('master_token_tbl', array('token' => $token))->row();
        return $result;
    }
	public function update_admin_password($data, $email) {
       
        $this->db->where('user_email', $email);
        $results = $this->db->update('user_info_tbl', $data);
        return $results;
    }
}