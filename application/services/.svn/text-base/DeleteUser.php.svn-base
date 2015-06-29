<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteUser
 *
 * @author sunil_salunkhe
 */

class Application_Service_DeleteUser
{
	public function execute($input)
	{
		try {
	
			$userInfoObj=new Application_Model_LjUserInfo();
			$res=$userInfoObj->delete($input['user_id']);
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}	