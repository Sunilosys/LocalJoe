<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaveSmsUsage
 *
 * @author ssalunkhe
 */
class Application_Service_SaveSmsUsage
{
	
	public function execute($input)
	{
		try{			
			$objSmsUsage = new Application_Model_LjSmsUsage();
			$id = $objSmsUsage->create($input);
                        return $id;
		} catch (Exception $e){
			throw $e;
		}
	}
}