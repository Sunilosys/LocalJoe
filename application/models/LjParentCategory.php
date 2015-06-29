<?php


class Application_Model_LjParentCategory extends Application_Model_LjBaseModel {
	//Modlular level variables
	protected $table_name = "parent_category";
	protected $table_pk = "parent_category_id";
	protected $class_name = "Application_Model_LjParentCategory";
	
	var $parent_category_id;
	var $name;
	var $supports_rating;
	var $is_active;
	var $date_created;

	

	//////////////////////////
	//Sets Entity info
	function setParent_category_id($parent_category_id){
		$this->parent_category_id = $parent_category_id;
	}
	function setParentCategoryName($name){
		$this->name = $name;
	}
	function setSupports_rating($supports_rating){
		$this->supports_rating = $supports_rating;
	}
	function setIs_active($is_active){
		$this->is_active = $is_active;
	}
	function setDate_created($date_created){
		$this->date_created = $date_created;
	}

	//////////////////////////

	//////////////////////////
	//Returns Loaded Entity info
	function getParent_category_id(){
		return $this->parent_category_id;
	}
	function getParentCategoryName(){
		return $this->name;
	}
	function getSupports_rating(){
		return $this->supports_rating;
	}
	function getIs_active(){
		return $this->is_active;
	}
	function getDate_created(){
		return $this->date_created;
	}

	
}//End class

