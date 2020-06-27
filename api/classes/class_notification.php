<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_notification
 *
 * @author srishti
 */
include_once 'class_db.php';
require_once 'firebase.php';
require_once 'push.php';

class class_notification {

    //put your code here
    public $action;
    public $user_id;
    public $SPID;
    public $JobID;
    public $UID;
    public $UIDType;
    public $NoticeID;
    public $receiver_id;

    public function GetUserDevice() {
        $ObjDB = new class_db();
        //$S = "UPDATE mrupaynotify SET NoticeStatus = '0' WHERE NoticeID = '" . $this->NoticeID . "'";
        // $S = "SELECT user_device,user_type FROM firebase_tbl WHERE user_id = '" . $this->user_id . "'";die;
        $ObjDB->sproc_name = $S;
      
        $R = $ObjDB->ExecuteQuery();
        //print_r($R);die;
        $this->testForHimanshu($R);
        
        return "OK";
    }    
    
    

    public function testForHimanshu($DeviceID = null, $Msg = 'Hello Sir', $title = 'LOCO Safety', $Usertype = null,$COS_ID = null) {
        $login_device = $DeviceID;
       
        $notification_msg = $Msg;
        $notification_title = $title;
        $login_type = $Usertype;   
        $firebase = new Firebase();
        $push = new Push();
        $payload = array();
        $payload['login_id'] =$COS_ID;
    //    $payload['user_type'] = $Usertype;

        $push->setTitle($notification_title);
        $push->setMessage($notification_msg);
        $push->setImage('');
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);

        $json = '';
        $response = '';

        $json = $push->getPush();
        $response = $firebase->send($login_device, $json);
        return $response;
    }

    public function DeactivateNotification() {
        $ObjDB = new class_db();
        //$S = "UPDATE mrupaynotify SET NoticeStatus = '0' WHERE NoticeID = '" . $this->NoticeID . "'";
        $S = "UPDATE notification_tbl SET notification_status = '20', notification_update_date = NOW() WHERE request_id = '" . $this->map_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return "OK";
    }

    public function GetActiveNotification() {
        $ObjDB = new class_db();
        //   $S = "SELECT * FROM mrupaynotify WHERE UID = '" . $this->UID . "' AND UIDType = '" . $this->UIDType . "' AND NotifyStatus = 1";
        $S = "SELECT * FROM notification_tbl WHERE request_id = '" . $this->map_id . "' AND notification_status = '10'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function SendNotification() {
        $login_device = "";
        $login_email = "";
        $notify_message = "";
        $notify_title = "";
        $ObjDB = new class_db();
        switch ($this->action) {
            case "addjob":
                //  $S = "SELECT ConsumerName, DeviceID FROM mrupayconsumer WHERE ConsumerID = '" . $this->ConsumerID . "'";
                $S = "SELECT login_email, login_device FROM login_tbl WHERE login_id = '" . $this->user_id . "'";

                $ObjDB->sproc_name = $S;
                $R = $ObjDB->SelectQuery();
                list($login_email, $login_device) = mysqli_fetch_row($R);
                //$DeviceID = "dCwrYbz9b5s:APA91bHAqDdbXu7cK5Ow9_LuOqxV5-jMUmNDtU871fvShm9__uUtPEHT4RyVFteYYbPzsUn9dAaCLpKoAwdW9VQi5eESfErYYuMa3NMIG4OZWdyE9Hlv7qiJqtT4u_IJBK0mMFwovsPK";
//                $S = "SELECT SPFirstName, SPLastName, DeviceID FROM mrupayserviceprovider WHERE SPID = '" . $this->SPID . "'";
//                $ObjDB->sproc_name = $S;
//                $R = $ObjDB->SelectQuery();
//                list($SPFirstName, $SPLastName, $SDeviceID) = mysqli_fetch_row($R);

                $S = "SELECT vol_f_name, vol_l_name FROM volunteer_tbl WHERE vol_id = '" . $this->vol_id . "'";
                $ObjDB->sproc_name = $S;
                $R = $ObjDB->SelectQuery();
                list($FName, $LName) = mysqli_fetch_row($R);


                //   $notification_msg = "Your job is assigned to " . $SPFirstName . " " . $SPLastName . " successfully.";
                $notification_msg = "Your request sent to " . $FName . " " . $LName . " successfully...";
                //  $notify_message_s = "Your job is assigned to " . $ConsumerName . " successfully.";

                $notification_title = "Request Received";
                break;
        }
        //JobID,SPID,ConsumerID,NotifyPage,NotifyTitle,NotifyMessage,NotifyDate,NotifyStatus
//        $Sp = "INSERT INTO mrupaynotify (JobID,UID,UIDType,NotifyPage,NotifyTitle,NotifyMessage,NotifyDate) "
//                . " VALUES ('" . $this->JobID . "','" . $this->SPID . "','SP','" . $this->action . "','" . $notify_title . "','" . $notify_message_s . "','" . Date('Y-m-d H:i:s') . "')";
        $Sp = "INSERT INTO notification_tbl(request_id, notification_title, notification_msg, notification_status, notifiation_add_date)
VALUES((SELECT MAX(map_id) FROM map_connect_user_tbl), '" . $notification_title . "', '" . $notification_msg . "', '20', NOW());";
        $ObjDB->sproc_name = $Sp;
        $R = $ObjDB->ExecuteQuery();

//        $Sc = "INSERT INTO mrupaynotify (JobID,UID,UIDType,NotifyPage,NotifyTitle,NotifyMessage,NotifyDate) "
//                . " VALUES ('" . $this->JobID . "','" . $this->ConsumerID . "','CU','" . $this->action . "','" . $notify_title . "','" . $notify_message . "','" . Date('Y-m-d H:i:s') . "')";
//        $ObjDB->sproc_name = $Sc;
//        $R = $ObjDB->ExecuteQuery();

        $firebase = new Firebase();
        $push = new Push();
        $payload = array();
        $payload['login_id'] = $this->login_id;
        $payload['login_email'] = $login_email;

        $push->setTitle($notification_title);
        $push->setMessage($notification_msg);
        $push->setImage('');
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);

        $json = '';
        $response = '';

        $json = $push->getPush();
        $response = $firebase->send($login_device, $json);



        ////For SP Mobile
        $pushS = new Push();
        $payloadS = array();
        $payloadS['login_id'] = $this->login_id;
        $payloadS['login_email'] = $login_email;

        $pushS->setTitle($notification_title);
        $pushS->setMessage($notification_msg);
        $pushS->setImage('');
        $pushS->setIsBackground(FALSE);
        $pushS->setPayload($payloadS);

        $json = '';
        $response = '';

        $json = $pushS->getPush();
        $response = $firebase->send($login_device, $json);

        return $response;
    }

    public function GetNotificationsDetails() {
        $RES = "";
        $arrParam = array();
        $arrParam["in_user_id"] = $this->user_id;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "get_notifications_sp";
        $R = $this->ObjDB->SelectSP();
        if ($R != null && !empty($R) && mysqli_num_rows($R) > 0) {
            $this->R_SET = $R;
            $RES = "OK";
        }
        return $RES;
    }

}
