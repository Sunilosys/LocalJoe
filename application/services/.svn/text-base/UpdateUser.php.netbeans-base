<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateUser
 *
 * @author sunil_salunkhe
 */
class Application_Service_UpdateUser
{
	public function execute($input)
	{
        
		try {
			$arPrimaryKeys = array(
							'user_id' => $input['user_id'],
						);
			
			$objUserInfo = new Application_Model_LjUserInfo();
			$objUserInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}