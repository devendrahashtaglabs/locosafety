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
    
    function __construct() {
        $this->ObjDB = new class_db();
    }

    public function ReturnResultSet() {
        return $this->R_SET;
    }

    public function SelectOrg() {
        $this->ObjDB->sproc_name = "select_active_org_names_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }
    
    public function SelectEventType() {
        $this->ObjDB->sproc_name = "select_event_type_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }

    public function SelectEthnicity() {
        $this->ObjDB->sproc_name = "select_master_ethnicity_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }
    
    public function SelectType() {
        $this->ObjDB->sproc_name = "select_all_type_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }

    public function SelectTypeList() {
        $this->ObjDB->sproc_name = "select_type_sp";
        $this->ObjDB->param_array = [$this->parent_type_id];
        $R = $this->ObjDB->SelectSP();
        return $R;
    }
    
    public function SelectTimeZone() {
        $this->ObjDB->sproc_name = "select_timezone_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }

    public function SelectCountry() {
        $this->ObjDB->sproc_name = "select_country_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }

    public function SelectCategory() {
        $this->ObjDB->sproc_name = "select_category_sp";
        $this->ObjDB->param_array = [$this->parent_category_id];
        $R = $this->ObjDB->SelectSP();
        return $R;
    }

    public function SelectDocType() {
        $this->ObjDB->sproc_name = "select_document_type_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }
    
    public function SelectBlogCategory()
    {
           $this->ObjDB->sproc_name = "select_blog_category";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }
    
    public function SelectMasterCategory()
    {
           $this->ObjDB->sproc_name = "select_all_category_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }
        
    public function InsertCSO() {
        $this->ObjDB->sproc_name = "insert_step1_sp";
        $R = $this->ObjDB->ExecuteQuery();
        return $R;
    }
//  Preeti -13-11-2019 ------------------------
    public function getSectionList(){
        $ObjDB = new class_db();
        /*$S = "SELECT user_details_tbl.*,master_section_tbl.*,master_shop_tbl.*,user_mapping_tbl.*,user_info_tbl.* 
                FROM `user_info_tbl`
                LEFT JOIN user_details_tbl ON user_info_tbl.user_info_id = user_details_tbl.user_info_id                
                LEFT JOIN user_mapping_tbl ON user_info_tbl.user_info_id = user_mapping_tbl.user_info_id
                LEFT JOIN master_shop_tbl ON user_mapping_tbl.shop_id = master_shop_tbl.shop_id
                LEFT JOIN master_section_tbl ON user_mapping_tbl.section_id = master_section_tbl.section_id
                WHERE user_info_tbl.user_info_id = '".$this->user_info_id."' ORDER BY master_section_tbl.section_name ASC";
                */
        /*$S = "SELECT master_shop_tbl.shop_name, master_section_tbl.* "
                . "FROM master_section_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = master_section_tbl.shop_id "
                . "WHERE master_section_tbl.shop_id IN (SELECT shop_id FROM `user_mapping_tbl` WHERE user_info_id = '".$this->user_info_id."') "
                . "AND section_status = '10' ORDER BY section_name ASC";*/
		$S = "SELECT master_shop_tbl.shop_name, master_section_tbl.* "
                . "FROM master_section_tbl "
                . "LEFT JOIN master_shop_tbl ON master_shop_tbl.shop_id = master_section_tbl.shop_id "
                . "WHERE master_section_tbl.shop_id  = '".$this->shop_id."' "
                . "AND master_section_tbl.section_status = '10' ORDER BY master_section_tbl.section_name ASC";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function getSectionDetail(){
        $ObjDB = new class_db();
        $S = "SELECT master_role_tbl.*,user_info_tbl.*,user_details_tbl.* "
                . "FROM user_details_tbl "
                . "LEFT JOIN user_info_tbl ON user_details_tbl.user_info_id = user_info_tbl.user_info_id "
                . "LEFT JOIN master_role_tbl ON user_info_tbl.user_role = master_role_tbl.role_id "
                . "WHERE user_details_tbl.user_info_id "
                . "IN (SELECT user_info_id FROM `user_mapping_tbl` WHERE section_id = '".$this->section_id."')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function ticketCount(){
        $ObjDB = new class_db();
        $S = "SELECT count(*) as total FROM tickets_tbl WHERE section_id = '".$this->section_id."' AND shop_id = '".$this->shop_id."' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function hardwareCount(){
        $ObjDB = new class_db();
        $S = "SELECT count(*) as total_hardware FROM hardware_mapping_section_tbl WHERE section_id = '".$this->section_id."' AND shop_id = '".$this->shop_id."' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function inchargeDetail(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM user_details_tbl "
                . "LEFT JOIN user_info_tbl ON user_info_tbl.user_info_id = user_details_tbl.user_info_id "
                . "WHERE user_details_tbl.user_info_id "
                . "IN (SELECT user_info_id FROM `user_mapping_tbl` "
                . "WHERE section_id = '".$this->section_id."' AND shop_id = '".$this->shop_id."')";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
        
    }
    public function maintenanceShopList(){
        $ObjDB = new class_db();
        $S = "SELECT * FROM `master_maintenance_shop_tbl` WHERE zone_id = '".$this->zone_id."' and division_id = '".$this->division_id."'";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function maintenanceSectionListByShop(){
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name, "
                . "master_maintenance_shop_tbl.maintenance_shop_name ,"
                . "master_maintenance_section_tbl.* "
                . "FROM `master_maintenance_section_tbl` "
                . "LEFT JOIN master_hardware_category_tbl ON master_hardware_category_tbl.id = master_maintenance_section_tbl.default_hardware_cat "
                . "LEFT JOIN master_maintenance_shop_tbl ON master_maintenance_shop_tbl.maintenance_shop_id = master_maintenance_section_tbl.maintenance_shop_id "
                . "WHERE master_maintenance_section_tbl.`maintenance_shop_id` = '".$this->maintenance_shop_id."' "
                . "AND master_maintenance_section_tbl.maintenance_section_status = 10 ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    public function hardwareListByCategory(){
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
                WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' 
                ORDER BY master_hardware_category_tbl.category_name";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
    //Preeti - 23-11-2019
    public function categoryDetail(){
        $ObjDB = new class_db();
        $S = "SELECT master_hardware_category_tbl.category_name,hardware_basic_tbl.hardware_category, "
                . "COUNT(*) as hardware_count "
                . "FROM `hardware_basic_tbl` "
                . "LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category = master_hardware_category_tbl.id "
                . "LEFT JOIN hardware_mapping_section_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id "
                . "WHERE hardware_basic_tbl.hardware_status != '80' "
                . "AND hardware_mapping_section_tbl.section_id = '".$this->section_id."' "
                . "GROUP BY hardware_basic_tbl.hardware_category";
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
    
    public function hardwareListBySectionCat(){
        $ObjDB = new class_db();
        /*$S = "SELECT
                master_section_tbl.*,master_shop_tbl.*,master_maintenance_section_tbl.maintenance_section_name,master_maintenance_shop_tbl.maintenance_shop_name,master_hardware_type_tbl.hardware_type_name,master_hardware_category_tbl.*,hardware_basic_tbl.*,hardware_mapping_section_tbl.*
                FROM hardware_basic_tbl 
                LEFT JOIN master_hardware_category_tbl ON hardware_basic_tbl.hardware_category = master_hardware_category_tbl.id
                LEFT JOIN hardware_mapping_section_tbl ON hardware_basic_tbl.hardware_id = hardware_mapping_section_tbl.hardware_id
                LEFT JOIN master_hardware_type_tbl ON hardware_basic_tbl.hardware_type = master_hardware_type_tbl.hardware_type_id
                LEFT JOIN master_maintenance_shop_tbl ON hardware_basic_tbl.default_maintenance_shop = master_maintenance_shop_tbl.maintenance_shop_id
                LEFT join master_maintenance_section_tbl ON hardware_basic_tbl.default_maintenance_section = master_maintenance_section_tbl.maintenance_section_id
                left JOIN master_shop_tbl ON hardware_mapping_section_tbl.shop_id = master_shop_tbl.shop_id
                LEFT JOIN master_section_tbl ON hardware_mapping_section_tbl.section_id = master_section_tbl.section_id
                WHERE hardware_basic_tbl.hardware_category = '".$this->hardware_category."'
                AND hardware_mapping_section_tbl.section_id = '".$this->section_id."' ";*/
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
                WHERE hardware_mapping_section_tbl.section_id = '".$this->section_id."' 
                AND hardware_basic_tbl.hardware_category = '".$this->hardware_category."' ";
        $ObjDB->sproc_name = $S;
        $R = $ObjDB->SelectQuery();
        return $R;
    }
}
