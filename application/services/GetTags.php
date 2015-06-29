<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetTags
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetTags
{
	public function execute($input)
	{
		try {
			
			$tagObj = new Application_Model_LjTag();			
			$tags = $tagObj->select();
			return $tags;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

