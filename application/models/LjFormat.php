<?php

class Application_Model_LjFormat extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "format";
    protected $table_pk = "format_id";
    protected $class_name = 'Application_Model_LjFormat';
    var $format_id;
    var $display_format;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setFormat_id($format_id) {
        $this->format_id = $format_id;
    }

    function setDisplay_format($display_format) {
        $this->display_format = $display_format;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getFormat_id() {
        return $this->format_id;
    }

    function getDisplay_format() {
        return $this->display_format;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class
?>
