<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateAction
 *
 * @author ssalunkhe
 */
class Application_Service_UpdateAction
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'posting_view_id' => $input['posting_view_id'],
						);
						
			$objPostInfo = new Application_Model_LjPostingView();
			$objPostInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
