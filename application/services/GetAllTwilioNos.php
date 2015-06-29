<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetAllTwilioNos
 *
 * @author ssalunkhe
 */
class Application_Service_GetAllTwilioNos
{
	public function execute($input)
	{
		try {
			
			$twilioObj = new Application_Model_LjTwilioPhoneNo();
			$twilioPhoneNos = $twilioObj->select();
			return $twilioPhoneNos;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}
