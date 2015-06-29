<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateShortList
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateShortList
{
	
	public function execute($input)
	{
		try{			
			$objFolder = new Application_Model_LjFolder();
			$folder_id = $objFolder->create($input);
                        return $folder_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
