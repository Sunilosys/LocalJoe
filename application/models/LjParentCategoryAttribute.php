<?php

class Application_Model_LjParentCategoryAttribute extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "parent_category_attribute";
    protected $table_pk = "parent_category_attribute_id";
    protected $class_name = 'Application_Model_LjParentCategoryAttribute';
    var $parent_category_attribute_id;
    var $format_id;
    var $parent_category_id;
    var $name;
    var $facet_name;
    var $facet_type;
    var $is_search_facet;
    var $is_active;
    var $sort_type;
    var $rule;
    var $is_required;
    var $solr_column_name;
    var $is_currency;
    var $help_text;
    var $range_increment;
    var $date_created;

    //////////////////////////
    //Sets Entity info
    function setParentCategory_attribute_id($parent_category_attribute_id) {
        $this->parent_category_attribute_id = $parent_category_attribute_id;
    }

    function setFormat_id($format_id) {
        $this->format_id = $format_id;
    }

    function setParentCategory_id($parent_category_id) {
        $this->parent_category_id = $parent_category_id;
    }

    function setParentCategoryAttrName($name) {
        $this->name = $name;
    }

    function setFacet_name($facet_name) {
        $this->facet_name = $facet_name;
    }

    function setFacet_type($facet_type) {
        $this->facet_type = $facet_type;
    }

    function setIs_search_facet($is_search_facet) {
        $this->is_search_facet = $is_search_facet;
    }

    function setIs_active($is_active) {
        $this->is_active = $is_active;
    }

    function setRule($rule) {
        $this->rule = $rule;
    }

    function setSortType($sort_type) {
        $this->sort_type = $sort_type;
    }

    function setIs_required($is_required) {
        $this->is_required = $is_required;
    }

    function setSolrColumnName($solr_column_name) {
        $this->solr_column_name = $solr_column_name;
    }

    function setIs_currency($is_currency) {
        $this->is_currency = $is_currency;
    }

    function setHelpText($help_text) {
        $this->help_text = $help_text;
    }

    function setRangeIncrement($range_increment) {
        $this->range_increment = $range_increment;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getParentCategory_attribute_id() {
        return $this->parent_category_attribute_id;
    }

    function getFormat_id() {
        return $this->format_id;
    }

    function getParentCategory_id() {
        return $this->parent_category_id;
    }

    function getParentCategoryAttrName() {
        return $this->name;
    }

    function getFacet_name() {
        return $this->facet_name;
    }

    function getFacet_type() {
        return $this->facet_type;
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

    function getSort_type() {
        return $this->sort_type;
    }

    function getIs_required() {
        return $this->is_required;
    }

    function getIs_currency() {
        return $this->is_currency;
    }

    function getSolr_column_name() {
        return $this->solr_column_name;
    }

    function getRange_increment() {
        return $this->range_increment;
    }

    function getHelp_text() {
        return $this->help_text;
    }

    function getDate_created() {
        return $this->date_created;
    }

}

//End class

