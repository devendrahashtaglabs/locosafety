<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserClass
 *
 * @author HashTagLabs
 */
include_once 'class_db.php';
include_once 'class_common.php';

class class_user {

    //put your code here
    public $user_id;
    public $user_type;
    public $school_id;
    public $user_f_name;
    public $user_l_name;
    public $user_email;
    public $user_phone;
    public $user_country;
    public $user_state;
    public $user_city;
    public $user_zipcode;
    public $user_address;
    public $user_dob;
    public $user_gender;
    public $user_pass;
    public $user_update_date;
    public $user_device;
    public $phone_valid;
    public $user_parent;
    public $user_child_num;
    public $user_child_detail;
    public $user_id_file;
    public $org_name;
    public $org_501C3, $org_email, $org_phone, $org_website, $org_mission, $org_cause, $org_profile, $org_country, $org_state, $org_city, $org_zipcode, $org_address, $org_taxid, $user_file_title;
    public $org_nonprofit, $org_service, $org_target, $org_volunteer_req, $org_min_time, $org_volunteer_num, $org_volunteer_police, $org_easy_access, $org_longitude, $org_latitude;
    public $school_desc, $school_student_num;
    public $ObjDB;
    public $R_SET;

    /*Preeti - 14-11-2019*/
    public $section_id;
    public $shop_id;
    public $division_id;
    public $zone_id;
    public $ticket_no;
    public $hardware_map_section_id;
    public $maintenance_shop_id;
    public $maintenance_section_id;
    public $case_type;
    public $case_remarks;
    public $tickets_created_date;
    public $tickets_updated_date;
    public $tickets_created_by;
    public $hardware_id;
    public $ticket_type;
    public $date;
    public $new_date;
    public $user_mobile;
    public $user_pin;
    public $user_role;
    
    function __construct() {
        $this->ObjDB = new class_db();
    }

    public function ReturnResultSet() {
        return $this->R_SET;
    }

    public function UserProfilePic() {
        $RES = "OK";
        $S = "UPDATE login_tbl SET login_profile_pic = '" . $this->user_profile_pic . "' WHERE login_id = '" . $this->user_id . "'";
        $this->ObjDB->sproc_name = $S;
        $r = $this->ObjDB->ExecuteQuery();
        return $RES;
    }

    public function UserCoverPic() {
        $RES = "OK";
        $S = "UPDATE login_tbl SET login_cover_pic = '" . $this->user_cover_pic . "' WHERE login_id = '" . $this->user_id . "'";
        $this->ObjDB->sproc_name = $S;
        $r = $this->ObjDB->ExecuteQuery();
        return $RES;
    }

