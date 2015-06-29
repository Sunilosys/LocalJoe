<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostController
 *
 * @author sunil_salunkhe
 */
require_once 'Mail/class.phpmailer.php';

// The Apache Solr Client library should be on the include path
// which is usually most easily accomplished by placing in the
// same directory as this script ( . or current directory is a default
// php include path entry in the php.ini)


class PostController extends Lj_Controller_Action {

    public function init() {

        parent::init();
    }

    public function indexAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function preprocessAction() {
        $this->_helper->layout->disableLayout();

        $finished = false;
        $start = 0;
        $rows = 100;
        $sessionObj = new Application_Service_LjSession();
        while (!$finished) {

            $input = array(
                'start' => $start,
                'rows' => $rows,
            );
            $postInfo = $sessionObj->execute_service('Application_Service_GetPostingsWithoutShortHtml', $input, false);
            $postingIds = null;
            $start = $start + $rows;
            foreach ($postInfo as $key => $value) {
                $postingIds = $postingIds . "," . $value['posting_id'];
            }
            if (isset($postingIds)) {
                $postingIds = trim($postingIds, ',');
                $postObj = new Application_Model_LjPosting();
                $pageHtml = $postObj->CreatePostSnippet($postingIds, true);
            } else {
                $finished = true;
            }
        }
        exit;
    }

