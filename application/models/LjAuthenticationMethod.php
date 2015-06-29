<?php

class Application_Model_LjAuthenticationMethod extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "authentication_method";
    protected $table_pk = "authentication_method_id";
    protected $class_name = 'Application_Model_LjAuthenticationMethod';
    var $authentication_method_id;
    var $authentication_method;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setAuthentication_method_id($authentication_method_id) {
        $this->authentication_method_id = $authentication_method_id;
    }

    function setAuthentication_method($authentication_method) {
        $this->authentication_method = $authentication_method;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getAuthentication_method_id() {
        return $this->authentication_method_id;
    }

    function getAuthentication_method() {
        return $this->authentication_method;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class

