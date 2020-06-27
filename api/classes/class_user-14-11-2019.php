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

    public function ActivateAccount() {
        $RES = "";
        $arrParam["in_user_phone"] = $this->user_phone;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "activate_account_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

    public function GetProfile() {
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
    }

    public function GetHardwareList() {
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
    }

    public function RaiseTickets() {
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
    }

    public function GetTicketDetails() {
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
    }

    public function HardwareMaintenance() {
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
    }

    public function DueCount() {
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
    }

    public function TestingCount() {
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
    }

    public function UpcomingCount() {
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
    }

    public function ActiveCount() {
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
    }

     public function ForgotPIN() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_phone"] = $this->user_phone;
        $arrParam["in_user_pin"] = md5($this->user_pin);
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "forgot_pin_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }
    
}
