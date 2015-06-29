<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateUser
 *
 * @author sunil_salunkhe
 */

class Application_Service_CreateUser
{
	
	public function execute($input)
	{
		try{			
			$objUserInfo = new Application_Model_LjUserInfo();
			$user_id = $objUserInfo->create($input);
                        return $user_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
