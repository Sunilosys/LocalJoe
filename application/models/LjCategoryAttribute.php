<?php

class Application_Model_LjCategoryAttribute extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "category_attribute";
    protected $table_pk = "category_attribute_id";
    protected $class_name = 'Application_Model_LjCategoryAttribute';
    var $category_attribute_id;
    var $format_id;
    var $category_id;
    var $name;
    var $display_sequence;
    var $is_searchable;
    var $is_search_facet;
    var $is_active;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setCategory_attribute_id($category_attribute_id) {
        $this->category_attribute_id = $category_attribute_id;
    }

    function setFormat_id($format_id) {
        $this->format_id = $format_id;
    }

    function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }

    function setCategoryAttrName($name) {
        $this->name = $name;
    }

    function setDisplay_sequence($display_sequence) {
        $this->display_sequence = $display_sequence;
    }

    function setIs_searchable($is_searchable) {
        $this->is_searchable = $is_searchable;
    }

    function setIs_search_facet($is_search_facet) {
        $this->is_search_facet = $is_search_facet;
    }

    function setIs_active($is_active) {
        $this->is_active = $is_active;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getCategory_attribute_id() {
        return $this->category_attribute_id;
    }

    function getFormat_id() {
        return $this->format_id;
    }

    function getCategory_id() {
        return $this->category_id;
    }

    function getCategoryAttrName() {
        return $this->name;
    }

    function getDisplay_sequence() {
        return $this->display_sequence;
    }

    function getIs_searchable() {
        return $this->is_searchable;
    }

    function getIs_search_facet() {
        return $this->is_search_facet;
    }

    function getIs_active() {
        return $this->is_active;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class

