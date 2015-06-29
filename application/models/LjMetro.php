<?php

class Application_Model_LjMetro extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "metro";
    protected $table_pk = "metro_id";
    protected $class_name = 'Application_Model_LjMetro';
    var $metro_id;
    var $metro_name;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setMetro_id($metro_id) {
        $this->metro_id = $metro_id;
    }

    function setMetro_name($metro_name) {
        $this->metro_name = $metro_name;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getMetro_id() {
        return $this->metro_id;
    }

    function getMetro_name() {
        return $this->metro_name;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class

