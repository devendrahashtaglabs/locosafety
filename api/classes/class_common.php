<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_common
 *
 * @author Hash
 */
include_once 'class_db.php';

class class_common {

    //put your code here
    public $user_email;
    public $token_value;
    public $user_type;
    public $C;
    public $H;
    public $S;
    public $V;
    public $P;

    public static function UnformatPhone($phone_number) {
        $phone_number = str_replace('(', '', $phone_number);
        $phone_number = str_replace(')', '', $phone_number);
        $phone_number = str_replace('-', '', $phone_number);
        $phone_number = str_replace(' ', '', $phone_number);
        return $phone_number;
    }

    public static function encryptLink($arrQuery) {

        $query = base64_encode(strrev(implode(',', $arrQuery)));
        return $query;
    }

    public static function decryptLink($query) {
        $arrQuery = explode(',', strrev(base64_decode($query)));
        return $arrQuery;
    }

    public static function base64url_encode($data1) {
        $data = implode(',', $data1);
        // First of all you should encode $data to Base64 string
        $b64 = base64_encode($data);
        // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
        if ($b64 === false) {
            return false;
        }
        // Convert Base64 to Base64URL by replacing â€œ+â€� with â€œ-â€� and â€œ/â€� with â€œ_â€�
        $url = strtr($b64, '+/', '-_');
        // Remove padding character from the end of line and return the Base64URL result
        return rtrim($url, '=');
    }

    /**
     * Decode data from Base64URL
     * @param string $data
     * @param boolean $strict
     * @return boolean|string
     */
    public static function base64url_decode($data, $strict = false) {
        // Convert Base64URL to Base64 by replacing â€œ-â€� with â€œ+â€� and â€œ_â€� with â€œ/â€�
        $b64 = strtr($data, '-_', '+/');
        $data = explode(',', base64_decode(',', $b64));
        $data1 = explode(',', base64_decode($b64, $strict));
        // Decode Base64 string and return the original data
        //return base64_decode($b64, $strict);
        return $data1;
    }

    
    public static function LogInsert($user_id, $user_type, $action_type, $action, $user_device) {
        $ObjDB = new class_db();
        $arrParam = array();
        $arrParam["in_user_id"] = $user_id;
        $arrParam["in_user_type"] = $user_type;
        $arrParam["in_action_type"] = $action_type;
        $arrParam["in_action_panel"] = "API";
        $arrParam["in_action_details"] = $action;
        $arrParam["in_action_date"] = date("Y-m-d H:i:s");
        $arrParam["in_action_device"] = $user_device;
        $ObjDB->param_array = $arrParam;
        $ObjDB->sproc_name = "insert_log_action_sp";
        $RES = $ObjDB->ExecuteSP();
        return $RES;
    }

    public function CheckToken() {
        $ct = 0;
        $ObjDB = new class_db();
        $S = "SELECT count(*) FROM token_tbl WHERE user_email = '" . $this->user_email . "' AND token_value = '" . $this->token_value . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        list($ct) = mysqli_fetch_row($R);
        return $ct;
    }

    public static function CreateUserID($user_type) {
        $rno = class_common::uniqueid(11);
        $today = Date("Ymd");
        $u_type = "P";
        switch ($user_type) {
            case "CSO":
                $u_type = "C";
                break;
            case "HSA":
                $u_type = "H";
                break;
            case "STU":
                $u_type = "S";
                break;
            case "VOL":
                $u_type = "V";
                break;
            case "ATD":
                $u_type = "A";
                break;
            case "ORG":
                $u_type = "O";
                break;
              case "SA":
                $u_type = "S";
                break;
              case "P":
                $u_type = "P";
                break;
            case "CSA":
                $u_type = "CA";
                $rno = class_common::uniqueid(10);
                break;
        }
        $userid = $u_type . $today . $rno;
        return $userid;
    }

    public static function uniqueid($ct) {
        $code = '';
        $data = '';
        srand((double) microtime() * 1000000);
        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";
        for ($i = 0; $i < $ct; $i++) {
            $code .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $code;
    }

    public static function OTP($ct) {
        $code = '';
        $data = '';
        srand((double) microtime() * 1000000);
        //$data = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $data = "1234567890";
        for ($i = 0; $i < $ct; $i++) {
            $code .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $code;
    }

    public static function StripSpecialChars($str) {
        $str = preg_replace("/[^a-zA-Z0-9\s]/", "", $str);
        return $str;
    }

    public static function StrToDB($str) {
        $str = str_replace("&lt;", "<", $str);
        $str = str_replace("&gt;", ">", $str);

        $str = str_replace("'", "&#39;", $str);
        $str = str_replace('"', "&#34;", $str);
        $str = str_replace("&quot;", "&#34;", $str);

        $str = str_replace('\n', "<br/>", $str);
        $str = str_replace('\r', "<br/>", $str);
        return $str;
    }

    public static function StrFromDB($str) {
        $str = str_replace("<", "&lt;", $str);
        $str = str_replace(">", "&gt;", $str);

        $str = str_replace("&#39;", "'", $str);
        $str = str_replace("&#34;", '"', $str);
        $str = str_replace("&#34;", "&quot;", $str);

        $str = str_replace("<br/>", '\n', $str);
        $str = str_replace("<br/>", '\r', $str);
        return $str;
    }
    
    public static function generateTicket($ct,$zone,$division){
        $code = '';
        $data = '';
        srand((double) microtime() * 1000000);
        $data = "1234567890";
        for ($i = 0; $i < $ct; $i++) {
            $code .= substr($data, (rand() % (strlen($data))), 1);
        }
        $ticket = $zone.'-'.$division.'-'.$code;
        return $ticket;
    }
    
    public static function getDivisionById($id){
        $ObjDB = new class_db();
        $S = "SELECT division_code FROM master_division_tbl WHERE division_id = '" . $id. "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        $res = mysqli_fetch_array($R);
        $division_code = $res['division_code'];
        return $division_code;
    }
    
    public static function getZoneById($id){
        $ObjDB = new class_db();
        $S = "SELECT zone_code FROM master_zone_tbl WHERE zone_id = '" . $id. "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        $res = mysqli_fetch_array($R);
        $zone_code = $res['zone_code'];
        return $zone_code;
    }
}
