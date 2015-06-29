<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateAddress
 *
 * @author sunil_salunkhe
 */
class Application_Service_UpdateAddress
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'user_id' => $input['user_id'],
						);
						
			$objAddrInfo = new Application_Model_LjAddress();
			$objAddrInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}