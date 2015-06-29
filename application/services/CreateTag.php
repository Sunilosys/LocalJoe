<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateTag
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreateTag
{
	
	public function execute($input)
	{
		try{			
			$objTag = new Application_Model_LjTag();
			$tagId = $objTag->create($input);
                        return $tagId;
		} catch (Exception $e){
			throw $e;
		}
	}
}