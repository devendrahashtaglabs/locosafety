<?php

header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_master.php';
include_once 'classes/class_common.php';
include_once 'classes/class_maintenance.php';
include_once 'classes/class_notification.php';
$RES = "";
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
    $Obj = new class_master();
    switch ($action) {
//      Preeti-13-11-2019
        case "sectionList":
            $OTh = new class_master();
            $OTh->shop_id = $JSON->shop_id;
            $R = $OTh->getSectionList();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['section_id'] = $row['section_id'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['shop_name'] = $row['shop_name'];
                    $aR['section_code'] = $row['section_code'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['section_add_date'] = $row['section_add_date'];
                    $OTh->section_id = $row['section_id'];
                    $OTh->zone_id = $row['zone_id'];
                    $OTh->division_id = $row['division_id'];
                    $S = $OTh->getSectionDetail();
                    if ($S != null && mysqli_num_rows($S) >= 0) {
                        while ($row1 = mysqli_fetch_array($S)) {
                            $aS = array();
                            //reset($aS);
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

                    $OTh->section_id = $aR['section_id'];
                    $OTh->shop_id = $aR['shop_id'];
                    $cat = $OTh->getCategory();
                    if ($cat != null && mysqli_num_rows($cat) > 0) {
                        $aS = array();
                        while ($row_cat = mysqli_fetch_array($cat)) {
                            $aS['category_code'] = $row_cat['category_code'];
                            $aS['category_name'] = $row_cat['category_name'];
                            $OTh->hardware_category = $aS['id'] = $row_cat['id'];
                            $cat_del = $OTh->getCategoryWiseSec();
                            if ($cat_del != null && mysqli_num_rows($cat_del) >= 0) {
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
                    // 11-12-2019
                    $ticketCount = $OTh->getTicketCountSection();
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
                    $ticketCount = $OTh->ticketCount();
                    $hardwareCount = $OTh->hardwareCount();
                    $inchargeDetail = $OTh->inchargeDetail();
                    if ($hardwareCount) {
                        while ($row2 = mysqli_fetch_array($hardwareCount)) {
                            $aR['hardware_active'] = $row2['active_hardware'];
                            $aR['hardware_count'] = $row2['total_hardware'];
                        }
                    }
                    if ($inchargeDetail) {
                        while ($row3 = mysqli_fetch_array($inchargeDetail)) {
                            $aR['user_f_name'] = empty($row3['user_f_name']) ? "NA" : $row3['user_f_name'];
                            $aR['user_l_name'] = empty($row3['user_l_name']) ? "NA" : $row3['user_l_name'];
                            $aR['user_mobile'] = empty($row3['user_mobile']) ? "NA" : $row3['user_mobile'];
                        }
                    }
                    $dueHardware = $OTh->dueScheduleCount();
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
            }
            break;
        case "maintenanceShopList":
            $OTh = new class_master();
            $OTh->zone_id = $JSON->zone_id;
            $OTh->division_id = $JSON->division_id;
            $R = $OTh->maintenanceShopList();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                $i = 0;
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['maintenance_shop_status'] = $row['maintenance_shop_status'];
                    $aR['maintenance_shop_add_date'] = $row['maintenance_shop_add_date'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "maintenanceSectionListByShop":
            $OTh = new class_master();
            $OTh->maintenance_shop_id = $JSON->maintenance_shop_id;
            $R = $OTh->maintenanceSectionListByShop();
            $aR = array();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR['category_name'] = $row['category_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
					//$OTm->maintenance_section_id = $OTh->maintenance_section_id = $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                    $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                    
                    $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                    $aR['default_hardware_cat'] = $row['default_hardware_cat'];
                    $aR['maintenance_section_code'] = $row['maintenance_section_code'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_section_status'] = $row['maintenance_section_status'];
                    $OTh->maintenance_section_id = $row['maintenance_section_id'];
                    $OTh->zone_id = $row['zone_id'];
                    $OTh->division_id = $row['division_id'];
                    $S = $OTh->getMaintenanceSectionDetail();
                   
                    if ($S != null && mysqli_num_rows($S) > 0) {
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
                            $aS['url'] = 'http://hashtaglabs.in/locosafety/uploads/'.$row1['user_profile_pic'];
                            $aS['user_address'] = $row1['user_address'];
                            $aS['user_address'] = $row1['user_address'];
                            $aS['user_address'] = $row1['user_address'];
                            $aR['section_incharge_detail'][] = $aS;
                            
                        }
                    }
                    // 11-12-2019
                    $cat = $OTh->getCategory();
                    $i=0;
                    if ($cat != null && mysqli_num_rows($cat) > 0) {                    
                        $aB = array();
                        while ($row_cat = mysqli_fetch_array($cat)) {
                            $aB['category_code'] = $row_cat['category_code'];
                            $aB['category_name'] = $row_cat['category_name'];
                            $OTh->hardware_category = $aB['id'] = $row_cat['id'];
                            $cat_del = $OTh->getCategoryMainSec();
                            if($cat_del != null && mysqli_num_rows($cat_del) >= 0){
                                $cD = array();
                                while ($cat_row = mysqli_fetch_array($cat_del)) {
                                    $cD['Open'] = $cat_row['Open'];
                                    $cD['fresh'] = $cat_row['fresh'];
                                    $cD['Under Maintenance'] = $cat_row['Under Maintenance'];
                                    $cD['Breakdown'] = $cat_row['Breakdown'];
                                    $cD['Close'] = $cat_row['Close'];
                                    $cD['Total'] = $cat_row['Total'];
                                    $aB['category_ticket_count'] = $cD;
                                }
                            }                                
                            $aR['category'][$i] = $aB;
                            $i++;
                        }
                    }
                    $C = $OTh->ticketStatusCountMainSection();
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
                            $aR['ticket_count'][0] = $aC;
                        }
                    }
                    
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "sectionHardwareCategoryList":
            $OTh = new class_master();
            $OTh->section_id = $JSON->section_id;
            $R = $OTh->hardwareListByCategory();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['category_name'] = $row['category_name'];
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_code'] = $row['hardware_code'];
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['hardware_company'] = $row['hardware_company'];
                    $aR['default_maintenance_shop'] = $row['default_maintenance_shop'];
                    $aR['default_maintenance_section'] = $row['default_maintenance_section'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['schedule_frequency_count'] = $row['schedule_frequency_count'];
                    $aR['schedule_frequency_cycle'] = $row['schedule_frequency_cycle'];
                    $aR['hardware_image'] = $row['hardware_image'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['shop_name'] = $row['shop_name'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "hardwareCategoryList":
            $OTh = new class_master();
            $R = $OTh->hardwareCategoryList();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['category_id'] = $row['id'];
                    $aR['category_code'] = $row['category_code'];
                    $aR['category_name'] = $row['category_name'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "hardwareListBySectionCat":
            $OTh = new class_master();
            $OTh->section_id = $JSON->section_id;
            $OTh->hardware_category = $JSON->hardware_category;
            $R = $OTh->hardwareListBySectionCat();
            if ($R != null && mysqli_num_rows($R) > 0) {
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['map_id'] = $row['map_id'];
                    $aR['schedule_start_date'] = $row['schedule_start_date'];
                    $aR['next_schedule_date'] = $row['next_schedule_date'];
                    $aR['schedule_status'] = $row['schedule_status'];
                    $aR['category_name'] = $row['category_name'];
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_code'] = $row['hardware_code'];
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['hardware_company'] = $row['hardware_company'];
                    $aR['default_maintenance_shop'] = $row['default_maintenance_shop'];
                    $aR['default_maintenance_section'] = $row['default_maintenance_section'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['schedule_frequency_count'] = $row['schedule_frequency_count'];
                    $aR['schedule_frequency_cycle'] = $row['schedule_frequency_cycle'];
                    $aR['hardware_image'] = $row['hardware_image'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['shop_name'] = $row['shop_name'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "hardwareSerialNoList":
            $OTh = new class_master();
            $OTh->hardware_category = $JSON->hardware_category;
            $OTh->maintenance_section_id = $JSON->maintenance_section_id;
            $R = $OTh->getHardwareSerialNoList();
            if ($R != null && mysqli_num_rows($R) >= 0) {
                $aR = array();
                while ($row = mysqli_fetch_array($R)) {
                    $aR['hardware_type_name'] = $row['hardware_type_name'];
                    $aR['category_name'] = $row['category_name'];
                    $aR['hardware_category'] = $row['hardware_category'];
                    $aR['hardware_type'] = $row['hardware_type'];
                    $aR['hardware_code'] = $row['hardware_code'];
                    $aR['hardware_name'] = $row['hardware_name'];
                    $aR['hardware_model'] = $row['hardware_model'];
                    $aR['hardware_company'] = $row['hardware_company'];
                    $aR['schedule_frequency_count'] = $row['schedule_frequency_count'];
                    $aR['schedule_frequency_cycle'] = $row['schedule_frequency_cycle'];
                    $aR['hardware_image'] = $row['hardware_image'];
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/' . $row['hardware_image'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['map_id'] = $row['map_id'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['map_status'] = $row['map_status'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
//------------------------------------------------------------------------------

        case "test_noti":
            $ObjN = new class_notification();
            $RES = $ObjN->testForHimanshu();
            $arr["res_status"] = $RES;
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