<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Users_model extends CI_Model{

    public function insertUser($data){
        $user_id        =  $data['user_id'];
        $user_type      =  $data['user_type'];
        $section_id     =  $data['section_id'];
        $shop_id        =  $data['shop_id'];
        $user_f_name    =  $data['user_f_name'];
        $user_l_name    =  $data['user_l_name'];
        $user_email     =  $data['user_email'];
        $user_phone     =  $data['user_phone'];
        $user_pass      =  $data['user_pass'];
        $user_division  =  $data['user_division']; 
        $user_zone      =  $data['user_zone'];
        $user_country   =  $data['user_country'];
        $user_state     =  $data['user_state'];
        $user_city      =  $data['user_city'];
        $user_zipcode   =  $data['user_zipcode'];
        $user_address   =  $data['user_address'];
        $user_dob       =  $data['user_dob'];
        $user_gender    =  $data['user_gender'];
        $user_profile_pic =  $data['user_profile_pic'];
        $userData = array(
            'user_id'           =>  $user_id,
            'login_type'        =>  $user_type,
            'section_id'        =>  $section_id,
            'shop_id'           =>  $shop_id,
            'user_f_name'       =>  $user_f_name,
            'user_l_name'       =>  $user_l_name,
            'login_email'       =>  $user_email,
            'login_phone'       =>  $user_phone,
            'login_pass'        =>  $user_pass,
            'user_division'     =>  $user_division,
            'user_zone'         =>  $user_zone,
            'user_country'      =>  $user_country,
            'user_state'        =>  $user_state,
            'user_city'         =>  $user_city,
            'user_zipcode'      =>  $user_zipcode,
            'user_address'      =>  $user_address,
            'user_dob'          =>  $user_dob,
            'user_gender'       =>  $user_gender,
            'user_profile_pic'  =>  $user_profile_pic
        );
        $user_stored_proc   = "CALL insert_user_sp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query              = $this->db->query($user_stored_proc,$userData);
        $query->next_result(); 
        $query->free_result();
        if($query){
            $this->session->set_flashdata('success', 'User Added successfully');
            redirect('users');
        }else{
            $this->session->set_flashdata('error', 'Somthing went worng. Error!!');
            redirect('users');
        } 
    }
    public function updateUser($data){
        $user_f_name        = $data['user_f_name'];
        $user_l_name        = $data['user_l_name'];
        $user_country       = $data['user_country'];
        $user_state         = $data['user_state'];
        $user_city          = $data['user_city'];
        $user_zipcode       = $data['user_zipcode'];
        $user_address       = $data['user_address'];
        $user_dob           = $data['user_dob'];
        $user_gender        = $data['user_gender'];
        $user_division      = $data['user_division'];   
        $user_zone          = $data['user_zone'];
        $shop_id            = $data['shop_id'];
        $user_type          = $data['user_type'];
        $section_id         = $data['section_id'];
        $user_id        	= $data['user_id'];
        $updatedData        = array(
                                    'user_id'           => $user_id,
                                    'section_id'       	=> $section_id,
                                    'shop_id'         	=> $shop_id,
                                    'user_f_name'       => $user_f_name,
                                    'user_l_name'       => $user_l_name,
                                    'user_division'     => $user_division,
                                    'user_zone'         => $user_zone,
                                    'user_country'      => $user_country,
                                    'user_state'       	=> $user_state,
                                    'user_city'      	=> $user_city,
                                    'user_zipcode'      => $user_zipcode,
                                    'user_address'      => $user_address,
                                    'user_dob'          => $user_dob,
                                    'user_gender'       => $user_gender
                                );
        $user_stored_proc   = "CALL update_user_details_sp(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query              = $this->db->query($user_stored_proc,$updatedData);
        $query->next_result(); 
        $query->free_result();
        if($query){
            $this->session->set_flashdata('updateUser', 'Updated User successfully');
            redirect('users/editUser/'.$user_id);
        }else{
            $this->session->set_flashdata('errorUser', 'Somthing went worng. Error!!');
            redirect('users/editUser/'.$user_id);
        } 
    }
    public function getUser(){
        $user_stored_proc   = "CALL select_all_user_sp()";
        $query              = $this->db->query($user_stored_proc);
        $result             = $query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $result; 
    }
	public function getFilterUser($status){
		$userdata			= array(
								'status' => $status
								);
        $user_stored_proc   = "CALL select_user_by_status_sp(?)";
        $query              = $this->db->query($user_stored_proc,$userdata);
        $result             = $query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $result; 
    }
    public function getUserBy($data){
        $user_id            = $data['user_id'];
        $user_stored_proc   = "CALL get_profile_sp(?)";
        $getUserBy          = array('id'=> $user_id); 
        $query              = $this->db->query($user_stored_proc, $getUserBy);
        $result             = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getLoginType(){
        $table      = 'master_login_type_tbl';
        $query      = $this->db->get($table);
        $result     = $query->result();
       	//$query->next_result(); 
        //$query->free_result();
        return $result; 
    }
    public function getCountry(){
        $user_stored_proc   = "CALL getCountry()";
        $query              = $this->db->query($user_stored_proc);
        $result             = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getState(){
        $table      = 'master_state_tbl';
        $query      = $this->db->get($table);
        $result     = $query->result();
        //$query->next_result(); 
        //$query->free_result();
        return $result; 
    }
	public function deleteUser($data){
		$userData				= array(
									'user_id' => $data['user_id']
									);
		$user_stored_proc	 	= "CALL delete_user_sp(?);";
        $query 					= $this->db->query($user_stored_proc,$userData);
        $result					= $query->result();
		$query->next_result(); 
		$query->free_result();
		if($query){
			$this->session->set_flashdata('success', 'Deleted User successfully');
			redirect('users');
		}else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('users');
		}  
	}
	public function getUserTypeName($data){
		$userData				= array(
									'login_type' => $data
									);
		$user_stored_proc	 	= "CALL get_user_type_name(?);";
        $query 					= $this->db->query($user_stored_proc,$userData);
        $results				= $query->result();
		if(!empty($results)){
			$result = $results[0];
			$typeName = $result->login_type_name;
		}
		$query->next_result(); 
		$query->free_result(); 
		return $typeName;
	}
}