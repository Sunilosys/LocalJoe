<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateSavedSearch
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateSavedSearch
{
	
	public function execute($input)
	{
		try{			
			$objSavedSearchInfo = new Application_Model_LjSavedSearch();
			$search_id = $objSavedSearchInfo->create($input);
                        return $search_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
