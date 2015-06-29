<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lj_Controller_Action
 *
 * @author sunil_salunkhe
 */
require_once 'Upload/LjUploadHandler.php';
require_once 'Upload/LjS3UploadHandler.php';
require_once 'Twilio/twilioSMS.php';
require_once 'Mail/class.phpmailer.php';
require_once 'Utility/Array2XML.php';
require_once 'Mail/Email_reader.php';
abstract class Lj_Controller_Action extends Zend_Controller_Action {

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
       
        $solrConfig = $this->getSolrConfig();
        if (isset($solrConfig)) {
            $this->view->rows = $solrConfig->rows;
            $this->view->start = $solrConfig->start;
            $this->view->visible_item_count_left_nav = $solrConfig->visible_item_count_left_nav;
            $this->view->start = (int) $solrConfig->start + (int) $solrConfig->rows;
        }

        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            if ($userInfo['user_id'] != 0) {
                $this->view->userLoggedIn = 1;
                $this->view->userId = $userInfo['user_id'];
                $this->view->userEmail = $userInfo['email'];
                $this->view->enableSMS = !isset($userInfo['enable_sms']) ? 0 : $userInfo['enable_sms'];
                $this->view->user_type_id = !isset($userInfo['user_type_id']) ? 0 : $userInfo['user_type_id'];
                $this->view->postAnonymously = !isset($userInfo['post_anonymously']) ? 0 : $userInfo['post_anonymously'];
              
                $this->view->userName = $userInfo['first_name'] . " " . $userInfo['last_name'];
                $this->view->firstName = $userInfo['first_name'] ;
                 $this->view->lastName = $userInfo['last_name'] ;
                $this->view->authentication_method_id = !isset($userInfo['authentication_method_id']) ? null : $userInfo['authentication_method_id'];
                $this->view->active_flag = !isset($userInfo['active_flag']) ? 0 : $userInfo['active_flag'];
                $uploadHandler = new LjS3UploadHandler();
                $this->view->profile_pic_url = $uploadHandler->GetS3ProfilePicUrl($this->view->userId);
                if (!isset($userInfo['enable_sms']))
                    $userInfo['enable_sms'] = 0;
                 if (!isset($userInfo['user_type_id']))
                    $userInfo['user_type_id'] = 0;
                 if (!isset($userInfo['post_anonymously']))
                    $userInfo['post_anonymously'] = 0;
                if (isset($userInfo['address'])) {
                    $this->view->address = !isset($userInfo['address']) ? null : $userInfo['address'];
                    $this->view->lat = !isset($userInfo['lat']) ? null : $userInfo['lat'];
                    $this->view->lon = !isset($userInfo['lon']) ? null : $userInfo['lon'];
                    $this->view->phone = !isset($userInfo['phone']) ? null : $userInfo['phone'];
                    $this->view->city = !isset($userInfo['city']) ? null : $userInfo['city'];
                    $this->view->zip = !isset($userInfo['zip']) ? null : $userInfo['zip'];
                } else {
                    $this->sessionObj = new Application_Service_LjSession();
                    $addressObj = $this->sessionObj->execute_service('Application_Service_GetUserDefaultLocation', $userInfo['user_id'], false);
                    if (isset($addressObj)) {
                        foreach ($addressObj as $key => $value) {
                            $userInfo['address'] = $value['address'];
                            $userInfo['lat'] = $value['lat'];
                            $userInfo['lon'] = $value['lon'];
                            $userInfo['city'] = $value['city'];
                            $userInfo['zip'] = $value['zip'];
                            $userInfo['phone'] = $value['phone'];
                        }

                        $this->view->address = !isset($userInfo['address']) ? null : $userInfo['address'];
                        $this->view->lat = !isset($userInfo['lat']) ? null : $userInfo['lat'];
                        $this->view->lon = !isset($userInfo['lon']) ? null : $userInfo['lon'];
                        $this->view->phone = !isset($userInfo['phone']) ? null : $userInfo['phone'];
                        $this->view->city = !isset($userInfo['city']) ? null : $userInfo['city'];
                        $this->view->zip = !isset($userInfo['zip']) ? null : $userInfo['zip'];
                        $userInfoNamespace->user_info = $userInfo;
                    }
                }
                if ((!isset($this->view->phone) || $this->view->phone == $this->view->phoneformat))
                    $this->view->phone = "";
            } else {
                $this->view->userLoggedIn = 0;
                $this->view->user_type_id = 0;
                //Zend_Session::namespaceUnset('UserInfo');
                $this->view->address = null;
                $this->view->lat = null;
                $this->view->lon = null;
                $this->view->phone = null;
                $this->view->city = null;
                $this->view->zip = null;
            }
        }
        else
        {
            $this->view->userLoggedIn = 0;
             $this->view->user_type_id = 0;
        }

        if (Zend_Registry::isRegistered('sso_config')) {
            $ssoConfig = Zend_Registry::get('sso_config');
            $this->view->sso_url = $ssoConfig->sso_url;
        } else {
            $ssoConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'sso');
            Zend_Registry::set('sso_config', $ssoConfig);
            if (isset($ssoConfig))
                $this->view->sso_url = $ssoConfig->sso_url;
        }
        $this->LoadSavedSearches();
        $this->LoadShortLists();
        //Edit Post
         if ($this->_request->isXmlHttpRequest()) {           
             $this->view->postingId  = $this->_request->getParam('postingId');
        } else if (isset($_GET['postingId']) && strlen($_GET['postingId']) > 0)
              $this->view->postingId  = $this->_request->getParam('postingId');
        
        
    }

    protected function getLoggedInUserInfo()
    {
            $userInfo = null;
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                $userInfo = $this->userInfoNamespace->user_info;               
            }
            return $userInfo;
    }
    protected function getSolrConfig() {
        $solrConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'solr');
        return $solrConfig;
    }

    protected function LoadSavedSearches() {
        //Get Saved Searches for logged in user
        $this->savedSearchesInfo = null;
        if ($this->view->userLoggedIn == 1) {
            $this->sessionObj = new Application_Service_LjSession();
            $savedSearches = $this->sessionObj->execute_service('Application_Service_GetSavedSearches', $this->view->userId, false);
            $this->savedSearchesInfo = $savedSearches;
        } else {
            $this->savedSearchesInfo = null;
        }
        
        $this->view->savedSearchHtml = $this->generateSavedSearchHtml($this->savedSearchesInfo);
       
    }

    protected function LoadShortLists() {


        //Get Shortlists for the logged in user       
        $this->shortlistInfo = null;
        if ($this->view->userLoggedIn == 1) {
            $this->sessionObj = new Application_Service_LjSession();
            $shortLists = $this->sessionObj->execute_service('Application_Service_GetShortlists', $this->view->userId, false);
            $this->shortlistInfo = $shortLists;
        } else {
            $this->shortlistInfo = null;
        }

        $this->view->shortListHtml = $this->generateShortListHtml($this->shortlistInfo);
    }

    protected function generateSavedSearchHtml($savedSearches) {
        $savedSearchHtml = null;
      
            $tokens = array(
                'savedSearchesInfo' => $savedSearches,
                'userLoggedIn' => $this->view->userLoggedIn
            );
            $savedSearchHtml = $this->getSavedSearchHtmlContents($tokens);
      
        //echo $savedSearchHtml;
        //exit;


        return $savedSearchHtml;
    }

    protected function generateShortListHtml($shortLists) {
        $shortListHtml = null;       
            $tokens = array(
                'shortListInfo' => $shortLists,
                'userLoggedIn' => $this->view->userLoggedIn
           );
        $shortListHtml = $this->getShortListHtmlContents($tokens);
      
        return $shortListHtml;
    }

    function getSavedSearchHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/saved_search_html.php';
        return ob_get_clean();
    }

    function getShortListHtmlContents(array $vars) {
        extract($vars);
        ob_start();
        include 'Templates/short_list_html.php';
        return ob_get_clean();
    }
    
     public function setAccountActivationKeyInDB($userId, $key) {
        $userInfoObj = new Application_Model_LjUserInfo();
        $DataInfo = array(
            'account_activation_key' => $key
        );
        $result = $userInfoObj->update($DataInfo, $userId);
    }
    
     public function setResetPwdKeyInDB($userId, $key) {
        $userInfoObj = new Application_Model_LjUserInfo();
        $DataInfo = array(
            'reset_password_key' => $key
        );
        $result = $userInfoObj->update($DataInfo, $userId);
    }
    
     public function setChangeEmailKeyInDB($userId, $key) {
        $userInfoObj = new Application_Model_LjUserInfo();
        $DataInfo = array(
            'email_authorization_key' => $key
        );
        $result = $userInfoObj->update($DataInfo, $userId);
    }
    
    public function sendActivationLink() {
        $userInfo = $this->getLoggedInUserInfo();
        if (isset($userInfo)) {
            $key = $this->createAccountActivationKey();
            $this->setAccountActivationKeyInDB($userInfo['user_id'], $key);
            $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
            $subject = $emailConfig->subject;
            $body = "";

            $tokens = array(
                'name' => $userInfo['first_name'] . ' ' . $userInfo['last_name'],
                'website' => $emailConfig->website,
                'activationUrl' => $emailConfig->activationUrl . '#page=activate&key=' . $key
            );

            if ($emailConfig->format == "html")
                $body = $this->getHtmlEmailContents($tokens);
            else
                $body = $this->getTextEmailContents($tokens);
            if ($this->sendEmail($emailConfig->fromName, $emailConfig->fromEmail, $userInfo['first_name'] . ' ' . $userInfo['last_name'], $userInfo['email'], $subject, $body,false))
                    return true;
            else
                return false;
        }
    }

    public function checkIfUserExists($userId) {
        $this->userInfo = new Application_Service_LjSession();
        $userInfoObj = $this->userInfo->execute_service('Application_Service_GetUser', $userId, false);
        if (isset($userInfoObj))
            return true;
        return false;
    }
    
    public function createAccountActivationKey() {

        // Generate a randomized token
        $key = md5(microtime(TRUE) . rand(0, 100000));
        return $key;
    }  
    
     public function createKey() {

        // Generate a randomized token
        $key = md5(microtime(TRUE) . rand(0, 100000));
        return $key;
    } 
    
     public function getResetPwdLink($userId) {
        
       
            $key = $this->createKey();
           
            $this->setResetPwdKeyInDB($userId, $key);
            $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
          
            $resetPwdUrl = $emailConfig->resetPwdUrl . '#page=resetpwd&key=' . $key;
           
            return $resetPwdUrl;
        
    }
    
         public function getChangeEmailLink($userId) {
        
       
            $key = $this->createKey();
           
            $this->setChangeEmailKeyInDB($userId, $key);
            $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
          
            $changeEmailUrl = $emailConfig->resetPwdUrl . '#page=changeemail&key=' . $key;
           
            return $changeEmailUrl;
        
    }
   

    public function sendEmail($fromName,$fromEmail,$toName,$toEmail,$subject,$body,$isReplyTo) {
        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled

            $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');


            $from = "From: " . $fromName . " " . $fromEmail;
            $to = $toEmail;

            $host = $emailConfig->smtpServer;
            $username = $emailConfig->smtpUser;
            $password = $emailConfig->smtpPwd;

            $mail->IsSMTP();                           // tell the class to use SMTP
            $mail->SMTPAuth = true;                  // enable SMTP authentication
            $mail->Port = 25;                    // set the SMTP server port
            $mail->Host = $host; // SMTP server
            $mail->Username = $username;     // SMTP server username
            $mail->Password = $password;            // SMTP server password
            //$mail->IsMail();  // tell the class to use Sendmail
            if ($isReplyTo)
            $mail->AddReplyTo($fromEmail,$fromName);
            $mail->SMTPSecure = 'tls';  
            $mail->From = $emailConfig->fromEmail;
            $mail->FromName = $emailConfig->fromName;           
            $mail->AddAddress($to);

            $mail->Subject = $subject;

            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            //$mail->SMTPDebug = 1;
            $mail->MsgHTML($body);

            $mail->IsHTML(true); // send as HTML
            $log = Zend_Registry::get('log');
            if (!$mail->Send()) {

                if (isset($log))
                    $log->info($mail->ErrorInfo);
                return false;
            }
            else {

                if (isset($log))
                    $log->info('Message has been sent to ' . $toEmail);
                return true;
            }

           
        } catch (phpmailerException $e) {
            //echo $e->getTrace();
            $log = Zend_Registry::get('log');
            if (isset($log))
                $log->info($e->getTrace());
            return false;
        }
        return false;
    }

    public function getHtmlEmailContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/email.html.php';
        return ob_get_clean();
    }
    
     public function getResetPwdEmailContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/reset_pwd_email.html.php';
        return ob_get_clean();
    }
    
      public function getResetPwdMsgContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/reset_pwd_msg.html.php';
        return ob_get_clean();
    }
    
     public function getEmailChangeEmailContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/email_change_email.html.php';
        return ob_get_clean();
    }
    
      public function getEmailChangeMsgContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/email_change_msg.html.php';
        return ob_get_clean();
    }

    public function getTextEmailContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/email.text.php';
        return ob_get_clean();
    }

}
