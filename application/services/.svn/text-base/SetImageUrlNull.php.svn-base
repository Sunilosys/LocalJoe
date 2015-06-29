<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SetImageUrlNull
 *
 * @author ssalunkhe
 */
class Application_Service_SetImageUrlNull
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'image_id' => $input['image_id'],
						);
						
			$objPostImageInfo = new Application_Model_LjImage();
			$objPostImageInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
