<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_log
 *
 * @author #Arun
 */
class class_log {

    //put your code here
    public $user_id, $user_type, $user_device, $event_id, $shift_id, $log_track_time, $log_latitude, $log_longitude;

    function __construct() {
        $this->ObjDB = new class_db();
    }

    public function ReturnResultSet() {
        return $this->R_SET;
    }

    public function InsertVOLLog() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_event_id"] = $this->event_id;
        $arrParam["in_shift_id"] = $this->shift_id;
        $arrParam["in_log_track_time"] = $this->log_track_time;
        $arrParam["in_log_latitude"] = $this->log_latitude;
        $arrParam["in_log_longitude"] = $this->log_longitude;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "insert_log_vol_tracking_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

    public function GetVolLogDetails() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $arrParam["in_event_id"] = $this->event_id;
        $arrParam["in_shift_id"] = $this->shift_id;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "select_log_vol_tracking_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }

}
