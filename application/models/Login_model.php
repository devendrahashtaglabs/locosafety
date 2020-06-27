<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login_model extends CI_Model{
	
    public function login($data){
        $admin_user         = $data['admin_user'];
        $admin_pass         = $data['admin_pass'];
        $this->db->select("*");
        $this->db->from("user_info_tbl");
        if($admin_user != ''){
            $this->db->where('user_email', $admin_user);
        }
        if($admin_pass != ''){
            $this->db->where('user_pass ', $admin_pass);
        }
        $q 			 = $this->db->get();
        $adminDetail = $q->row();
		//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
		if(empty($adminDetail)){
			$this->session->set_flashdata('loginError', 'Email and/or password invalid.');
			redirect('login');
		}else{

			//print_r($adminDetail);
			//exit;

            if($adminDetail->user_status == '10'){
				$user_role 	= $adminDetail->user_role;
				if($user_role == '1' || $user_role == '2' || $user_role == '3' ){
					if(!empty($user_role)){
						$this->db->select("*");
						$this->db->from("master_role_tbl");
						$this->db->where('role_id ', $user_role);
						$q 			 	= $this->db->get();
						$loggedInDetail = $q->row();
						$this->session->set_userdata('loggedInAdminDetail', $loggedInDetail);				
					}
					$admin_id 	= $adminDetail->user_info_id;
					$this->session->set_userdata('loggedInAdmin', $admin_id);
				}else{
					redirect('login');
				}				
            }else{
            	$this->session->set_flashdata('loginError', 'That your account is under verification.');
				redirect('login');
            }
            $loggedInAdmin = $this->session->userdata('loggedInAdmin');
			if(!empty($loggedInAdmin)){
				//$this->session->set_flashdata('loginSuccess', 'You have loggedin Successfully !!!');
			}
            return $loggedInAdmin;
        }
    }
}