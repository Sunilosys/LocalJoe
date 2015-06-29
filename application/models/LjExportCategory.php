<?php

class Application_Model_LjExportCategory extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "export_category";
    protected $table_pk = "export_id";
    protected $class_name = 'Application_Model_LjExportCategory';
    var $export_id;
    var $user_id;
    
    var $date_exported;

    //////////////////////////
    //Sets Entity info
    function setExport_id($export_id) {
        $this->export_id = $export_id;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }


    function setDate_exported($date_exported) {
        $this->date_exported = $date_exported;
    }

   
    function getExport_id() {
        return $this->export_id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getDate_exported() {
        return $this->date_exported;
    }

}

//End class

