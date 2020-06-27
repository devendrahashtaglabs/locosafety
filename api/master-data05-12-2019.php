<?php

header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_master.php';
include_once 'classes/class_common.php';
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
            //$OTh->user_info_id = $JSON->user_info_id;
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
                    $S = $OTh->getSectionDetail();
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
                            $aS['url'] = 'http://hashtaglabs.in/locosafety/uploads/'.$row1['user_profile_pic'];
                            $aS['user_address'] = $row1['user_address'];
                            $aS['user_address'] = $row1['user_address'];
                            $aS['user_address'] = $row1['user_address'];
                            $aR['section_incharge_detail'][] = $aS;
                        }
                    }
                    
                    $OTh->section_id = $aR['section_id'];
                    $OTh->shop_id = $aR['shop_id'];
                    $ticketCount = $OTh->ticketCount();
                    $hardwareCount = $OTh->hardwareCount();
                    $inchargeDetail = $OTh->inchargeDetail();
                    $categoryDetail = $OTh->categoryDetail();
                    if($ticketCount){
                        while ($row1 = mysqli_fetch_array($ticketCount)) {
                            $aR['ticket_count'] = $row1['total'];
                        }
                    }
                    if($hardwareCount){
                        while ($row2 = mysqli_fetch_array($hardwareCount)) {
                            $aR['hardware_count'] = $row2['total_hardware'];
                        }
                    }
                    if($inchargeDetail){
                        while ($row3 = mysqli_fetch_array($inchargeDetail)) {
                            $aR['user_f_name'] = empty($row3['user_f_name']) ? "NA" : $row3['user_f_name'];
                            $aR['user_l_name'] = empty($row3['user_l_name']) ? "NA" : $row3['user_l_name'];
                            $aR['user_mobile'] = empty($row3['user_mobile']) ? "NA" : $row3['user_mobile'];
                        }
                    }
                    if($categoryDetail){
                        while ($row4 = mysqli_fetch_array($categoryDetail)) {
                            $aC = array();
                            $aC['category_name'] = $row4['category_name'];
                            $aC['hardware_category'] = $row4['hardware_category'];
                            $aC['cat_hardware_count'] = $row4['hardware_count'];
                            $aR['category_detail'][] = $aC;
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
            if ($R != null && mysqli_num_rows($R) >= 0) {
                $i = 0;
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR['category_name'] = $row['category_name'];
                    $aR['maintenance_shop_name'] = $row['maintenance_shop_name'];
                    $aR['maintenance_section_id'] = $row['maintenance_section_id'];
                    $aR['maintenance_shop_id'] = $row['maintenance_shop_id'];
                    $aR['default_hardware_cat'] = $row['default_hardware_cat'];
                    $aR['maintenance_section_code'] = $row['maintenance_section_code'];
                    $aR['maintenance_section_name'] = $row['maintenance_section_name'];
                    $aR['maintenance_section_status'] = $row['maintenance_section_status'];
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
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/'.$row['hardware_image'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['shop_name'] = $row['shop_name'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            }else{
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
            }else{
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
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/'.$row['hardware_image'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['section_id'] = $row['section_id'];
                    $aR['section_name'] = $row['section_name'];
                    $aR['shop_id'] = $row['shop_id'];
                    $aR['shop_name'] = $row['shop_name'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            }else{
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
                    $aR['url'] = 'http://hashtaglabs.in/locosafety/uploads/hardware/'.$row['hardware_image'];
                    $aR['hardware_status'] = $row['hardware_status'];
                    $aR['map_id'] = $row['map_id'];
                    $aR['hardware_id'] = $row['hardware_id'];
                    $aR['hardware_serial_no'] = $row['hardware_serial_no'];
                    $aR['map_status'] = $row['map_status'];
                    $arr["res_data"][] = $aR;
                }
                $arr["res_status"] = "200";
            }else{
                $arr["res_status"] = "401";
            }
            break;
//------------------------------------------------------------------------------
        case "scategory":
            $R = $Obj->SelectMasterCategory();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $aR = array();
                while ($row = mysqli_fetch_array($R)) {
                    $aR[] = $row;
                }
                $arr["res_data"] = $aR;
                unset($aR);
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;

        case "scategorylist":
            $Obj->parent_category_id = $JSON->parent_category_id;
            $R = $Obj->SelectCategory();
            if ($R != null && mysqli_num_rows($R) > 0) {

                $aR = array();
                while ($row = mysqli_fetch_array($R)) {
                    $aR[] = $row;
                }
                $arr["res_data"] = $aR;
                unset($aR);
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;

        case "test_noti":
            $ObjN = new class_notification();
            $RES = $ObjN->testForHimanshu();
            $arr["res_status"] = $RES;
            break;
        case "orgname":
            $R = $Obj->SelectOrg();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["org_id"] = $row["user_id"];
                    $aR["org_name"] = $row["org_name"];
                    $arr["res_data"][] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "s_type":
            $R = $Obj->SelectType();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $aR = array();
                while ($row = mysqli_fetch_array($R)) {
                    $aR[] = $row;
                }
                $arr["res_data"] = $aR;
                unset($aR);
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
            
            
        case "stypelist":
            $Obj->parent_type_id = $JSON->parent_type_id;
            $R = $Obj->SelectTypeList();
            if ($R != null && mysqli_num_rows($R) > 0) {

                $aR = array();
                while ($row = mysqli_fetch_array($R)) {
                    $aR[] = $row;
                }
                $arr["res_data"] = $aR;
                unset($aR);
                $arr["res_status"] = "200";
            } else {
                $arr["res_status"] = "401";
            }
            break;
            
            
        case "sethnicity":
            $R = $Obj->SelectEthnicity();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["ethnicity_id"] = $row["ethnicity_id"];
                    $aR["ethnicity_code"] = $row["ethnicity_code"];
                    $aR["ethnicity_name"] = $row["ethnicity_name"];
                    $arr["res_data"][] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "sevents":
            $R = $Obj->SelectEventType();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["event_type_id"] = $row["event_type_id"];
                    $aR["event_type"] = $row["event_type"];
                    $aR["event_type_name"] = $row["event_type_name"];
                    $arr["res_data"][] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "stimezone":
            $R = $Obj->SelectTimeZone();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["timezone_id"] = $row["timezone_id"];
                    $aR["timezone_code"] = $row["timezone_code"];
                    $aR["timezone_hours"] = $row["timezone_hours"];
                    $aR["timezone_name"] = $row["timezone_name"];
                    $arr["res_data"][] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "scountry":
            $R = $Obj->SelectCountry();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["country_id"] = $row["country_id"];
                    $aR["country_code"] = $row["country_code"];
                    $aR["country_name"] = $row["country_name"];
                    $arr["res_data"][] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "sstate":
            $Obj->country_id = $JSON->country_id;
            $R = $Obj->SelectState();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["state_id"] = $row["state_id"];
                    $aR["state_code"] = $row["state_code"];
                    $aR["state_name"] = $row["state_name"];
                    $arr["res_data"][] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
            }
            break;
        case "sdoctype":
            $R = $Obj->SelectDocType();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["document_type_id"] = $row["document_type_id"];
                    $aR["document_type"] = $row["document_type"];
                    $aR["document_type_name"] = $row["document_type_name"];
                    $arr["res_data"][] = $aR;
                }
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