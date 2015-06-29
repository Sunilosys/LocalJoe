<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddPostingToShortList
 *
 * @author sunil_salunkhe
 */
class Application_Service_AddPostingToShortList
{
	
	public function execute($input)
	{
		try{			
			$objFolderPosting = new Application_Model_LjFolderPosting();
			$folderPosting_id = $objFolderPosting->create($input);
                        return $folderPosting_id;
		} catch (Exception $e){
			throw $e;
		}
	}
}
