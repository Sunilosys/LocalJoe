<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteImage
 *
 * @author sunil_salunkhe
 */

class Application_Service_DeleteImage
{
	public function execute($input)
	{
		try {
	
			$imageInfoObj=new Application_Model_LjImage();
                        
			$res=$imageInfoObj->delete($input['image_id']);
                        return $res;
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}