    public function Login() {
        $RES = "NOTVALID";
        $arrParam = array();
        $arrParam["in_user_phone"] = $this->user_phone;
        $arrParam["in_user_pin"] = $this->user_pin;
        // $arrParam["in_user_login_current"] = date("Y-m-d H:i:s");
        $arrParam["in_user_device"] = $this->user_device;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "user_login_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "VALID";
        }
        return $RES;
    }

    private function logLogin($R) {
        $row = mysqli_fetch_array($R);
        mysqli_data_seek($R, 0);
        $arrParam = array();
        $arrParam["in_user_id"] = $row["user_id"];
        $arrParam["in_user_type"] = $row["user_type"];
        $arrParam["in_action_type"] = "LOGIN";
        $arrParam["in_action_panel"] = "LOGIN";
        $arrParam["in_action_details"] = "";
        $arrParam["in_action_date"] = date("Y-m-d H:i:s");
        $arrParam["in_action_device"] = $this->user_device;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "insert_log_login_sp";
        $RES = $this->ObjDB->ExecuteSP();
    }

    public function AddToken() {
        $arrParam = array();
        $arrParam["in_action_type"] = 'insert';
        $arrParam["in_user_email"] = $this->user_email;
        $arrParam["in_created_at"] = date("Y-m-d H:i:s");
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "crud_token_sp";
        $R = $this->ObjDB->SelectSP();
        list($token_value) = mysqli_fetch_row($R);
        return $token_value;
    }

    public function GetUserID() {
        return $this->user_id;
    }

    public function GetUserOTP() {
        return $this->phone_valid;
    }

    public function OTPValid() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_phone_valid"] = $this->phone_valid;
        $arrParam["in_user_type"] = $this->user_type;

        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "valid_otp_sp";
        $RES = $this->ObjDB->ExecuteSP();
        if ($RES == "OK") {
            $action = "user_id:" . $this->user_id . ",user_type:" . $this->user_type . ",phone_valid:" . $this->phone_valid;
            class_common::LogInsert($this->user_id, $this->user_type, "OTP" . $this->user_type, $action, $this->user_device);
        }
        return $RES;
    }

    public function ForgotPass() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_email"] = $this->user_email;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "valid_email_id_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

    public function ForgotPassNew() {
        $RES = "INVALIDEMAIL";
        $arrParam = array();
        $arrParam["in_user_email"] = $this->user_email;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "valid_email_forgot_sp";
        $R = $this->ObjDB->SelectSP();

        if ($R != null && !empty($R) && !is_bool($R)) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }

   
    public function ResendOTP() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_user_device"] = $this->user_device;
        $arrParam["in_user_type"] = $this->user_type;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "resend_otp_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

    public function ChangePhone() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_user_phone"] = $this->user_phone;
        $arrParam["in_user_device"] = $this->user_device;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "change_mobile_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

    public function ChangePass() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_user_pass_old"] = md5($this->user_pass_old);
        $arrParam["in_user_pass"] = md5($this->user_pass_new);
        $arrParam["in_user_device"] = $this->user_device;
        $arrParam["in_user_type"] = $this->user_type;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "change_pass_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

    public function ForgotPassNewMob() {
        $RES = "INVALIDEMAIL";
        $arrParam = array();
        $arrParam["in_user_email"] = $this->user_email;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "valid_email_forgot_sp";
        $R = $this->ObjDB->SelectSP();

        if ($R != null && !empty($R) && !is_bool($R)) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }

    /*public function ActivateAccount() {
        $RES = "";
        $arrParam["in_user_phone"] = $this->user_phone;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "activate_account_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }*/

    /*public function GetProfile() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "get_profile_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/

    /*public function GetHardwareList() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_section_id"] = $this->section_id;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "get_hardware_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/

    /*public function RaiseTickets() {
        $RES = "";
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_shop_id"] = $this->shop_id;
        $arrParam["in_section_id"] = $this->section_id;
        $arrParam["in_hardware_id"] = $this->hardware_id;
        $arrParam["in_hardware_status"] = $this->hardware_status;
        $arrParam["in_remarks"] = $this->ticket_remark;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "raise_tickets_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }*/

    /*public function GetTicketDetails() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_section_id"] = $this->section_id;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "get_raise_tickets_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/

    /*public function HardwareMaintenance() {
        $RES = "";
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_hardware_id"] = $this->hardware_id;
        $arrParam["in_hardware_status"] = $this->hardware_status;
        $arrParam["in_service_date"] = $this->service_date;
        $arrParam["in_service_date_next"] = $this->service_date_next;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "maintain_hardware_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }*/

    /*public function DueCount() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_section_id"] = $this->section_id;
        $arrParam["in_date"] = $this->date;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "due_count_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/

    /*public function TestingCount() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_section_id"] = $this->section_id;
        $arrParam["in_date"] = $this->date;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "testing_count_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/

    /*public function UpcomingCount() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_section_id"] = $this->section_id;
        $arrParam["in_date"] = $this->date;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "upcoming_count_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/

    /*public function Active_Count() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_section_id"] = $this->section_id;
        $arrParam["in_date"] = $this->date;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "active_count_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }*/
    /*
    public function ForgotPIN() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_phone"] = $this->user_phone;
        $arrParam["in_user_pin"] = md5($this->user_pin);
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "forgot_pin_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }*/
    
