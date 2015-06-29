<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateCategoryAtrribute
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateCategoryAtrribute
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'category_id' => $input['category_id'],
                                                        'category_attribute_id' => $input['category_attribute_id']
						);
						
			$obj = new Application_Model_LjCategoryAttribute();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
