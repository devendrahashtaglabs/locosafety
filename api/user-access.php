<?php

header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_user.php';
include_once 'classes/class_master.php';
include_once 'classes/class_common.php';
include_once 'classes/class_notification.php';
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
            if ($R != null && mysqli_num_rows($R) >= 0) {
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
                    $aR['next_schedule_date'] = $row['next_schedule_date'];
                    $aR['hardware_image'] = $row['hardware_image'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "raiseTicket":
            $OTh = new class_user();
            $main_section = explode(',', $JSON->maintenance_section_id);
            $division = class_common::getDivisionById($JSON->division_id);
            $zone = class_common::getZoneById($JSON->zone_id);
            $ticket_no = class_common::generateTicket(6, $zone, $division);
            $i = 1;
            foreach ($main_section as $main_sec) {
                $OTh->maintenance_section_id = $main_sec;
                $OTh->section_id = $JSON->section_id;
                $OTh->zone_id = $JSON->zone_id;
                $OTh->division_id = $JSON->division_id;
                $OTh->shop_id = $JSON->shop_id;
                $OTh->hardware_id = $JSON->hardware_id;
                $OTh->hardware_map_section_id = $JSON->hardware_map_section_id;
                $OTh->maintenance_shop_id = $JSON->maintenance_shop_id;
//                $OTh->maintenance_section_id = $JSON->maintenance_section_id;
                $OTh->case_type = $JSON->case_type;
                $OTh->case_remarks = $JSON->case_remarks;
                $OTh->tickets_created_date = date('Y-m-d');
                $OTh->tickets_created_by = $JSON->tickets_created_by;
                $ticket_num = $OTh->ticket_no = $ticket_no . '-' . $i;
                $R = $OTh->raiseTickets();
                $T = $OTh->ticketLog();
                
                /* ---- Notification -----------*/
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
                //$ticketNo = $ticket_no . '-' . $i;
                $ticketNo = $ticket_num;
                $Msg = "A ticket number   " . $ticketNo . "  has been raised.";
                $Title = "Ticket Raised";
                $Not = new class_user();
                $Not = new class_notification();
                $ResNot = $Not->testForHimanshu($DeviceID, $Msg, $Title);
                $OTh->Msg = $Msg;
                $OTh->Title = "LOCO Safety";
                $OTh->ticket_no = $ticketNo;
                $OTh->receiver_id = $ReceiverID;

                $DataUsers = $OTh->InsertNotification();
                /*------Notification--------- */
                $arr["ticket_no"][] = $ticketNo;
                $i++;
            }

            if ($R == '0' || $R != null) {

                $H = $OTh->updateHardwareMappingTbl();
                $arr["res_status"] = "200";
//                $arr["ticket_no"] = $ticketNo;//-- 09-12-2019
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "raisedTicketList":
            $OTh = new class_user();
            $OTh->section_id = $JSON->section_id;
            $R = $OTh->raisedTicketList();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['category_name'] = $row['category_name'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['hardware_image'] = $row['hardware_image'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
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
            if ($R != null && mysqli_num_rows($R) >= 0) {
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
                    $aR['user_profile_pic'] = $row['user_profile_pic'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/' . $row['user_profile_pic'];
                    $aR[] = '';
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
            $OTh->shop_id = $JSON->shop_id;
            $OTh->section_id = $JSON->section_id;
            $OTh->date = $JSON->date;
            $sec = $OTh->checkSectionExist();
            if ($sec != null && mysqli_num_rows($sec) >= 0) {
                $R = $OTh->dueScheduleCount();
                if ($R != null && mysqli_num_rows($R) > 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $arr['dueCount'] = $row['dueCount'];
                    }
                }
                /* $T = $OTh->underTestingCount();
                  if ($T != null && mysqli_num_rows($T) > 0) {
                  while ($row = mysqli_fetch_array($T)) {
                  $arr['underTestingCount'] = $row['testingCount'];
                  }
                  } */
                $A = $OTh->activeCount();
                if ($A != null && mysqli_num_rows($A) > 0) {
                    while ($row = mysqli_fetch_array($A)) {
                        $arr['activeCount'] = $row['activeCount'];
                    }
                }
                $OTh->new_date = date('Y-m-d', strtotime($JSON->date . ' + 5 days'));
                $U = $OTh->UpcomingCount();
                if ($U != null && mysqli_num_rows($U) > 0) {
                    while ($row = mysqli_fetch_array($U)) {
                        $arr['upcomingCount'] = $row['upcomingCount'];
                    }
                }
                $Tkt = $OTh->raiseTicketCount();
                if ($Tkt != null && mysqli_num_rows($Tkt) > 0) {
                    while ($row = mysqli_fetch_array($Tkt)) {
                        $arr['ticketCount'] = $row['ticketCount'];
                    }
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "forgetPIN":
            $OTh = new class_user();
            $OTh->user_mobile = $JSON->user_mobile;
            $OTh->user_pin = $JSON->user_pin;
            $Chk = $OTh->checkMobileExist();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $R = $OTh->updatePIN();
                if ($R) {
                    $arr["res_status"] = "200";
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "hardwareDetail":
            $OTh = new class_user();
            $OTh->hardware_id = $JSON->hardware_id;
            $R = $OTh->getHardwareDetail();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['schedule_id'] = $row['schedule_id'];
                    $aR['schedule_status'] = $row['schedule_status'];
                    $aR['hardware_category_name'] = $row['hardware_category_name'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['hardware_image'] = $row['hardware_image'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
                    $aR['schedule_start_date'] = $row['schedule_start_date'];
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
            } else {
                $arr["res_status"] = "401";
            }
            break;
        //Preeti - 19-11-2019
        case "shopListForManager":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $Chk = $OTh->checkUserExist();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $R = $OTh->getShopList();
                if ($R != null && mysqli_num_rows($R) >= 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $aR = array();
                        $OTh->shop_id = $aR['shop_id'] = $row['shop_id'];
                        $OTh->zone_id = $aR['zone_id'] = $row['zone_id'];
                        $OTh->division_id = $aR['division_id'] = $row['division_id'];
                        
                        $aR['shop_name'] = $row['shop_name'];
                        // 10-12-2019
                        $shop_detail = $OTh->getShopInchDetail();
                        if ($shop_detail != null && mysqli_num_rows($shop_detail) > 0) {
                            $aS = array();
                            while ($row_shop = mysqli_fetch_array($shop_detail)) {
                                $aS['user_f_name'] = $row_shop['user_f_name'];
                                $aS['user_l_name'] = $row_shop['user_l_name'];
                                $aS['user_mobile'] = $row_shop['user_mobile'];
                                $aS['user_profile_pic'] = $row_shop['user_profile_pic'];
                                $aS['url'] = 'http://hashtaglabs.in/locosafety/uploads/' . $row_shop['user_profile_pic'];
                                $aR['shop_incharge'][] = $aS;
                            }
                        }
                        $cat = $OTh->getAllCategory();
                        if ($cat != null && mysqli_num_rows($cat) > 0) {
                            $aS = array();
                            while ($row_cat = mysqli_fetch_array($cat)) {
                                $aS['category_code'] = $row_cat['category_code'];
                                $aS['category_name'] = $row_cat['category_name'];
                                $OTh->hardware_category = $aS['id'] = $row_cat['id'];
                                $cat_del = $OTh->getCategoryWise();
                                if($cat_del != null && mysqli_num_rows($cat_del) >= 0){
                                    $cD = array();
                                    while ($cat_row = mysqli_fetch_array($cat_del)) {
                                        $cD['Total'] = $cat_row['Total'];
                                        $cD['Active'] = $cat_row['Active'];
                                        $cD['Under Maintenance'] = $cat_row['Under Maintenance'];
                                        $cD['Breakdown'] = $cat_row['Breakdown'];
                                        $aS['hardware_count'] = $cD;
                                    }
                                }                                
                                $aR['category'][] = $aS;
                            }
                        }
                        $secCount = $OTh->getSectionCount();
                        if ($secCount != null && mysqli_num_rows($secCount) > 0) {
                            while ($row_sec = mysqli_fetch_array($secCount)) {
                                $aR['sectionCount'] = $row_sec['sectionCount'];
                            }
                        }
                        $ticketCount = $OTh->getTicketCount();
                        if ($ticketCount) {
                        while ($row_cnt = mysqli_fetch_array($ticketCount)) {
                            $aC = array();
                            $aC['Open'] = $row_cnt['Open'];
                            $aC['Under Maintenance'] = $row_cnt['Under Maintenance'];
                            $aC['Breakdown'] = $row_cnt['Breakdown'];
                            $aC['Close'] = $row_cnt['Close'];
                            $aC['Total'] = $row_cnt['Total'];
                            $aR['ticket_count'][] = $aC;
                            }
                        }
                        $hardwareCount = $OTh->getHardwareCount();
                        if ($hardwareCount != null && mysqli_num_rows($hardwareCount) > 0) {
                            while ($row_hrd = mysqli_fetch_array($hardwareCount)) {
                                $aR['totalHardware'] = $row_hrd['totalHardware'];
                            }
                        }
                        $aR['activeHardware'] = $OTh->getHardwareCountActive();
                        
                        /*$hardwareCount = $OTh->getHardwareCount();
                        if ($hardwareCount != null && mysqli_num_rows($hardwareCount) > 0) {
                            while ($row_hrd = mysqli_fetch_array($hardwareCount)) {
                                $aH = array();
                                $aH['activeHardware'] = $row_hrd['activeHardware'];
                                $aH['totalHardware'] = $row_hrd['totalHardware'];
                                $aR['hardare_count'][] = $aH;
                            }
                        }*/
                        $dueHardware = $OTh->dueScheduleCountShop();
                        if ($dueHardware != null && mysqli_num_rows($dueHardware) > 0) {
                            while ($row_due = mysqli_fetch_array($dueHardware)) {
                                $aR['dueCount'] = $row_due['dueCount'];
                            }
                        }
                        $arr["res_data"][] = $aR;
                    }
                    $arr["res_status"] = "200";
                } else {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "No data available.";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "User not exist";
            }
            break;
        case "sectionListForManager":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $Chk = $OTh->checkUserExist();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $R = $OTh->getSectionList();
                if ($R != null && mysqli_num_rows($R) >= 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $aR = array();
                        $OTh->section_id = $aR['section_id'] = $row['section_id'];
                        $aR['shop_id'] = $row['shop_id'];
                        $aR['section_code'] = $row['section_code'];
                        $aR['section_name'] = $row['section_name'];
                        $aR['shop_name'] = $row['shop_name'];
                        $OTh->zone_id = $aR['zone_id'] = $row['zone_id'];
                        $OTh->division_id = $aR['division_id'] = $row['division_id'];
                        // 10-12-2019
                        $cat = $OTh->getAllCategory();
                        if ($cat != null && mysqli_num_rows($cat) > 0) {
                            $aS = array();
                            while ($row_cat = mysqli_fetch_array($cat)) {
                                $aS['category_code'] = $row_cat['category_code'];
                                $aS['category_name'] = $row_cat['category_name'];
                                $OTh->hardware_category = $aS['id'] = $row_cat['id'];
                                $cat_del = $OTh->getCategoryWiseSec();
                                if($cat_del != null && mysqli_num_rows($cat_del) >= 0){
                                    $cD = array();
                                    while ($cat_row = mysqli_fetch_array($cat_del)) {
                                        $cD['Total'] = $cat_row['Total'];
                                        $cD['Active'] = $cat_row['Active'];
                                        $cD['Under Maintenance'] = $cat_row['Under Maintenance'];
                                        $cD['Breakdown'] = $cat_row['Breakdown'];
                                        $aS['hardware_count'] = $cD;
                                    }
                                }                                
                                $aR['category'][] = $aS;
                            }
                        }
                        $arr["res_data"][] = $aR;
                    }
                    $arr["res_status"] = "200";
                } else {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "No data available.";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "User not exist";
            }
            break;
        case "maintenanceShopListForManager":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $Chk = $OTh->checkUserExist();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $R = $OTh->getMaintenanceShopList();
                if ($R != null && mysqli_num_rows($R) >= 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $aR = array();
                        $OTh->maintenance_shop_id = $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                        $OTh->zone_id = $aR['zone_id'] = $row['zone_id'];
                        $OTh->division_id = $aR['division_id'] = $row['division_id'];
                        $aR['maintenance_shop_code'] = $row['maintenance_shop_code'];
                        $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                        // 10-12-2019
                        $shop_detail = $OTh->getMainShopInchDetail();
                        if ($shop_detail != null || mysqli_num_rows($shop_detail) >= 0) {
                            $aS = array();
                            while ($row_shop = mysqli_fetch_array($shop_detail)) {
                                $aS['user_f_name'] = $row_shop['user_f_name'];
                                $aS['user_l_name'] = $row_shop['user_l_name'];
                                $aS['user_mobile'] = $row_shop['user_mobile'];
                                $aS['user_profile_pic'] = $row_shop['user_profile_pic'];
                                $aS['url'] = 'http://hashtaglabs.in/locosafety/uploads/' . $row_shop['user_profile_pic'];
                                $aR['Incharge_detail'][] = $aS;
                            }
                        }
                        // 11-12-2019
                        $cat = $OTh->getAllCategory();
                        if ($cat != null && mysqli_num_rows($cat) > 0) {
                            $aS = array();
                            while ($row_cat = mysqli_fetch_array($cat)) {
                                $aS['category_code'] = $row_cat['category_code'];
                                $aS['category_name'] = $row_cat['category_name'];
                                $OTh->hardware_category = $aS['id'] = $row_cat['id'];
                                $cat_del = $OTh->getCategoryMainShop();
                                if($cat_del != null && mysqli_num_rows($cat_del) >= 0){
                                    $cD = array();
                                    while ($cat_row = mysqli_fetch_array($cat_del)) {
                                        $cD['Open'] = $cat_row['Open'];
                                        $cD['Under Maintenance'] = $cat_row['Under Maintenance'];
                                        $cD['Breakdown'] = $cat_row['Breakdown'];
                                        $cD['Close'] = $cat_row['Close'];
                                        $cD['fresh'] = $cat_row['fresh'];
                                        $cD['pending'] = $cat_row['pending'];
                                        $cD['Total'] = $cat_row['Total'];
                                        $aS['category_ticket_count'] = $cD;
                                    }
                                }                                
                                $aR['category'][] = $aS;
                            }
                        }
                        $C = $OTh->ticketStatusCountMainShop();
                        if ($C != null && mysqli_num_rows($C) > 0) {
                            while ($row_cnt = mysqli_fetch_array($C)) {
                                $aC = array();
                                $aC['Open'] = $row_cnt['Open'];
                                $aC['Under Maintenance'] = $row_cnt['Under Maintenance'];
                                $aC['Breakdown'] = $row_cnt['Breakdown'];
                                $aC['fresh'] = $row_cnt['fresh'];
                                $aC['pending'] = $row_cnt['pending'];
                                $aC['Close'] = $row_cnt['Close'];
                                $aC['Total'] = $row_cnt['Total'];
                                $aR['ticket_count'][] = $aC;
                            }
                        }
                        $secCount = $OTh->getMaintenanceSectionCount();
                        if ($secCount != null && mysqli_num_rows($secCount) > 0) {
                            while ($row_sec = mysqli_fetch_array($secCount)) {
                                $aR['sectionCount'] = $row_sec['sectionCount'];
                            }
                        }
                        $arr["res_data"][] = $aR;
                    }
                    $arr["res_status"] = "200";
                } else {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "No data available.";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "User not exist";
            }
            break;
        case "maintenanceSectionListForManager":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $Chk = $OTh->checkUserExist();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $R = $OTh->getMaintenanceSectionList();
                if ($R != null && mysqli_num_rows($R) >= 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $aR = array();
                        $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                        $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                        $aR['default_hardware_cat'] = $row['default_hardware_cat'];
                        $aR['hardware_category_name'] = $row['category_name'];
                        $aR['maintenance_section_code'] = $row['maintenance_section_code'];
                        $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                        $aR['maintenance_shop_code'] = $row['maintenance_shop_code'];
                        $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                        $arr["res_data"][] = $aR;
                    }
                    $arr["res_status"] = "200";
                } else {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "No data available.";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "User not exist";
            }
            break;
        case "hardwareListManager":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $Chk = $OTh->checkUserExist();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $S = $OTh->getShopSectionList();
                if ($S != null && mysqli_num_rows($S) >= 0) {
                    while ($row1 = mysqli_fetch_array($S)) {
                        $aR = array();
                        $OTh->shop_id = $aR['shop_id'] = $row1['shop_id'];
                        $OTh->section_id = $aR['section_id'] = $row1['section_id'];
                        $H = $OTh->GetHardwareList();
                        if ($H != null && mysqli_num_rows($H) >= 0) {
                            while ($row = mysqli_fetch_array($H)) {
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
                                $aR['next_schedule_date'] = $row['next_schedule_date'];
                                $aR['hardware_type_name'] = $row['hardware_type_name'];
                                $aR['hardware_image'] = $row['hardware_image'];
                                $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
                                $arr["res_data"][] = $aR;
                            }
                        }
                    }
                } else {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "No data available.";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "User not exist";
            }
            break;
        case "viewRaisedTicket":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $R = $OTh->ticketListManager();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['status'] = $row['status'];
                    $aR['ticket_id'] = $row['ticket_id'];
                    $aR['ticket_no'] = $row['ticket_no'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_name'] = $row['shop_name'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['zone_id'] = $row['zone_id'];
                    $aR['division_id'] = $row['division_id'];
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
        case "myTicketShop":
            $OTh = new class_user();
            $OTh->shop_id = $JSON->shop_id;
            $R = $OTh->shopTicket();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['status'] = $row['status'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['shop_name'] = $row['shop_name'];
                    $aR['ticket_id'] = $row['ticket_id'];
                    $aR['zone_id'] = $row['zone_id'];
                    $aR['division_id'] = $row['division_id'];
                    $aR['ticket_no'] = $row['ticket_no'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['section_name'] = $row['section_name'];
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
        //Preeti - 20-11-2019
        case "myTickets":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $R = $OTh->getUserDetail();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row1 = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['role_name'] = $row1['role_name'];
                    $aR['user_f_name'] = $row1['user_f_name'];
                    $aR['user_l_name'] = $row1['user_l_name'];
                    $aR['user_dob'] = $row1['user_dob'];
                    $aR['user_gender'] = $row1['user_gender'];
                    $aR['division_name'] = $row1['division_name'];
                    $aR['zone_name'] = $row1['zone_name'];
                    $aR['user_zone'] = $row1['user_zone'];
                    $aR['user_division'] = $row1['user_division'];
                    $aR['user_email'] = $row1['user_email'];
                    $aR['user_mobile'] = $row1['user_mobile'];
                    $user_role = $row1['user_role'];
                    switch ($user_role) {
                        case 1:
                            $arr["res_message"] = "Super Admin";
                            $arr["res_status"] = "401";
                            break;
                        case 2:
                            $T = $OTh->ticketListManager();
                            if ($T != null && mysqli_num_rows($T) >= 0) {
                                while ($row = mysqli_fetch_array($T)) {
                                    $aR['status'] = $row['status'];
                                    $aR['ticket_id'] = $row['ticket_id'];
                                    $aR['ticket_no'] = $row['ticket_no'];
                                    $aR['shop_id'] = $row['shop_id'];
                                    $aR['section_name'] = $row['section_name'];
                                    $aR['shop_name'] = $row['shop_name'];
                                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                                    $aR['section_id'] = $row['section_id'];
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
                        case 3:
                            $T = $OTh->ticketListManager();
                            if ($T != null && mysqli_num_rows($T) >= 0) {
                                while ($row = mysqli_fetch_array($T)) {
                                    $aR['status'] = $row['status'];
                                    $aR['ticket_id'] = $row['ticket_id'];
                                    $aR['ticket_no'] = $row['ticket_no'];
                                    $aR['shop_id'] = $row['shop_id'];
                                    $aR['section_name'] = $row['section_name'];
                                    $aR['shop_name'] = $row['shop_name'];
                                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                                    $aR['section_id'] = $row['section_id'];
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
                        case 4:
                            $S = $OTh->ticketListShop();
                            if ($S != null && mysqli_num_rows($S) >= 0) {
                                while ($row = mysqli_fetch_array($S)) {
                                    $aR['status'] = $row['status'];
                                    $aR['ticket_id'] = $row['ticket_id'];
                                    $aR['ticket_no'] = $row['ticket_no'];
                                    $aR['shop_id'] = $row['shop_id'];
                                    $aR['section_name'] = $row['section_name'];
                                    $aR['shop_name'] = $row['shop_name'];
                                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                                    $aR['section_id'] = $row['section_id'];
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
                        case 5:
                            $S = $OTh->ticketListSection();
                            if ($S != null && mysqli_num_rows($S) >= 0) {
                                while ($row = mysqli_fetch_array($S)) {
                                    $aR['status'] = $row['status'];
                                    $aR['ticket_id'] = $row['ticket_id'];
                                    $aR['ticket_no'] = $row['ticket_no'];
                                    $aR['shop_id'] = $row['shop_id'];
                                    $aR['section_name'] = $row['section_name'];
                                    $aR['shop_name'] = $row['shop_name'];
                                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                                    $aR['section_id'] = $row['section_id'];
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
                        case 6:
                            $S = $OTh->ticketListMaintenanceShop();
                            if ($S != null && mysqli_num_rows($S) >= 0) {
                                while ($row = mysqli_fetch_array($S)) {
                                    $aR['status'] = $row['status'];
                                    $aR['ticket_id'] = $row['ticket_id'];
                                    $aR['ticket_no'] = $row['ticket_no'];
                                    $aR['shop_id'] = $row['shop_id'];
                                    $aR['section_name'] = $row['section_name'];
                                    $aR['shop_name'] = $row['shop_name'];
                                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                                    $aR['section_id'] = $row['section_id'];
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
                        case 7:
                            $S = $OTh->ticketListMaintenanceShop();
                            if ($S != null && mysqli_num_rows($S) >= 0) {
                                while ($row = mysqli_fetch_array($S)) {
                                    $aR['status'] = $row['status'];
                                    $aR['ticket_id'] = $row['ticket_id'];
                                    $aR['ticket_no'] = $row['ticket_no'];
                                    $aR['shop_id'] = $row['shop_id'];
                                    $aR['section_name'] = $row['section_name'];
                                    $aR['shop_name'] = $row['shop_name'];
                                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                                    $aR['section_id'] = $row['section_id'];
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
                        default :
                            $arr["res_message"] = "User not exist";
                            $arr["res_status"] = "401";
                            break;
                    }
                }
            }
            break;
        case "myWork":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $OTh->date = date('Y-m-d');
            $R = $OTh->getUserDetail();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row1 = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['role_name'] = $row1['role_name'];
                    $aR['user_f_name'] = $row1['user_f_name'];
                    $aR['user_l_name'] = $row1['user_l_name'];
                    $aR['user_dob'] = $row1['user_dob'];
                    $aR['user_gender'] = $row1['user_gender'];
                    $aR['division_name'] = $row1['division_name'];
                    $aR['zone_name'] = $row1['zone_name'];
                    $aR['user_zone'] = $row1['user_zone'];
                    $aR['user_division'] = $row1['user_division'];
                    $aR['user_email'] = $row1['user_email'];
                    $aR['user_mobile'] = $row1['user_mobile'];
                    $OTh->user_role = $user_role = $row1['user_role'];
                    if ($user_role == '4') {
                        $S = $OTh->getShopListInch();
                        if ($S != null && mysqli_num_rows($S) >= 0) {
                            while ($row = mysqli_fetch_array($S)) {
                                $aS = array();
                                $aS['shop_id'] = $row['shop_id'];
                                $aS['shop_name'] = $row['shop_name'];
                                $aS['section_id'] = $row['section_id'];
                                $aS['section_code'] = $row['section_code'];
                                $aS['section_name'] = $row['section_name'];
                                $OTh->shop_id = $row['shop_id'];
                                $OTh->section_id = $row['section_id'];
                                $Due = $OTh->dueCountShop();
                                if ($Due != null && mysqli_num_rows($Due) > 0) {
                                    while ($row_due = mysqli_fetch_array($Due)) {
                                        $aS['dueCount'] = $row_due['dueCount'];
                                    }
                                }
                                $Due = $OTh->overdueCountShop();
                                if ($Due != null && mysqli_num_rows($Due) > 0) {
                                    while ($row_due = mysqli_fetch_array($Due)) {
                                        $aS['overdueCount'] = $row_due['overdueCount'];
                                    }
                                }
                                $H = $OTh->GetDueHardwareList();
                                if ($H != null && mysqli_num_rows($H) >= 0) {
                                    while ($row2 = mysqli_fetch_array($H)) {
                                        $aH = array();
                                        $aH['schedule_start_date'] = $row2['schedule_start_date'];
                                        $aH['hardware_id'] = $row2['hardware_id'];
                                        $aH['hardware_category'] = $row2['hardware_category'];
                                        $aH['hardware_type'] = $row2['hardware_type'];
                                        $aH['hardware_code'] = $row2['hardware_code'];
                                        $aH['hardware_name'] = $row2['hardware_name'];
                                        $aH['hardware_model'] = $row2['hardware_model'];
                                        $aH['hardware_company'] = $row2['hardware_company'];
                                        $aH['schedule_frequency_count'] = $row2['schedule_frequency_count'];
                                        $aH['schedule_frequency_cycle'] = $row2['schedule_frequency_cycle'];
                                        //new detail -22-11-2019 
                                        $aH['schedule_id'] = $row2['schedule_id'];
                                        $aH['map_id'] = $row2['map_id'];
                                        $aH['schedule_status'] = $row2['schedule_status'];
                                        $aH['hardware_serial_no'] = $row2['hardware_serial_no'];
                                        $aH['hardware_category_name'] = $row2['hardware_category_name'];
                                        $aH['hardware_type_name'] = $row2['hardware_type_name'];
                                        $aH['next_schedule_date'] = $row2['next_schedule_date'];
                                        $aH['hardware_type_name'] = $row2['hardware_type_name'];
                                        $aH['hardware_image'] = $row2['hardware_image'];
                                        $aH['url'] = 'http://hashtaglabs.in/locosafety/uploads/' . $row2['hardware_image'];
                                        $aS['hardware_detail'][] = $aH;
                                    }
                                }
                                $aR['shop_detail'][] = $aS;
                            }
                        }
                    } elseif ($user_role == '5') {
                        $S = $OTh->getSectionListInch();
                        if ($S != null && mysqli_num_rows($S) >= 0) {
                            while ($row = mysqli_fetch_array($S)) {
                                $aS = array();
//                                $aS['shop_id'] = $row['shop_id'];
//                                $aS['shop_name'] = $row['shop_name'];
//                                $aS['section_id'] = $row['section_id'];
//                                $aS['section_code'] = $row['section_code'];
//                                $aS['section_name'] = $row['section_name'];
                                $OTh->section_id = $row['section_id'];
                                $Due = $OTh->dueCountSection();
                                if ($Due != null && mysqli_num_rows($Due) > 0) {
                                    while ($row_due = mysqli_fetch_array($Due)) {
                                        $aS['dueCount'] = $row_due['dueCount'];
                                    }
                                }
                                $Due = $OTh->overdueCountSection();
                                if ($Due != null && mysqli_num_rows($Due) > 0) {
                                    while ($row_due = mysqli_fetch_array($Due)) {
                                        $aS['overdueCount'] = $row_due['dueCount'];
                                    }
                                }
                                $H = $OTh->GetDueHardwareList();
                                if ($H != null && mysqli_num_rows($H) >= 0) {
                                    while ($row2 = mysqli_fetch_array($H)) {
                                        $aH = array();
                                        $aH['schedule_start_date'] = $row2['schedule_start_date'];
                                        $aH['hardware_category_name'] = $row2['hardware_category_name'];
                                        $aH['hardware_id'] = $row2['hardware_id'];
                                        $aH['hardware_category'] = $row2['hardware_category'];
                                        $aH['hardware_type'] = $row2['hardware_type'];
                                        $aH['hardware_code'] = $row2['hardware_code'];
                                        $aH['hardware_name'] = $row2['hardware_name'];
                                        $aH['hardware_model'] = $row2['hardware_model'];
                                        $aH['hardware_company'] = $row2['hardware_company'];
                                        $aH['schedule_frequency_count'] = $row2['schedule_frequency_count'];
                                        $aH['schedule_frequency_cycle'] = $row2['schedule_frequency_cycle'];
                                        $aH['hardware_type_name'] = $row2['hardware_type_name'];
                                        //new detail -22-11-2019 
                                        $aH['schedule_id'] = $row2['schedule_id'];
                                        $aH['map_id'] = $row2['map_id'];
                                        $aH['schedule_status'] = $row2['schedule_status'];
                                        $aH['hardware_serial_no'] = $row2['hardware_serial_no'];
                                        $aH['hardware_category_name'] = $row2['hardware_category_name'];
                                        $aH['hardware_type_name'] = $row2['hardware_type_name'];
                                        $aH['next_schedule_date'] = $row2['next_schedule_date'];
                                        $aH['hardware_type_name'] = $row2['hardware_type_name'];
                                        $aH['hardware_image'] = $row2['hardware_image'];
                                        $aH['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/'.$row['hardware_image'];
                                        $aS['hardware_detail'][] = $aH;
                                    }
                                }

                                $aR['shop_detail'][] = $aS;
                            }
                        }
                    } elseif ($user_role == '6') {
                        $S = $OTh->getMaintShopListInch();
                        if ($S != null && mysqli_num_rows($S) >= 0) {
                            while ($row = mysqli_fetch_array($S)) {
                                $aS = array();
                                $aS['maintenance_shop_id'] = $row['maintenance_shop_id'];
                                $OTh->maintenance_shop_id = $row['maintenance_shop_id'];
                                $T = $OTh->ticketListMaintenanceShop();
                                if ($T != null && mysqli_num_rows($T) > 0) {
                                    while ($row_tkt = mysqli_fetch_array($T)) {
                                        $aT = array();
                                        $aT['status'] = $row_tkt['status'];
                                        $aT['ticket_id'] = $row_tkt['ticket_id'];
                                        $aT['ticket_no'] = $row_tkt['ticket_no'];
                                        $aT['ticket_status'] = $row_tkt['ticket_status'];
                                        $aT['case_type'] = $row_tkt['case_type'];
                                        $aT['case_remarks'] = $row_tkt['case_remarks'];
                                        $aT['tickets_created_date'] = $row_tkt['tickets_created_date'];
                                        $aT['shop_name'] = $row_tkt['shop_name'];
                                        $aT['section_name'] = $row_tkt['section_name'];
                                        $aS['ticket_detail'][] = $aT;
                                    }
                                }
                                //$C = $OTh->ticketStatusCountMainSection();
                                $C = $OTh->ticketStatusCountMainShop();
                                if ($C != null && mysqli_num_rows($C) > 0) {
                                    while ($row_cnt = mysqli_fetch_array($C)) {
                                        $aC = array();
                                        $aC['fresh'] = $row_cnt['fresh'];
                                        $aC['pending'] = $row_cnt['pending'];
                                        $aC['Close'] = $row_cnt['Close'];
                                        $aS['ticket_count'][] = $aC;
                                    }
                                }
                                $aR['shop_detail'][] = $aS;
                            }
                        }
                    } elseif ($user_role == '7') {
                        $S = $OTh->getMaintShopListInch();
                        if ($S != null && mysqli_num_rows($S) >= 0) {
                            while ($row = mysqli_fetch_array($S)) {
                                $aS = array();
//                                $aS['maintenance_shop_id'] = $row['maintenance_shop_id'];
//                                $aS['maintenance_shop_name'] = $row['maintenance_shop_name'];
//                                $aS['maintenance_section_id'] = $row['maintenance_section_id'];
//                                $aS['default_hardware_cat'] = $row['default_hardware_cat'];
//                                $aS['maintenance_section_name'] = $row['maintenance_section_name'];

                                $OTh->maintenance_section_id = $row['maintenance_section_id'];
                                $T = $OTh->ticketListMainSection();
                                if ($T != null && mysqli_num_rows($T) >= 0) {
                                    while ($row_tkt = mysqli_fetch_array($T)) {
                                        $aT = array();
                                        $aT['status'] = $row_tkt['status'];
                                        $aT['ticket_id'] = $row_tkt['ticket_id'];
                                        $aT['ticket_no'] = $row_tkt['ticket_no'];
                                        $aT['ticket_status'] = $row_tkt['ticket_status'];
                                        $aT['case_type'] = $row_tkt['case_type'];
                                        $aT['case_remarks'] = $row_tkt['case_remarks'];
                                        $aT['tickets_created_date'] = $row_tkt['tickets_created_date'];
                                        $aT['shop_name'] = $row_tkt['shop_name'];
                                        $aT['section_name'] = $row_tkt['section_name'];
                                        $aS['ticket_detail'][] = $aT;
                                    }
                                }
                                $C = $OTh->ticketStatusCountMainSection();
                                if ($C != null && mysqli_num_rows($C) > 0) {
                                    while ($row_cnt = mysqli_fetch_array($C)) {
                                        $aC = array();
                                        $aC['fresh'] = $row_cnt['fresh'];
                                        $aC['pending'] = $row_cnt['pending'];
                                        $aC['Close'] = $row_cnt['Close'];
                                        $aS['ticket_count'][] = $aC;
                                    }
                                }
                                $aR['shop_detail'][] = $aS;
                            }
                        }
                    } else {
                        $arr["res_status"] = "401";
                    }
                }
                $arr["res_data"][] = $aR;
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "pieChartDataShop":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $OTh->shop_id = $JSON->shop_id;
            $OTh->date = $JSON->date;
            $sec = $OTh->checkShopExist();
            if ($sec != null && mysqli_num_rows($sec) > 0) {
                $R = $OTh->dueScheduleCountShop();
                if ($R != null && mysqli_num_rows($R) > 0) {
                    while ($row = mysqli_fetch_array($R)) {
                        $arr['dueCount'] = $row['dueCount'];
                    }
                }
                $T = $OTh->underTestingCountShop();
                if ($T != null && mysqli_num_rows($T) > 0) {
                    while ($row = mysqli_fetch_array($T)) {
                        $arr['underTestingCount'] = $row['testingCount'];
                    }
                }
                $A = $OTh->activeCountShop();
                if ($A != null && mysqli_num_rows($A) > 0) {
                    while ($row = mysqli_fetch_array($A)) {
                        $arr['activeCount'] = $row['activeCount'];
                    }
                }
                $OTh->new_date = date('Y-m-d', strtotime($JSON->date . ' + 5 days'));
                $U = $OTh->upcomingCountShop();
                if ($U != null && mysqli_num_rows($U) > 0) {
                    while ($row = mysqli_fetch_array($U)) {
                        $arr['upcomingCount'] = $row['upcomingCount'];
                    }
                }
                $Tkt = $OTh->raiseTicketCountShop();
                if ($Tkt != null && mysqli_num_rows($Tkt) > 0) {
                    while ($row = mysqli_fetch_array($Tkt)) {
                        $arr['ticketCount'] = $row['ticketCount'];
                    }
                }
                $S = $OTh->ticketListShop();
                if ($S != null && mysqli_num_rows($S) >= 0) {
                    while ($row = mysqli_fetch_array($S)) {
                        $aR['status'] = $row['status'];
                        $aR['ticket_id'] = $row['ticket_id'];
                        $aR['ticket_no'] = $row['ticket_no'];
                        $aR['shop_id'] = $row['shop_id'];
                        $aR['section_name'] = $row['section_name'];
                        $aR['shop_name'] = $row['shop_name'];
                        $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                        $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                        $aR['section_id'] = $row['section_id'];
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
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        //Preeti - 21-11-2019
        case "accountActivation":
            $OTh = new class_user();
            $OTh->user_mobile = $JSON->user_mobile;
            $U = $OTh->checkLogin();
            if ($U != null && mysqli_num_rows($U) > 0) {
                $R = $OTh->activateAccount();
                if ($R) {
                    $arr["res_status"] = "200";
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "Mobile number not exist or already active.";
            }
            break;
        //Preeti - 29-11-2019
        case "myWorkShopIncharge":
            $OTh = new class_user();
            $OTm = new class_master();
            $OTm->shop_id = $JSON->shop_id;
            $OTh->shop_id = $JSON->shop_id;
            $OTh->date = date('Y-m-d');
            $R = $OTm->getSectionList();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['section_id'] = $row['section_id'];
                    $aR['section_code'] = $row['section_code'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_name'] = $row['shop_name'];
                    $OTh->section_id = $row['section_id'];
                    
                    $Due = $OTh->dueCountShop();
                    if ($Due != null && mysqli_num_rows($Due) > 0) {
                        while ($row_due = mysqli_fetch_array($Due)) {
                            $aR['dueCount'] = $row_due['dueCount'];
                        }
                    }
                    $Due = $OTh->overdueCountShop();
                    if ($Due != null && mysqli_num_rows($Due) > 0) {
                        while ($row_due = mysqli_fetch_array($Due)) {
                            $aR['overdueCount'] = $row_due['overdueCount'];
                        }
                    }
                    $H = $OTh->GetDueHardwareList();
                    if ($H != null && mysqli_num_rows($H) >= 0) {
                        while ($row2 = mysqli_fetch_array($H)) {
                            $aH = array();
                            $aH['schedule_start_date'] = $row2['schedule_start_date'];
                            $aH['hardware_id'] = $row2['hardware_id'];
                            $aH['hardware_category'] = $row2['hardware_category'];
                            $aH['hardware_type'] = $row2['hardware_type'];
                            $aH['hardware_code'] = $row2['hardware_code'];
                            $aH['hardware_name'] = $row2['hardware_name'];
                            $aH['hardware_model'] = $row2['hardware_model'];
                            $aH['hardware_company'] = $row2['hardware_company'];
                            $aH['schedule_frequency_count'] = $row2['schedule_frequency_count'];
                            $aH['schedule_frequency_cycle'] = $row2['schedule_frequency_cycle'];
                            //new detail -22-11-2019 
                            $aH['schedule_id'] = $row2['schedule_id'];
                            $aH['map_id'] = $row2['map_id'];
                            $aH['schedule_status'] = $row2['schedule_status'];
                            $aH['hardware_serial_no'] = $row2['hardware_serial_no'];
                            $aH['hardware_category_name'] = $row2['hardware_category_name'];
                            $aH['hardware_type_name'] = $row2['hardware_type_name'];
                            $aH['next_schedule_date'] = $row2['next_schedule_date'];
                            $aH['hardware_type_name'] = $row2['hardware_type_name'];
                            $aH['hardware_image'] = $row2['hardware_image'];
                            $aH['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/'.$row2['hardware_image'];
                            $aR['hardware_detail'][] = $aH;
                        }
                    }
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            }else{
                $arr["res_status"] = "401";
            }
            break;
        //Preeti - 09-12-2019
        case "forceFullLogout":
            $OTh = new class_user();
            $OTh->user_info_id = $JSON->user_info_id;
            $user_device_id = $JSON->user_device_id;
            $Chk = $OTh->getDeviceId();
            if ($Chk != null && mysqli_num_rows($Chk) > 0) {
                $aR = array();
                while($row = mysqli_fetch_array($Chk)){
                    $aR['user_device_id'] = $row['user_device_id'];
                }
                if($aR['user_device_id'] == $user_device_id){
                    $arr["res_msg"] = "same";   
                }else{
                    $arr["res_msg"] = "diff";
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        //------------------------------------
 
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
            if ($RES == "VALID") {
                $RSET = $OTh->ReturnResultSet();
                $ROW_DATA = mysqli_fetch_assoc($RSET);
                if ($ROW_DATA["user_info_id"] == 'INVALID') {
                    $arr["res_status"] = "401";
                    $arr["res_msg_code"] = $RES;
                    $arr["res_message"] = "Invalid email ID or password.";
                } else {
//                    $ROW_DATA["user_profile_pic"] = empty($ROW_DATA["user_profile_pic"]) ? "" : $siteurl_upload . $ROW_DATA["user_id"] . '/' . $ROW_DATA["user_profile_pic"];

                    $arr["res_status"] = "200";
                    $arr["res_msg_code"] = $RES;
                    $arr["res_message"] = "User authenticated.";
                    $ROW_DATA["maintenance_shop_id"] = $ROW_DATA["maintenance_shop_id"];
                    $ROW_DATA["user_info_id"] = $ROW_DATA["user_info_id"];
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