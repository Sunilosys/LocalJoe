<?php

class Application_Model_LjFriend extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "friend";
    protected $table_pk = "friend_id";
    protected $class_name = 'Application_Model_LjFriend';
    var $friend_id;
    var $friend_user_id;
    var $user_id;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setFriend_id($friend_id) {
        $this->friend_id = $friend_id;
    }

    function setFriend_user_id($friend_user_id) {
        $this->friend_user_id = $friend_user_id;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getFriend_id() {
        return $this->friend_id;
    }

    function getFriend_user_id() {
        return $this->friend_user_id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class

