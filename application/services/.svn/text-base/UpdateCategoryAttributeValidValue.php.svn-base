<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateCategoryAttributeValidValue
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateCategoryAtrributeValidValue
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'category_attribute_valid_value_id' => $input['category_attribute_valid_value_id'],
                                                        'parent_category_attribute_id' => $input['parent_category_attribute_id'],
                                                        'category_attribute_id' => $input['category_attribute_id']
						);
						
			$obj = new Application_Model_LjCategoryAttrValues();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
