<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author sunil_salunkhe
 */
class AboutController extends Lj_Controller_Action{
     public function init()
    {
        /* Initialize action controller here */
           parent::init();
    }

    public function indexAction()
    {
        //$this->_helper->layout->disableLayout();
        if ($this->view->userLoggedIn)
        {
        $this->savedSearchesInfo = null;
		$this->sessionObj = new Application_Service_LjSession();
		$savedSearches = $this->sessionObj->execute_service('Application_Service_GetSavedSearches', $this->view->userId, false);
		$this->savedSearchesInfo = $savedSearches;
		if (isset($this->savedSearchesInfo) && sizeof($this->savedSearchesInfo) > 0)
			$this->view->savedSearchHtml = $this->generateSavedSearchHtml($this->savedSearchesInfo);
        }
    }
}

?>
