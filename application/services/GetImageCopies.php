<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetImageCopies
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetImageCopies
{
	public function execute($input)
	{
		try {
			
			$imageCopyObj = new Application_Model_LjImageCopy();
			if(isset($input) && $input!='')
			$imageCopyObj->where_clause="image_id='".$input."'";
			$imageCopies = $imageCopyObj->select();
			return $imageCopies;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}
