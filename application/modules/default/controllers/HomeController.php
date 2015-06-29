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
class HomeController extends Lj_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();
//           $postObj = new Application_Model_LjPosting();
//            $recentlyPostedItemsHtml = $postObj->GetRecentlyPostedItems("0", "false");
//        $this->view->recentlyPostedItemsHtml = $recentlyPostedItemsHtml;
    }

    public function indexAction() {
        $this->_helper->layout->disableLayout();
          $this->sessionObj = new Application_Service_LjSession();
          
      
    }

    public function getrecentlyposteditemsAction() {
        $this->_helper->layout->disableLayout();
        $recentlyPostedItemsHtml = "";
        if ($this->_request->isXmlHttpRequest()) {
            $categoryId = $this->_request->getParam('categoryId');
            $isParentCategory = $this->_request->getParam('isParentCategory');
            if (!isset($categoryId))
                $categoryId = "0";
            if (!isset($isParentCategory))
                $isParentCategory = "false";

            $postObj = new Application_Model_LjPosting();
            $recentlyPostedItemsHtml = $postObj->GetRecentlyPostedItems($categoryId, $isParentCategory);
        }
        echo $recentlyPostedItemsHtml;
        exit;
    }

}

?>
