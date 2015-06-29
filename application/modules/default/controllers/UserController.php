<?php

class UserController extends Lj_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function getgoogleuserinfoAction() {

        $this->googleUserInfoNS = new Zend_Session_Namespace('GoogleUserInfo');
        $this->arGoogleUserInfo = array();
        if (isset($this->googleUserInfoNS) && isset($this->googleUserInfoNS->google_user_info)) {
            $this->arGoogleUserInfo = $this->googleUserInfoNS->google_user_info;
            Zend_Session::namespaceUnset('GoogleUserInfo');
        } else {
            $this->arGoogleUserInfo = array(
                'status' => 'failure'
            );
        }
        echo json_encode($this->arGoogleUserInfo);
        exit;
    }

    public function checkauthAction() {
        $this->_helper->layout->disableLayout();
        if (!empty($_GET['openid_ext1_value_first']) && !empty($_GET['openid_ext1_value_last']) && !empty($_GET['openid_ext1_value_email'])) {
            $firstName = $_GET['openid_ext1_value_first'];
            $lastName = $_GET['openid_ext1_value_last'];
            $email = $_GET['openid_ext1_value_email'];

            $arGoogleUserInfoArray = array(
                'status' => 'success',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email
            );
            Zend_Session::namespaceUnset('GoogleUserInfo');
            $this->googleUserInfoNS = new Zend_Session_Namespace('GoogleUserInfo');
            $this->googleUserInfoNS->google_user_info = $arGoogleUserInfoArray;
        }
    }

    public function signupAction() {
        // $this->_helper->layout->disableLayout();      
    }

    public function sendactivationlinkAction() {
        $statusArray = array('status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED);

        $this->_helper->layout->disableLayout();
        $userInfo = $this->getLoggedInUserInfo();
        if ($this->sendActivationLink())
            $statusArray = array('status' => Application_Model_LjConstants::$SUCCESS,
                'message' => 'Activation link has been sent to ' . $userInfo['email'] . '.');
        else
            $statusArray = array('status' => Application_Model_LjConstants::$FAILURE,
                'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED);
        echo json_encode($statusArray);
        exit;
    }

    public function profileAction() {
        $this->_helper->layout->disableLayout();
        $profilePostTabHtml = "";
        $start = 0;
        $rows = 10;
        $statusFilter = "Active";
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $this->view->welcomeMessage = Application_Model_LjConstants::$WELCOME_MESSAGE;
            $solrConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'solr');
            if (isset($solrConfig)) {
                $this->view->rows = $solrConfig->rows;
                $this->view->start = $solrConfig->start;
                $start = $solrConfig->start;
                $rows = $solrConfig->rows;
            }
            $this->view->start = (int) $solrConfig->start + (int) $solrConfig->rows;
            $profilePostTabHtml = $this->generatePostActivityHtml($userInfoNamespace->user_info['user_id'], $start, $rows, $statusFilter);
            if ($profilePostTabHtml != "") {
                $tempArray = explode('<PostNoFound>', $profilePostTabHtml);
                $this->view->postTabHtml = $tempArray[0];
                if ($tempArray[1] == "")
                    $this->view->numFound = 0;
                else
                    $this->view->numFound = $tempArray[1];
            }
        }
        else {
            if (!$this->_request->isXmlHttpRequest()) {
                $this->_redirector = $this->_helper->getHelper('Redirector');
                $this->_redirector->gotoUrl('#page=home?ref=profile');
            }
            exit;
        }
    }

    public function postlistingAction() {
        $this->_helper->layout->disableLayout();
        $profilePostTabHtml = "";
        if ($this->_request->isXmlHttpRequest()) {
            $start = $this->_request->getParam('startRowIndex');
            $rows = $this->_request->getParam('rows');
            $statusFilter = $this->_request->getParam('statusFilter');
            $tab = $this->_request->getParam('tab');
            $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($userInfoNamespace) && $userInfoNamespace->user_info) {
                if (isset($tab) && $tab == "AllActivities")
                    $profilePostTabHtml = $this->generatePostActivityHtml($userInfoNamespace->user_info['user_id'], $start, $rows, "Active");

                else if (isset($tab) && $tab == "PostResponses")
                    $profilePostTabHtml = $this->generatePostResponseHtml($userInfoNamespace->user_info['user_id'], $start, $rows, "Active");

                else
                    $profilePostTabHtml = $this->generateUserProfilePostHtml($userInfoNamespace->user_info['user_id'], $start, $rows, $statusFilter);
            }
        }


        echo $profilePostTabHtml;
        exit;
    }

    public function enablesmsAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isXmlHttpRequest()) {
            $enableSMS = $this->_request->getParam('enable_sms');
            $this->sessionObj = new Application_Service_LjSession();


            if (isset($this->view->userId)) {
                $userObj = new Application_Model_LjUserInfo();
                $status = $userObj->EnableSMSForUser($this->view->userId, $enableSMS);
                $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
                if (isset($userInfoNamespace->user_info)) {
                    $userInfo = $userInfoNamespace->user_info;
                    $userInfo['enable_sms'] = $enableSMS;
                    $userInfoNamespace->user_info = $userInfo;
                }
            }
        }

        exit;
    }

    public function setprivacyAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isXmlHttpRequest()) {
            $postAnonymously = $this->_request->getParam('post_anonymously');
            $this->sessionObj = new Application_Service_LjSession();


            if (isset($this->view->userId)) {
                $userObj = new Application_Model_LjUserInfo();
                $status = $userObj->SetPrivacyForUser($this->view->userId, $postAnonymously);
                $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
                if (isset($userInfoNamespace->user_info)) {
                    $userInfo = $userInfoNamespace->user_info;
                    $userInfo['post_anonymously'] = $postAnonymously;
                    $userInfoNamespace->user_info = $userInfo;
                }
            }
        }

        exit;
    }

    private function generateUserProfilePostHtml($userId, $start, $rows, $statusFilter) {
        $pageHtml = "";
        $postObj = new Application_Model_LjPosting();
        $pageHtml = $postObj->CreateProfilePostSnippet($userId, $start, $rows, $statusFilter);
        return $pageHtml;
    }

    private function generatePostResponseHtml($userId, $start, $rows, $statusFilter) {
        $pageHtml = "";
        $postObj = new Application_Model_LjPosting();
        $pageHtml = $postObj->CreatePostResponseSnippet($userId, $start, $rows, $statusFilter);
        return $pageHtml;
    }

    private function generatePostActivityHtml($userId, $start, $rows, $statusFilter) {
        $pageHtml = "";
        $postObj = new Application_Model_LjPosting();
        $pageHtml = $postObj->CreatePostActivitySnippet($userId, $start, $rows, $statusFilter);
        return $pageHtml;
    }

    public function updateAction() {
        $this->_helper->layout->disableLayout();
        $updateStatus = array(
            'status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
        );
        $message = null;
        try {
            if ($this->_request->isXmlHttpRequest()) {
                $user_id = $this->_request->getParam('user_id');
                $arUserInfo['user_id'] = $user_id;
                $emailId = null;
                $updateType = $this->_request->getParam('update_type');
                if (strtolower($updateType) == 'name') {
                    $arUserInfo['first_name'] = $this->_request->getParam('first_name');
                    $arUserInfo['last_name'] = $this->_request->getParam('last_name');
                    $message = "Your name has been successfully updated";
                } else if (strtolower($updateType) == 'email') {
                    $emailId = $this->_request->getParam('emailId');
                } else if (strtolower($updateType) == 'phone') {
                    $arUserInfo['phone'] = $this->_request->getParam('phone');
                    if ($this->_request->getParam('phone') == "")
                        $message = "Your phone has been successfully removed.";
                    else
                        $message = "Your phone has been successfully updated.";
                } else if (strtolower($updateType) == 'address') {

                    $message = "Your address has been successfully updated.";
                }
                $this->user_info = new Application_Service_LjSession();

                $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
                if (isset($userInfoNamespace->user_info)) {

                    $updateStatus = array(
                        'status' => Application_Model_LjConstants::$SUCCESS,
                        'message' => $message
                    );
                    $userInfo = $userInfoNamespace->user_info;
                    if (strtolower($updateType) == 'name') {

                        $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);

                        $userInfo['first_name'] = $this->_request->getParam('first_name');
                        $userInfo['last_name'] = $this->_request->getParam('last_name');
                        $userInfo['name'] = $this->_request->getParam('first_name') . ' ' . $this->_request->getParam('last_name');
                    } else if (strtolower($updateType) == 'phone') {

                        $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);

                        $userInfo['phone'] = $this->_request->getParam('phone');
                    } else if (strtolower($updateType) == 'address') {
                        $userInfo['address'] = $this->_request->getParam('address');
                        $userInfo['lat'] = $this->_request->getParam('lat') == 'undefined' ? '' : $this->_request->getParam('lat');
                        $userInfo['lon'] = $this->_request->getParam('lon') == 'undefined' ? '' : $this->_request->getParam('lon');
                        $userInfo['city'] = $this->_request->getParam('city') == 'undefined' ? '' : $this->_request->getParam('city');
                        $userInfo['zip'] = $this->_request->getParam('zip') == 'undefined' ? '' : $this->_request->getParam('zip');
                    } else if (strtolower($updateType) == 'email' && isset($emailId)) {


                        $toUserFirstName = $userInfo['first_name'];
                        $toUserLastName = $userInfo['last_name'];
                        $toEmail = $emailId;

                        $subject = "Instructions For Updating Your Registered Email ID on LocalJoe";
                        $tokens = array(
                            'first_name' => $toUserFirstName,
                            'change_email_url' => $this->getChangeEmailLink($user_id),
                            'new_email' => $emailId
                        );
                        $message = $this->getEmailChangeEmailContents($tokens);

                        $message = urldecode($message);
                        $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
                        if ($this->sendEmail($emailConfig->fromName, $emailId, $toUserFirstName . ' ' . $toUserLastName, $toEmail, $subject, $message, true)) {
                            $tokens = array(
                                'new_email' => $emailId
                            );


                            $updateStatus = array(
                                'status' => Application_Model_LjConstants::$SUCCESS,
                                'message' => $this->getEmailChangeMsgContents($tokens)
                            );
                        }
                        else
                            $updateStatus = array(
                                'status' => Application_Model_LjConstants::$FAILURE,
                                'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
                            );
                    }
                    $userInfoNamespace->user_info = $userInfo;
                }
            }
        } catch (Exception $e) {
            $updateStatus = array(
                'status' => Application_Model_LjConstants::$FAILURE,
                'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
            );
        }
        echo json_encode($updateStatus);
        exit;
    }

    public function manageAction() {
        $this->_helper->layout->disableLayout();
        try {
            if ($this->_request->isXmlHttpRequest()) {

                $user_id = $this->_request->getParam('user_id');
                $arUserInfo['user_id'] = $user_id;
                $arUserInfo['first_name'] = $this->_request->getParam('first_name');
                $arUserInfo['last_name'] = $this->_request->getParam('last_name');
                $arUserInfo['email'] = $this->_request->getParam('email');
                //$arUserInfo['password'] = $this->_request->getParam('password');
                $arUserInfo['authentication_method_id'] = $this->_request->getParam('authentication_method_id');
                $arUserInfo['active_flag'] = $this->_request->getParam('active_flag');
                $this->sessionObj = new Application_Service_LjSession();
                $userInfoObj = $this->sessionObj->execute_service('Application_Service_GetUser', $user_id, false);
                $arUserInfo['name'] = $arUserInfo['first_name'] . ' ' . $arUserInfo['last_name'];
                if (isset($userInfoObj)) {
                    $arUserInfo['new_user'] = 0;
                    $arUserInfo['user_type_id'] = $userInfoObj->user_type_id;
                    $arUserInfo['enable_sms'] = $userInfoObj->enable_sms;
                    $arUserInfo['post_anonymously'] = $userInfoObj->post_anonymously;
                    $this->save('update');
                    if ($this->_request->getParam('address') == 'undefined' || $this->_request->getParam('address') == 'null') {
                        $addressObj = $this->sessionObj->execute_service('Application_Service_GetUserDefaultLocation', $user_id, false);
                        if (isset($addressObj)) {
                            foreach ($addressObj as $key => $value) {
                                $arUserInfo['address'] = $value['address'];
                                $arUserInfo['lat'] = $value['lat'];
                                $arUserInfo['lon'] = $value['lon'];
                                $arUserInfo['city'] = $value['city'];
                                $arUserInfo['zip'] = $value['zip'];
                                $arUserInfo['phone'] = $value['phone'];
                            }
                        }
                    } else {
                        $arUserInfo['address'] = $this->_request->getParam('address');
                        $arUserInfo['lat'] = $this->_request->getParam('lat') == 'undefined' ? '' : $this->_request->getParam('lat');
                        $arUserInfo['lon'] = $this->_request->getParam('lon') == 'undefined' ? '' : $this->_request->getParam('lon');
                        $arUserInfo['city'] = $this->_request->getParam('city') == 'undefined' ? '' : $this->_request->getParam('city');
                        $arUserInfo['zip'] = $this->_request->getParam('zip') == 'undefined' ? '' : $this->_request->getParam('zip');
                        $arUserInfo['phone'] = $this->_request->getParam('phone') == 'undefined' ? '' : $this->_request->getParam('phone');
                    }

                    if ($arUserInfo['active_flag'] == '1') {
                        $postObj = new Application_Model_LjPosting();
                        $postObj->ChangePostingStatusToActiveForNewUser($user_id);
                    }
                } else {

                    $arUserInfo['new_user'] = 1;
                    $arUserInfo['enable_sms'] = 0;
                    $arUserInfo['user_type_id'] = 0;
                    $arUserInfo['post_anonymously'] = 0;
                    $this->save('create');
                    $arUserInfo['address'] = $this->_request->getParam('address') == 'undefined' ? '' : $this->_request->getParam('address');
                    $arUserInfo['lat'] = $this->_request->getParam('lat') == 'undefined' ? '' : $this->_request->getParam('lat');
                    $arUserInfo['lon'] = $this->_request->getParam('lon') == 'undefined' ? '' : $this->_request->getParam('lon');
                    $arUserInfo['city'] = $this->_request->getParam('city') == 'undefined' ? '' : $this->_request->getParam('city');
                    $arUserInfo['zip'] = $this->_request->getParam('zip') == 'undefined' ? '' : $this->_request->getParam('zip');
                    $arUserInfo['phone'] = $this->_request->getParam('phone') == 'undefined' ? '' : $this->_request->getParam('phone');
                }
                if ($this->_request->getParam('phone') != 'undefined') {
                    $arUserInfo['phone'] = $this->_request->getParam('phone');
                }
                Zend_Session::namespaceUnset('UserInfo');
                $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');

                $this->userInfoNamespace->user_info = $arUserInfo;
                $this->view->requestStatus = "success";
                $this->view->user_type_id = $arUserInfo['user_type_id'];
            }
        } catch (Exception $e) {
            $this->view->requestStatus = "failure";
            $this->view->user_type_id = 0;
        }
    }

    public function setemailAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isXmlHttpRequest()) {
            $arUserInfo['user_id'] = 0;
            $arUserInfo['email'] = $this->_request->getParam('email');
            Zend_Session::namespaceUnset('UserInfo');
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');

            $this->userInfoNamespace->user_info = $arUserInfo;
        }
        exit;
    }

    public function getlocationAction() {
        $location = null;
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $location = array(
                'address' => !isset($userInfo['address']) ? "" : $userInfo['address'],
                'lat' => !isset($userInfo['lat']) ? "" : $userInfo['lat'],
                'lon' => !isset($userInfo['lon']) ? "" : $userInfo['lon'],
                'phone' => !isset($userInfo['phone']) ? "" : $userInfo['phone'],
                'city' => !isset($userInfo['city']) ? "" : $userInfo['city'],
                'zip' => !isset($userInfo['zip']) ? "" : $userInfo['zip'],
            );
        } else {

            $location = array(
                'address' => "",
                'lat' => "",
                'lon' => "",
                'phone' => "",
                'city' => "",
                'zip' => "",
            );
        }

        echo json_encode($location);
        exit;
    }

    public function checkloginstatusAction() {
        $this->loggedInStatus = 0;
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            if ($userInfo['user_id'] != 0) {
                $this->loggedInStatus = 1;
            } else {
                $this->loggedInStatus = 0;
            }
        }
        else
            $this->loggedInStatus = 0;
        if ($this->loggedInStatus == 1)
            $loggedInStatus = array('loggedInStatus' => $this->loggedInStatus,
                'user_id' => $userInfo['user_id'],
                'first_name' => $userInfo['first_name'],
                'last_name' => $userInfo['last_name'],
                'name' => $userInfo['first_name'] . ' ' . $userInfo['last_name'],
                'email' => $userInfo['email'],
                'phone' => !isset($userInfo['phone']) ? '' : $userInfo['phone'],
                'authentication_method_id' => $userInfo['authentication_method_id']);
        else
            $loggedInStatus = array('loggedInStatus' => $this->loggedInStatus);
        echo json_encode($loggedInStatus);
        exit;
    }

    public function signoutAction() {
        $status = "success";
        Zend_Session::namespaceUnset('UserInfo');
        $statusArray = array('status' => $status);
        echo json_encode($statusArray);
        exit;
    }

    public function resetpwdAction() {
        $this->_helper->layout->disableLayout();
        $key = null;
        if ($this->_request->isXmlHttpRequest()) {
            $key = $this->_request->getParam('key');
        } else {
            if (isset($_GET['key']))
                $key = $_GET['key'];
        }
        if (isset($key) && strlen(trim($key)) > 0) {
            $userInfo = $this->checkResetPwdKey($key);
            if (isset($userInfo)) {
                foreach ($userInfo as $key => $value) {
                    $this->view->validUser = 1;
                    $this->view->userName = $value['first_name'] . " " . $value['last_name'];
                    $this->view->userEmail = $value['email'];
                    $this->view->userId = $value['user_id'];

                    $this->view->authentication_method_id = $value['authentication_method_id'];
                }
            } else {
                $this->view->validUser = 0;
            }
        } else {
            $this->view->validUser = 0;
        }
    }

    public function changeemailAction() {
        $this->_helper->layout->disableLayout();
        $key = null;
        if ($this->_request->isXmlHttpRequest()) {
            $key = $this->_request->getParam('key');
        } else {
            if (isset($_GET['key']))
                $key = $_GET['key'];
        }
        if (isset($key) && strlen(trim($key)) > 0) {
            $userInfo = $this->checkChangeEmailKey($key);
            if (isset($userInfo)) {
                foreach ($userInfo as $key => $value) {
                    $this->view->validUser = 1;
                    $this->view->userName = $value['first_name'] . " " . $value['last_name'];
                    $this->view->userEmail = $value['email'];
                    $this->view->userId = $value['user_id'];

                    $this->view->authentication_method_id = $value['authentication_method_id'];
                }
            } else {
                $this->view->validUser = 0;
            }
        } else {
            $this->view->validUser = 0;
        }
    }

    public function activateAction() {
        $this->_helper->layout->disableLayout();
        $key = null;
        if ($this->_request->isXmlHttpRequest()) {
            $key = $this->_request->getParam('key');
        } else {
            if (isset($_GET['key']))
                $key = $_GET['key'];
        }
        if (isset($key) && strlen(trim($key)) > 0) {
            $userInfo = $this->checkAccountActivationKey($key);
            if (isset($userInfo)) {
                foreach ($userInfo as $key => $value) {
                    $this->view->validUser = 1;
                    $this->view->userName = $value['first_name'] . " " . $value['last_name'];
                    $this->view->userEmail = $value['email'];
                    $this->view->userId = $value['user_id'];
                    $this->view->userLoggedIn = 1;
                    $this->view->authentication_method_id = $value['authentication_method_id'];
                    $userInfoObj = new Application_Model_LjUserInfo();
                    //Set user active_flag to 1
                    $userInfoObj->ActivateUser($value['user_id']);
                    $postObj = new Application_Model_LjPosting();
                    //Change posting status to active from created.
                    $postObj->ChangePostingStatusToActiveForNewUser($value['user_id']);
                    $arUserInfo['user_id'] = $value['user_id'];
                    $arUserInfo['email'] = $value['email'];
                    $arUserInfo['first_name'] = $value['first_name'];
                    $arUserInfo['last_name'] = $value['last_name'];
                    $arUserInfo['authentication_method_id'] = $value['authentication_method_id'];
                    $arUserInfo['active_flag'] = 1;
                    Zend_Session::namespaceUnset('UserInfo');
                    $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
                    $this->userInfoNamespace->user_info = $arUserInfo;
                }
            } else {
                $this->view->validUser = 0;
            }
        } else {
            $this->view->validUser = 0;
        }
    }

    public function resetpwdemailAction() {
        $resetPwdStatus = array(
            'status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
        );
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $userId = $this->_request->getParam('userId');
            $emailId = $this->_request->getParam('emailId');
            $sendEmail = $this->_request->getParam('sendEmail');

            if ($sendEmail == "1") {
                $this->sessionObj = new Application_Service_LjSession();
                $userInfoObj = $this->sessionObj->execute_service('Application_Service_GetUser', $userId, false);

                if (isset($userInfoObj)) {
                    $toUserFirstName = $userInfoObj->first_name;
                    $toUserLastName = $userInfoObj->last_name;
                    $toEmail = $emailId;

                    $subject = "Instructions For Resetting Your LocalJoe Password";
                    $tokens = array(
                        'first_name' => $userInfoObj->first_name,
                        'reset_pwd_url' => $this->getResetPwdLink($userId)
                    );
                    $message = $this->getResetPwdEmailContents($tokens);

                    $message = urldecode($message);
                    $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
                    if ($this->sendEmail($emailConfig->fromName, $emailId, $toUserFirstName . ' ' . $toUserLastName, $toEmail, $subject, $message, true)) {
                        $tokens = array(
                            'reset_pwd_email' => $emailId
                        );


                        $resetPwdStatus = array(
                            'status' => Application_Model_LjConstants::$SUCCESS,
                            'message' => $this->getResetPwdMsgContents($tokens)
                        );
                    }
                    else
                        $resetPwdStatus = array(
                            'status' => Application_Model_LjConstants::$FAILURE,
                            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
                        );
                }
            }
            else {
                $tokens = array(
                    'reset_pwd_email' => $emailId
                );
                $resetPwdStatus = array(
                    'status' => Application_Model_LjConstants::$SUCCESS,
                    'message' => $this->getResetPwdMsgContents($tokens)
                );
            }
        }
        echo json_encode($resetPwdStatus);
        exit;
    }

    private function checkAccountActivationKey($key) {
        $userInfoObj = new Application_Model_LjUserInfo();
        $where = "where account_activation_key='" . $key . "'";
        $userInfoObj->sql_stmt = 'select user_id,first_name,last_name,email,authentication_method_id,active_flag from user_info ' . "$where";
        $result = $userInfoObj->query();
        return $result;
    }

    private function checkResetPwdKey($key) {
        $userInfoObj = new Application_Model_LjUserInfo();
        $where = "where reset_password_key='" . $key . "'";
        $userInfoObj->sql_stmt = 'select user_id,first_name,last_name,email,authentication_method_id,active_flag from user_info ' . "$where";
        $result = $userInfoObj->query();
        return $result;
    }

    private function checkChangeEmailKey($key) {
        $userInfoObj = new Application_Model_LjUserInfo();
        $where = "where email_authorization_key='" . $key . "'";
        $userInfoObj->sql_stmt = 'select user_id,first_name,last_name,email,authentication_method_id,active_flag from user_info ' . "$where";
        $result = $userInfoObj->query();
        return $result;
    }

    private function save($action) {
        $arUserInfo = array();
        $screen = null;
        $ip = 'unknown';
        if (isset($_SERVER['REMOTE_ADDR']))
         $ip=$_SERVER['REMOTE_ADDR'];
        if ($action == 'create') {
            $arUserInfo = array(
                'user_id' => $this->_request->getParam('user_id'),
                'authentication_method_id' => $this->_request->getParam('authentication_method_id'),
                'first_name' => $this->_request->getParam('first_name'),
                'last_name' => $this->_request->getParam('last_name'),
                'email' => $this->_request->getParam('email'),
                'active_flag' => $this->_request->getParam('active_flag'),
                'date_created' => date("Y-m-d H:i:s"),
                'date_updated' => date("Y-m-d H:i:s"),
                'last_login_date' => date("Y-m-d H:i:s"),
                 'last_login_ip' => $ip
                
            );
        } else if ($action == 'update') {
            $arUserInfo = array(
                'user_id' => $this->_request->getParam('user_id'),
                'authentication_method_id' => $this->_request->getParam('authentication_method_id'),
                'first_name' => $this->_request->getParam('first_name'),
                'last_name' => $this->_request->getParam('last_name'),
                'email' => $this->_request->getParam('email'),
                'active_flag' => $this->_request->getParam('active_flag'),
                'last_login_date' => date("Y-m-d H:i:s"),
                'reset_password_key' => '',
                 'last_login_ip' => $ip
            );
        }


        try {

            $this->user_info = new Application_Service_LjSession();
            if ($action == 'create') {
                $userResult = $this->user_info->execute_service('Application_Service_CreateUser', $arUserInfo, true);
                if ($arUserInfo['active_flag'] != '1') {
                    $key = $this->createAccountActivationKey();
                    $this->setAccountActivationKeyInDB($arUserInfo['user_id'], $key);
                    $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
                    $subject = $emailConfig->subject;
                    $body = "";

                    $tokens = array(
                        'name' => $arUserInfo['first_name'] . ' ' . $arUserInfo['last_name'],
                        'website' => $emailConfig->website,
                        'activationUrl' => $emailConfig->activationUrl . '#page=activate&key=' . $key
                    );

                    if ($emailConfig->format == "html")
                        $body = $this->getHtmlEmailContents($tokens);
                    else
                        $body = $this->getTextEmailContents($tokens);
                    $this->sendEmail($emailConfig->fromName, $emailConfig->fromEmail, $arUserInfo['first_name'] . ' ' . $arUserInfo['last_name'], $arUserInfo['email'], $subject, $body, false);
                }
            } elseif ($action == 'update') {
                $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);
                $screen = $this->_request->getParam('screen');
                if (isset($screen) && $screen != 'undefined'
                        && $this->_request->getParam('screen') == "change-email") {
                    $arUserInfo = array(
                        'user_id' => $this->_request->getParam('user_id'),
                        'email_authorization_key' => ''
                    );
                    $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);
                }
            }
        } catch (Exception $e) {

            //throw $e;
        }
    }

}