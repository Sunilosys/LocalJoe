<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteCategoryAttribute
 *
 * @author ssalunkhe
 */
class Application_Service_DeleteCategoryAttribute
{
	public function execute($input)
	{
		try {
	
                        //Delete Post Address
                        $obj=new Application_Model_LjCategoryAttribute();                      
			$objDelete=$obj->deleteArr($input);
                       
                        
		} catch (Exception $e) {
			throw $e;
		}
	}
}