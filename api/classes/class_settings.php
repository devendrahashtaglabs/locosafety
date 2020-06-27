<?php

/**
 * Description of class_db
 *
 * @Sri Technocrat
 */
date_default_timezone_set("Asia/Kolkata");

class class_settings {
    /*     * *******database connection****** */
    public $dbserver = 'localhost'; //
    public $dbname = 'hashtag1_locosafe_db';//'hashtag1_locodb';
    public $dbuser = 'hashtag1_ztpuser';
    public $dbpassword = 'ztpuser'; 
    public $connect = null;
    public $db = null;
    public $siteurl = '';
    public $siteadmin = "";

//-------------------preeti-----------------------
    public function getSiteUrl_New(){
        return $this->siteurl_new;
    }
    public function getAdminEmail() {
        return $this->siteadmin;
    }
    public function getSiteUrl() {
        return $this->siteurl;
    }
    
    public function getImageUrl() {
        return $this->imageurl;
    }

    public function getConImageUrl() {
        return $this->con_imageurl;
    }

    public function getSPImageUrl() {
        return $this->sp_imageurl;
    }

    public function getMobImageUrl() {
        return $this->mob_imageurl;
    }

    public function MyConnectDB() {
        $this->connect = mysqli_connect($this->dbserver, $this->dbuser, $this->dbpassword, $this->dbname);
        return $this->connect;
    }

    public function MyDisConnectDB() {
        mysqli_close($this->connect);
    }

}

?>