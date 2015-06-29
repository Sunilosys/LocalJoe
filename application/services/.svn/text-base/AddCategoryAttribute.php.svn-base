<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddCategoryAttribute
 *
 * @author ssalunkhe
 */
class Application_Service_AddCategoryAttribute
{
	
	public function execute($input)
	{
		try{			
			$obj = new Application_Model_LjCategoryAttribute();
			$id = $obj->create($input);
                        return $id;
		} catch (Exception $e){
			throw $e;
		}
	}
}

