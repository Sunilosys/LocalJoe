<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Service_UpdateParentCategoryAttribute
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'parent_category_attribute_id' => $input['parent_category_attribute_id'],
						);
						
			$obj = new Application_Model_LjParentCategoryAttribute();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
