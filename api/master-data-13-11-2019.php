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
        
          case "sgrade":
            $R = $Obj->SelectMasterGrade();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["id"] = $row["id"];
                    $aR["grade_number"] = $row["grade_number"];
                    $aR["grade_name"] = $row["grade_name"];
                    $arr["res_data"][] = $aR;
                }
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
        case "sschool":
            $R = $Obj->SelectSchool();
            if ($R != null && mysqli_num_rows($R) > 0) {
                $arr["res_status"] = "200";
                while ($row = mysqli_fetch_array($R)) {
                    $aR = array();
                    $aR["user_id"] = $row["hsa_id"];
                    $aR["school_id"] = $row["school_id"];
                    $aR["school_name"] = empty($row["school_name"]) ? "" : ($row["school_name"]);
                    $arr["res_data"][] = $aR;
                }
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