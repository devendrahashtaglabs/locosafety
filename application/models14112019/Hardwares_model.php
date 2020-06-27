<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Hardwares_model extends CI_Model{
    public function insertHardware($data){
        $user_id                = $data['user_id'];
        $shop_id                = $data['shop_id'];
        $section_id             = $data['section_id'];
        $hardware_category      = $data['hardware_category'];
        $hardware_type          = $data['hardware_type'];
        $hardware_number        = $data['hardware_number'];
        $hardware_name          = $data['hardware_name'];
        $hardware_company       = $data['hardware_company'];
        $hardware_model         = $data['hardware_model'];
        $hardware_dimensions    = $data['hardware_dimensions'];
        $hardware_description   = $data['hardware_description'];
        $hardware_mfg_date      = $data['hardware_mfg_date'];   
        $hardware_exp_date      = $data['hardware_exp_date'];    
        $hardware_image         = $data['hardware_image'];
        $service_frequency_count = $data['service_frequency_count'];
        $service_frequency_cycle = $data['service_frequency_cycle'];
        $service_date           = $data['service_date'];
        $service_date_next      = $data['service_date_next'];
        $inserteddata           = array(
                                    'user_id'               => $user_id,
                                    'shop_id'               => $shop_id,
                                    'section_id'            => $section_id,
                                    'hardware_category'     => $hardware_category,
                                    'hardware_type'         => $hardware_type,
                                    'hardware_number'       => $hardware_number,
                                    'hardware_name'         => $hardware_name,
                                    'hardware_company'      => $hardware_company,
                                    'hardware_model'        => $hardware_model,
                                    'hardware_dimensions'   => $hardware_dimensions,
                                    'hardware_description'  => $hardware_description,
                                    'hardware_mfg_date'     => $hardware_mfg_date,
                                    'hardware_exp_date'     => $hardware_exp_date,
                                    'hardware_image'        => $hardware_image,
                                    'service_frequency_count'   => $service_frequency_count,
                                    'service_frequency_cycle'   => $service_frequency_cycle,
                                    'service_date'          => $service_date,
                                    'service_date_next'     => $service_date_next,
                                );
        $hardware_stored_proc   = "CALL insert_hardware_sp('$user_id','$shop_id','$section_id','$hardware_category','$hardware_type','$hardware_number','$hardware_name','$hardware_company','$hardware_model','$hardware_dimensions','$hardware_description','$hardware_mfg_date','$hardware_exp_date','$hardware_image','$service_frequency_count','$service_frequency_cycle','$service_date','$service_date_next');";
        $query                  = $this->db->query($hardware_stored_proc,$inserteddata);
        $query->next_result(); 
        $query->free_result();  
        if($query){
            $this->session->set_flashdata('hardwareSuccess', 'Hardware Added successful');
            redirect('hardwares');
        }else{
            $this->session->set_flashdata('hardwareError', 'Somthing went worng. Error!!');
            redirect('hardwares');
        }
    }
    public function updateHardware($data){
        $section_id                 = $data['section_id'];
        $hardware_category          = $data['hardware_category'];
        $hardware_type              = $data['hardware_type'];
        $hardware_number            = $data['hardware_number'];
        $hardware_name              = $data['hardware_name'];
        $hardware_company           = $data['hardware_company'];
        $hardware_model             = $data['hardware_model'];
        $hardware_dimensions        = $data['hardware_dimensions'];
        $hardware_description       = $data['hardware_description'];
        $hardware_mfg_date          = $data['hardware_mfg_date'];   
        $hardware_exp_date          = $data['hardware_exp_date'];
        $hardware_image             = $data['hardware_image'];
        $id                         = $data['id'];
        $service_frequency_count    = $data['service_frequency_count'];
        $service_frequency_cycle    = $data['service_frequency_cycle'];
        $service_date               = $data['service_date'];
        $service_date_next          = $data['service_date_next'];
        $updatedData                = array(
                                        'section_id'                => $section_id,
                                        'hardware_category'         => $hardware_category,
                                        'hardware_type'             => $hardware_type,
                                        'hardware_number'           => $hardware_number,
                                        'hardware_name'             => $hardware_name,
                                        'hardware_company'          => $hardware_company,
                                        'hardware_model'            => $hardware_model,
                                        'hardware_dimensions'       => $hardware_dimensions,
                                        'hardware_description'      => $hardware_description,
                                        'hardware_mfg_date'         => $hardware_mfg_date,
                                        'hardware_exp_date'         => $hardware_exp_date,
                                        'hardware_image'            => $hardware_image,
                                        'id'                        => $id,
                                        'service_frequency_count'   => $service_frequency_count,
                                        'service_frequency_cycle'   => $service_frequency_cycle,
                                        'service_date'              => $service_date,
                                        'service_date_next'         => $service_date_next,
                                    );
		//echo "<pre>";print_r($updatedData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
        $hardware_stored_proc   = "CALL update_hardware_sp('$section_id','$hardware_category','$hardware_type','$hardware_number','$hardware_name','$hardware_company','$hardware_model','$hardware_dimensions','$hardware_description','$hardware_mfg_date','$hardware_exp_date','$hardware_image','$id','$service_frequency_count','$service_frequency_cycle','$service_date','$service_date_next');";
        $query                  = $this->db->query($hardware_stored_proc,$updatedData);
        $query->next_result(); 
        $query->free_result();
        if($query){
            $this->session->set_flashdata('updatedHardware', 'Updated hardware successfully');
            redirect('hardwares/editHardware/'.$id);
        }else{
            $this->session->set_flashdata('errorHardware', 'Somthing went worng. Error!!');
            redirect('hardwares/editHardware/'.$id);
        } 
    }
	public function getHardware(){
        $hardware_stored_proc   = "CALL select_all_hardware_sp();";
        $query                  = $this->db->query($hardware_stored_proc);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
	public function getStatusFilter($status){
		$hardwareData			= array(
									'service_status' => $status,
								);
        $hardware_stored_proc   = "CALL get_all_hardware_by_status_sp(?);";
        $query                  = $this->db->query($hardware_stored_proc,$hardwareData);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
	public function getHMCount(){
        $hardware_stored_proc   = "CALL get_all_hardware_sp();";
        $query                  = $this->db->query($hardware_stored_proc);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
	public function getMaintenanceLog($id){
		$data 					= array(
									 'id' => $id,
									);
        $hardware_stored_proc   = "CALL get_maintenace_log_sp(?);";
        $query                  = $this->db->query($hardware_stored_proc,$data);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function getHardwareBy($id){
        $hardware_stored_proc   = "CALL select_hardware_sp('$id');";
        $query                  = $this->db->query($hardware_stored_proc);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result(); 
        return $result; 
    }
    public function deleteHardware($data){
        $id                     = $data['id'];
        $hardware_stored_proc   = "CALL delete_hardware_sp('$id');";
        $query                  = $this->db->query($hardware_stored_proc);
        $result                 = $query->result();
        $query->next_result(); 
        $query->free_result();
        if($query){
            $this->session->set_flashdata('deletedHardware', 'Deleted hardware successfully');
            redirect('hardwares');
        }else{
            $this->session->set_flashdata('errorHardware', 'Somthing went worng. Error!!');
            redirect('hardwares');
        }  
    }
}