<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateImageCopy
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateImageCopy
{
	
	public function execute($input)
	{
		try{			
			$objImageCopy = new Application_Model_LjImageCopy();
			$imageCopyId = $objImageCopy->create($input);
                        return $imageCopyId;
		} catch (Exception $e){
			throw $e;
		}
	}
}
