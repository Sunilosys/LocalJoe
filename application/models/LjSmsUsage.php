<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LjSmsUsage
 *
 * @author ssalunkhe
 */
class Application_Model_LjSmsUsage extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "sms_usage";
    protected $table_pk = "sms_usage_id";
    protected $class_name = 'Application_Model_LjSmsUsage';
    var $sms_usage_id;
    var $from_phone;
    var $to_phone;
    var $twilio_phone_id;
    var $sms;
    var $is_active;

    //////////////////////////
    //Sets Entity info
    function setId($sms_usage_id) {
        $this->sms_usage_id = $sms_usage_id;
    }

    function setFrom_phone($from_phone) {
        $this->from_phone = $from_phone;
    }

    function setTo_phone($to_phone) {
        $this->to_phone = $to_phone;
    }

    function setTwilioPhone_id($twilio_phone_id) {
        $this->twilio_phone_id = $twilio_phone_id;
    }

    function setSms($sms) {
        $this->sms = $sms;
    }

    function setIs_active($is_active) {
        $this->is_active = $is_active;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getId() {
        return $this->sms_usage_id;
    }

    function getFrom_phone() {
        return $this->phone_no;
    }

    function getTo_phone() {
        return $this->is_active;
    }

    function getTwiloPhone_id() {
        return $this->twilio_phone_id;
    }

    function getSms() {
        return $this->sms;
    }

}

//End class

