<?php

class Application_Model_LjTag extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "tag";
    protected $table_pk = "tag_id";
    protected $class_name = 'Application_Model_LjTag';
    var $tag_id;
    var $tag_name;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setTag_id($tag_id) {
        $this->tag_id = $tag_id;
    }

    function setTag_name($tag_name) {
        $this->tag_name = $tag_name;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getTag_id() {
        return $this->_tag_id;
    }

    function getTag_name() {
        return $this->_tag_name;
    }

    function getDate_created() {
        return $this->_date_created;
    }

}

//End class

