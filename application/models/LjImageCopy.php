<?php

class Application_Model_LjImageCopy extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "image_copy";
    protected $table_pk = "image_copy_id";
    protected $class_name = 'Application_Model_LjImageCopy';
    var $image_copy_id;
    var $image_id;
    var $image_type_id;
    var $image_file;
    var $image_size;
    var $width;
    var $height;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function Setimage_copy_id($image_copy_id) {
        $this->image_copy_id = $image_copy_id;
    }

    function Setimage_id($image_id) {
        $this->image_id = $image_id;
    }

    function Setimage_type_id($image_type_id) {
        $this->image_type_id = $image_type_id;
    }

    function Setimage_file($image_file) {
        $this->image_file = $image_file;
    }

    function Setimage_size($image_size) {
        $this->image_size = $image_size;
    }

    function Setwidth($width) {
        $this->width = $width;
    }

    function Setheight($height) {
        $this->height = $height;
    }

    function Setdate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function Getimage_copy_id() {
        return $this->image_copy_id;
    }

    function Getimage_id() {
        return $this->image_id;
    }

    function getImage_type_id() {
        return $this->image_type_id;
    }

    function getImage_file() {
        return $this->image_file;
    }

    function getImage_size() {
        return $this->image_size;
    }

    function getWidth() {
        return $this->width;
    }

    function getHeight() {
        return $this->height;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class
?>
