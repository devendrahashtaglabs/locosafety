<?php

header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_user.php';
include_once 'classes/class_common.php';
require '../PHPMailer-master/class.phpmailer.php';
require '../PHPMailer-master/class.smtp.php';
require '../PHPMailer-master/PHPMailerAutoload.php';

$RES = "";
$siteurl = class_api::get_site_url() . 'user/resetpassword'; // 'https://ztp.hashtaglabs.in/user/resetpassword';
$loginurl = class_api::get_site_url() . 'user/login';
$siteurl_upload = class_api::get_site_url() . 'uploads/'; //'https://ztp.hashtaglabs.in/uploads/';
//$siteurl = 'http://localhost/ztp_nw/user/resetpassword';
$arr = array();
$api_key = empty($_REQUEST["api_key"]) ? "501" : $_REQUEST["api_key"];
$api_key = ($api_key == class_api::req_api_key()) ? "VALID" : "501";
$action = empty($_REQUEST["action"]) ? "400" : $_REQUEST["action"];
if ($api_key == "501") {
    $arr["res_status"] = "501";
} elseif ($action == "400") {
    $arr["res_status"] = "400";
} else {
    $arr["api_res_key"] = class_api::res_api();
    $JSONDATA = file_get_contents('php://input');
    $JSON = json_decode($JSONDATA);
    switch ($action) {
//Preeti - 14-11-2019
        case "hardwareList":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $OTh->shop_id = $JSON->shop_id;
            $R = $OTh->GetHardwareList();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['section_id'] = $row['section_id'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['shop_name'] = $row['shop_name'];
                    $aR['hardware_category_name'] = $row['hardware_category_name'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_code'] = $row['hardware_code'];
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['hardware_company'] = $row['hardware_company'];
                    $aR['schedule_frequency_count'] = $row['schedule_frequency_count'];
                    $aR['schedule_frequency_cycle'] = $row['schedule_frequency_cycle'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['hardware_type_code'] = $row['hardware_type_code'];
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['schedule_id'] = $row['schedule_id'];
                    $aR['schedule_status'] = $row['schedule_status'];
                    $aR['map_id'] = $row['map_id'];
                    $aR['schedule_start_date'] = $row['schedule_start_date'];
                                       
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }    
            break;
        case "raiseTicket":
            $OTh = new class_user();
            $OTh->ticket_type = $JSON->ticket_type;
            $OTh->zone_id = $JSON->zone_id;
            $OTh->division_id = $JSON->division_id;
            $OTh->shop_id = $JSON->shop_id;
            $OTh->section_id = $JSON->section_id;
            $OTh->hardware_id = $JSON->hardware_id;
            $OTh->hardware_map_section_id = $JSON->hardware_map_section_id;
            $OTh->maintenance_shop_id = $JSON->maintenance_shop_id;
            $OTh->maintenance_section_id = $JSON->maintenance_section_id;
            $OTh->case_type = $JSON->case_type;
            $OTh->case_remarks = $JSON->case_remarks;
            $OTh->tickets_created_date = date('Y-m-d');
            $OTh->tickets_created_by = $JSON->tickets_created_by;
            $division = class_common::getDivisionById($JSON->division_id);
            $zone = class_common::getZoneById($JSON->zone_id);
            $OTh->ticket_no = class_common::generateTicket(6,$zone,$division);
            $R = $OTh->raiseTickets();
            if ($R) {
                $H = $OTh->updateHardwareBasicTbl();
                $T = $OTh->ticketLog();
                $arr["res_status"] = "200";
                
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "raisedTicketList":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $R = $OTh->raisedTicketList();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['user_f_name'] = $row['user_f_name'];
                    $aR['user_l_name'] = $row['user_l_name'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_name'] = $row['shop_name'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['ticket_id'] = $row['ticket_id'];
                    $aR['zone_id'] = $row['zone_id'];
                    $aR['division_id'] = $row['division_id'];
                    $aR['ticket_no'] = $row['ticket_no'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['hardware_map_section_id'] = $row['hardware_map_section_id'];
                    $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                    $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                    $aR['ticket_status'] = $row['ticket_status'];
                    $aR['case_type'] = $row['case_type'];
                    $aR['case_remarks'] = $row['case_remarks'];
                    $aR['tickets_created_date'] = $row['tickets_created_date'];
                    $aR['tickets_created_by'] = $row['tickets_created_by'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }    
            break;
        case "getProfile":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $R = $OTh->getUserDetail();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['role_name'] = $row['role_name'];
                    $aR['division_name'] = $row['division_name'];
                    $aR['zone_name'] = $row['zone_name'];
                    $aR['user_info_id'] = $row['user_info_id'];
                    $aR['user_zone'] = $row['user_zone'];
                    $aR['user_division'] = $row['user_division'];
                    $aR['user_zone'] = $row['user_zone'];
                    $aR['user_division'] = $row['user_division'];
                    $aR['user_role'] = $row['user_role'];
                    $aR['user_email'] = $row['user_email'];
                    $aR['user_mobile'] = $row['user_mobile'];
                    $aR['user_f_name'] = $row['user_f_name'];
                    $aR['user_l_name'] = $row['user_l_name'];
                    $aR['user_dob'] = $row['user_dob'];
                    $aR['user_gender'] = $row['user_gender'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }    
            break;
        //-Preeti - 18-11-2019
        case "pieChartData":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $OTh->date = $JSON->date;
            $sec = $OTh->checkSectionExist();
            if($sec != null && mysqli_num_rows($sec) > 0){
            $R = $OTh->dueScheduleCount();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $arr['dueCount'] = $row['dueCount'];
                }
            } 
            $T = $OTh->underTestingCount();
            if ($T != null && mysqli_num_rows($T) > 0) {
                while ($row = mysqli_fetch_array($T)) {
                    $arr['underTestingCount'] = $row['testingCount'];
                }
            }
            $A = $OTh->activeCount();
            if($A != null && mysqli_num_rows($A) > 0){
                while ($row = mysqli_fetch_array($A)) {
                    $arr['activeCount'] = $row['activeCount'];
                }
            }
            $OTh->new_date = date('Y-m-d', strtotime($JSON->date. ' + 5 days'));
            $U = $OTh->UpcomingCount();
            if($U != null && mysqli_num_rows($U) > 0){
                while ($row = mysqli_fetch_array($U)) {
                    $arr['upcomingCount'] = $row['upcomingCount'];
                }
            }
            $Tkt = $OTh->raiseTicketCount();
            if($Tkt != null && mysqli_num_rows($Tkt) > 0){
                while ($row = mysqli_fetch_array($Tkt)) {
                    $arr['ticketCount'] = $row['ticketCount'];
                }
            }
                $arr["res_status"] = "200";
            }else{
                $arr["res_status"] = "401";  
            }
            break;
        case "forgetPIN":
            $OTh = new class_user();
            $OTh->user_mobile = $JSON->user_mobile;
            $OTh->user_pin = $JSON->user_pin;
            $Chk = $OTh->checkMobileExist();
            if($Chk != null && mysqli_num_rows($Chk) > 0){
                $R = $OTh->updatePIN();
                if ($R){
                    $arr["res_status"] = "200";
                    }
  
            }else{
                $arr["res_status"] = "401";
            }
            break;
        case "hardwareDetail":
            $OTh = new class_user();
            $OTh->hardware_id = $JSON->hardware_id;
            $R = $OTh->getHardwareDetail();
            if($R != null && mysqli_num_rows($R) > 0){
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['next_schedule_date'] = $row['next_schedule_date'];
                    $aR['status'] = $row['status'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_name'] = $row['shop_name'];
                    $aR['map_id'] = $row['map_id'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_code'] = $row['hardware_code'];
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['hardware_company'] = $row['hardware_company'];
                    $aR['schedule_frequency_count'] = $row['schedule_frequency_count'];
                    $aR['schedule_frequency_cycle'] = $row['schedule_frequency_cycle'];
                    $arr["res_data"] = $aR;
                }
                $arr["res_status"] = "200";
            }else{
                $arr["res_status"] = "401";
            }
            break;
        case "forceFullLogout":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $Chk = $OTh->checkUserExist();
            if($Chk != null && mysqli_num_rows($Chk) > 0){
                $R = $OTh->forceFullLogout();
                if($R){
                    $arr["res_status"] = "200";
                    }
            }else{
                $arr["res_status"] = "401";
            }
            break;
//------------------------------------
        case "activate_account":
            $OTh = new class_user();
            $OTh->user_phone = $JSON->user_phone;
            $RES = $OTh->ActivateAccount();
            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message_code"] = $RES;
                $arr["res_message"] = "Your account is successfully activated...";
            } else {
                $arr["res_status"] = "401";
                $arr["res_message_code"] = $RES;
                $arr["res_message"] = "Your account does not exist...";
            }

            break;
        /*case "get_profile":
            $OTh = new class_user();
            $OTh->user_id = $JSON->user_id;
            $OTh->user_type = $JSON->user_type;
            $OTh->user_device = $JSON->user_device;
            $RES = $OTh->GetProfile();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
//                    $ROW_DATA["grade_date"] = empty($ROW_DATA["grade_date"]) ? "" : date("m-d-Y", strtotime($ROW_DATA["grade_date"]));
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"] = $aD;
                unset($aD);
                $arr["res_status"] = "200";
            } else {
                $arr["res_message"] = $RES;
                $arr["res_status"] = "401";
            }

            break;*/
        /*case "get_hardware_list":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $RES = $OTh->GetHardwareList();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
//                    $ROW_DATA["grade_date"] = empty($ROW_DATA["grade_date"]) ? "" : date("m-d-Y", strtotime($ROW_DATA["grade_date"]));
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"] = $aD;
                unset($aD);
                $arr["res_status"] = "200";
            } else {
                $arr["res_message"] = $RES;
                $arr["res_status"] = "401";
            }

            break;*/
        /*case "raise_tickets":
            $OTh = new class_user();
            $OTh->user_id = empty($JSON->user_id) ? "" : class_common::StrToDB($JSON->user_id);
            $OTh->shop_id = $JSON->shop_id;
            $OTh->section_id = $JSON->section_id;
            $OTh->hardware_id = $JSON->hardware_id;
            $OTh->hardware_status = $JSON->hardware_status;
            $OTh->ticket_remark = $JSON->ticket_remark;
            $RES = $OTh->RaiseTickets();
            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message"] = $RES;
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            }

            break;*/
        /*case "get_raise_tickets":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $RES = $OTh->GetTicketDetails();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
//                    $ROW_DATA["grade_date"] = empty($ROW_DATA["grade_date"]) ? "" : date("m-d-Y", strtotime($ROW_DATA["grade_date"]));
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"] = $aD;
                unset($aD);
                $arr["res_status"] = "200";
            } else {
                $arr["res_message"] = $RES;
                $arr["res_status"] = "401";
            }

            break;*/
        case "hardware_maintenance":
            $OTh = new class_user();
            $OTh->user_id = empty($JSON->user_id) ? "" : class_common::StrToDB($JSON->user_id);
            $OTh->hardware_id = $JSON->hardware_id;
            $OTh->hardware_status = $JSON->hardware_status;
            $OTh->service_date = $JSON->service_date;
            $OTh->service_date_next = $JSON->service_date_next;
            $RES = $OTh->HardwareMaintenance();
            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message"] = $RES;
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            }

            break;
        /*case "pie_chart_data":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $OTh->date = $JSON->date;
            $RES = $OTh->DueCount();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"]["duecount_data"] = $aD;
                unset($aD);
            }*/
        /*$RES = $OTh->TestingCount();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"]["testingcount_data"] = $aD;
                unset($aD);
            }

            $RES = $OTh->UpcomingCount();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"]["upcomingcount_data"] = $aD;
                unset($aD);
            }
            
             $RES = $OTh->ActiveCount();
            if ($RES != "INVALID") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_assoc($RSET)) {
                    $aD[] = $ROW_DATA;
                }
                $arr["res_data"]["activecount_data"] = $aD;
                unset($aD);
            }


            $arr["res_status"] = "200";
            break;

            */

        /*case "forgot_pin":
            $OTh = new class_user();
            $OTh->user_phone = $JSON->user_phone;
            $OTh->user_pin = $JSON->user_pin;
            $RES = $OTh->ForgotPIN();
            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message_code"] = $RES;
                $arr["res_message"] = "Your PIN changed successfully";
            } else {
                $arr["res_status"] = "401";
                $arr["res_message_code"] = $RES;
                  $arr["res_message"] = "User does not exist";
            }
            //$arr["res_test"] = $JSON->user_type;
            break;*/
        case "change_pass_mob":

            $OTh = new class_user();
            $OTh->user_id = $JSON->user_id;
            $OTh->user_pass_old = $JSON->user_pass_old;
            $OTh->user_pass_new = $JSON->user_pass_new;
            $OTh->user_device = $JSON->user_device;
            $OTh->user_type = $JSON->user_type;
            $RES = $OTh->ChangePass();
            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message_code"] = $RES;
                $arr["res_message"] = "Your password changed successfully";
            } else {
                $arr["res_status"] = "401";
                $arr["res_message_code"] = $RES;
                $arr["res_message"] = "Please enter correct old password";
            }

            break;

        case "change_phone":
            $OTh = new class_user();
            $OTh->user_id = $JSON->user_id;
            $user_phone = class_common::UnformatPhone($JSON->user_phone);
            $OTh->user_phone = $user_phone; //$JSON->user_phone;
            $OTh->user_device = $JSON->user_device;
            $RES = $OTh->ChangePhone();
            if ($RES == "PHONEEXISTS") {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            } else {

                $arr["res_status"] = "200";
                $arr["res_message"] = $RES;
            }
            break;

        case "resend_otp":
            $OTh = new class_user();
            $OTh->user_id = $JSON->user_id;
            $OTh->user_device = $JSON->user_device;
            $OTh->user_type = $JSON->user_type;
            $RES = $OTh->ResendOTP();
            if ($RES == "INVALIDUSERID") {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            } else {

                $arr["res_status"] = "200";
                $arr["res_message"] = $RES;
            }
            break;

        case "new_pass":
            /**/
            $OTh = new class_user();
            $OTh->user_id = $JSON->user_id;
            $OTh->user_pass = $JSON->user_pass;
            $OTh->user_device = $JSON->user_device;
            $OTh->user_update_date = $JSON->user_update_date;

            $RES = $OTh->NewPass();
            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message"] = $RES;
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            }
            //$arr["res_test"] = $JSON->user_type;
            break;

        case "validate_otp":
            /**/
            $OTh = new class_user();
            $OTh->user_id = $JSON->user_id;
            $OTh->phone_valid = $JSON->phone_otp;
            $OTh->user_type = $JSON->user_type;
            $OTh->user_device = $JSON->user_device;
            $RES = $OTh->OTPValid();

            if ($RES == "OK") {
                $arr["res_status"] = "200";
                $arr["res_message_code"] = $RES;
                if ($OTh->user_type == 'CSO') {
                    $arr["res_message"] = "OTP verification is success, due for Admin Verification. You will receive notification once it is active";
                } else {
                    $arr["res_message"] = "OTP verified";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            }
            //$arr["res_test"] = $JSON->user_type;
            break;

        case "login":
            $OTh = new class_user();
            $OTh->user_phone = $JSON->user_phone;
            $OTh->user_pin = $JSON->user_pin;
            $OTh->user_device = $JSON->user_device;
            $RES = $OTh->Login();
            //echo $RES;die;
            if ($RES == "VALID") {
                $RSET = $OTh->ReturnResultSet();
                $ROW_DATA = mysqli_fetch_assoc($RSET);
                if($ROW_DATA["user_info_id"] == 'INVALID'){
                    $arr["res_status"] = "401";
                    $arr["res_msg_code"] = $RES;
                    $arr["res_message"] = "Invalid email ID or password.";
                }else{
//                    $ROW_DATA["user_profile_pic"] = empty($ROW_DATA["user_profile_pic"]) ? "" : $siteurl_upload . $ROW_DATA["user_id"] . '/' . $ROW_DATA["user_profile_pic"];

                    $arr["res_status"] = "200";
                    $arr["res_msg_code"] = $RES;
                    $arr["res_message"] = "User authenticated.";
                    $arr["res_data"] = $ROW_DATA;
                    $userArr = array(
                     //   'user_id' => $ROW_DATA["user_id"],
                    //    'user_type' => $ROW_DATA["user_type"]
                    );
                    //$query = base64_encode(strrev(implode(',',$userArr)));            
                    $query = class_common::base64url_encode($userArr);
                    $arr["res_query_string"] = $query;
                }               
            } else {
                $arr["res_status"] = "401";
                $arr["res_msg_code"] = $RES;
                $arr["res_message"] = "Invalid email ID or password.";
            }
            break;

        case "forgot_pass_mob":
            /**/
            $OTh = new class_user();
            $OTh->user_email = $JSON->user_email;
            $RES = $OTh->ForgotPassNewMob();
            if ($RES != "INVALIDEMAIL") {
                //list($user_id, $user_f_name, $user_l_name) = mysqli_fetch_row($RES,$conn);
                $RSET = $OTh->ReturnResultSet();
                if (!empty($RSET)) {
                    $ROW_DATA = mysqli_fetch_array($RSET);
                    $a = array();
                    $a["user_f_name"] = $ROW_DATA['user_f_name'];
                    $a["user_l_name"] = $ROW_DATA['user_l_name'];
                    $a["email_id"] = $ROW_DATA['user_email'];
                    $email_us_id = base64_encode($ROW_DATA["user_id"]);
                    $content = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                  <td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#f8f8f8" style="font-family:helvetica, sans-serif;" class="MainContainer">
                  <tbody>
                  <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                  <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                  <td class="movableContentContainer">
                  <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody style="background-color:#222">
                  <tr>
                  <td height="15"></td>
                  </tr>
                  <tr>
                  <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                  <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                  <td valign="top" width="" style="padding-left:15px;"><a href="#"><img src="' . class_api::get_site_url() . '/build/images/logo.jpg" alt="Logo" title="Logo"></a></td>
                  <td width="10" valign="top">&nbsp;</td>
                  <td valign="middle" style="vertical-align: middle;"></td>
                  </tr>
                  </tbody>
                  </table>
                  </td>
                  <td valign="top" width="90" class="spechide">&nbsp;</td>
                  <td valign="middle" style="vertical-align: middle;" width="150"></td>
                  </tr>
                  </tbody>
                  </table>
                  </td>
                  </tr>
                  <tr>
                  <td height="15"></td>
                  </tr>
                  </tbody>
                  </table>
                  </div>
                  <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:0 15px; border:1px solid #b6b6b6">
                  <tbody>
                  <tr>
                  <td height="18"></td>
                  </tr>
                  <tr>
                  <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                  <td class="specbundle">
                  <div class="contentEditableContainer contentTextEditable">
                  <div class="contentEditable" style="text-align: left;">
                  <h2 style="font-size: 20px;font-family:verdana;color:#000000;">Dear ' . ucfirst($a["user_f_name"] . ' ' . $a["user_l_name"]) . ',</h2>
                  <p style="line-height:20px;font-family:verdana;color:#000000;">
                  <span style="font-family:verdana;color:#000000;">Reset password request for the following account:</span><br>
                  <span style="font-family:verdana;color:#000000;"><strong>Email ID:</strong> ' . $a["email_id"] . '</span><br><br>
                  <span style="font-family:verdana;color:#000000;">If this was a mistake, just ignore this email and nothing will happen.</span><br>
                  <span style="font-family:verdana;color:#000000;">To reset your password, visit the following address:</span><br>
                  <a  href="' . $siteurl . '?n_key=' . $email_us_id . '" target="_blank">Reset Password</a>
                  </p>
                  </div>
                  </div>
                  </td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                  <td class="specbundle" style="font-family:verdana;">Regards,</td>
                  </tr>
                  <tr>
                  <td class="specbundle" style="font-family:verdana;">Administrator</td>
                  </tr>
                  <tr>
                  <td class="specbundle" style="font-family:verdana;">(Zoe Blueprint)</td>
                  </tr>
                  <tr>
                  <td class="specbundle">&nbsp;</td>
                  </tr>
                  </tbody>
                  </table>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                  </div>
                  <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                  <table style="background-color: #272727;" width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                  <tr>
                  <td height="8"></td>
                  </tr>
                  <tr>
                  <td height="8">
                  <div class="contentEditableContainer contentTextEditable">
                  <div class="contentEditable" style="text-align: center;color:#AAAAAA;">
                  <p style="margin:2px 0; font-size:10px;">&copy; ' . date("Y") . ' Hashtag Labs. All rights reserved. | by # HashTag</p>
                  </div>
                  </div>
                  </td>
                  </tr>
                  <tr>
                  <td height="8"></td>
                  </tr>
                  </tbody>
                  </table>
                  </div>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                  </td>
                  </tr>
                  </tbody>
                  </table>';

                    /* $mail = new PHPMailer();
                      $mail->IsSMTP(false);
                      $mail->SMTPDebug = 0;
                      $mail->SMTPSecure = 'ssl';
                      $mail->Host = 'mail.hashtaglabs.in';
                      $mail->Port = 465;
                      $mail->Username = 'zoeblueprint@hashtaglabs.in';
                      $mail->Password = 'Yop=mjPlBnSN';
                      $mail->SMTPAuth = true;      // TCP port to connect to
                      $mail->SetFrom('zoeblueprint@hashtaglabs.in');
                     */
                    $mail = new PHPMailer();
                    $mail->IsSMTP(false);
                    $mail->SMTPDebug = 0;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Host = 'mail.hashtaglabs.in';
                    $mail->Port = 465;
                    $mail->Username = 'blueprint@hashtaglabs.in';
                    $mail->Password = 'A!NTC(j!fvf[';
                    $mail->SMTPAuth = true;      // TCP port to connect to        
                    $mail->SetFrom('blueprint@hashtaglabs.in');

                    $mail->AddAddress($a["email_id"]);
                    $mail->IsHTML(true);       // Set email format to HTML
                    $mail->Subject = "Zoe Blueprint - Reset Your Password";

                    $mail->Body = $content;
                    $send = $mail->Send();
                    //print_r($send);
                    //exit;
                    if (!$send) {
                        $arr["reset_link"] = 'Failled';
                    } else {
                        $arr["reset_link"] = $siteurl . '?n_key=' . $email_us_id;
                    }

                    $arr["reset_link"] = $siteurl . '?n_key=' . $email_us_id;
                    $arr["res_status"] = "200";
                    $arr["res_message_code"] = $RES;
                    $arr["res_message"] = "Password reset link has been sent to your email ID";
                    $arr["res_data"] = $ROW_DATA;
                } else {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = $RES;
                    $arr["res_message"] = "Email ID is not registered";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message_code"] = $RES;
                $arr["res_message"] = "Email ID is not registered";
            }
            //$arr["res_test"] = $JSON->user_type;
            break;

        default:
            $arr["api_res_key"] = "NOT VALID";
            $arr["res_status"] = "601";
            break;
    }
    /*
      if (!empty($_GET['token_value'])) {
      $OTh = new class_common();
      $OTh->user_id = $_GET['user_email'];
      $OTh->token_value = $_GET['token_value'];
      $Token = $OTh->CheckToken();
      } else {
      $Token = 1;
      }
      if ($Token > 0) {

      } else {
      $arr["res_status"] = "402";
      } */
}
$RES = json_encode($arr);
echo $RES;
?>