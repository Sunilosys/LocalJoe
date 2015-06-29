<?php

class Application_Model_LjFolderPosting extends Application_Model_LjBaseModel{

    //Modlular level variables
    protected $table_name = "folder_posting";
    protected $table_pk = "folder_posting_id";
    protected $class_name = 'Application_Model_LjFolderPosting';
    var $folder_posting_id;
    var $posting_id;
    var $folder_id;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setFolder_posting_id($folder_posting_id) {
        $this->folder_posting_id = $folder_posting_id;
    }

    function setPosting_id($posting_id) {
        $this->posting_id = $posting_id;
    }

    function setFolder_id($folder_id) {
        $this->folder_id = $folder_id;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getFolder_posting_id() {
        return $this->folder_posting_id;
    }

    function getPosting_id() {
        return $this->posting_id;
    }

    function getFolder_id() {
        return $this->folder_id;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class
?>
