<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddParentCategoryAttribute
 *
 * @author ssalunkhe
 */
class Application_Service_AddParentCategoryAttribute
{
	
	public function execute($input)
	{
		try{			
			$obj = new Application_Model_LjParentCategoryAttribute();
			$id = $obj->create($input);
                        return $id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
