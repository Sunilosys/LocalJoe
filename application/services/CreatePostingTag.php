<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreatePostingTag
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreatePostingTag
{
	
	public function execute($input)
	{
		try{			
			$objPostTag = new Application_Model_LJPostingTag();
			$postTagId = $objPostTag->create($input);
                        return $postTagId;
		} catch (Exception $e){
			throw $e;
		}
	}
}