    public function detailsAction() {
        $postingId = null;
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $this->_helper->layout->disableLayout();
        } else {
            if (isset($_GET['postingId']) && strlen($_GET['postingId']) > 0)
                $postingId = $_GET['postingId'];
        }
        $this->longHtml = null;
        if (isset($postingId)) {
            $this->postObj = new Application_Model_LjPosting();
            $this->longHtml = $this->postObj->CreatePostLongHtml($postingId);
            if (isset($this->longHtml))
                $this->view->postInfo = $this->longHtml;
        }
        if (!isset($this->longHtml))
            $this->view->postInfo = "";
        echo $this->view->postInfo;
        exit;
    }

    public function poststatisticsAction() {

        $postingId = null;
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
        }
        $postStats = null;
        $postStatsArray = null;
        if (isset($postingId)) {
            $this->postObj = new Application_Model_LjPosting();
            $postStats = $this->postObj->GetPostStatistics($postingId);
        }

        $fbShareCount = 0;
        $twitterShareCount = 0;
        $emailCount = 0;
        $viewCount = 0;
        $responseCount = 0;
        if (isset($postStats)) {
            foreach ($postStats as $key => $value) {


                if (strtolower($value['action']) == "view")
                    $viewCount = $value['count'];
                else if (strtolower($value['action']) == "facebook share")
                    $fbShareCount = $value['count'];
                else if (strtolower($value['action']) == "twitter share")
                    $twitterShareCount = $value['count'];
                else if (strtolower($value['action']) == "email to friend")
                    $emailCount = $value['count'];
                else if (strtolower($value['action']) == "response")
                    $responseCount = $value['count'];
            }


            $postStatsArray[] = array(
                "view_count" => $viewCount,
                "email_count" => $emailCount,
                "fbshare_count" => $fbShareCount,
                "twitter_share_count" => $twitterShareCount,
                "response_count" => $responseCount
            );
        }
        if (isset($postStatsArray))
            echo json_encode($postStatsArray);
        else
            echo "";
        exit;
    }

    public function listingAction() {
        $this->_helper->layout->disableLayout();
        $pageHtml = "";

        if ($this->_request->isXmlHttpRequest()) {
            $postObj = new Application_Model_LjPosting();
            $pageHtml = $postObj->GetSearchPostings($this->_request->getParam('postingIds'), true);
        }
//       $pageHtml = html($pageHtml);
//        $tempArray = array(
//                 'data' => $pageHtml                
//            );


        echo $pageHtml;
        exit;
    }

    public function getlastpostshareinfoAction() {
        $this->_helper->layout->disableLayout();
        $responseArray = array(
            'status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
        );
        if ($this->_request->isXmlHttpRequest()) {
            $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
            $postObj = new Application_Model_LjPosting();
            $postInfo = $postObj->GetLastPostForUser();

            if (isset($postInfo) && sizeof($postInfo) > 0) {
                foreach ($postInfo as $key => $value) {
                    $responseArray = array(
                        'status' => Application_Model_LjConstants::$SUCCESS,
                        'postingId' => $value['posting_id'],
                        'postTitle' => $value['title'],
                        'postDesc' => $value['description'],
                        'detailsUrl' => urlencode($postConfig->post_share_url . $value['posting_id']),
                        'twitterShareLink' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . strip_tags($value['title']));
                }
            }
        }
        echo json_encode($responseArray);
        exit;
    }

    public function createAction() {
        $this->_helper->layout->disableLayout();
    }

    public function getAction() {
        $this->_helper->layout->disableLayout();
        $postInfoArray = null;
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $this->sessionObj = new Application_Service_LjSession();
            $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingsByIds', $postingId, false);
            if (isset($this->postInfo)) {
                $postObj = new Application_Model_LjPosting();
                $postInfoArray = $postObj->ConvertPostInfoAsArray($this->postInfo);
            }
        }
        if (isset($postInfoArray) && sizeof($postInfoArray))
            echo json_encode($postInfoArray);
        else
            echo "";
        exit;
    }
    
     public function hideAction() {
        $this->_helper->layout->disableLayout();
        $hideStatus = Application_Model_LjConstants::$FAILURE;
        if ($this->_request->isXmlHttpRequest()) {
            $postingViewId = $this->_request->getParam('postingViewId');
            $this->sessionObj = new Application_Service_LjSession();

           
                if (isset($this->view->userId)) {
                    $postObj = new Application_Model_LjPosting();
                    $status = $postObj->hidePostFromTimeline($postingViewId);
                    if ($status) {
                        $hideStatus = Application_Model_LjConstants::$SUCCESS;
                    }
                    else
                        $hideStatus = Application_Model_LjConstants::$FAILURE;
                }
                else {
                    $hideStatus = Application_Model_LjConstants::$FAILURE;
                }
            
        }
        echo $hideStatus;
        exit;
    }

    public function flagdeletedAction() {
        $this->_helper->layout->disableLayout();
        $flagAsDeletedStatus = array(
            'status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
        );
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $this->sessionObj = new Application_Service_LjSession();
            $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingById', $postingId, false);

            if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
                if ($this->view->userId == $this->postInfo->user_id) {
                    $postObj = new Application_Model_LjPosting();
                    $status = $postObj->FlagPostAsDeleted($postingId);
                    if ($status) {
                        $flagAsDeletedStatus = array(
                            'status' => Application_Model_LjConstants::$SUCCESS,
                            'message' => Application_Model_LjConstants::$POST_FLAG_DELETD_SUCCESS_MESSAGE
                        );
                        $actionId = Application_Model_LjConstants::$POST_ACTION_DELETE_ID;
                        $arAction = array(
                            'posting_id' => $postingId,
                            'user_id' => $this->view->userId,
                            'action_id' => $actionId,
                            'date_created' => date("Y-m-d H:i:s")
                        );
                        $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $arAction, false);
                    }
                    else
                        $flagAsDeletedStatus = array(
                            'status' => Application_Model_LjConstants::$FAILURE,
                            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
                        );
                }
                else {
                    $flagAsDeletedStatus = array(
                        'status' => Application_Model_LjConstants::$FAILURE,
                        'message' => Application_Model_LjConstants::$POST_FLAG_DELETED_NOT_AUTHORIZED_MESSAGE
                    );
                }
            }
        }
        echo json_encode($flagAsDeletedStatus);
        exit;
    }

