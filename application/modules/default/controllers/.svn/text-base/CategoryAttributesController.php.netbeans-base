<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryAttributesController
 *
 * @author sunil_salunkhe
 */
class CategoryAttributesController extends Lj_Controller_Action {

    public function getAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isXmlHttpRequest()) {
            $categoryId = $this->_request->getParam('category_id');
            $this->categoryAtrributes = new Application_Service_LjSession();
            $categoryAtrributes = $this->categoryAtrributes->execute_service('Application_Service_GetCategoryAttributes', $categoryId, false);
            $this->view->categoryAtrributesInfo = $categoryAtrributes;
            $this->view->category_id = $categoryId;

            $this->emphasized_category_ids = "";
            foreach ($categoryAtrributes as $key => $value) {
                if (isset($value['rule']) && strtolower($value['rule']) == "emphasized") {
                 
                        $this->emphasized_category_ids = $this->emphasized_category_ids . "," . $value['category_attribute_id'];
                }
            }
             $this->view->emphasizedCategoryIds = trim($this->emphasized_category_ids,',');
        }
    }

}

