<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login_model extends CI_Model{
    public function login($data){
        $admin_user         = $data['admin_user'];
        $admin_pass         = $data['admin_pass'];
        $this->db->select("*");
        $this->db->from("admin_tbl");
        if($admin_user != ''){
            $this->db->where('admin_user', $admin_user);
        }
        if($admin_pass != ''){
            $this->db->where('admin_pass ', $admin_pass);
        }
        $q = $this->db->get();
        $adminDetail = $q->result();
		if(empty($adminDetail)){
			$this->session->set_flashdata('loginError', 'Login details not matched !!!');
			redirect('login');
		}
        if(!empty($adminDetail)){
            $adminDetail = $adminDetail[0]; 
            if($adminDetail->admin_status == '1'){
                $admin_id = $adminDetail->admin_id;
                $this->session->set_userdata('loggedInAdmin', $admin_id);
            }
            $loggedInAdmin = $this->session->userdata('loggedInAdmin');
			if(!empty($loggedInAdmin)){
				$this->session->set_flashdata('loginSuccess', 'You have loggedin Successfully !!!');
			}
            return $loggedInAdmin;
        }
    }
	public function loggedInDetail($id){
        $this->db->select("*");
        $this->db->from("admin_tbl");
        $this->db->where('admin_id', $id);
        $q 				= $this->db->get();
        $loggedInDetail = $q->result();	
		return $loggedInDetail; 
	}
}