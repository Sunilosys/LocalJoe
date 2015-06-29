<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateCategory
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateCategory
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'category_id' => $input['category_id'],
                                                        'parent_category_id' => $input['parent_category_id']
						);
						
			$obj = new Application_Model_LjCategory();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}