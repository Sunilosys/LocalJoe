<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateImage
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateImage
{
	
	public function execute($input)
	{
		try{			
			$objImage = new Application_Model_LjImage();
			$imageId = $objImage->create($input);
                        return $imageId;
		} catch (Exception $e){
			throw $e;
		}
	}
}

