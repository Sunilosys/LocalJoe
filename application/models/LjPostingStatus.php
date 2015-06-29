<?php

class Application_Model_LjPostingStatus {

    //Modlular level variables
    protected $table_name = "posting_status";
    protected $table_pk = "posting_status_id";
    protected $class_name = 'Application_Model_LjPostingStatus';
    var $posting_status_id;
    var $posting_status;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setPosting_status_id($posting_status_id) {
        $this->posting_status_id = $posting_status_id;
    }

    function setPosting_status($posting_status) {
        $this->posting_status = $posting_status;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getPosting_status_id() {
        return $this->posting_status_id;
    }

    function getPosting_status() {
        return $this->posting_status;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class
?>
