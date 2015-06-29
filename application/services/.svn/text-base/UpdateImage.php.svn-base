<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateImage
 *
 * @author sunil_salunkhe
 */
class Application_Service_UpdateImage
{
	public function execute($input)
	{
		try {
			$arPrimaryKeys = array(
							'image_id' => $input['image_id'],
						);
						
			$objImageInfo = new Application_Model_LjImage();
			$objImageInfo->updateArr($input, $arPrimaryKeys);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
