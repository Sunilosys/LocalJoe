<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LjTwilioPhoneNo
 *
 * @author ssalunkhe
 */
class Application_Model_LjTwilioPhoneNo extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "twilio_phone_no";
    protected $table_pk = "twilio_phone_id";
    protected $class_name = 'Application_Model_LjTwilioPhoneNo';
    var $twilio_phone_id;
    var $twilio_phone_no;   
    var $is_active;   
   

    //////////////////////////
    //Sets Entity info
    function setTwilioPhone_id($twilio_phone_id) {
        $this->twilio_phone_id = $twilio_phone_id;
    }

  
    function setPhone_no($phone_no) {
        $this->phone_no = $phone_no;
    }
    
      function setIs_active($is_active) {
        $this->is_active = $is_active;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getTwilioPhone_id() {
        return $this->twilio_phone_id;
    }

    function getTwilioPhone_no() {
        return $this->twilio_phone_no;
    }
     function getIs_active() {
        return $this->is_active;
    }
  

   

}

//End class
