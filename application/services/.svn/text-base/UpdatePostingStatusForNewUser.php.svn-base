<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdatePostingStatusForNewUser
 *
 * @author sunil_salunkhe
 */
class Application_Service_UpdatePostingStatusForNewUser
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'user_id' => $input['user_id'],
                                                        'posting_status_id'=> 1
						);
						
			$objPostInfo = new Application_Model_LjPosting();                       
			$objPostInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}

