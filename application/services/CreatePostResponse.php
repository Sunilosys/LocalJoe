<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreatePostResponse
 *
 * @author ssalunkhe
 */
class Application_Service_CreatePostResponse
{
	
	public function execute($input)
	{
		try{			
			$objPostRes = new Application_Model_LjPostingResponse();
			$response_id = $objPostRes->create($input);
                        return $response_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
