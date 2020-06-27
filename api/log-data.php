<?php


header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_common.php';
include_once 'classes/class_log.php';

$siteurl_upload = class_api::get_site_url() . "uploads/";
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
    switch ($action) {
        case "i_vol_log":
            $OTh = new class_log();
            $OTh->user_id = $JSON->user_id;
            $OTh->event_id = $JSON->event_id;
            $OTh->shift_id = $JSON->shift_id;
            $OTh->log_track_time = $JSON->log_track_time;
            $OTh->log_latitude = $JSON->log_latitude;
            $OTh->log_longitude = $JSON->log_longitude;
            $RES = $OTh->InsertVOLLog();
            if ($RES == "INVALID") {
                $arr["res_status"] = "401";
                $arr["res_message"] = $RES;
            } else {
                $arr["res_status"] = "200";
                $a = array();
                $arr["res_data"] = $RES;
            }
            break;

        case "get_vol_tracking_log":
            $OTh = new class_log();
            $OTh->user_id = $JSON->user_id;
            $OTh->event_id = $JSON->event_id;
            $OTh->shift_id = $JSON->shift_id;
            $RES = $OTh->GetVolLogDetails();
            if ($RES == "OK") {
                $RSET = $OTh->ReturnResultSet();
                $aD = array();
                while ($ROW_DATA = mysqli_fetch_array($RSET)) {
                    $aD[] = array(
                        'user_id' => empty($ROW_DATA["user_id"]) ? "" : $ROW_DATA["user_id"],
                        'event_id' => empty($ROW_DATA["event_id"]) ? "" : $ROW_DATA["event_id"],
                        'shift_id' => empty($ROW_DATA["shift_id"]) ? "" : $ROW_DATA["shift_id"],
                        'log_track_time' => empty($ROW_DATA["log_track_time"]) ? "" : date("m-d-Y h:s:i", strtotime($ROW_DATA["log_track_time"])),
                        'log_latitude' => empty($ROW_DATA["log_latitude"]) ? "" : $ROW_DATA["log_latitude"],
                        'log_longitude' => empty($ROW_DATA["log_longitude"]) ? "" : $ROW_DATA["log_longitude"],
                        'log_status' => empty($ROW_DATA["log_status"]) ? "" : $ROW_DATA["log_status"],
                        'log_add_date' => empty($ROW_DATA["log_add_date"]) ? "" : date("m-d-Y h:s:i", strtotime($ROW_DATA["log_add_date"]))
                    );
                }
               // print_r($aD);die;
                $arr["res_data"] = $aD;
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