<?php
include_once 'class_db.php';
include_once 'class_common.php';

class class_maintenance {
    public $maintenance_shop_id;
    public $maintenance_section_id;
    public $date;
            function __construct() {
        $this->ObjDB = new class_db();
    }

    public function maintenanceSectionList(){
        $ObjDB = new class_db();
        $S = "SELECT master_maintenance_shop_tbl.*, master_maintenance_section_tbl.*
            FROM `master_maintenance_shop_tbl` 
            LEFT JOIN master_maintenance_section_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = master_maintenance_section_tbl.maintenance_shop_id
            WHERE master_maintenance_shop_tbl.maintenance_shop_id = '".$this->maintenance_shop_id."' 
            ORDER BY maintenance_section_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getMaintenanceSectionDetail(){
        $ObjDB = new class_db();
        $S = "SELECT master_role_tbl.*,user_info_tbl.*,user_details_tbl.* "
                . "FROM user_details_tbl "
                . "LEFT JOIN user_info_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id "
                . "LEFT JOIN master_role_tbl ON user_info_tbl.user_role = master_role_tbl.role_id "
                . "WHERE user_details_tbl.user_info_id "
                . "IN (SELECT user_info_id FROM `user_mapping_tbl` WHERE maintenance_section_id = '".$this->maintenance_section_id."')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function maintenanceTicketCount(){
        $ObjDB = new class_db();
        $S = "SELECT count(*) as total FROM tickets_tbl WHERE maintenance_section_id = '".$this->maintenance_section_id."' AND maintenance_shop_id = '".$this->maintenance_shop_id."' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function maintenanceRaisedTicketList(){
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
                WHERE tickets_tbl.maintenance_section_id = '".$this->maintenance_section_id."' 
                ORDER BY tickets_tbl.tickets_created_date DESC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function checkMaintenanceSectionExist(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM master_maintenance_section_tbl where master_maintenance_section_tbl.maintenance_section_id = '".$this->maintenance_section_id."' AND master_maintenance_section_tbl.maintenance_section_status = 10";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketStatusCountMaintenanceSection(){
        $ObjDB = new class_db();
        $S = "SELECT "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date = '".$this->date."' THEN 1 ELSE 0 END),0) AS 'fresh', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.tickets_created_date < '".$this->date."' THEN 1 ELSE 0 END),0) AS 'pending', "
                . "IFNULL(SUM(CASE WHEN tickets_tbl.ticket_status = '50' THEN 1 ELSE 0 END),0) AS 'Close' "
                . "FROM tickets_tbl "
                . "WHERE tickets_tbl.maintenance_section_id = '".$this->maintenance_section_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;  
    }
    public function maintenanceSectionTicketCount(){
        $ObjDB = new class_db();
        $S = "SELECT COUNT(*) as total FROM tickets_tbl WHERE tickets_tbl.maintenance_section_id = '".$this->maintenance_section_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
}
?>

