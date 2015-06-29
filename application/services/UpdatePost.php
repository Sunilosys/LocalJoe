<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdatePost
 *
 * @author sunil_salunkhe
 */
class Application_Service_UpdatePost
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'posting_id' => $input['posting_id'],
						);
						
			$objUserInfo = new Application_Model_LjPosting();
			$objUserInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
