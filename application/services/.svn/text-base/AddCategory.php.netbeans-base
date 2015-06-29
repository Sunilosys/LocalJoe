<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddCategory
 *
 * @author ssalunkhe
 */
class Application_Service_AddCategory
{
	
	public function execute($input)
	{
		try{			
			$obj = new Application_Model_LjCategory();
			$id = $obj->create($input);
                        return $id;
		} catch (Exception $e){
			throw $e;
		}
	}
}

