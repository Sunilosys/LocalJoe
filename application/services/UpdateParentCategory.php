<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateParentCategory
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateParentCategory
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'parent_category_id' => $input['parent_category_id'],
						);
						
			$obj = new Application_Model_LjParentCategory();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}

