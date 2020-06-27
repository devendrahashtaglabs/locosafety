<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_master
 *
 * @author HashTagLabs
 */
include_once 'class_db.php';

class class_master {

    public $country_id;
    public $ObjDB;
    public $R_SET;
    public $user_info_id;
    public $zone_id;
    public $division_id;
    public $maintenance_shop_id;
    public $hardware_category;
    public $shop_id;
    public $maintenance_section_id;
    public $section_id;
    public $date;

    function __construct() {
        $this->ObjDB = new class_db();
    }

    public function ReturnResultSet() {
        return $this->R_SET;
    }

//  Preeti -13-11-2019 ------------------------
    public function getSectionList() {
        $ObjDB = new class_db();
        $S = "SELECT master_shop_tbl.*, master_section_tbl.* "
                . "FROM master_section_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = master_section_tbl.shop_id "
                . "WHERE master_section_tbl.shop_id  = '" . $this->shop_id . "' "
                . "AND master_section_tbl.section_status = '10' ORDER BY master_section_tbl.section_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getSectionDetail() {
        $ObjDB = new class_db();
        $S = "SELECT master_role_tbl.*,user_info_tbl.*,user_details_tbl.* "
                . "FROM user_details_tbl "
                . "LEFT JOIN user_info_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id "
                . "LEFT JOIN master_role_tbl ON user_info_tbl.user_role = master_role_tbl.role_id "
                . "WHERE user_details_tbl.user_info_id "
                . "IN (SELECT user_info_id FROM `user_mapping_tbl` WHERE section_id = '" . $this->section_id . "')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function ticketCount() {
        $ObjDB = new class_db();
        $S = "SELECT count(*) as total "
                . "FROM tickets_tbl "
                . "WHERE section_id = '" . $this->section_id . "' AND shop_id = '" . $this->shop_id . "' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function hardwareCount() {
        $ObjDB = new class_db();
        /* $S = "SELECT count(*) as total_hardware "
          . "FROM hardware_mapping_section_tbl "
          . "WHERE section_id = '".$this->section_id."' AND shop_id = '".$this->shop_id."' "; */
        $S = "SELECT "
                . "IFNULL(SUM(CASE WHEN hardware_mapping_section_tbl.map_status = 10 THEN 1 ELSE 0 END),'0') as active_hardware, "
                . "count(*) as total_hardware "
                . "FROM hardware_mapping_section_tbl "
                . "WHERE section_id = '" . $this->section_id . "' AND shop_id = '" . $this->shop_id . "' AND map_status != '80' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function inchargeDetail() {
        $ObjDB = new class_db();
        $S = "SELECT * FROM user_details_tbl "
                . "LEFT JOIN user_info_tbl ON user_info_tbl.user_info_id = user_details_tbl.user_info_id "
                . "WHERE user_details_tbl.user_info_id "
                . "IN (SELECT user_info_id FROM `user_mapping_tbl` "
                . "WHERE section_id = '" . $this->section_id . "' AND shop_id = '" . $this->shop_id . "')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function maintenanceShopList() {
        $ObjDB = new class_db();
        $S = "SELECT * FROM `master_maintenance_shop_tbl` "
                . "WHERE zone_id = '" . $this->zone_id . "' AND division_id = '" . $this->division_id . "' AND maintenance_shop_status = '10'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function maintenanceSectionListByShop() {
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name, "
                . "master_maintenance_shop_tbl.* ,"
                . "master_maintenance_section_tbl.* "
                . "FROM `master_maintenance_section_tbl` "
                . "LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = master_maintenance_section_tbl.default_hardware_cat "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = master_maintenance_section_tbl.maintenance_shop_id "
                . "WHERE master_maintenance_section_tbl.`maintenance_shop_id` = '" . $this->maintenance_shop_id . "' "
                . "AND master_maintenance_section_tbl.maintenance_section_status = 10 ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function hardwareListByCategory() {
        $ObjDB = new class_db();
        $S = "SELECT master_shop_tbl.shop_name,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,
                master_hardware_type_tbl.hardware_type_name,master_hardware_category_tbl.category_name ,hardware_basic_tbl.*,
                hardware_mapping_section_tbl.*
                FROM hardware_mapping_section_tbl
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = hardware_mapping_section_tbl.shop_id
                LEFT JOIN hardware_basic_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id
                LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = hardware_basic_tbl.hardware_category
                LEFT JOIN master_hardware_type_tbl ON master_hardware_type_tbl.hardware_type_id = hardware_basic_tbl.hardware_type
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = hardware_basic_tbl.default_maintenance_shop
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = hardware_basic_tbl.default_maintenance_section
                WHERE hardware_mapping_section_tbl.section_id = '" . $this->section_id . "'
                ORDER BY master_hardware_category_tbl.category_name";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    //Preeti - 23-11-2019
    public function categoryDetail() {
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name, hardware_basic_tbl.hardware_category as hardware_category, COUNT(*) as hardware_count
                FROM `hardware_mapping_section_tbl`
                LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id
                LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category =  master_hardware_category_tbl.id
                WHERE hardware_mapping_section_tbl.map_status = '10'
                AND hardware_mapping_section_tbl.section_id =  '" . $this->section_id . "' ";

        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function hardwareCategoryList() {
        $ObjDB = new class_db();
        $S = "SELECT * FROM `master_hardware_category_tbl` WHERE `category_status` = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function hardwareListBySectionCat() {
        $ObjDB = new class_db();
        $S = "SELECT hardware_schedule_config_tbl.*,master_section_tbl.*,master_shop_tbl.shop_name,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,
                master_hardware_type_tbl.hardware_type_name,master_hardware_category_tbl.category_name ,hardware_basic_tbl.*,
                hardware_mapping_section_tbl.*
                FROM hardware_mapping_section_tbl
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = hardware_mapping_section_tbl.shop_id
                LEFT JOIN hardware_basic_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id
                LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = hardware_basic_tbl.hardware_category
                LEFT JOIN master_hardware_type_tbl ON master_hardware_type_tbl.hardware_type_id = hardware_basic_tbl.hardware_type
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = hardware_basic_tbl.default_maintenance_shop
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = hardware_basic_tbl.default_maintenance_section
                LEFT JOIN master_section_tbl ON hardware_mapping_section_tbl.section_id = master_section_tbl.section_id
                LEFT JOIN hardware_schedule_config_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id
                WHERE hardware_mapping_section_tbl.section_id = '" . $this->section_id . "'
                AND hardware_basic_tbl.hardware_category = '" . $this->hardware_category . "' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getHardwareSerialNoList() {
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_type_tbl.hardware_type_name,master_hardware_category_tbl.category_name,"
                . "hardware_basic_tbl.*,hardware_mapping_section_tbl.* "
                . "FROM hardware_mapping_section_tbl "
                . "LEFT JOIN tickets_tbl ON hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category = master_hardware_category_tbl.id "
                . "LEFT JOIN master_hardware_type_tbl ON hardware_basic_tbl.hardware_type = master_hardware_type_tbl.hardware_type_id "
                . "WHERE hardware_mapping_section_tbl.hardware_id "
                . "IN (SELECT hardware_id FROM `hardware_basic_tbl` WHERE hardware_basic_tbl.hardware_category = '" . $this->hardware_category . "') "
                . "AND hardware_mapping_section_tbl.map_status = 60 "
                . "AND tickets_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getMaintenanceSectionDetail() {
        $ObjDB = new class_db();
        $S = "SELECT master_role_tbl.*,user_info_tbl.*,user_details_tbl.* "
                . "FROM user_details_tbl "
                . "LEFT JOIN user_info_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id "
                . "LEFT JOIN master_role_tbl ON user_info_tbl.user_role = master_role_tbl.role_id "
                . "WHERE user_details_tbl.user_info_id "
                . "IN (SELECT user_info_id FROM `user_mapping_tbl` WHERE maintenance_section_id = '" . $this->maintenance_section_id . "')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    //10-12-2019
    public function getCategory() {
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.* "
                . "FROM master_hardware_category_tbl "
                . "WHERE master_hardware_category_tbl.category_status = 10 "
                . "AND master_hardware_category_tbl.zone_id = '" . $this->zone_id . "' "
                . "AND master_hardware_category_tbl.division_id = '" . $this->division_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getCategoryWiseSec() {
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) AS Total, "
                . "IFNULL(SUM(CASE WHEN hardware_mapping_section_tbl.map_status = '10' THEN 1 ELSE 0 END),0) AS 'Active', "
                . "IFNULL(SUM(CASE WHEN hardware_mapping_section_tbl.map_status = '60' THEN 1 ELSE 0 END),0) AS 'Under Maintenance', "
                . "IFNULL(SUM(CASE WHEN hardware_mapping_section_tbl.map_status = '90' THEN 1 ELSE 0 END),0) AS 'Breakdown' "
                . "FROM hardware_mapping_section_tbl "
                . "WHERE hardware_id "
                . "IN (SELECT hardware_id "
                . "FROM hardware_basic_tbl WHERE hardware_basic_tbl.hardware_category = '" . $this->hardware_category . "')  "
                . "AND section_id = '" . $this->section_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getTicketCountSection() {
        $ObjDB = new class_db();
        /*
          $S = "SELECT IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '20' THEN 1 ELSE 0 END),0) AS 'Open' , "
          . "IFNULL (SUM(CASE WHEN tickets_tbl.case_type = '60' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'Under Maintenance', "
          . "IFNULL(SUM(CASE WHEN tickets_tbl.case_type = '90' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'Breakdown', "
          . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close' , "
          . "COUNT(*) as Total "
          . "FROM tickets_tbl "
          . "WHERE tickets_tbl.section_id = '" . $this->section_id . "' ";
         *
         */
//Change by Srishti to get distinct count
        $S = "SELECT
(SELECT COUNT(DISTINCT hardware_map_section_id) FROM tickets_tbl WHERE ticket_status = '20' AND section_id = '" . $this->section_id . "') AS 'Open',
(SELECT COUNT(DISTINCT hardware_map_section_id) FROM tickets_tbl WHERE case_type = '60' AND ticket_status != '50' AND section_id = '" . $this->section_id . "') AS 'Under Maintenance',
(SELECT COUNT(DISTINCT hardware_map_section_id) FROM tickets_tbl WHERE case_type = '90' AND ticket_status != '50' AND section_id = '" . $this->section_id . "') AS 'Breakdown',
(SELECT COUNT(DISTINCT hardware_map_section_id) FROM tickets_tbl WHERE ticket_status = '50' AND section_id = '" . $this->section_id . "') AS 'Close',
(SELECT COUNT(DISTINCT hardware_map_section_id) FROM tickets_tbl WHERE section_id = '" . $this->section_id . "') AS 'Total'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function dueScheduleCount() {
        $ObjDB = new class_db();
        $today = date('Y-m-d');
        $S = "SELECT COUNT(*) as dueCount "
                . "FROM `hardware_schedule_config_tbl` "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = hardware_schedule_config_tbl.map_id "
                . "LEFT JOIN hardware_basic_tbl ON hardware_mapping_section_tbl.hardware_id = hardware_basic_tbl.hardware_id "
                . "LEFT JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id "
                . "WHERE hardware_mapping_section_tbl.section_id = '" . $this->section_id . "' "
                . "AND hardware_schedule_config_tbl.next_schedule_date < '$today' "
                . "AND hardware_mapping_section_tbl.map_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function ticketStatusCountMainSection() {
        $ObjDB = new class_db();
        $today = date('Y-m-d');
        $S = "SELECT IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '20' THEN 1 ELSE 0 END),0) AS 'Open' , "
                . "IFNULL (SUM(CASE WHEN tickets_tbl.case_type = '60' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'Under Maintenance', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.case_type = '90' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'Breakdown', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date = '$today' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'fresh', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date < '$today' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'pending', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close', "
                . "COUNT(*) as Total "
                . "FROM tickets_tbl "
                . "WHERE tickets_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getCategoryMainSec() {
        $ObjDB = new class_db();
        $today = date('Y-m-d');
        $S = "SELECT IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '20' THEN 1 ELSE 0 END),0) AS 'Open' , "
                . "IFNULL (SUM(CASE WHEN tickets_tbl.case_type = '60' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'Under Maintenance', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.case_type = '90' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'Breakdown', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date = '$today' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'fresh', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date < '$today' AND tickets_tbl.ticket_status != '50' THEN 1 ELSE 0 END),0) AS 'pending', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close', "
                . "COUNT(*) as Total "
                . "FROM tickets_tbl "
                . "WHERE tickets_tbl.hardware_map_section_id "
                . "IN (SELECT hardware_mapping_section_tbl.map_id "
                . "FROM hardware_mapping_section_tbl "
                . "WHERE hardware_mapping_section_tbl.hardware_id "
                . "IN (SELECT hardware_basic_tbl.hardware_id "
                . "FROM hardware_basic_tbl "
                . "WHERE hardware_basic_tbl.hardware_category = '" . $this->hardware_category . "')) "
                . "AND tickets_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

}
