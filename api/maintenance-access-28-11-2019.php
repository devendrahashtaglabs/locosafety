<?php

header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_maintenance.php';
include_once 'classes/class_notification.php';
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
        //Preeti - 25-11-2019
        case "maintenanceSectionList":
            $OTh = new class_maintenance();
            $OTh->maintenance_shop_id = $JSON->maintenance_shop_id;
            $R = $OTh->maintenanceSectionList();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                    $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['maintenance_section_code'] = $row['maintenance_section_code'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_section_add_date'] = $row['maintenance_section_add_date'];
                    $OTh->maintenance_section_id = $row['maintenance_section_id'];
                    $S = $OTh->getMaintenanceSectionDetail();
                    if ($S != null && mysqli_num_rows($S) >= 0) {
                        while ($row1 = mysqli_fetch_array($S)) {
                            $aS = array();
                            $aS['user_role'] = $row1['user_role'];
                            $aS['user_email'] = $row1['user_email'];
                            $aS['user_mobile'] = $row1['user_mobile'];
                            $aS['user_f_name'] = $row1['user_f_name'];
                            $aS['user_l_name'] = $row1['user_l_name'];
                            $aS['user_dob'] = $row1['user_dob'];
                            $aS['user_gender'] = $row1['user_gender'];
                            $aS['user_profile_pic'] = $row1['user_profile_pic'];
                            $aS['url'] = 'http://hashtaglabs.in/locosafety/uploads/' . $row1['user_profile_pic'];
                            $aS['user_address'] = $row1['user_address'];
                            $aR['section_incharge_detail'][] = $aS;
                        }
                    }
                    $ticketCount = $OTh->maintenanceTicketCount();
                    if ($ticketCount) {
                        while ($row1 = mysqli_fetch_array($ticketCount)) {
                            $aR['ticket_count'] = $row1['total'];
                        }
                    }

                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "maintenanceRaisedTicketList":
            $OTh = new class_maintenance();
            $OTh->maintenance_section_id = $JSON->maintenance_section_id;
            $R = $OTh->maintenanceRaisedTicketList();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['category_name'] = $row['category_name'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['status'] = $row['status'];
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
        case "maintenancePieChartData":
            $OTh = new class_maintenance();
            $OTh->maintenance_section_id = $JSON->maintenance_section_id;
            $OTh->date = date('Y-m-d');
            $sec = $OTh->checkMaintenanceSectionExist();
            if ($sec != null && mysqli_num_rows($sec) >= 0) {
                $R = $OTh->ticketStatusCountMaintenanceSection();
                if ($R != null && mysqli_num_rows($R) > 0) {
                    while ($row_cnt = mysqli_fetch_array($R)) {
                        $aR = array();
                        $aR['fresh'] = $row_cnt['fresh'];
                        $aR['pending'] = $row_cnt['pending'];
                        $aR['Close'] = $row_cnt['Close'];
                    }
                }
                $ticketCount = $OTh->maintenanceSectionTicketCount();
                if ($ticketCount) {
                    while ($row1 = mysqli_fetch_array($ticketCount)) {
                        $aR['ticket_count'] = $row1['total'];
                    }
                }
                $arr["res_data"][] = $aR;

                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        //Preeti - 27-11-2019
        case "myWorkMaintenanceShop":
            $OTh = new class_maintenance();
            $OTh->maintenance_shop_id = $JSON->maintenance_shop_id;
            $OTh->date = date('Y-m-d');
            $R = $OTh->maintenanceSectionList();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                    $OTh->maintenance_section_id = $row['maintenance_section_id'];
                    $ticketCount = $OTh->ticketStatusCountMaintenanceSection();
                    if ($ticketCount) {
                        while ($row_cnt = mysqli_fetch_array($ticketCount)) {
                            $aC = array();
                            $aC['fresh'] = $row_cnt['fresh'];
                            $aC['pending'] = $row_cnt['pending'];
                            $aC['Close'] = $row_cnt['Close'];
                            $aR['ticket_count'][] = $aC;
                        }
                    }
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;

        case "closeTicketFixedHardware":
            $OTh = new class_maintenance();
            $OTh->user_info_id = $JSON->user_info_id;
            $OTh->ticket_no = $JSON->ticket_no;
            $OTh->case_remarks = $JSON->case_remarks;
            $T = $OTh->closeTicket();

            $receiver_id = '';
            $device_id = '';
            $ReceiverID = '';
            $DeviceID = '';
            $DataUsers = $OTh->GetReceiverID();
            foreach ($DataUsers as $row) {
                $receiver_id = $row['user_info_id'];
                  $device_id = $row['user_device_id'];
            }
            $ReceiverID = $receiver_id;
            $DeviceID = $device_id;
            $ticketNo = $JSON->ticket_no;
            $Msg = "A ticket number   " . $ticketNo . "  has been closed.";
            $Title = "Ticket Closed";
            $Not = new class_maintenance();
            $Not = new class_notification();
            $ResNot = $Not->testForHimanshu($DeviceID, $Msg, $Title);
            $OTh->Msg = $Msg;
            $OTh->Title = "LOCO Safety";
            $OTh->ticket_no = $ticketNo;
            $OTh->receiver_id = $ReceiverID;
            $DataUsers = $OTh->InsertNotification();

            if ($T) {


                $allT = $OTh->getAllTicket();
                if ($allT != null && mysqli_num_rows($allT) == 0) {
                    $OTh->updateHardwareStatus();
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "closeTicketNotFixedHardware":
            $OTh = new class_maintenance();
            $OTh->user_info_id = $JSON->user_info_id;
            $OTh->ticket_no = $JSON->ticket_no;
            $OTh->hardware_serial_no = $JSON->hardware_serial_no;
            $OTh->shop_id = $JSON->shop_id;
            $OTh->section_id = $JSON->section_id;
            $OTh->case_remarks = $JSON->case_remarks;
            $OTh->user_info_id = $JSON->user_info_id;
            $OTh->date = date('Y-m-d');

            $T = $OTh->closeTicket();
            $receiver_id = '';
            $ReceiverID = '';
            $DataUsers = $OTh->GetReceiverID();
           foreach ($DataUsers as $row) {
                $receiver_id = $row['user_info_id'];
                  $device_id = $row['user_device_id'];
            }
            $ReceiverID = $receiver_id;
            $DeviceID = $device_id;
            $ticketNo = $JSON->ticket_no;
            //$Msg = "A ticket has been closed.";           
            $Msg = "A ticket number   " . $ticketNo . "  has been closed.";
            $Title = "Ticket Closed";
            $Not = new class_maintenance();
              $Not = new class_notification();
            $ResNot = $Not->testForHimanshu($DeviceID, $Msg, $Title);
            $OTh->Msg = $Msg;
            $OTh->Title = "LOCO Safety";
            $OTh->ticket_no = $ticketNo;
            $OTh->receiver_id = $ReceiverID;
            $DataUsers = $OTh->InsertNotification();

            if ($T) {
                $P = $OTh->getPreviousHardwareId();
                if ($P != null && mysqli_num_rows($P) > 0) {
                    while ($row1 = mysqli_fetch_array($P)) {
                        $aR = array();
                        $OTh->pre_hardware_id = $row1['hardware_id'];
                    }
                    $OTh->clearHardwareMapping();
                    $arr["res_message"]['clear_mapping'] = "200";
                }
                $R = $OTh->getNewHardwareId();
                if ($R != null && mysqli_num_rows($R) > 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $aR = array();
                        $OTh->new_hardware_id = $row['hardware_id'];
                    }
                }
                $uH = $OTh->updateHardwareMapping();
                if ($uH) {
                    $arr["res_message"]['update_hardware_mapping'] = "200";
                }
                $uRH = $OTh->updateReplaceHardware();
                if ($uRH) {
                    $arr["res_message"]['update_replace_hardware'] = "200";
                }

                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        default:
            $arr["api_res_key"] = "NOT VALID";
            $arr["res_status"] = "601";
            break;
    }
}
$RES = json_encode($arr);
echo $RES;
?>