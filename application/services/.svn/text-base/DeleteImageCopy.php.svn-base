<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Service_DeleteImageCopy
{
	public function execute($input)
	{
		try {
	
			$imageInfoObj=new Application_Model_LjImageCopy();                      
			$res=$imageInfoObj->deleteArr($input);
                        return $res;
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}
