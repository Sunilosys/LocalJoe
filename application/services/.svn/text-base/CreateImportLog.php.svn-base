<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateImportLog
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateImportLog
{
	
	public function execute($input)
	{
		try{			
			$obj = new Application_Model_LjImportCategory();
			$import_id = $obj->create($input);
                        return $import_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}