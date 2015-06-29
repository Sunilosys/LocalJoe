<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of checkIfActivePostingForUser
 *
 * @author sunil_salunkhe
 */


class Application_Service_checkIfActivePostingForUser
{
	
	public function execute($input)
	{
		try{			
			
			$userId = $input['user_id'];
			$posting_status_id = $input['posting_status_id'];
			
			$postingObj = new Application_Model_LjPosting();
			$postingObj->where_clause=" user_id='".$userId."' and posting_status_id !='".$posting_status_id."'";
			$postings = $postingObj->select();
                        if (isset($postings))
                            return true;
			else
                            return false;
                            
		}	
		catch (Exception $e){
			throw $e;
		}
		
		
	}
	
	
}