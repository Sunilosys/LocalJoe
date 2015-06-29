<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteSavedSearch
 *
 * @author sunil_salunkhe
 */
class Application_Service_DeleteSavedSearch
{
	public function execute($input)
	{
		try {
	
			$savedSearchObj=new Application_Model_LjSavedSearch();
			$res = $savedSearchObj->deleteArr($input);
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}
