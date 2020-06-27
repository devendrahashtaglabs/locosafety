<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_cso
 *
 * @author HashTagLabs
 */
include_once 'class_db.php';
include_once 'class_common.php';

class class_search {

    //put your code here

    public $event_type_id, $event_heading, $event_details, $event_address, $event_country, $event_state, $event_city, $event_postcode, $event_timezone, $event_latitude, $event_longitude, $event_email, $event_phone, $event_image, $event_register_start_date, $event_register_end_date, $event_add_date, $event_update_date;
    public $user_id, $cso_id, $shift_id, $event_id, $shift_date, $shift_vol_req, $shift_start_time, $shift_end_time, $shift_rank, $shift_task, $shift_status, $shift_add_date, $shift_update_date;
    public $ObjDB;
    public $R_SET;
    public $blog_id, $blog_category, $blog_title, $blog_short_desc, $blog_long_desc, $blog_likes, $blog_dislikes, $blog_comments, $blog_status, $blog_created_date, $blog_updated_date;
    public $user_id_file, $user_file_title, $user_type, $user_device, $search_keyword, $seach_row_number, $search_page_size, $map_add_date, $search_city, $search_state, $search_postcode, $search_event_type, $search_organisation;
    public $current_date;

    function __construct() {
        $this->ObjDB = new class_db();
    }

    public function ReturnResultSet() {
        return $this->R_SET;
    }

    
      public function GetUserDevice() {
        $ObjDB = new class_db();
        //$S = "UPDATE mrupaynotify SET NoticeStatus = '0' WHERE NoticeID = '" . $this->NoticeID . "'";
        $S = "SELECT m.map_id, m.cso_id, c.csoa_id, f.user_device AS device_id, f.user_type FROM map_user_event_tbl m 
LEFT JOIN csoa_tbl c ON m.cso_id = c.cso_id LEFT JOIN firebase_tbl f ON c.csoa_id = f.user_id
WHERE m.map_id  = '" . $this->map_id . "' AND f.user_device != ''";

        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();

        return $R;
    }
    
    
    public function IEvRequest() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_event_id"] = $this->event_id;
        $arrParam["in_cso_id"] = $this->cso_id;
        $arrParam["in_shift_id"] = $this->shift_id;
        $arrParam["in_map_add_date"] = $this->map_add_date;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "insert_event_request_sp";
        $RES = $this->ObjDB->ExecuteSP(); /**/
        return $RES;
    }

    public function SearchEvents() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_search_keyword"] = $this->search_keyword;
        $arrParam["in_seach_row_number"] = $this->seach_row_number;
        $arrParam["in_search_page_size"] = $this->search_page_size;
        $arrParam["in_current_date"] = $this->current_date;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "search_events_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }

    public function SearchEventsFilter() {
        $RES = "";
//        $arrParam = array();
//        $arrParam["in_search_keyword"] = $this->search_keyword;
//        $arrParam["in_seach_row_number"] = $this->seach_row_number;
//        $arrParam["in_search_page_size"] = $this->search_page_size;
//        $arrParam["in_search_city"] = $this->search_city;
//        $arrParam["in_search_state"] = $this->search_state;
//        $arrParam["in_search_postcode"] = $this->search_postcode;
//        $arrParam["in_search_event_type"] = $this->search_event_type;
        //$arrParam["in_search_organisation"] = $this->search_organisation;
        //$this->ObjDB->param_array = $arrParam;
        /*
        $S = "SELECT master_state_tbl.state_name, master_country_tbl.country_name, master_event_type_tbl.event_type_name, event_tbl.* 
FROM event_tbl, master_event_type_tbl, master_country_tbl, master_state_tbl
WHERE master_event_type_tbl.event_type_id = event_tbl.event_type_id
AND master_country_tbl.country_id = event_tbl.event_country
AND master_state_tbl.state_id = event_tbl.event_state
AND event_tbl.event_status = '10'";
        $sub = empty($this->search_state) ? "" : " AND event_tbl.event_state = '" . $this->search_state . "'";
        $sub .= empty($this->search_city) ? "" : " AND event_tbl.event_city LIKE CONCAT('%','" . $this->search_city . "','%')";
        $sub .= empty($this->search_keyword) ? "" : " AND event_tbl.event_heading LIKE CONCAT('%','" . $this->search_keyword . "','%')";
        $sub .= empty($this->search_postcode) ? "" : " AND event_tbl.event_postcode = '" . $this->search_postcode . "'";
        $sub .= empty($this->search_event_type) ? "" : " AND event_tbl.event_type_id = '" . $this->search_event_type . "'";
        $sub .= " AND event_tbl.event_registration_end_date >= '" . $this->current_date . "' ";
        $S .= $sub . " ORDER BY event_tbl.event_add_date DESC LIMIT " . $this->seach_row_number . " , " . $this->search_page_size;*/
        $S = "SELECT master_state_tbl.state_name, master_country_tbl.country_name, master_event_type_tbl.event_type_name,cso_tbl.cso_name AS org_name, event_tbl.* 
FROM event_tbl, master_event_type_tbl, master_country_tbl, master_state_tbl, cso_tbl
WHERE master_event_type_tbl.event_type_id = event_tbl.event_type_id AND event_tbl.cso_id = cso_tbl.cso_id
AND master_country_tbl.country_id = event_tbl.event_country
AND master_state_tbl.state_id = event_tbl.event_state
AND event_tbl.event_status = '10'";
        $sub = empty($this->search_state) ? "" : " AND event_tbl.event_state = (SELECT state_id FROM master_state_tbl WHERE state_name = '" . $this->search_state . "') ";
        $sub .= empty($this->search_city) ? "" : " AND event_tbl.event_city LIKE CONCAT('%','".$this->search_city."','%')";
        $sub .= empty($this->search_keyword) ? "" : " AND event_tbl.event_heading LIKE CONCAT('%','".$this->search_keyword."','%')";
        $sub .= empty($this->search_postcode) ? "" : " AND event_tbl.event_postcode = '".$this->search_postcode."'";
        $sub .= empty($this->search_event_type) ? "" : " AND event_tbl.event_type_id IN (SELECT event_type_id FROM master_event_type_tbl WHERE event_type_name LIKE CONCAT ('%','".$this->search_event_type."','%'))";
        $sub .= empty($this->search_org) ? "" : " AND cso_tbl.cso_name LIKE CONCAT('%', '".$this->search_org."','%') ";
      //  $sub .= " AND event_tbl.event_register_end_date >= '" . $this->current_date . "' ";
       // $sub .= empty($this->search_org) ? "" : " AND cso_tbl.cso_name LIKE CONCAT('%',".$this->search_org."','%')";
       $S .= $sub . " ORDER BY event_tbl.event_add_date DESC LIMIT ".$this->seach_row_number." , ".$this->search_page_size;
        $this->ObjDB->sproc_name = $S; //"search_events_filter_sp";
//        print_r($S);die;
        $R = $this->ObjDB->SelectQuery();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        
        return $RES;
    }

    public function GetVolShift() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_event_id"] = $this->event_id;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "get_all_shift_vol";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }
  public function InsertNotification() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_map_id"] = $this->map_id;
        $arrParam["in_notification_title"] = $this->Title;
        $arrParam["in_notification_msg"] = $this->Msg;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "insert_noti_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }
    
    
}
