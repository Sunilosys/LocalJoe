<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateImportLog
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateImportLog
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'import_id' => $input['import_id'],
						);
						
			$obj = new Application_Model_LjImportCategory();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
