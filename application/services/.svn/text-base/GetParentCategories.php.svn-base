<?php

class Application_Service_GetParentCategories
{
	public function execute($input)
	{
		try {
			
			$parentCategoryObj = new Application_Model_LjParentCategory();
			if(isset($input) && $input!='')
			$parentCategoryObj->where_clause="is_active = 1 and parent_category_id='".$input."'";
                        else
                        $parentCategoryObj->where_clause="is_active = 1";    
                     
			$parentCategories = $parentCategoryObj->select();
			return $parentCategories;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

