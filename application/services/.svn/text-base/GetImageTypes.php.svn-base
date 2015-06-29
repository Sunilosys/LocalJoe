<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetImageTypes
 *
 * @author sunil_salunkhe
 */

class Application_Service_GetImageTypes
{
	public function execute($input)
	{
		try {
			
			$imageTypeObj = new Application_Model_LjImageType();			
			$imageTypes = $imageTypeObj->select();
			return $imageTypes;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}
