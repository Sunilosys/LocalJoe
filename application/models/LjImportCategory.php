<?php

class Application_Model_LjImportCategory extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "import_category";
    protected $table_pk = "import_id";
    protected $class_name = 'Application_Model_LjImportCategory';
    var $import_id;
    var $user_id;
    
    var $date_exported;

    //////////////////////////
    //Sets Entity info
    function setImport_id($import_id) {
        $this->import_id = $import_id;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }


    function setDate_imported($date_imported) {
        $this->date_imported = $date_imported;
    }

   
    function getImport_id() {
        return $this->import_id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getDate_imported() {
        return $this->date_imported;
    }

}

//End class

