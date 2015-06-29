<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteParentCategoryAttribute
 *
 * @author ssalunkhe
 */
class Application_Service_DeleteParentCategoryAttribute
{
	public function execute($input)
	{
		try {
	
                        //Delete Post Address
                        $obj=new Application_Model_LjParentCategoryAttribute();                      
			$objDelete=$obj->deleteArr($input);
                       
                        
		} catch (Exception $e) {
			throw $e;
		}
	}
}
