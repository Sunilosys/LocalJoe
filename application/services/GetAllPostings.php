<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetAllPostings
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetAllPostings
{
	public function execute($input)
	{
		try {
			
			$postObj = new Application_Model_LjPosting();
			$postings = $postObj->select();
			return $postings;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}
