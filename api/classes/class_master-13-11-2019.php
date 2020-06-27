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
    
    public function SelectSchool() {
        $this->ObjDB->sproc_name = "get_all_school_sp";
        $R = $this->ObjDB->SelectSPSingle();
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

    public function SelectState() {
        $this->ObjDB->sproc_name = "select_state_sp";
        $this->ObjDB->param_array = [$this->country_id];
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
    
       public function SelectMasterGrade()
    {
           $this->ObjDB->sproc_name = "select_grade_sp";
        $R = $this->ObjDB->SelectSPSingle();
        return $R;
    }
    
    
    public function InsertCSO() {
        $this->ObjDB->sproc_name = "insert_step1_sp";
        $R = $this->ObjDB->ExecuteQuery();
        return $R;
    }

}
