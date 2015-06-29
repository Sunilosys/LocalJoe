<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteAddress
 *
 * @author sunil_salunkhe
 */
class Application_Service_DeleteAddress
{
	public function execute($input)
	{
		try {
	
                        //Delete Post Address
                        $PostAddressObj=new Application_Model_LjAddress();                      
			$PostAddrDelete=$PostAddressObj->deleteArr($input);
                       
                        
		} catch (Exception $e) {
			throw $e;
		}
	}
}
