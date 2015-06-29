<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreatePost
 *
 * @author sunil_salunkhe
 */
class Application_Service_CreatePost
{
	
	public function execute($input)
	{
		try{			
			$objPostInfo = new Application_Model_LjPosting();
			$posting_id = $objPostInfo->create($input);
                        return $posting_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}

