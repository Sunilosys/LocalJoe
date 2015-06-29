<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Service_CreatePostingImage
{
	
	public function execute($input)
	{
		try{			
			$objImage = new Application_Model_LjPostingImage();
			$imageId = $objImage->create($input);
                        return $imageId;
		} catch (Exception $e){
			throw $e;
		}
	}
}

