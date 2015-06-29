<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RemoveSpamFlag
 *
 * @author sunil_salunkhe
 */
class Application_Service_RemoveSpamFlag
{
	public function execute($input)
	{
		try {
	
			$PostViewObj = new Application_Model_LjPostingView();
			$res = $PostViewObj->deleteArr($input);
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}
