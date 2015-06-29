<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateFormat
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateFormat
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'format_id' => $input['format_id'],
						);
						
			$obj = new Application_Model_LjFormat();
			$obj->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
