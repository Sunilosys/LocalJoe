<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RemovePostingFromShortList
 *
 * @author sunil_salunkhe
 */
class Application_Service_RemovePostingFromShortList
{
	public function execute($input)
	{
		try {
	
			$folderPostObj=new Application_Model_LjFolderPosting();
			$res = $folderPostObj->deleteArr($input);
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}
