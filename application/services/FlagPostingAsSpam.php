<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FlagPostingAsSpam
 *
 * @author sunil_salunkhe
 */
class Application_Service_FlagPostingAsSpam
{
	
	public function execute($input)
	{
		try{			
			$objPostingView = new Application_Model_LjPostingView;
			$PostingViewId = $objPostingView->create($input);
                        return $PostingViewId;
		} catch (Exception $e){
			throw $e;
		}
	}
}

