<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeletePostAttribute
 *
 * @author sunil_salunkhe
 */
class Application_Service_DeletePostAttribute
{
	public function execute($input)
	{
		try {
	
                        //Delete Posting Attribute
			$PostAttrObj=new Application_Model_LjPostingAttribute();                      
			$PostAttrDelete=$PostAttrObj->deleteArr($input);                       
                        
		} catch (Exception $e) {
			throw $e;
		}
	}
}