//    Preeti -14-11-2019----------
    public function GetHardwareList(){
        $ObjDB = new class_db();
        $S = "SELECT master_shop_tbl.shop_name as shop_name, "
                . "master_section_tbl.section_name as section_name, "
                . "hardware_schedule_config_tbl.*, "
                . "master_hardware_category_tbl.category_name as hardware_category_name, "
                . "hardware_basic_tbl.*, "
                . "hardware_mapping_section_tbl.*,"
                . "master_hardware_type_tbl.* "
                . "FROM hardware_mapping_section_tbl "
                . "LEFT JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "LEFT JOIN master_section_tbl ON hardware_mapping_section_tbl.section_id = master_section_tbl.section_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_hardware_type_tbl ON master_hardware_type_tbl.hardware_type_id = hardware_basic_tbl.hardware_type "
                . "LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = hardware_basic_tbl.hardware_category "
                . "LEFT JOIN hardware_schedule_config_tbl ON hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_mapping_section_tbl.shop_id = '".$this->shop_id."'"
                . "AND hardware_basic_tbl.hardware_status = 10 ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    
    public function raiseTickets(){
        $ObjDB = new class_db();
        $S = "INSERT INTO `tickets_tbl`(`zone_id`, `division_id`, `ticket_no`, `shop_id`, `section_id`, `hardware_map_section_id`, `maintenance_shop_id`, `maintenance_section_id`,`ticket_status`, `case_type`, `case_remarks`, `tickets_created_date`,`tickets_created_by`) "
                . "VALUES ('".$this->zone_id."','".$this->division_id."','".$this->ticket_no."','".$this->shop_id."','".$this->section_id."','".$this->hardware_map_section_id."','".$this->maintenance_shop_id."','".$this->maintenance_section_id."',20,'".$this->case_type."','".$this->case_remarks."','".$this->tickets_created_date."','".$this->tickets_created_by."')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }
    //--15-11-2019--------------
    public function updateHardwareBasicTbl(){
        $ObjDB = new class_db();
        $S = "UPDATE hardware_basic_tbl SET hardware_status = '60' WHERE hardware_id = '".$this->hardware_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }

    public function ticketLog(){
        $ObjDB = new class_db();
        $sql = "SELECT * FROM tickets_log_tbl WHERE ticket_no = '".$this->ticket_no."'";
        $ObjDB->sproc_name = $sql;
        $res = $ObjDB->SelectQuery();
        if($row = mysqli_fetch_array($res) > 0){
            $S = "UPDATE `tickets_log_tbl` SET `ticket_status`= 20,`assigned_shop_id`= '". $this->maintenance_shop_id."',`assigned_section_id`='". $this->maintenance_section_id."',`log_updated_by`='". $this->tickets_created_by."',`log_update_date`= '".$this->tickets_created_date."' WHERE ticket_no = '".$this->ticket_no."'";
        }else{
            $S = "INSERT INTO `tickets_log_tbl`(`ticket_no`, `ticket_status`, `assigned_shop_id`, `assigned_section_id`,`log_updated_by`, `log_update_date`) VALUES ('".$this->ticket_no."',20,'". $this->maintenance_shop_id."','". $this->maintenance_section_id."','". $this->tickets_created_by."','".$this->tickets_created_date."')";
        }
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }
    
    public function raisedTicketList(){
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name,master_hardware_type_tbl.hardware_type_name,hardware_basic_tbl.*,user_details_tbl.user_f_name,user_details_tbl.user_l_name,master_section_tbl.section_name,master_shop_tbl.shop_name,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,tickets_tbl.* 
                FROM `tickets_tbl` 
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id 
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id 
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id 
                LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id 
                LEFT JOIN user_info_tbl ON user_info_tbl.user_info_id = tickets_tbl.tickets_created_by 
                LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id 
                LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id 

                LEFT JOIN hardware_basic_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id 
                LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category = master_hardware_category_tbl.id
                LEFT JOIN master_hardware_type_tbl ON hardware_basic_tbl.hardware_type = master_hardware_type_tbl.hardware_type_id 
                WHERE tickets_tbl.section_id = '".$this->section_id."' 
                ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    
    public function getUserDetail(){
        $ObjDB = new class_db();
        $S = "SELECT user_details_tbl.*,master_role_tbl.role_name,master_division_tbl.division_name,master_zone_tbl.zone_name,user_info_tbl.* "
                . "FROM `user_info_tbl` "
                . "LEFT JOIN master_zone_tbl ON master_zone_tbl.zone_id = user_info_tbl.user_zone "
                . "LEFT JOIN master_division_tbl ON master_division_tbl.division_id=user_info_tbl.user_division "
                . "LEFT JOIN master_role_tbl ON master_role_tbl.role_id = user_info_tbl.user_role "
                . "LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id "
                . "WHERE user_info_tbl.user_info_id = '".$this->user_info_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    //Preeti - 18-11-2019
    public function dueScheduleCount() {
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as dueCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function underTestingCount(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as testingCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 60";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function activeCount(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as activeCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date >= '".$this->date."' "
                . "AND hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function upcomingCount(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as upcomingCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_basic_tbl.hardware_status = 10 "
                . "AND hardware_schedule_config_tbl.next_schedule_date >= '".$this->date."' AND hardware_schedule_config_tbl.next_schedule_date < '".$this->new_date."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function raiseTicketCount(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as ticketCount FROM `tickets_tbl` "
                . "WHERE tickets_tbl.section_id = '".$this->section_id."' "
                . "AND tickets_tbl.ticket_status = 20";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function checkSectionExist(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM master_section_tbl where master_section_tbl.section_id = '".$this->section_id."' AND master_section_tbl.section_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function checkShopExist(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM master_shop_tbl where master_shop_tbl.shop_id = '".$this->shop_id."' AND master_shop_tbl.shop_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function checkMobileExist(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM user_info_tbl where user_info_tbl.user_mobile = '".$this->user_mobile."' AND user_info_tbl.user_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function updatePIN(){
        $ObjDB = new class_db();
        $S = "UPDATE user_info_tbl SET user_pin = '".$this->user_pin."' WHERE user_mobile = '".$this->user_mobile."' AND user_info_tbl.user_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }
    
    public function getHardwareDetail(){
        $ObjDB = new class_db();
        $S = "SELECT hardware_schedule_config_tbl.next_schedule_date,master_status_tbl.status ,master_section_tbl.section_name,master_shop_tbl.shop_name,hardware_mapping_section_tbl.* ,master_hardware_category_tbl.category_name as hardware_category, master_hardware_type_tbl.hardware_type_name as hardware_type ,hardware_basic_tbl.*
                FROM hardware_basic_tbl 
                LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = hardware_basic_tbl.hardware_id
                LEFT JOIN master_hardware_type_tbl ON master_hardware_type_tbl.hardware_type_id =  hardware_basic_tbl.hardware_id
                LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = hardware_mapping_section_tbl.shop_id
                LEFT JOIN master_section_tbl ON master_section_tbl.section_id = hardware_mapping_section_tbl.section_id
                LEFT JOIN master_status_tbl ON master_status_tbl.status_code = hardware_basic_tbl.hardware_status
                LEFT JOIN hardware_schedule_config_tbl ON hardware_schedule_config_tbl.map_id = hardware_mapping_section_tbl.map_id
                WHERE hardware_basic_tbl.hardware_id = '".$this->hardware_id."' ORDER BY hardware_basic_tbl.hardware_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function checkUserExist(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM user_info_tbl where user_info_tbl.user_info_id = '".$this->user_info_id."' AND user_info_tbl.user_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function forceFullLogout(){
        $ObjDB = new class_db();
        $S = "UPDATE user_info_tbl SET user_status = '80' WHERE user_info_id = '".$this->user_info_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }
    public function getShopList(){
        $ObjDB = new class_db();
        $S = "SELECT master_shop_tbl.*,user_info_tbl.* FROM `user_info_tbl` "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.zone_id = user_info_tbl.user_zone "
                . "AND master_shop_tbl.division_id = user_info_tbl.user_division "
                . "WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' "
                . "AND user_info_tbl.user_role = 3 "
                . "AND master_shop_tbl.shop_status = 10 "
                . "ORDER BY master_shop_tbl.shop_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getSectionList(){
        $ObjDB = new class_db();
        $S = "SELECT master_section_tbl.*,master_shop_tbl.*,user_info_tbl.* "
                . "FROM `user_info_tbl` "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.zone_id = user_info_tbl.user_zone "
                . "AND master_shop_tbl.division_id = user_info_tbl.user_division "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' "
                . "AND user_info_tbl.user_role = 3 "
                . "AND master_shop_tbl.shop_status = 10 "
                . "AND master_section_tbl.section_status = 10 "
                . "ORDER BY master_section_tbl.section_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getMaintenanceShopList(){
        $ObjDB = new class_db();
        $S = "SELECT master_maintenance_shop_tbl.*,user_info_tbl.* "
                . "FROM `user_info_tbl` "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.zone_id = user_info_tbl.user_zone "
                . "AND master_maintenance_shop_tbl.division_id = user_info_tbl.user_division "
                . "WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' "
                . "AND user_info_tbl.user_role = 3 "
                . "AND master_maintenance_shop_tbl.maintenance_shop_status = 10 ORDER BY master_maintenance_shop_tbl.`maintenance_shop_name` ASC ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getMaintenanceSectionList(){
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.*,master_maintenance_section_tbl.*,master_maintenance_shop_tbl.*,user_info_tbl.* 
                FROM `user_info_tbl` 
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.zone_id = user_info_tbl.user_zone AND master_maintenance_shop_tbl.division_id = user_info_tbl.user_division 
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_shop_id = master_maintenance_shop_tbl.maintenance_shop_id
                LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = master_maintenance_section_tbl.default_hardware_cat
                WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' 
                AND user_info_tbl.user_role = 3 
                AND master_maintenance_section_tbl.maintenance_section_status = 10 
                ORDER BY master_maintenance_section_tbl.maintenance_section_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getShopSectionList(){
        $ObjDB = new class_db();
        $S = "SELECT master_section_tbl.*,master_shop_tbl.*,user_info_tbl.* FROM `user_info_tbl` 
                LEFT JOIN master_shop_tbl ON master_shop_tbl.zone_id = user_info_tbl.user_zone AND master_shop_tbl.division_id = user_info_tbl.user_division 
                LEFT JOIN master_section_tbl ON master_section_tbl.shop_id = master_shop_tbl.shop_id
                WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' 
                AND user_info_tbl.user_role = 3 
                AND master_shop_tbl.shop_status = 10 
                ORDER BY master_shop_tbl.shop_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketListManager(){
        $ObjDB = new class_db();
        $S = "SELECT tickets_tbl.*,master_shop_tbl.shop_name,master_section_tbl.section_name,
                master_section_tbl.section_code,master_maintenance_shop_tbl.maintenance_shop_name, 
                master_maintenance_section_tbl.maintenance_section_name, master_status_tbl.status
                FROM tickets_tbl
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id
                LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id
                LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status
                LEFT JOIN user_info_tbl ON user_info_tbl.user_zone = tickets_tbl.zone_id AND user_info_tbl.user_division = tickets_tbl.division_id
                LEFT JOIN master_role_tbl ON master_role_tbl.role_id = user_info_tbl.user_role
                WHERE user_info_tbl.user_info_id = '".$this->user_info_id."'
                AND (user_info_tbl.user_role = '3' OR user_info_tbl.user_role = '2')
                ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function shopTicket(){
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.shop_id = '".$this->shop_id."'
            ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    //-20-11-2019
    public function ticketListShop() {
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,"
                . "master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,"
                . "master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.shop_id IN (SELECT user_mapping_tbl.shop_id FROM user_mapping_tbl WHERE user_mapping_tbl.user_info_id = '".$this->user_info_id."') ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketListSection(){
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,"
                . "master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,"
                . "master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.section_id IN (SELECT user_mapping_tbl.section_id FROM user_mapping_tbl WHERE user_mapping_tbl.user_info_id = '".$this->user_info_id."') ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketListMaintenanceShop(){
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,"
                . "master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,"
                . "master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.maintenance_shop_id  IN "
                . "(SELECT user_mapping_tbl.maintenance_shop_id  FROM user_mapping_tbl WHERE user_mapping_tbl.user_info_id = '".$this->user_info_id."') "
                . "ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketListMaintenanceSection(){
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,"
                . "master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,"
                . "master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.maintenance_section_id  IN (SELECT user_mapping_tbl.maintenance_section_id  FROM user_mapping_tbl WHERE user_mapping_tbl.user_info_id = '".$this->user_info_id."') ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketListDivAdmin(){
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,"
                . "master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,"
                . "master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.maintenance_section_id  IN (SELECT user_mapping_tbl.maintenance_section_id  FROM user_mapping_tbl WHERE user_mapping_tbl.user_info_id = '".$this->user_info_id."') ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getShopListInch(){
        $ObjDB = new class_db();
        $S = "SELECT master_section_tbl.*,master_shop_tbl.*,user_info_tbl.* "
                . "FROM `user_info_tbl` "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.zone_id = user_info_tbl.user_zone AND master_shop_tbl.division_id = user_info_tbl.user_division "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' "
                . "AND user_info_tbl.user_role = '4' "
                . "AND master_shop_tbl.shop_status = 10 "
                . "AND master_section_tbl.section_status = 10 "
                . "ORDER BY master_shop_tbl.shop_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function dueCountShop(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as dueCount "
                . "FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date >= '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function overdueCountShop(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as overdueCount "
                . "FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getSectionListInch(){
        $ObjDB = new class_db();
        $S = "SELECT master_section_tbl.*,master_shop_tbl.*,user_mapping_tbl.* FROM `user_mapping_tbl` "
                . "LEFT JOIN master_shop_tbl ON user_mapping_tbl.shop_id = master_shop_tbl.shop_id "
                . "LEFT JOIN master_section_tbl ON user_mapping_tbl.section_id = master_section_tbl.section_id "
                . "WHERE user_mapping_tbl.user_info_id = 6";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;        
    }
    public function dueCountSection() {
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as dueCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date >= '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function overdueCountSection() {
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as dueCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getMaintShopListInch(){
        $ObjDB = new class_db();
        $S = "SELECT master_maintenance_section_tbl.*,master_maintenance_shop_tbl.*,user_info_tbl.* 
                FROM `user_info_tbl` 
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.zone_id = user_info_tbl.user_zone 
                AND master_maintenance_shop_tbl.division_id = user_info_tbl.user_division 
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_shop_id = master_maintenance_shop_tbl.maintenance_shop_id 
                WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' 
                AND user_info_tbl.user_role = '6' OR  user_info_tbl.user_role = '7'
                AND master_maintenance_shop_tbl.maintenance_shop_status = 10 
                AND master_maintenance_section_tbl.maintenance_section_status = 10 
                ORDER BY master_maintenance_shop_tbl.maintenance_shop_name ASC ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketListMainSection(){
        $ObjDB = new class_db();
        $S = "SELECT master_status_tbl.status,master_maintenance_section_tbl.maintenance_section_name,"
                . "master_maintenance_shop_tbl.maintenance_shop_name ,master_shop_tbl.shop_name,"
                . "master_section_tbl.section_name,tickets_tbl.* "
                . "FROM tickets_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id "
                . "LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id "
                . "LEFT JOIN master_status_tbl ON master_status_tbl.status_code = tickets_tbl.ticket_status "
                . "LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id "
                . "WHERE tickets_tbl.maintenance_section_id  = '".$this->maintenance_section_id."' "
                . "ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketStatusCountMainSection(){
        $ObjDB = new class_db();
        $S = "SELECT "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '20' THEN 1 ELSE 0 END),0) AS 'open', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '30' THEN 1 ELSE 0 END),0) AS 'assign', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '40' THEN 1 ELSE 0 END),0) AS 'OnHold', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close' "
                . "FROM tickets_tbl WHERE tickets_tbl.maintenance_section_id = '".$this->maintenance_section_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;  
    }
    public function dueScheduleCountShop() {
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as dueCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function underTestingCountShop(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as testingCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 60";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function activeCountShop(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as activeCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_schedule_config_tbl.next_schedule_date >= '".$this->date."' "
                . "AND hardware_basic_tbl.hardware_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function upcomingCountShop(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as upcomingCount FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "WHERE hardware_mapping_section_tbl.shop_id = '".$this->shop_id."' "
                . "AND hardware_basic_tbl.hardware_status = 10 "
                . "AND hardware_schedule_config_tbl.next_schedule_date BETWEEN '".$this->date."' AND '".$this->new_date."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function raiseTicketCountShop(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as ticketCount FROM `tickets_tbl` "
                . "WHERE tickets_tbl.shop_id = '".$this->shop_id."' "
                . "AND tickets_tbl.ticket_status = 20";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    //Preeti - 21-11-2019
    public function checkLogin(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM user_info_tbl WHERE user_mobile = '".$this->user_mobile."' AND user_status = '80' OR user_status = '0'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function activateAccount(){
        $ObjDB = new class_db();
        $S = "UPDATE user_info_tbl SET user_status = '10' WHERE user_mobile = '".$this->user_mobile."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }
}