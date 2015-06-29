<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddParentCategory
 *
 * @author ssalunkhe
 */
class Application_Service_AddParentCategory
{
	
	public function execute($input)
	{
		try{			
			$obj = new Application_Model_LjParentCategory();
			$id = $obj->create($input);
                        return $id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
