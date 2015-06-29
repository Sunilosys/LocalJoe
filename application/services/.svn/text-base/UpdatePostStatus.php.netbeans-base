<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdatePostStatus
 *
 * @author sunil_salunkhe
 */
class Application_Service_UpdatePostStatus
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'posting_id' => $input['posting_id'],
						);
						
			$objPostInfo = new Application_Model_LjPosting();
			$objPostInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}