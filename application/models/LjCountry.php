<?php

class Application_Model_LjCountry extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "country";
    protected $table_pk = "country_id";
    protected $class_name = 'Application_Model_LjCountry';
    var $country_id;
    var $country;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setCountry_id($country_id) {
        $this->country_id = $country_id;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getCountry_id() {
        return $this->country_id;
    }

    function getCountry() {
        return $this->country;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class
?>
