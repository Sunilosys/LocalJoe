<?php

class Application_Service_GetCategoryAttrValues
{
	public function execute($input)
	{
		try {
			
			$categoryAttrValuesObj = new Application_Model_LjCategoryAttrValues();
			if(isset($input) && $input!='')
			$categoryAttrValuesObj->where_clause="$_category_attribute_id='".$input."'";
			$categoryAttrValues = $categoryAttrValuesObj->select();
			return $categoryAttrValues;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}	