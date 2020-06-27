<?php

header("Access-Control-Allow-Origin: *");
include_once 'classes/class_api.php';
include_once 'classes/class_cso.php';
include_once 'classes/class_user.php';
include_once 'classes/class_common.php';

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
    switch ($action) {

        case "event_doc_upload":
            if (is_uploaded_file($_FILES['event_waiver_doc']['tmp_name'])) {
                $file_size = $_FILES["event_waiver_doc"]["size"];
                if ($file_size > 2000000) {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "FILESIZE";
                } else {
                    //$UserFileTitle = $_REQUEST['event_title'];
                    $EventID = $_REQUEST["event_id"]; // strtolower(str_replace(' ', '-', class_common::StripSpecialChars($UserFileTitle)));
                    $UserID = $_REQUEST['user_id'];
                    //$dir = '../../../blueprint/uploads/' . $UserID . '/events/';
                 //   $dir = 'D://HIMANSHU MISHRA/Upload Files/' . $UserID . '/'; //Local URL
                   $dir = '../uploads/' . $UserID . '/events/';
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }
                    $ext = pathinfo($_FILES['event_waiver_doc']['name'], PATHINFO_EXTENSION);
                    $doc = "EVW-" . $EventID . '.' . $ext;
                    $tmp_name = $_FILES['event_waiver_doc']['tmp_name'];
                    $doc_name = $_FILES['event_waiver_doc']['name'];
                    move_uploaded_file($tmp_name, $dir . $doc);

                    $OTh = new class_cso();
                    $OTh->user_id = $UserID;
                    $OTh->event_waiver_doc = $doc;
                    $OTh->event_id = $EventID;

                    $RES = $OTh->UCSOEventWaiverDoc();

                    $arr["res_status"] = "200";
                    $arr["res_message"] = "FILEUP";
                    $aR["event_waiver_doc"] = $siteurl_upload . $UserID . "/events/" . $doc;
                    $arr["res_data"] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "NOFILE";
            }
            break;



        case "doc_locker_file_upload":
            if (is_uploaded_file($_FILES['document_file_name']['tmp_name'])) {
                $file_size = $_FILES["document_file_name"]["size"];
                if ($file_size > 2000000) {
                    $arr["res_status"] = "401";
                    $arr["res_msg_code"] = "FILESIZE";
                    $arr["res_message"] = "Please upload file not more than 2MB.";
                } else {
                    //$UserFileTitle = $_REQUEST['event_title'];
                    //$DocID = $_REQUEST["document_id"]; // strtolower(str_replace(' ', '-', class_common::StripSpecialChars($UserFileTitle)));
                    $UserID = $_REQUEST['user_id'];
                    //user_type, user_device                    
                    $DocType = $_REQUEST['document_type']; //id from master document type
                    $DocName = $_REQUEST['document_name']; //name that is entered in textbox
                    // $dir = '../../../blueprint/uploads/' . $UserID . '/'; // Blueprint URL
                    //$dir = 'D://HIMANSHU MISHRA/Upload Files/' . $UserID . '/'; //Local URL
                    $dir = '../uploads/' . $UserID . '/'; //Staging URL
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }
                    $ext = pathinfo($_FILES['document_file_name']['name'], PATHINFO_EXTENSION);
                    $image = str_replace(" ", "_", strtolower($DocName . '_' . $DocType)) . '.' . $ext; //"DOC-" . $DocID . '.' . $ext;
                    $tmp_name = $_FILES['document_file_name']['tmp_name'];
                    $doc_name = $_FILES['document_file_name']['name'];


                    $OTh = new class_cso();
                    $OTh->user_id = $UserID;
                    $OTh->user_device = '';
                    $OTh->user_type = '';
                    $OTh->document_file_name = $image;
                    //$OTh->document_id = $DocID;
                    $OTh->document_type = $DocType;
                    $OTh->document_name = $DocName;

                    $RES = $OTh->ULockerDocument();

                    If ($RES == 'FILEEXISTS') {
                        $arr["res_status"] = "401";
                        $arr["res_message_code"] = "FILEEXISTS";
                        $arr["res_message"] = "File already exists";
                    } else {
                        move_uploaded_file($tmp_name, $dir . $image);
                        $arr["res_status"] = "200";
                        $arr["res_msg_code"] = $RES = "OK" ? "FILESAVE" : "FILEUPDATE";
                        $arr["res_message"] = $RES = "OK" ? "File save successfully." : "File updated successfully.";
                        $aR["document_file_name"] = $siteurl_upload . $UserID . "/" . $image;
                        $arr["res_data"] = $aR;
                    }
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message_code"] = "NOFILE";
                $arr["res_message"] = "FILEEXISTS";
            }
            break;
        case "user_cover_pic_upload":
            if (is_uploaded_file($_FILES['user_cover_pic']['tmp_name'])) {
                $file_size = $_FILES["user_cover_pic"]["size"];
                if ($file_size > 2000000) {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "FILESIZE";
                } else {
                    $UserID = $_REQUEST['user_id'];
                    //$fileExtension = $_REQUEST['file_ext'];
                    //$dir = '../../../blueprint/uploads/' . $UserID . '/';
                    $dir = '../uploads/' . $UserID . '/'; //Staging URL
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }
                    $ext = pathinfo($_FILES['user_cover_pic']['name'], PATHINFO_EXTENSION);
                    //$imageTittle = str_replace(" ", "-", strtolower($_REQUEST['user_file_title']));
                    $image = 'cov-' . $UserID . '.' . $ext;
                    $tmp_name = $_FILES['user_cover_pic']['tmp_name'];
                    $doc_name = $_FILES['user_cover_pic']['name'];
                    move_uploaded_file($tmp_name, $dir . $image);
                    $OTh = new class_user();
                    $OTh->user_id = $UserID;
                    $OTh->user_cover_pic = $image;
                    $RES = $OTh->UserCoverPic();
                    $arr["res_status"] = "200";
                    $arr["res_message"] = "FILEUP";
                    $aR["user_cover_pic"] = $siteurl_upload . $UserID . "/" . $image;
                    $arr["res_data"] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "NOFILE";
            }
            break;
        case "user_profile_pic_upload":
            if (is_uploaded_file($_FILES['user_profile_pic']['tmp_name'])) {
                $file_size = $_FILES["user_profile_pic"]["size"];
                if ($file_size > 2000000) {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "FILESIZE";
                } else {
                    $UserID = $_REQUEST['user_id'];
                    //$fileExtension = $_REQUEST['file_ext'];
                    //This location to be used for BLUPRINT
                    //$dir = '../../../blueprint/uploads/' . $UserID . '/';
                    $dir = '../uploads/' . $UserID . '/';
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }
                    $ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
                    //$imageTittle = str_replace(" ", "-", strtolower($_REQUEST['user_file_title']));
                    $image = 'pro-' . $UserID . '.' . $ext;
                    $tmp_name = $_FILES['user_profile_pic']['tmp_name'];
                    $doc_name = $_FILES['user_profile_pic']['name'];
                    move_uploaded_file($tmp_name, $dir . $image);
                    $OTh = new class_user();
                    $OTh->user_id = $UserID;
                    $OTh->user_profile_pic = $image;
                    $RES = $OTh->UserProfilePic();

                    $arr["res_status"] = "200";
                    $arr["res_message"] = "FILEUP";
                    $aR["user_profile_pic"] = $siteurl_upload . $UserID . "/" . $image;
                    $arr["res_data"] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "NOFILE";
            }
            break;
        case "cso_event_file_upload":
            if (is_uploaded_file($_FILES['event_image']['tmp_name'])) {
                $file_size = $_FILES["event_image"]["size"];
                if ($file_size > 2000000) {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "FILESIZE";
                } else {
                    //$UserFileTitle = $_REQUEST['event_title'];
                    $EventID = $_REQUEST["event_id"]; // strtolower(str_replace(' ', '-', class_common::StripSpecialChars($UserFileTitle)));
                    $UserID = $_REQUEST['user_id'];
                    //$dir = '../../../blueprint/uploads/' . $UserID . '/events/';

                    $dir = '../uploads/' . $UserID . '/events/';
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }
                    $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
                    $image = "EV-" . $EventID . '.' . $ext;
                    $tmp_name = $_FILES['event_image']['tmp_name'];
                    $doc_name = $_FILES['event_image']['name'];
                    move_uploaded_file($tmp_name, $dir . $image);

                    $OTh = new class_cso();
                    $OTh->user_id = $UserID;
                    $OTh->event_image = $image;
                    $OTh->event_id = $EventID;

                    $RES = $OTh->UCSOEventImage();

                    $arr["res_status"] = "200";
                    $arr["res_message"] = "FILEUP";
                    $aR["event_image"] = $siteurl_upload . $UserID . "/events/" . $image;
                    $arr["res_data"] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "NOFILE";
            }
            break;
        case "cso_reg_file_upload":
            if (is_uploaded_file($_FILES['user_id_file']['tmp_name'])) {
                $file_size = $_FILES["user_id_file"]["size"];
                if ($file_size > 2000000) {
                    $arr["res_status"] = "401";
                    $arr["res_message"] = "FILESIZE";
                } else {
                    $UserFileTitle = $_REQUEST['user_file_title'];
                    $UserFile = strtolower(str_replace(' ', '-', $UserFileTitle));
                    $UserID = $_REQUEST['user_id'];
                    //$fileExtension = $_REQUEST['file_ext'];
                    //$dir = '../../../blueprint/uploads/' . $UserID . '/';
                    $dir = '../uploads/' . $UserID . '/';
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }

                    $ext = pathinfo($_FILES['user_id_file']['name'], PATHINFO_EXTENSION);
                    //$imageTittle = str_replace(" ", "-", strtolower($_REQUEST['user_file_title']));
                    $image = $UserFile . '-' . $UserID . '.' . $ext;
                    $tmp_name = $_FILES['user_id_file']['tmp_name'];
                    $doc_name = $_FILES['user_id_file']['name'];
                    move_uploaded_file($tmp_name, $dir . $image);

                    $OTh = new class_cso();
                    $OTh->user_id = $UserID;
                    $OTh->user_file_title = $UserFileTitle;
                    $OTh->user_id_file = $image;

                    $RES = $OTh->UCSOidfile();

                    $arr["res_status"] = "200";
                    $arr["res_message"] = "FILEUP";
                    $aR["user_id_file"] = $siteurl_upload . $UserID . "/" . $image;
                    $arr["res_data"] = $aR;
                }
            } else {
                $arr["res_status"] = "401";
                $arr["res_message"] = "NOFILE";
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