//    public function deleteAction() {
//        $this->_helper->layout->disableLayout();
//        $deleteStatus = array(
//            'status' => Application_Model_LjConstants::$FAILURE,
//            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
//        );
//        if ($this->_request->isXmlHttpRequest()) {
//            $postingId = $this->_request->getParam('postingId');
//            $this->sessionObj = new Application_Service_LjSession();
//            $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingById', $postingId, false);
//
//            if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
//                if ($this->view->userId == $this->postInfo->user_id) {
//                    $postObj = new Application_Model_LjPosting();
//                    $status = $postObj->DeletePost($postingId);
//                    if ($status)
//                        $deleteStatus = array(
//                            'status' => Application_Model_LjConstants::$SUCCESS,
//                            'message' => Application_Model_LjConstants::$POST_DELETE_SUCCESS_MESSAGE
//                        );
//                    else
//                        $deleteStatus = array(
//                            'status' => Application_Model_LjConstants::$FAILURE,
//                            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
//                        );
//                }
//                else {
//                    $deleteStatus = array(
//                        'status' => Application_Model_LjConstants::$FAILURE,
//                        'message' => Application_Model_LjConstants::$POST_DELETE_NOT_AUTHORIZED_MESSAGE
//                    );
//                }
//            }
//        }
//        echo json_encode($deleteStatus);
//        exit;
//    }
    public function repostAction() {
        $this->_helper->layout->disableLayout();
        $repostStatus = array(
            'status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
        );
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $this->sessionObj = new Application_Service_LjSession();
            $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingById', $postingId, false);

            if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
                if ($this->view->userId == $this->postInfo->user_id) {
                    $postObj = new Application_Model_LjPosting();
                    $status = $postObj->Repost($postingId);
                    if ($status) {
                        $repostStatus = array(
                            'status' => Application_Model_LjConstants::$SUCCESS,
                            'message' => Application_Model_LjConstants::$POST_REPOST_SUCCESS_MESSAGE
                        );
                        $actionId = Application_Model_LjConstants::$POST_ACTION_REPOST_ID;
                        $arAction = array(
                            'posting_id' => $postingId,
                            'user_id' => $this->view->userId,
                            'action_id' => $actionId,
                            'date_created' => date("Y-m-d H:i:s")
                        );
                        $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $arAction, false);
                    }
                    else
                        $repostStatus = array(
                            'status' => Application_Model_LjConstants::$FAILURE,
                            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
                        );
                }
                else {
                    $repostStatus = array(
                        'status' => Application_Model_LjConstants::$FAILURE,
                        'message' => Application_Model_LjConstants::$POST_REPOST_NOT_AUTHORIZED_MESSAGE
                    );
                }
            }
        }
        echo json_encode($repostStatus);
        exit;
    }

    public function editAction() {
        $postingId = null;
        $postInfoArray = null;
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $postingId = $this->_request->getParam('postingId');
        } else if (isset($_GET['postingId']) && strlen($_GET['postingId']) > 0)
            $postingId = $_GET['postingId'];

        if (!isset($postingId))
            exit;
        $this->sessionObj = new Application_Service_LjSession();
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingsByIds', $postingId, false);

        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            if ($this->view->userId == $this->postInfo[0]['user_id']) {
                $this->view->postingId = $this->postInfo[0]['posting_id'];
                $postObj = new Application_Model_LjPosting();
                $postInfoArray = $postObj->ConvertPostInfoAsArray($this->postInfo);
                $this->view->title = strip_tags($postInfoArray['title']);
                $this->view->description = $postInfoArray['description'];
                $this->view->categoryId = $postInfoArray['category_id'];
                $this->view->parentCategoryId = $postInfoArray['parent_category_id'];
                $this->view->address = $postInfoArray['address'];
                $this->view->categoryName = $postInfoArray['category_name'];
                $this->view->parentCategoryName = $postInfoArray['parent_category_name'];
                $this->view->lat = $postInfoArray['lat'];
                $this->view->lon = $postInfoArray['lon'];
                $this->view->zip = $postInfoArray['zip'];
                $this->view->city = $postInfoArray['city'];
                $this->view->phone = $postInfoArray['phone'];
                $this->view->tags = $postInfoArray['tags'];
                $this->view->post_anonymously = $postInfoArray['post_anonymously'];
                $categoryAttrArray = null;
                foreach ($postInfoArray['category_attributes'] as $key => $value) {
                    $categoryAttrArray[] = array(
                        "category_attribute_id" => $value['category_attribute_id'],
                        "name" => $value['name'],
                        "value" => $value['value'],
                        "dimension" => urldecode($value['dimension'])
                    );
                }
                if (isset($categoryAttrArray))
                    $this->view->categoryAttributes = json_encode($categoryAttrArray);
                else
                    $this->view->categoryAttributes = null;
            }
        }
    }

    public function formatcurrencyAction() {
        $this->_helper->layout->disableLayout();
        $formattedCurrency = "";
        try {

            if ($this->_request->isXmlHttpRequest()) {
                $postObj = new Application_Model_LjPosting();
                $formattedCurrency = $postObj->formatCurrency($this->_request->getParam('attrValue'));
            }
        } catch (Exception $e) {
            $formattedCurrency = $this->_request->getParam('attrValue');
        }
        echo $formattedCurrency;
        exit;
    }

    public function fbshareAction() {
        $this->_helper->layout->disableLayout();
        $fbSharePostData = array('status' => 'failure');
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $postObj = new Application_Model_LjPosting();
            $postInfo = $postObj->GetFbSharePostInfo($postingId);

            if (isset($postInfo)) {

                $fbSharePostData = array(
                    'status' => 'success',
                    'method' => 'feed',
                    'name' => strip_tags($postInfo['emphasized_section']) . '-' . $postInfo['title'],
                    'caption' => $postConfig->post_share_url,
                    'description' => strip_tags($postInfo['description']),
                    'link' => $postConfig->post_share_url . $postInfo['posting_id'],
                    'picture' => $postInfo['cover_image_url']
                );
            }
        }
        echo json_encode($fbSharePostData);
        exit;
    }

    public function updatecaptionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $imageId = $this->_request->getParam('imageId');
            $caption = $this->_request->getParam('caption');
            $this->sessionObj = new Application_Service_LjSession();
            if (isset($imageId) && $imageId != "" && $imageId != "undefined") {
                $arImageInfo = array(
                    'image_id' => $imageId,
                    'image_title' => $caption
                );
                print_r($arImageInfo);
                $imageResult = $this->sessionObj->execute_service('Application_Service_UpdateImage', $arImageInfo, false);
            }
        }
        exit;
    }

    function associative_push($arr, $tmp) {
        if (is_array($tmp)) {
            foreach ($tmp as $key => $value) {
                $arr[$key] = $value;
            }
            return $arr;
        }
        return false;
    }

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $postData = json_decode(stripslashes($_POST['data']), true);
            if ($postData['postingId'] == "" || $postData['postingId'] == "undefined")
                $this->save('create');
            else
                $this->save('update');
        }
    }

    public function confirmAction() {
        
    }
    


    public function sendresponseAction() {
        $sendResponseStatus = array(
            'status' => Application_Model_LjConstants::$FAILURE,
            'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
        );
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $emailId = $this->_request->getParam('emailId');
            $senderName = $this->_request->getParam('senderName');
            $senderContactNo = $this->_request->getParam('senderContactNo');
            $subject = $this->_request->getParam('subject');
            $message = $this->_request->getParam('message');
            
            $toUserFirstName = "";
            $toUserLastName = "";
            $toEmail = "";
            $toPhone = "";
            $smsBody = $this->_request->getParam('smsBody');
            $enableSMS = $this->_request->getParam('enableSMS');
            $message = 'Hey, you got a response from ' . $senderName. ', you can reply to this email to get back.<br/><br/>' . $message;
            $message = urldecode($message);

            $this->sessionObj = new Application_Service_LjSession();
            $toUserInfo = $this->sessionObj->execute_service('Application_Service_GetPostOwner', $postingId, false);
            if (isset($toUserInfo)) {
                foreach ($toUserInfo as $key => $value) {
                    if (isset($value['external_email']) && strlen($value['external_email']) > 0) {
                        $toUserFirstName = "";
                        $toUserLastName = "";
                        $toEmail = $value['external_email'];
                    } else {
                        $toUserFirstName = $value['first_name'];
                        $toUserLastName = $value['last_name'];
                        $toEmail = $value['email'];
                    }
                    $toPhone = $value['phone'];
                }
                if ($this->sendEmail($senderName, $emailId, $toUserFirstName . ' ' . $toUserLastName, $toEmail, $subject, $message, true)) {
                    $sendResponseStatus = array(
                        'status' => Application_Model_LjConstants::$SUCCESS,
                        'message' => ""
                    );
                    $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
                    if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                        $userInfo = $this->userInfoNamespace->user_info;
                        $arResponseInfo = array(
                            'posting_id' => $postingId,
                            'user_id' => $userInfo['user_id'],
                            'subject' => $subject,
                            'message' => $message,
                            'date_created' => date("Y-m-d H:i:s")
                        );
                        $postResInfo = $this->sessionObj->execute_service('Application_Service_CreatePostResponse', $arResponseInfo, false);
                        $actionId = Application_Model_LjConstants::$POST_ACTION_RESPONSE_ID;
                        $arResonseAction = array(
                            'posting_id' => $postingId,
                            'user_id' => $userInfo['user_id'],
                            'action_id' => $actionId,
                            'date_created' => date("Y-m-d H:i:s")
                        );
                        $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $arResonseAction, false);
                    }
                }
                else
                    $sendResponseStatus = array(
                        'status' => Application_Model_LjConstants::$FAILURE,
                        'message' => Application_Model_LjConstants::$ERROR_MESSAGE_UNEXPECTED
                    );
               
                try {

                    if ($enableSMS == '1' && $toPhone != "") {
                        $twilioSMS = new twilioSMS();

                        $sendSMS = $twilioSMS->SendSMS($senderContactNo,$toUserFirstName . ' ' . $toUserLastName, $toPhone, $smsBody,"Send SMS");
                    }
                } catch (Exception $ex) {
                    
                }
            }
        }
        echo json_encode($sendResponseStatus);
        exit;
    }

    private function setPostingStatus($userId) {
        $input = array(
            'posting_status_id' => Application_Model_LjConstants::$POST_STATUS_CREATED_ID,
            'user_id' => $userId
        );
        $this->postingInfo = new Application_Service_LjSession();
        $postingInfoObj = $this->postingInfo->execute_service('Application_Service_checkIfActivePostingForUser', $input, false);

        if ($postingInfoObj)
            $postingStatus = Application_Model_LjConstants::$POST_STATUS_ACTIVE_ID;
        else
            $postingStatus = Application_Model_LjConstants::$POST_STATUS_CREATED_ID;
        return $postingStatus;
    }

    private function save($action) {
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        $postData = json_decode(stripslashes($_POST['data']), true);
        $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        $userInfo = $this->userInfoNamespace->user_info;
        $currentDate = date("Y-m-d H:i:s");
        $expiryDate = date('Y-m-d H:i:s', strtotime($postConfig->expireafter));
        $postDesc = urldecode($postData['post_desc']);
        if (isset($userInfo['active_flag']) && $userInfo['active_flag'] == 1)
            $postingStatus = Application_Model_LjConstants::$POST_STATUS_ACTIVE_ID;
        else
            $postingStatus = Application_Model_LjConstants::$POST_STATUS_CREATED_ID;

        $postAnonymously = $postData['postAnonymously'];
        if ($postAnonymously != "undefined" && $postAnonymously != "" && $postAnonymously == 'Yes')
            $postAnonymously = '1';
        else
            $postAnonymously = '0';
        $upload_handler = new LjS3UploadHandler();
        $arPostInfo = array();
        if ($action == 'create') {
            $arPostInfo = array(
                'posting_status_id' => $postingStatus,
                'title' => strip_tags($postData['post_title']),
                'description' => $postDesc,
                'user_id' => $userInfo['user_id'],
                'category_id' => $postData['category_id'],
                'post_anonymously' => $postAnonymously,
                'posting_date' => $currentDate,
                'date_created' => $currentDate,
                'date_updated' => $currentDate,
                'expiration_date' => $expiryDate
            );
        } else if ($action == 'update') {
            $arPostInfo = array(
                'posting_id' => $postData['postingId'],
                'title' => strip_tags($postData['post_title']),
                'description' => $postDesc,
                'post_anonymously' => $postAnonymously,
                'posting_date' => $currentDate,
                'date_updated' => $currentDate,
                'expiration_date' => $expiryDate,
                'is_indexed' => 0,
                'is_preprocessed'=> 0,
                'short_html'=> null
            );
        }

        try {

            $this->sessionObj = new Application_Service_LjSession();
            $posting_id = null;
            $arPostingId = null;

            if ($action == 'create') {
                $postResult = $this->sessionObj->execute_service('Application_Service_CreatePost', $arPostInfo, false);
                if ($postResult) {
                    $posting_id = (int) $postResult;
                    $arPostingId = array(
                        'posting_id' => (int) $postResult
                    );

//                    if ($postingStatus == Application_Model_LjConstants::$POST_STATUS_CREATED_ID) {
//                        $key = $this->createAccountActivationKey();
//                        $this->setAccountActivationKeyInDB($userInfo['user_id'], $key);
//                        $emailConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'email');
//                        $subject = $emailConfig->subject;
//                        $body = "";
//
//                        $tokens = array(
//                            'name' => $toName,
//                            'website' => $emailConfig->website,
//                            'activationUrl' => $emailConfig->activationUrl . '#page=activate&key=' . $key
//                        );
//
//                        if ($emailConfig->format == "html")
//                            $body = $this->getHtmlEmailContents($tokens);
//                        else
//                            $body = $this->getTextEmailContents($tokens);
//                        $this->sendEmail($emailConfig->fromName, $emailConfig->fromEmail, $userInfo['name'], $userInfo['email'], $subject, $body, false);
//                    }
                    $actionId = Application_Model_LjConstants::$POST_ACTION_CREATE_ID;
                    $arAction = array(
                        'posting_id' => $posting_id,
                        'user_id' => $userInfo['user_id'],
                        'action_id' => $actionId,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                    $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $arAction, false);
                }
            } else if ($action == 'update') {
                $posting_id = $postData['postingId'];
                $postResult = $this->sessionObj->execute_service('Application_Service_UpdatePost', $arPostInfo, false);
                $actionId = Application_Model_LjConstants::$POST_ACTION_EDIT_ID;
                $arAction = array(
                    'posting_id' => $posting_id,
                    'user_id' => $userInfo['user_id'],
                    'action_id' => $actionId,
                    'date_created' => date("Y-m-d H:i:s")
                );
                $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $arAction, false);
            }
            $arPostingId = array(
                'posting_id' => $posting_id
            );
            //Posting Attribute Section
            $deletePostAttribute = $this->sessionObj->execute_service('Application_Service_DeletePostAttribute', $arPostingId, false);

            if (isset($postData['posting_category_attributes']) && count($postData['posting_category_attributes']) > 0) {
                for ($i = 0; $i < count($postData['posting_category_attributes']); ++$i) {
                    $category_attribute_id = $postData['posting_category_attributes'][$i]['category_attribute_id'];
                    $value = $postData['posting_category_attributes'][$i]['value'];
                    $dimension = $postData['posting_category_attributes'][$i]['dimension'];
                    $arPostCategoryInfo = array(
                        'posting_id' => $posting_id,
                        'category_attribute_id' => $category_attribute_id,
                        'value' => $value,
                        'dimension' => $dimension,
                        'is_other' => 0,
                        'date_created' => $currentDate
                    );

                    $postAttrResult = $this->sessionObj->execute_service('Application_Service_CreatePostAttribute', $arPostCategoryInfo, false);
                }
            }
            //End
            //Library Images Section
            $libray_image_ids = array();
            if (isset($postData['library_images']) && count($postData['library_images']) > 0) {
                for ($i = 0; $i < count($postData['library_images']); ++$i) {
                    $fileName = $postData['library_images'][$i]['fileName'];
                    $imageId = $postData['library_images'][$i]['imageId'];
                    $caption = $postData['library_images'][$i]['caption'];
                    $org_image_width = $postData['library_images'][$i]['org_img_width'];
                    $org_image_height = $postData['library_images'][$i]['org_img_height'];
                    $size = $postData['library_images'][$i]['size'];
                    $image_type_width = $postData['library_images'][$i]['image_type_width'];
                    $image_type_height = $postData['library_images'][$i]['image_type_height'];
                    $image_type_size = $postData['library_images'][$i]['image_type_size'];


                    if (isset($imageId) && $imageId != "" && $imageId != "undefined") {
                        $arImageInfo = array(
                            'image_id' => $imageId,
                            'image_title' => $caption
                        );

                        $imageResult = $this->sessionObj->execute_service('Application_Service_UpdateImage', $arImageInfo, false);
                    } else {

                        $arImageInfo = array(
                            'user_id' => $userInfo['user_id'],
                            'image_title' => $caption,
                            'image_file' => $fileName,
                            'width' => $org_image_width,
                            'height' => $org_image_height,
                            'image_size' => $size,
                            'date_created' => $currentDate
                        );
                        $last_insert_image_id = $this->sessionObj->execute_service('Application_Service_CreateImage', $arImageInfo, false);
                        $libray_image_ids[] = array(
                            "image_id" => $last_insert_image_id,
                            "file_name" => $fileName
                        );
                        $upload_handler->copy($fileName, $last_insert_image_id);
                        $arImageTypeInfo = array(
                            'image_id' => $last_insert_image_id,
                            'image_type_id' => 1,
                            'image_file' => $fileName,
                            'width' => $image_type_width,
                            'height' => $image_type_height,
                            'image_size' => $image_type_size,
                            'date_created' => $currentDate
                        );
                        $imageTypeResult = $this->sessionObj->execute_service('Application_Service_CreateImageCopy', $arImageTypeInfo, false);
                    }
                }
            }
            //End
            //Posting Images Section
            if (isset($postData['posting_images']) && count($postData['posting_images']) > 0) {

                $deletePostImageResult = $this->sessionObj->execute_service('Application_Service_DeletePostingImage', $arPostingId, false);

                for ($i = 0; $i < count($postData['posting_images']); ++$i) {
                    $fileName = $postData['posting_images'][$i]['fileName'];
                    $imageId = $postData['posting_images'][$i]['imageId'];
                    $isCover = $postData['posting_images'][$i]['is_main_image'];
                    $arPostImageInfo = array();
                    if ($imageId == "" || $imageId == "undefined") {
                        foreach ($libray_image_ids as $key => $value) {
                            if ($value['file_name'] == $fileName) {
                                $imageId = $value['image_id'];
                                break;
                            }
                        }
                    }

                    $arPostImageInfo = array(
                        'posting_id' => $posting_id,
                        'image_id' => $imageId,
                        'is_main_image' => $isCover,
                        'date_created' => $currentDate
                    );
                    $postImageResult = $this->sessionObj->execute_service('Application_Service_CreatePostingImage', $arPostImageInfo, false);
                }
            }
            //End
            //Save tags
            if (isset($postData['tags']) && strlen(trim($postData['tags'])) > 0) {
                $tags = explode(",", $postData['tags']);
                for ($i = 0; $i < sizeof($tags); $i++) {
                    $tag = trim($tags[$i]);
                    if (strlen($tag) > 0) {
                        $tagId = null;
                        //check if tag already exists in tag table

                        $tagInfo = $this->sessionObj->execute_service('Application_Service_GetTagByName', $tag, false);
                        if (isset($tagInfo)) {
                            $tagId = $tagInfo->tag_id;
                        } else {
                            $arTagInfo = array(
                                'tag_name' => $tag,
                                'date_created' => $currentDate
                            );
                            $tagId = $this->sessionObj->execute_service('Application_Service_CreateTag', $arTagInfo, false);
                        }
                        if (isset($tagId)) {
                            $arPostTagInfo = array(
                                'tag_id' => $tagId,
                                'posting_id' => $posting_id,
                                'date_created' => $currentDate
                            );
                            $postTagInfo = $this->sessionObj->execute_service('Application_Service_GetPostTagByTagId', $arPostTagInfo, false);
                            if (!isset($postTagInfo)) {

                                $postTagInfo = $this->sessionObj->execute_service('Application_Service_CreatePostingTag', $arPostTagInfo, false);
                            }
                        }
                    }
                }
            }

            if (isset($postData['location_address']) && isset($postData['lat']) && isset($postData['lon'])) {
                $arPostAddressInfo = array(
                    'posting_id' => $posting_id,
                    'city' => $postData['city'],
                    'address' => $postData['location_address'],
                    'zip' => $postData['zip_code'],
                    'lat' => $postData['lat'],
                    'lon' => $postData['lon'],
                    'phone' => $postData['phone_no'] != $this->view->phoneformat ? $postData['phone_no'] : "",
                    'date_created' => $currentDate
                );
                $postAddressDelete = $this->sessionObj->execute_service('Application_Service_DeleteAddress', $arPostingId, false);
                $postAddressInfo = $this->sessionObj->execute_service('Application_Service_CreateAddress', $arPostAddressInfo, false);
            }
            //Update user default location in session
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                $arUserInfo = $this->userInfoNamespace->user_info;
                $arUserInfo['address'] = $postData['location_address'];
                $arUserInfo['lat'] = $postData['lat'];
                $arUserInfo['lon'] = $postData['lon'];
                $arUserInfo['city'] = $postData['city'];
                $arUserInfo['zip'] = $postData['zip'];
                $arUserInfo['phone'] = $postData['phone_no'] != $this->view->phoneformat ? $postData['phone_no'] : "";
                $this->userInfoNamespace->user_info = $arUserInfo;
            }
            //End
            //Creat short html snippet
            $postObj = new Application_Model_LjPosting();
            $shortHtml = $postObj->CreatePostSnippet($posting_id, false);
            $longHtml = $postObj->CreatePostLongHtml($posting_id);
            //end
//            $response = array(
//                'postingId' => $posting_id,
//                'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $posting_id) . '&text=' . strip_tags($postData['post_title']));
//            echo json_encode($response);
            exit;
        } catch (Exception $e) {

            throw $e;
        }
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

}

