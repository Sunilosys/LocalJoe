<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateAddress
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateAddress
{
	
	public function execute($input)
	{
		try{			
			$objAddrInfo = new Application_Model_LjAddress();
			$addressId = $objAddrInfo->create($input);
                        return $addressId;
		} catch (Exception $e){
			throw $e;
		}
	}
}
