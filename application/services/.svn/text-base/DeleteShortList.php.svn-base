<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteShortList
 *
 * @author sunil_salunkhe
 */
class Application_Service_DeleteShortList
{
	public function execute($input)
	{
		try {
                        $folderPostObj=new Application_Model_LjFolderPosting();
			$res = $folderPostObj->deleteArr($input);
			$folderObj=new Application_Model_LjFolder();
			$res = $folderObj->deleteArr($input);
			
		} catch (Exception $e) {
			throw $e;
		}
	}
}