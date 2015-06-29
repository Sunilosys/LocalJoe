<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddCategoryAttributeValidValue
 *
 * @author ssalunkhe
 */
class Application_Service_AddCategoryAttributeValidValue
{
	
	public function execute($input)
	{
		try{			
			$obj = new Application_Model_LjCategoryAttrValues();
			$id = $obj->create($input);
                        return $id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
