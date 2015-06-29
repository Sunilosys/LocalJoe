<?php
/**
 *  Sample Foo Resource
 */
require_once 'Upload/LjS3UploadHandler.php';
class Api_PostController extends Rest_Controller implements Rest_Resource
{
 public function init() {
        if (Zend_Registry::isRegistered('parent_category_info')) {
            $this->view->parentCategoryInfo = Zend_Registry::get('parent_category_info');
        } else {
            $this->ParentCategoryService = new Application_Service_LjSession();
            $parentCategoryInfo = $this->ParentCategoryService->execute_service('Application_Service_GetParentCategories', null, false);
            $this->view->parentCategoryInfo = $parentCategoryInfo;
            Zend_Registry::set('parent_category_info', $parentCategoryInfo);
        }
        if (Zend_Registry::isRegistered('category_info')) {
            $this->view->categoryInfo = Zend_Registry::get('category_info');
        } else {
            $this->CategoryService = new Application_Service_LjSession();
            $categoryInfo = $this->CategoryService->execute_service('Application_Service_GetCategories', null, false);
            $this->view->categoryInfo = $categoryInfo;
            Zend_Registry::set('category_info', $categoryInfo);
        }

        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            if ($userInfo['user_id'] != 0) {
                $this->view->userLoggedIn = 1;
                $this->view->userId = $userInfo['user_id'];
                $this->view->userEmail = $userInfo['email'];
                $this->view->userName = $userInfo['first_name'] . " " . $userInfo['last_name'];
            } else {
                $this->view->userLoggedIn = 0;
                Zend_Session::namespaceUnset('UserInfo');
            }
        }
        else
            $this->view->userLoggedIn = 0;

        if (Zend_Registry::isRegistered('sso_config')) {
            $ssoConfig = Zend_Registry::get('sso_config');
            $this->view->sso_url = $ssoConfig->sso_url;
        } else {
            $ssoConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'sso');
            Zend_Registry::set('sso_config', $ssoConfig);
            if (isset($ssoConfig))
                $this->view->sso_url = $ssoConfig->sso_url;
        }
    }

    public function get($id, $params = null)
    {
        if ($this->_request->isXmlHttpRequest()) {
             $this->_helper->layout->disableLayout();             
        }
        else
        {
         $this->_helper->layout->enableLayout();
        }
        
         $this->longHtml = null;
        if (isset($id) && strlen($id) > 0) {
            $this->postObj = new Application_Model_LjPosting();            
            $this->longHtml = $this->postObj->CreatePostLongHtml($id);            
              if (isset($this->longHtml) && strlen($this->longHtml) > 0)
                $this->view->postInfo = trim($this->longHtml);
              else
                $this->view->postInfo = "<div class='instruction'>Oops, this posting is no longer active. </div>";  
        }
      
    }
//     
//
//    public function post($data, $params = null)
//    {
//        return array('message' => 'Creating resource', 'data' => $data);
//    }
//
//    public function put($data, $id = null, $params = null)
//    {
//        return array('message' => 'Updating resource with id ' . $id, 
//            'data' => $data);
//    }
//
//    public function delete($id, $params = null)
//    {
//        return array('message' => 'Deleting resource with id ' . $id);
//    }
}
