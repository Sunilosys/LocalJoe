<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreatePostAttribute
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreatePostAttribute
{
	
	public function execute($input)
	{
		try{			
			$objPostAttr = new Application_Model_LjPostingAttribute();
			$posting_attr_id = $objPostAttr->create($input);
                        return $posting_attr_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}