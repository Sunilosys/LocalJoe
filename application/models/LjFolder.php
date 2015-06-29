<?php

class Application_Model_LjFolder extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "folder";
    protected $table_pk = "folder_id";
    protected $class_name = 'Application_Model_LjFolder';
    var $folder_id;
    var $user_id;
    var $folder_name;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setFolder_id($folder_id) {
        $this->folder_id = $folder_id;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setFolder_name($folder_name) {
        $this->folder_name = $folder_name;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getFolder_id() {
        return $this->folder_id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getFolder_name() {
        return $this->folder_name;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class

