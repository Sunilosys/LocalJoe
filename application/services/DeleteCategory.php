<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteCategory
 *
 * @author ssalunkhe
 */
class Application_Service_DeleteCategory
{
	public function execute($input)
	{
		try {
	
                        //Delete Post Address
                        $obj=new Application_Model_LjCategory();                      
			$objDelete=$obj->deleteArr($input);
                       
                        
		} catch (Exception $e) {
			throw $e;
		}
	}
}
