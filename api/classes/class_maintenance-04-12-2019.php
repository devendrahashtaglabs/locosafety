<?php

include_once 'class_db.php';
include_once 'class_common.php';

class class_maintenance {

    public $maintenance_shop_id;
    public $maintenance_section_id;
    public $date;
    public $ticket_no;
    public $case_remarks;
    public $user_info_id;
    public $hardware_serial_no;
    public $shop_id;
    public $section_id;
    public $new_hardware_id;
    public $pre_hardware_id;

    function __construct() {
        $this->ObjDB = new class_db();
    }

    public function maintenanceSectionList() {
        $ObjDB = new class_db();
        $S = "SELECT master_maintenance_shop_tbl.*, master_maintenance_section_tbl.*
            FROM `master_maintenance_shop_tbl` 
            LEFT JOIN master_maintenance_section_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = master_maintenance_section_tbl.maintenance_shop_id
            WHERE master_maintenance_shop_tbl.maintenance_shop_id = '" . $this->maintenance_shop_id . "' 
            AND master_maintenance_section_tbl.maintenance_section_status = '10' 
            ORDER BY maintenance_section_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function getMaintenanceSectionInfo() {
        $ObjDB = new class_db();
        $S = "SELECT master_maintenance_section_tbl.* "
                . "FROM master_maintenance_section_tbl "
                . "WHERE master_maintenance_section_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "'";
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

    public function maintenanceTicketCount() {
        $ObjDB = new class_db();
        $S = "SELECT count(*) as total FROM tickets_tbl WHERE maintenance_section_id = '" . $this->maintenance_section_id . "' AND maintenance_shop_id = '" . $this->maintenance_shop_id . "' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function maintenanceRaisedTicketList() {
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name,master_hardware_type_tbl.hardware_type_name,master_status_tbl.status,hardware_basic_tbl.*,user_details_tbl.user_f_name,user_details_tbl.user_l_name,master_section_tbl.section_name,master_shop_tbl.shop_name,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,tickets_tbl.* 
                FROM `tickets_tbl`
                LEFT JOIN master_status_tbl ON tickets_tbl.ticket_status = master_status_tbl.status_code
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id 
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id 
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id 
                LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id 
                LEFT JOIN user_info_tbl ON user_info_tbl.user_info_id = tickets_tbl.tickets_created_by 
                LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id 
                LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id 
                LEFT JOIN hardware_basic_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id 
                LEFT JOIN master_hardware_type_tbl ON hardware_basic_tbl.hardware_type = master_hardware_type_tbl.hardware_type_id
                LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category = master_hardware_category_tbl.id
                WHERE tickets_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "' 
                ORDER BY tickets_tbl.tickets_created_date DESC";
        //echo $S;exit;
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function checkMaintenanceSectionExist() {
        $ObjDB = new class_db();
        $S = "SELECT * FROM master_maintenance_section_tbl "
                . "WHERE master_maintenance_section_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "' "
                . "AND master_maintenance_section_tbl.maintenance_section_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function ticketStatusCountMaintenanceSection() {
        $ObjDB = new class_db();
        $S = "SELECT "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date = '" . $this->date . "' THEN 1 ELSE 0 END),0) AS 'fresh', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date < '" . $this->date . "' THEN 1 ELSE 0 END),0) AS 'pending', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close' "
                . "FROM tickets_tbl "
                . "WHERE tickets_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function maintenanceSectionTicketCount() {
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as total "
                . "FROM tickets_tbl "
                . "WHERE tickets_tbl.maintenance_section_id = '" . $this->maintenance_section_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function maintenanceShopTicketCount() {
        $ObjDB = new class_db();
        $S = "SELECT "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date = '" . $this->date . "' THEN 1 ELSE 0 END),0) AS 'fresh', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date < '" . $this->date . "' THEN 1 ELSE 0 END),0) AS 'pending', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close' "
                . "FROM tickets_tbl "
                . "WHERE tickets_tbl.maintenance_shop_id = '" . $this->maintenance_shop_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function maintenanceShopRaisedTicketList() {
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name,master_hardware_type_tbl.hardware_type_name,master_status_tbl.status,hardware_basic_tbl.*,user_details_tbl.user_f_name,user_details_tbl.user_l_name,master_section_tbl.section_name,master_shop_tbl.shop_name,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,tickets_tbl.* 
                FROM `tickets_tbl`
                LEFT JOIN master_status_tbl ON tickets_tbl.ticket_status = master_status_tbl.status_code
                LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = tickets_tbl.maintenance_shop_id 
                LEFT JOIN master_maintenance_section_tbl ON master_maintenance_section_tbl.maintenance_section_id = tickets_tbl.maintenance_section_id 
                LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = tickets_tbl.shop_id 
                LEFT JOIN master_section_tbl ON master_section_tbl.section_id = tickets_tbl.section_id 
                LEFT JOIN user_info_tbl ON user_info_tbl.user_info_id = tickets_tbl.tickets_created_by 
                LEFT JOIN user_details_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id 
                LEFT JOIN hardware_mapping_section_tbl ON hardware_mapping_section_tbl.map_id = tickets_tbl.hardware_map_section_id 
                LEFT JOIN hardware_basic_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id 
                LEFT JOIN master_hardware_type_tbl ON hardware_basic_tbl.hardware_type = master_hardware_type_tbl.hardware_type_id
                LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category = master_hardware_category_tbl.id
                WHERE tickets_tbl.maintenance_shop_id = '" . $this->maintenance_shop_id . "' 
                ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    //Preeti - 27-11-2019
    public function closeTicket() {
        $ObjDB = new class_db();
        $today = date('Y-m-d');
        $S = "UPDATE tickets_tbl SET `ticket_status` = '50', case_remarks = '" . $this->case_remarks . "',"
                . "`tickets_updated_date` = '" . $today . "',`tickets_updated_by`= '" . $this->user_info_id . "' "
                . "WHERE `ticket_no` = '" . $this->ticket_no . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }

    public function getAllTicket() {
        $ObjDB = new class_db();
        $ticket = $this->ticket_no;
        $ticket = substr($ticket, 0, 14);
        $S = "SELECT * FROM tickets_tbl WHERE `ticket_no` LIKE '%$ticket%' AND `ticket_status` != '50'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function updateHardwareStatus() {
        $ObjDB = new class_db();
        /*$S = "  UPDATE hardware_basic_tbl 
            SET hardware_basic_tbl.hardware_status = '10' 
            WHERE hardware_basic_tbl.hardware_id 
            IN (SELECT hardware_mapping_section_tbl.hardware_id 
                FROM hardware_mapping_section_tbl WHERE hardware_mapping_section_tbl.map_id 
                    IN (SELECT tickets_tbl.hardware_map_section_id 
                    FROM tickets_tbl 
                    WHERE tickets_tbl.`ticket_no` = '" . $this->ticket_no . "'))";*/
        //Preeti - 29-11-2019
        $S = "UPDATE hardware_mapping_section_tbl SET hardware_mapping_section_tbl.map_status = '10'
                 WHERE hardware_mapping_section_tbl.map_id 
                    IN (SELECT tickets_tbl.hardware_map_section_id 
                    FROM tickets_tbl 
                    WHERE tickets_tbl.`ticket_no` = '" . $this->ticket_no . "')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }

    public function updateHardwareMapping() {
        $ObjDB = new class_db();
        $S = "UPDATE hardware_mapping_section_tbl "
                . "SET hardware_mapping_section_tbl.shop_id = '" . $this->shop_id . "', "
                . "hardware_mapping_section_tbl.section_id = '" . $this->section_id . "' "
                . "WHERE hardware_mapping_section_tbl.hardware_serial_no = '" . $this->hardware_serial_no . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }

    /*public function getNewHardwareId() {
        $ObjDB = new class_db();
        $S = "SELECT hardware_id FROM hardware_mapping_section_tbl WHERE hardware_mapping_section_tbl.hardware_serial_no = '" . $this->hardware_serial_no . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }

    public function updateReplaceHardware() {
        $ObjDB = new class_db();
        $S = "UPDATE hardware_basic_tbl SET `hardware_status` = '10', "
                . "`hardware_updated_date` = '" . $this->date . "',`hardware_updated_by`= '" . $this->user_info_id . "' "
                . "WHERE `hardware_id` = '" . $this->new_hardware_id . "'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }

    public function getPreviousHardwareId() {
        $ObjDB = new class_db();
        $S = "SELECT hardware_mapping_section_tbl.hardware_id 
                FROM hardware_mapping_section_tbl WHERE hardware_mapping_section_tbl.map_id 
                IN (SELECT tickets_tbl.hardware_map_section_id FROM tickets_tbl WHERE tickets_tbl.`ticket_no` = '" . $this->ticket_no . "')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }*/

    public function clearHardwareMapping() {
        $ObjDB = new class_db();
        /*$S = "UPDATE hardware_mapping_section_tbl SET hardware_mapping_section_tbl.shop_id = NULL, "
                . "hardware_mapping_section_tbl.section_id = NULL "
                . "WHERE hardware_mapping_section_tbl.hardware_id = '" . $this->pre_hardware_id . "'";*/
        $S = "UPDATE hardware_mapping_section_tbl SET hardware_mapping_section_tbl.shop_id = NULL, "
                . "hardware_mapping_section_tbl.section_id = NULL "
                . "WHERE hardware_mapping_section_tbl.map_id IN (SELECT tickets_tbl.hardware_map_section_id FROM tickets_tbl WHERE tickets_tbl.`ticket_no` = '" . $this->ticket_no . "')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->ExecuteQuery();
        return $R;
    }

    public function GetReceiverID() {
        $ObjDB = new class_db();
        $S = "SELECT t.tickets_created_by AS user_info_id, ud.user_device_id FROM tickets_tbl t LEFT JOIN user_device_tbl ud
                ON t.tickets_created_by = ud.user_info_id
                WHERE ticket_no = '" . $this->ticket_no . "' ";
        $ObjDB->sproc_name = $S;
        //print_r($S);die;
        $R = $ObjDB->SelectQuery();

        return $R;
    }

    public function InsertNotification() {
        $RES = "INVALID";
        $arrParam = array();
        $arrParam["in_ticket_no"] = $this->ticket_no;
        $arrParam["in_sender_id"] = $this->user_info_id;
        $arrParam["in_receiver_id"] = $this->receiver_id;
        $arrParam["in_notification_title"] = $this->Title;
        $arrParam["in_notification_msg"] = $this->Msg;
        $this->ObjDB->param_array = $arrParam;
        $this->ObjDB->sproc_name = "insert_noti_sp";
        $RES = $this->ObjDB->ExecuteSP();
        return $RES;
    }

}
?>

