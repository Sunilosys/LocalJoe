<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchController
 *
 * @author sunil_salunkhe
 */
require_once('Apache/Solr/Service.php');

class SearchController extends Lj_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction() {
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        //Default Search
//        if (!$this->_request->isXmlHttpRequest()) {
//            $searchText = "";
//            $categoryFields = "";
//            $categoryName = "All Categories";
//            $isParentCategory = "false";
//            if (isset($_GET['keyword']) && strlen($_GET['keyword']) > 0) {
//                $searchText = $_GET['keyword'];
//            }
//            if (isset($_GET['category']) && strlen($_GET['category']) > 0) {
//                $categoryName = $_GET['category'];
//            }
//
//            if (isset($_GET['is_parent_category']) && strlen($_GET['is_parent_category']) > 0) {
//                $isParentCategory = $_GET['is_parent_category'];
//            }
//            if ($categoryName != "All Categories") {
//                if ($isParentCategory == "true")
//                    $categoryFields = "parent_category_name_t:" + $categoryName;
//                else
//                    $categoryFields = "category_name_t:" + $categoryName;
//            }
//            $searchParamArray = array(
//                'searchText' => $searchText,
//                'categoryName' => $categoryName,
//                'isParentCategory' => $isParentCategory,
//                'refreshRefineSection' => "true",
//                'refreshCategorySection' => "true",
//                'categoryFields' => $categoryFields,
//                'selectedFields' => "",
//                'rangeFields' => "",
//                'dateFields' => "",
//                'multiSelectFields' => "",
//                'start' => 0,
//                'sort' => 'date_updated_dt desc'
//            );
//            $this->search($searchParamArray);
//            
//        }
    }

    public function listingAction() {
        $this->_helper->layout->disableLayout();
        $log = Zend_Registry::get('log');

        $time_start = microtime(true);


        if ($this->_request->isXmlHttpRequest()) {
            $searchText = $this->_request->getParam('searchText');
            $categoryName = $this->_request->getParam('categoryName');
            $isParentCategory = $this->_request->getParam('isParentCategory');
            $refreshRefineSection = $this->_request->getParam('refreshRefineSection');
            $categoryFields = $this->_request->getParam('categoryFields');
            $selectedFields = $this->_request->getParam('selectedFields');
            $rangeFields = $this->_request->getParam('rangeFields');
            $dateFields = $this->_request->getParam('dateFields');
            $multiSelectFields = $this->_request->getParam('multiSelectFields');
            $start = $this->_request->getParam('start');
            $sort = $this->_request->getParam('sort');
            //Special Handling for '+' sign
            if (stristr($multiSelectFields, '~plus~') !== FALSE)
                $multiSelectFields = str_replace('~plus~', '+', $multiSelectFields);

            if (stristr($selectedFields, '~plus~') !== FALSE)
                $selectedFields = str_replace('~plus~', '+', $selectedFields);
            //End            
            $searchParamArray = array(
                'searchText' => $searchText,
                'categoryName' => $categoryName,
                'isParentCategory' => $isParentCategory,
                'refreshRefineSection' => $refreshRefineSection,
                'categoryFields' => $categoryFields,
                'selectedFields' => $selectedFields,
                'rangeFields' => $rangeFields,
                'dateFields' => $dateFields,
                'multiSelectFields' => $multiSelectFields,
                'start' => $start,
                'sort' => $sort,
            );
            Zend_Session::namespaceUnset('PreviousSavedSearch');
            $this->prevSavedSearchNS = new Zend_Session_Namespace('PreviousSavedSearch');
            $this->prevSavedSearchNS->previousSavedSearch = urlencode(json_encode($searchParamArray));


            $this->search($searchParamArray);
            $time_end = microtime(true);
            if (isset($log))
                $log->info("Search Completed. Time Taken " . ($time_end - $time_start));
        }
        exit;
    }

    public function searchbyshortlistAction() {
        $this->_helper->layout->disableLayout();
        $pageHtml = "";
        if ($this->_request->isXmlHttpRequest()) {
            $shortlistId = $this->_request->getParam('shortlistId');
            $sort = $this->_request->getParam('sort');
            $input = array('shortlistId' => $shortlistId, 'sort' => $sort);
            $this->sessionObj = new Application_Service_LjSession();
            $folderPostings = $this->sessionObj->execute_service('Application_Service_GetFolderPostings', $input, false);
            if (isset($folderPostings) && $folderPostings != "") {
                $postObj = new Application_Model_LjPosting();
                $pageHtml = $postObj->GetSearchPostings($folderPostings, true);
                $postArray = explode(',', $folderPostings);
                $pageHtml = $pageHtml . '<SolrNoFound>' . sizeof($postArray);
            }
        }
        echo $pageHtml;
        exit;
    }

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $lastSearchId = null;
        $this->savedSearchHtml = "";
        $previousSavedSearch = "";
        if ($this->_request->isXmlHttpRequest()) {
            $userId = null;
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                $userInfo = $this->userInfoNamespace->user_info;
                if ($userInfo['user_id'] != 0)
                    $userId = $userInfo['user_id'];
            }
            $savedSearchName = $this->_request->getParam('savedSearchName');
            $this->prevSavedSearchNS = new Zend_Session_Namespace('PreviousSavedSearch');
            if (isset($this->prevSavedSearchNS) && $this->prevSavedSearchNS->previousSavedSearch) {

                if (isset($userId)) {
                    $previousSavedSearch = $this->prevSavedSearchNS->previousSavedSearch;
                    $arSavedSearchInfo = array(
                        'user_id' => $userId,
                        'search_terms' => $previousSavedSearch,
                        'search_name' => $savedSearchName,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                    $this->sessionObj = new Application_Service_LjSession();
                    $lastSearchId = $this->sessionObj->execute_service('Application_Service_CreateSavedSearch', $arSavedSearchInfo, false);
                }
            }
            if (isset($lastSearchId)) {
                $this->savedSearchesInfo = null;
                $this->sessionObj = new Application_Service_LjSession();
                $savedSearches = $this->sessionObj->execute_service('Application_Service_GetSavedSearches', $userId, false);
                $this->savedSearchesInfo = $savedSearches;
                if (isset($this->savedSearchesInfo) && sizeof($this->savedSearchesInfo) > 0)
                    $this->savedSearchHtml = $this->generateSavedSearchHtml($this->savedSearchesInfo);
            } else {
                $this->savedSearchHtml = "";
            }
        }

        echo $this->savedSearchHtml;
        exit;
    }

    public function deleteAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {

            $savedSearchId = $this->_request->getParam('savedSearchId');
            $userId = null;
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                $userInfo = $this->userInfoNamespace->user_info;
                if ($userInfo['user_id'] != 0)
                    $userId = $userInfo['user_id'];
            }
            if (isset($userId)) {

                $arSavedSearchInfo = array(
                    'user_id' => $userId,
                    'search_id' => $savedSearchId
                );
                $this->sessionObj = new Application_Service_LjSession();
                $deleteResult = $this->sessionObj->execute_service('Application_Service_DeleteSavedSearch', $arSavedSearchInfo, false);
            }
        }
        exit;
    }

    private function search($paramArray) {
        $statsFieldsArray = null;
        $searchArray = null;
        $facetFields = $this->getAllFieldsForCategory($paramArray['categoryName'], $paramArray['isParentCategory'], $paramArray['categoryFields']);
        //Prepare facet field array. Facet field array includes all fields except range fields 
        $allFieldsArray = $this->createAllFieldsArray($paramArray['categoryName'], $facetFields);
        $facetFieldsArray = $this->createFacetFieldsArray($paramArray['categoryName'], $facetFields);
        //End
        //Prepare stats fields array. Stats field array includes only range fields
        if (isset($facetFields))
            $statsFieldsArray = $this->createStatsFieldsArray($facetFields);
        //End

        $solrConfig = $this->getSolrConfig();

        $searchArray = array(
            'solr_host' => $solrConfig->solr_host,
            'solr_port' => $solrConfig->solr_port,
            'solr_root' => $solrConfig->solr_root,
            'q' => $this->generateSolrQuery($paramArray['searchText']),
            'fq' => $this->generateFilterQuery($paramArray['categoryName'], $paramArray['categoryFields'], $paramArray['selectedFields'], $paramArray['multiSelectFields'], $paramArray['rangeFields'], $paramArray['dateFields']),
            'wt' => $solrConfig->wt,
            'start' => $paramArray['start'],
            'rows' => $solrConfig->rows,
            'facet.field' => $facetFieldsArray,
            'sort' => $paramArray['sort'],
            'facet.mincount' => $solrConfig->facet_mincount,
            'stats' => isset($statsFieldsArray) ? 'true' : 'false',
            'stats.field' => isset($statsFieldsArray) ? $statsFieldsArray : ""
        );
      
        $results = $this->doSolrRequest($searchArray);

        //Check if search is done all categories and it falls within single category
        if ($results->response->numFound > 0 && $paramArray['categoryName'] == "All Categories") {

            $categoryCount = 0;
            foreach ($results->facet_counts->facet_fields->parent_category_name_t as $facet => $count) {
                if ($count != 0)
                    $categoryCount = $categoryCount + 1;
            }

            if ($categoryCount == 1) {
                $categoryFields = "parent_category_name_t:";
                $categoryName = "";
                $isParentCategory = 'true';
                foreach ($results->facet_counts->facet_fields->parent_category_name_t as $facet => $count) {
                    if ($count != 0) {
                        $categoryFields = $categoryFields . '"' . $facet . '"';
                        $categoryName = '"' . $facet . '"';
                    }
                }
                $searchParamArray = array(
                    'searchText' => $paramArray['searchText'],
                    'categoryName' => $categoryName,
                    'isParentCategory' => $isParentCategory,
                    'refreshRefineSection' => $paramArray['refreshRefineSection'],
                    'categoryFields' => $categoryFields,
                    'selectedFields' => $paramArray['selectedFields'],
                    'rangeFields' => $paramArray['rangeFields'],
                    'dateFields' => $paramArray['dateFields'],
                    'multiSelectFields' => $paramArray['multiSelectFields'],
                    'start' => $paramArray['start'],
                    'sort' => $paramArray['sort'],
                );
                Zend_Session::namespaceUnset('PreviousSavedSearch');
                $this->prevSavedSearchNS = new Zend_Session_Namespace('PreviousSavedSearch');
                $this->prevSavedSearchNS->previousSavedSearch = urlencode(json_encode($searchParamArray));


                $this->search($searchParamArray);
                exit;
            }
        }
        //End
        //Save the previous search
        Zend_Session::namespaceUnset('PreviousSearch');
        $this->previousSearchNS = new Zend_Session_Namespace('PreviousSearch');
        $this->previousSearchNS->previous_search_url = $this->_request->getParams();
        if (isset($results)) {
            $pageHtml = $this->generateSearchResultHtml($results);

            $leftNavHtml = "";
            $numFound = $results->response->numFound;
            if ($paramArray['refreshRefineSection'] === 'true') {
                $showClearAll = false;
                if ($paramArray['selectedFields'] != "" || $paramArray['multiSelectFields'] != "" || $paramArray['rangeFields'] != "" || $paramArray['dateFields'] != "")
                    $showClearAll = true;

                if (!$showClearAll && $paramArray['isParentCategory'] == "false")
                    $showClearAll = true;
                $facetFieldsObjArray = $this->processFacetFields($results, $facetFields, $allFieldsArray, $facetFieldsArray, $statsFieldsArray, $paramArray);
                $leftNavHtml = $this->generateRefineSectionHtml($facetFieldsObjArray, $showClearAll);
            }
            //if ($pageHtml != "")

            $pageHtml = $pageHtml . '<SolrNoFound>' . $numFound;
            if ($this->_request->isXmlHttpRequest()) {
                if ($leftNavHtml != "")
                    echo $pageHtml . '<leftNavSection>' . $leftNavHtml;
                else
                    echo $pageHtml;
            }
            else {
                $this->view->pageHtml = $pageHtml;
                $this->view->leftNavHtml = $leftNavHtml;
            }
        } else {
            $this->view->pageHtml = "";
        }
    }

    public function manageshortlistAction() {
        $this->_helper->layout->disableLayout();
        $this->addRemoveShortListHtml = "";
        $favorite_list = "";
        if ($this->_request->isXmlHttpRequest()) {

            $folderId = $this->_request->getParam('shortlistId');
            $postingId = $this->_request->getParam('postingId');
            $action = $this->_request->getParam('shortlistaction');
            if (isset($folderId) && isset($postingId)) {

                $arShortlistInfo = array(
                    'posting_id' => $postingId,
                    'folder_id' => $folderId
                );
                $this->sessionObj = new Application_Service_LjSession();
                $actionId = 0;
                if ($action == "Add") {
                    $result = $this->sessionObj->execute_service('Application_Service_AddPostingToShortList', $arShortlistInfo, false);
                    $actionId = Application_Model_LjConstants::$POST_ACTION_FAVORITE_ID;
                } else if ($action == "Remove") {
                    $result = $this->sessionObj->execute_service('Application_Service_RemovePostingFromShortList', $arShortlistInfo, false);
                    $actionId = Application_Model_LjConstants::$POST_ACTION_REMOVE_FAVORITE_ID;
                }
                $userInfo = $this->getLoggedInUserInfo();
                if (isset($userInfo)) {
                    $arAction = array(
                        'posting_id' => $postingId,
                        'user_id' => $userInfo['user_id'],
                        'action_id' => $actionId,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                    $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $arAction, false);
                }
            }

            $postObj = new Application_Model_LjPosting();
            $remove_shortlists = $postObj->GetUserShortListsToRemovePosting($postingId);

            if (isset($remove_shortlists) && sizeof($remove_shortlists)) {
                foreach ($remove_shortlists as $key => $value) {
                    $favorite_list = $favorite_list . '|' . $value['folder_id'];
                }
            }
            $favorite_list = trim($favorite_list, '|');
        }

        echo $favorite_list;
        exit;
    }

    public function viewshareemailAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $action = $this->_request->getParam('userAction');
            if (isset($postingId) && isset($action)) {
                $userInfo = $this->getLoggedInUserInfo();
                $userId = null;
                if (isset($userInfo)) {
                    $userId = $userInfo['user_id'];
                }
                $this->sessionObj = new Application_Service_LjSession();
                $actionId = 1;
                if (strtolower($action) == "view")
                    $actionId = Application_Model_LjConstants::$POST_ACTION_VIEW_ID;
                else if (strtolower($action) == "email")
                    $actionId = Application_Model_LjConstants::$POST_ACTION_EMAIL_ID;
                else if (strtolower($action) == "facebook share")
                    $actionId = Application_Model_LjConstants::$POST_ACTION_FB_SHARE_ID;
                else if (strtolower($action) == "twitter share")
                    $actionId = Application_Model_LjConstants::$POST_ACTION_TWITTER_SHARE_ID;
                if (isset($userId)) {
                    $input = array(
                        'posting_id' => $postingId,
                        'user_id' => $userInfo['user_id'],
                        'action_id' => $actionId,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                } else {
                    $input = array(
                        'posting_id' => $postingId,
                        'action_id' => $actionId,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                }
                $result = $this->sessionObj->execute_service('Application_Service_SaveViewShareEmail', $input, false);
            }
        }

        exit;
    }

    public function flagspamAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $action = $this->_request->getParam('flagaction');
            if (isset($postingId) && isset($action)) {
                $userInfo = $this->getLoggedInUserInfo();
                if (isset($userInfo)) {
                    $this->sessionObj = new Application_Service_LjSession();
                    if ($action == "Spam") {
                        $input = array(
                            'posting_id' => $postingId,
                            'user_id' => $userInfo['user_id'],
                            'action_id' => Application_Model_LjConstants::$POST_ACTION_SPAM_ID,
                            'date_created' => date("Y-m-d H:i:s")
                        );
                        $result = $this->sessionObj->execute_service('Application_Service_FlagPostingAsSpam', $input, false);
                    } else if ($action == "Remove") {
                        $input = array(
                            'posting_id' => $postingId,
                            'user_id' => $userInfo['user_id'],
                            'action_id' => Application_Model_LjConstants::$POST_ACTION_SPAM_ID
                        );
                        $result = $this->sessionObj->execute_service('Application_Service_RemoveSpamFlag', $input, false);
                    }
                }
            }
        }

        exit;
    }

    public function getshortlistsbypostingAction() {
        $this->_helper->layout->disableLayout();
        $addShortlistHtml = "";
        if ($this->_request->isXmlHttpRequest()) {
            $postingId = $this->_request->getParam('postingId');
            $postObj = new Application_Model_LjPosting();
            $remove_shortlists = $postObj->GetUserShortListsToRemovePosting($postingId);
            $is_favorite = false;
            if (isset($remove_shortlists) && sizeof($remove_shortlists))
                $is_favorite = true;

            $arShortList = array(
                'add_shortlists' => $postObj->GetUserShortListsToAddPosting($postingId),
                'is_favorite' => $is_favorite,
                'posting_id' => $postingId
            );
            $addShortlistHtml = $postObj->getAddShortListContents($arShortList);
        }
        echo $addShortlistHtml;
        exit;
    }

    public function getusershortlistsAction() {
        $this->_helper->layout->disableLayout();
        echo $this->view->shortListHtml;
        exit;
    }

    public function getusersavedsearchesAction() {
        $this->_helper->layout->disableLayout();
        echo $this->view->savedSearchHtml;
        exit;
    }

    public function saveshortlistAction() {
        $this->_helper->layout->disableLayout();
        $lastShortListId = null;
        $this->shortlistHtml = "";
        if ($this->_request->isXmlHttpRequest()) {
            $userId = null;
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                $userInfo = $this->userInfoNamespace->user_info;
                if ($userInfo['user_id'] != 0)
                    $userId = $userInfo['user_id'];
            }
            $shortlistName = $this->_request->getParam('shortlistName');

            if (isset($userId)) {

                $arShortlistInfo = array(
                    'user_id' => $userId,
                    'folder_name' => $shortlistName,
                    'date_created' => date("Y-m-d H:i:s")
                );
                $this->sessionObj = new Application_Service_LjSession();
                $lastShortListId = $this->sessionObj->execute_service('Application_Service_CreateShortList', $arShortlistInfo, false);
            }

            if (isset($lastShortListId)) {
                $this->shortlistInfo = null;
                if ($this->view->userLoggedIn == 1) {
                    $this->sessionObj = new Application_Service_LjSession();
                    $shortLists = $this->sessionObj->execute_service('Application_Service_GetShortlists', $this->view->userId, false);
                    $this->shortlistInfo = $shortLists;
                }

                $this->shortlistHtml = $this->generateShortListHtml($this->shortlistInfo);
            } else {
                $this->shortlistHtml = "";
            }
        }
        if ($this->shortlistHtml != "")
            $this->shortlistHtml = $this->shortlistHtml . '<LastShortListId>' . $lastShortListId;
        echo $this->shortlistHtml;
        exit;
    }

    public function deleteshortlistAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isXmlHttpRequest()) {

            $shortlistId = $this->_request->getParam('shortlistId');
            $userId = null;
            $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info)) {
                $userInfo = $this->userInfoNamespace->user_info;
                if ($userInfo['user_id'] != 0)
                    $userId = $userInfo['user_id'];
            }
            if (isset($userId)) {

                $arShortlistInfo = array(
                    'folder_id' => $shortlistId
                );
                $this->sessionObj = new Application_Service_LjSession();
                $deleteResult = $this->sessionObj->execute_service('Application_Service_DeleteShortList', $arShortlistInfo, false);
            }
        }
        exit;
    }

    public function recentlistingsAction() {
        $this->_helper->layout->disableLayout();
        $recentlyPostedItemsHtml = "";
        if ($this->_request->isXmlHttpRequest()) {


            $categoryId = "0";

            $isParentCategory = "false";

            $postObj = new Application_Model_LjPosting();
            $recentlyPostedItemsHtml = $postObj->GetRecentPostsForAdmin($categoryId, $isParentCategory);
        }
        echo $recentlyPostedItemsHtml;
        exit;
    }
    
      public function spampostsAction() {
        $this->_helper->layout->disableLayout();
        $recentlyPostedItemsHtml = "";
        if ($this->_request->isXmlHttpRequest()) {

            $postObj = new Application_Model_LjPosting();
            $recentlyPostedItemsHtml = $postObj->GetSpamPostsForAdmin();
        }
        echo $recentlyPostedItemsHtml;
        exit;
    }
    
         public function recentloginsAction() {
        $this->_helper->layout->disableLayout();
        $recentLoginsHtml = "";
        if ($this->_request->isXmlHttpRequest()) {

            $userObj = new Application_Model_LjUserInfo();
            $recentLoginsHtml = $userObj->GetRecentLogins();
        }
        echo $recentLoginsHtml;
        exit;
    }

    private function generateSearchResultHtml($results) {
        $pageHtml = "";
        $postingIds = "";

        for ($i = 0; $i < count($results->response->docs); $i++) {
            if ($postingIds == "")
                $postingIds = $results->response->docs[$i]->posting_id_i;
            else
                $postingIds = $postingIds . ',' . $results->response->docs[$i]->posting_id_i;
        }

        if ($postingIds != "") {
            $postObj = new Application_Model_LjPosting();
            $pageHtml = $postObj->GetSearchPostings($postingIds, true);
        }


        return $pageHtml;
    }

    private function generateRefineSectionHtml($facetFieldsObjArray, $showClearAll) {
        $log = Zend_Registry::get('log');

        $time_start = microtime(true);

        $leftNavHtml = "";
        $category_fields_hidden = "";
        $select_fields_hidden = "";
        $multiselect_fields_hidden = "";
        $range_fields_hidden = "";
        $all_fields_hidden = "";
        $emphasizedField = "";
        for ($i = 0; $i < sizeof($facetFieldsObjArray); $i++) {
            $all_fields_hidden = $all_fields_hidden . ',' . $facetFieldsObjArray[$i]['solr_column_name'] . '_' . $facetFieldsObjArray[$i]['facet_type'];
            if ($facetFieldsObjArray[$i]['solr_column_name'] == "parent_category_name_t" || $facetFieldsObjArray[$i]['solr_column_name'] == "category_name_t")
                $category_fields_hidden = $category_fields_hidden . ',' . $facetFieldsObjArray[$i]['solr_column_name'];
            if ($facetFieldsObjArray[$i]['facet_type'] == "select") {
                $leftNavHtml = $leftNavHtml . $this->getSelectHtmlContents($facetFieldsObjArray[$i]);
                if ($facetFieldsObjArray[$i] != "parent_category_name_t" && $facetFieldsObjArray[$i] != "category_name_t")
                    $select_fields_hidden = $select_fields_hidden . ',' . $facetFieldsObjArray[$i]['solr_column_name'];
            }
            else if ($facetFieldsObjArray[$i]['facet_type'] == "multiselect") {
                $leftNavHtml = $leftNavHtml . $this->getMultiSelectHtmlContents($facetFieldsObjArray[$i]);
                if ($facetFieldsObjArray[$i] != "parent_category_name_t" && $facetFieldsObjArray[$i] != "category_name_t")
                    $multiselect_fields_hidden = $multiselect_fields_hidden . ',' . $facetFieldsObjArray[$i]['solr_column_name'];
            }
            else if ($facetFieldsObjArray[$i]['facet_type'] == "range") {
                $leftNavHtml = $leftNavHtml . $this->getRangeHtmlContents($facetFieldsObjArray[$i]);
                if ($facetFieldsObjArray[$i] != "parent_category_name_t" && $facetFieldsObjArray[$i] != "category_name_t")
                    $range_fields_hidden = $range_fields_hidden . ',' . $facetFieldsObjArray[$i]['solr_column_name'];
            }
            if ($facetFieldsObjArray[$i]['is_emphasized'] && $emphasizedField == "")
                $emphasizedField = $facetFieldsObjArray[$i]['facet_name'] . '|' . $facetFieldsObjArray[$i]['solr_column_name'];
        }


        $tokens = array(
            'left_nav_html' => $leftNavHtml,
            'showClearAll' => $showClearAll,
            'category_fields_hidden' => trim($category_fields_hidden, ','),
            'select_fields_hidden' => trim($select_fields_hidden, ','),
            'multiselect_fields_hidden' => trim($multiselect_fields_hidden, ','),
            'range_fields_hidden' => trim($range_fields_hidden, ','),
            'all_fields_hidden' => trim($all_fields_hidden, ','),
            'emphasized_hidden' => trim($emphasizedField)
        );
        $leftNavHtml = $this->getLeftNavHtmlContents($tokens);
        $time_end = microtime(true);
        if (isset($log))
            $log->info("Generated Refine Html. Time Taken " . ($time_end - $time_start));

        return $leftNavHtml;
    }

    private function generateSolrQuery($searchText) {
        $query = "*:*";
        if (isset($searchText) && strlen(trim($searchText)) > 0) {
            $query = 'all:' . $searchText;
        }

        return $query;
    }

    private function generateFilterQuery($categoryName, $categoryFields, $selectedFields, $multiSelectFields, $rangeFields, $dateFields) {
        $fq = "";

        if (isset($selectedFields) && strlen(trim($selectedFields)) > 0) {
            if ($fq == "")
                $fq = " ( " . $selectedFields;
            else
                $fq = $fq . " AND " . $selectedFields;
        }
        if (isset($multiSelectFields) && strlen(trim($multiSelectFields)) > 0) {
            if ($fq == "")
                $fq = " ( " . $multiSelectFields;
            else
                $fq = $fq . " AND " . $multiSelectFields;
        }
        if (isset($rangeFields) && strlen(trim($rangeFields)) > 0) {

            if ($fq == "")
                $fq = " ( " . $rangeFields;
            else
                $fq = $fq . " AND " . $rangeFields;
        }
        if (isset($dateFields) && strlen(trim($dateFields)) > 0) {
            $dateFields = $this->formatDateFieldsForSolrQuery($dateFields);
            if (strlen(trim($dateFields)) > 0) {
                if ($fq == "")
                    $fq = " ( " . $dateFields;
                else
                    $fq = $fq . " AND " . $dateFields;
            }
        }
        if ($fq != "")
            $fq = $fq . ' )';

        if (isset($categoryFields) && strlen(trim($categoryFields)) > 0) {
            if (isset($categoryName) && strlen(trim($categoryName)) > 0)
                $fq = $fq . " AND (" . $categoryFields . ") AND " . 'parent_category_name_t:' . $categoryName;
            else
                $fq = $fq . " AND (" . $categoryFields . ")";
        }
        $fq = trim($fq, " AND ");
        $fq = trim($fq, " OR ");
        if ($fq != "")
            $fq = $fq . ' AND posting_status_id_i:2';
        else
            $fq = 'posting_status_id_i:2';

        return $fq;
    }

    private function doSolrRequest($params) {

        try {
            $results = null;
            $solr = new Apache_Solr_Service($params['solr_host'], $params['solr_port'], $params['solr_root']);

            $query = $params['q'];
            $start = (int) $params['start'];
            $rows = (int) $params['rows'];
            $additionalParameters = array();

            if (isset($params['fq']) && sizeof($params['fq']) > 0)
                $additionalParameters = array(
                    'facet' => 'true',
                    'wt' => $params['wt'],
                    'facet.field' => $params['facet.field'],
                    'fq' => $params['fq'],
                    'sort' => $params['sort'],
                    'facet.limit' => -1,
                    'facet.mincount' => !isset($params['facet.mincount']) ? 1 : $params['facet.mincount'],
                    'stats' => $params['stats'],
                    'stats.field' => $params['stats.field']
                );
            else
                $additionalParameters = array(
                    'facet' => 'true',
                    'wt' => $params['wt'],
                    'facet.field' => $params['facet.field'],
                    'sort' => $params['sort'],
                    'facet.limit' => -1,
                    'facet.mincount' => !isset($params['facet.mincount']) ? 1 : $params['facet.mincount'],
                    'stats' => $params['stats'],
                    'stats.field' => $params['stats.field']
                );
            $log = Zend_Registry::get('log');

            $time_start = microtime(true);


            $results = $solr->search($query, $start, $rows, $additionalParameters);
            $time_end = microtime(true);
            if (isset($log))
                $log->info("Solr Data Fetch has taken " . ($time_end - $time_start));
        } catch (Exception $ex) {
            $log = Zend_Registry::get('log');
            $results = null;

            if (isset($log))
                $log->info($ex->getTrace());
        }
        return $results;
    }

    private function getAllFieldsForCategory($categoryName, $isParentCategory, $categoryFields) {
        $categoryFields = str_replace('"', '', $categoryFields);
        $categoryName = str_replace('"', '', $categoryName);
        $facetFields = null;


        if (isset($categoryFields) && strlen($categoryFields) > 0) {
            $categoryFields = str_replace('(', '', $categoryFields);
            $categoryFields = str_replace(')', '', $categoryFields);
            $tempArray = explode(":", $categoryFields);
            $catFieldsArray = explode(" OR ", $tempArray[1]);

            if ($isParentCategory === "true") {
                $parentCatName = $catFieldsArray[0];
                $this->sessionObj = new Application_Service_LjSession();
                $facetFields = $this->sessionObj->execute_service('Application_Service_GetFacetFieldsByParentCatName', $parentCatName, false);
            } else {
                $catNames = "";
                for ($i = 0; $i < sizeof($catFieldsArray); $i++) {

                    if ($tempArray[0] != 'parent_category_name_t')
                        $catNames = $catNames . ',' . "'" . $catFieldsArray[$i] . "'";
                }
                $catNames = trim($catNames, ',');
                $categoryArray = array('parent_category' => $categoryName, 'categories' => $catNames);
                $this->sessionObj = new Application_Service_LjSession();
                $facetFields = $this->sessionObj->execute_service('Application_Service_GetFacetFieldsByCatNames', $categoryArray, false);
            }
        }
        return $facetFields;
    }

    private function createAllFieldsArray($categoryName, $facetFields) {

        $categoryName = str_replace('"', '', $categoryName);
        $allFieldsArray = array();
        if (isset($categoryName) && $categoryName === "All Categories") {
            $allFieldsArray[] = 'parent_category_name_t';
            //$allFieldsArray[] = 'city_name_t';
        } else {
            $allFieldsArray[] = 'category_name_t';
            if (isset($this->view->partition) && strtolower($this->view->partition) != 'singapore')
                $allFieldsArray[] = 'city_name_t';
            if (isset($facetFields)) {
                foreach ($facetFields as $key => $value) {
                    if (isset($value['solr_column_name']) && strlen($value['solr_column_name']) > 0)
                        $allFieldsArray[] = $value['solr_column_name'];
                }
            }
            $allFieldsArray[] = 'tag_tc';
        }

        if (sizeof($allFieldsArray) == 0)
            return null;
        else
            return $allFieldsArray;
    }

    private function createFacetFieldsArray($categoryName, $facetFields) {

        $categoryName = str_replace('"', '', $categoryName);
        $facetFieldsArray = array();
        if (isset($categoryName) && $categoryName === "All Categories") {
            $facetFieldsArray[] = 'parent_category_name_t';
            // $facetFieldsArray[] = 'city_name_t';
        } else {
            $facetFieldsArray[] = 'category_name_t';
            if (isset($this->view->partition) && strtolower($this->view->partition) != 'singapore')
                $facetFieldsArray[] = 'city_name_t';
            if (isset($facetFields)) {
                foreach ($facetFields as $key => $value) {
                    if (isset($value['solr_column_name']) && strlen($value['solr_column_name']) > 0 &&
                            strtolower($value['facet_type']) != 'range')
                        $facetFieldsArray[] = $value['solr_column_name'];
                }
            }
            $facetFieldsArray[] = 'tag_tc';
        }

        if (sizeof($facetFieldsArray) == 0)
            return null;
        else
            return $facetFieldsArray;
    }

    private function createStatsFieldsArray($facetFields) {
        $statsFieldsArray = array();
        if (isset($facetFields)) {
            foreach ($facetFields as $key => $value) {
                if (isset($value['solr_column_name']) && strlen($value['solr_column_name']) > 0 &&
                        strtolower($value['facet_type']) == 'range')
                    $statsFieldsArray[] = $value['solr_column_name'];
            }
        }

        if (sizeof($statsFieldsArray) == 0)
            return null;
        else
            return $statsFieldsArray;
    }

    private function processFacetFields($results, $facetFields, $allFieldsArray, $facetFieldsArray, $statsFieldsArray, $paramArray) {
        $categoryName = $paramArray['categoryName'];
        $isParentCategory = $paramArray['isParentCategory'];
        $categoryFields = $paramArray['categoryFields'];
        $rangeFields = $paramArray['rangeFields'];
        $dateFields = $paramArray['dateFields'];
        $categoryFields = str_replace('"', '', $categoryFields);
        $categoryName = str_replace('"', '', $categoryName);
        $searchText = "";
        if ($paramArray['searchText'] != "")
            $searchText = $paramArray['searchText'];
        $facetFieldsObjArray = array();
        $facetName = null;
        $facetType = null;
        $solrColumnName = null;
        $parentCount = 0;
        $childAttrCounts = null;
        $facetHeading = null;

        $childAttrSelected = array();
        $facetParams = null;
        $displayFormat = null;
        $isCurrency = 0;
        $rangeIncrement = 10;
        $visibleItemCountLeftNav = 0;
        $isEmphasized = false;

        $postObj = new Application_Model_LjPosting();
        if (isset($results->responseHeader->params->fq)) {
            $facetParams = $results->responseHeader->params->fq;
        }
        if (!$this->view->visible_item_count_left_nav) {
            $solrConfig = $this->getSolrConfig();
            if (isset($solrConfig))
                $this->view->visible_item_count_left_nav = $solrConfig->visible_item_count_left_nav;
        }
        $visibleItemCountLeftNav = $this->view->visible_item_count_left_nav;
        $this->sessionObj = new Application_Service_LjSession();
        $categoryKey = "";
        if (isset($categoryFields) && strlen($categoryFields) > 0 && $isParentCategory != "true") {
            $categoryFields = str_replace('(', '', $categoryFields);
            $categoryFields = str_replace(')', '', $categoryFields);
            $tempArray = explode(":", $categoryFields);
            $catFieldsArray = explode(" OR ", $tempArray[1]);
            $catNames = "";
            for ($i = 0; $i < sizeof($catFieldsArray); $i++) {

                if ($tempArray[0] != 'parent_category_name_t')
                    $catNames = $catNames . ',' . "'" . $catFieldsArray[$i] . "'";
            }
            $catNames = trim($catNames, ',');
            $categoryKey = str_replace(',', '', $catNames);
        }

        if (isset($categoryFields) && strlen($categoryFields) > 0 && $isParentCategory == "true") {
            $tempArray = explode(":", $categoryFields);
            $parentCatName = $tempArray[1];
            $categoryKey = $parentCatName;
        }

        for ($i = 0; $i < sizeof($allFieldsArray); $i++) {
            $childAttrCounts = array();
            $childAttrSelected = array();
            if ($allFieldsArray[$i] == 'parent_category_name_t' || $allFieldsArray[$i] == 'category_name_t') {
                $facetName = str_replace('"', '', $categoryName);
                if ($allFieldsArray[$i] == 'category_name_t' && $isParentCategory === "false")
                    $facetType = "multiselect";
                else
                    $facetType = "multiselect";
                if ($categoryName == "All Categories")
                    $facetType = "select";
                $solrColumnName = $allFieldsArray[$i];
                $facetHeading = "Category";
            }
            else if ($allFieldsArray[$i] == 'tag_tc') {
                $facetName = 'Tags';
                $facetType = "multiselect";
                $solrColumnName = 'tag_tc';
                $facetHeading = "Tags";
            } else if ($allFieldsArray[$i] == 'city_name_t') {
                $facetName = 'City';
                $facetType = "multiselect";
                $solrColumnName = 'city_name_t';
                $facetHeading = "City";
            } else {
                if (isset($facetFields)) {
                    foreach ($facetFields as $key => $value) {
                        if ($value['solr_column_name'] === $allFieldsArray[$i]) {
                            $isEmphasized = (strtolower($value['rule']) == 'emphasized') ? true : false;
                            $facetName = $value['facet_name'];
                            $facetType = $value['facet_type'];
                            $solrColumnName = $value['solr_column_name'];
                            $facetHeading = $value['facet_name'];
                            $displayFormat = $value['display_format'];
                            $isCurrency = $value['is_currency'];
                            $rangeIncrement = $value['range_increment'];
                        }
                    }
                }
            }
            $rangeKeys = array();
            $rangeCount = 0;
            $isFacetField = true;
            $isStatsField = false;
            if (in_array($allFieldsArray[$i], $facetFieldsArray, true)) {
                $isFacetField = true;
                $isStatsField = false;
            } else if (in_array($allFieldsArray[$i], $statsFieldsArray, true)) {
                $isFacetField = false;
                $isStatsField = true;
            }
            if ($isFacetField) {
                foreach ($results->facet_counts->facet_fields->$allFieldsArray[$i] as $facet => $count) {

                    $isSelected = false;
                    if (isset($facetParams)) {
                        $regexPattern = "";
                        if (preg_match('^.*_t$^', $allFieldsArray[$i]) || preg_match('^.*_tc$^', $allFieldsArray[$i])) {
                            $regexPattern = '^.*' . $allFieldsArray[$i] . ':\(.*"' . $facet . '".*\).*$^';
                        } else {
                            $regexPattern = '^.*' . $allFieldsArray[$i] . ':\(.*' . $facet . '.*\).*$^';
                        }
                        if (preg_match($regexPattern, $facetParams))
                            $isSelected = true;
                    }

                    // Solr sends this back if it's empty.
                    if (($facet == '_empty_' || $count == 0) && !$isSelected) {
                        continue;
                    }
                    $childAttrCounts[] = $facet . ' (' . $count . ')';
                    if ($isSelected) {
                        if ($count == 0)
                            $childAttrSelected[] = '-1';
                        else
                            $childAttrSelected[] = '1';
                    } else {

                        $childAttrSelected[] = '0';
                    }
                }
            }
            if ($isStatsField) {
                if (strtolower($facetType) == "range" && strtolower($displayFormat) != "date") {
                    $childAttrCounts = array();
                    $childAttrSelected = array();
                    $statsObj = $results->stats->stats_fields->$allFieldsArray[$i];
                    if (isset($statsObj)) {
                        $min = $statsObj->min;
                        $max = $statsObj->max;
                        $childAttrCounts[] = ' (' . $statsObj->count . ')';
                        if ($isCurrency == 1) {
                            $min = $postObj->formatCurrency($this->RoundSigDigs($min, $rangeIncrement));
                            $max = $postObj->formatCurrency($this->RoundSigDigs($max, $rangeIncrement));
                        } else {
                            $min = $this->RoundSigDigs($min, $rangeIncrement);
                            $max = $this->RoundSigDigs($max, $rangeIncrement);
                        }
                        $allMinMax = "";
                        $this->minMaxRangeNS = new Zend_Session_Namespace($categoryKey . $allFieldsArray[$i]);
                        if (isset($this->minMaxRangeNS) && isset($this->minMaxRangeNS->minmax)) {
                            $allMinMax = $this->minMaxRangeNS->minmax;
                            if (stristr($facetParams, $allFieldsArray[$i]) !== FALSE) {
                                $rangeFieldArray = explode(' AND ', $rangeFields);
                                $minMaxFromFQ = "";
                                for ($j = 0; $j < sizeof($rangeFieldArray); $j++) {
                                    if (stristr($rangeFieldArray[$j], $allFieldsArray[$i]) !== FALSE) {
                                        $tempArray = explode(':', $rangeFieldArray[$j]);
                                        $temp = str_replace('[', '', $tempArray[1]);
                                        $temp = str_replace(']', '', $temp);
                                        $tempArray = explode(' TO ', $temp);
                                        if ($isCurrency == 1)
                                            $minMaxFromFQ = $postObj->formatCurrency(trim($tempArray[0])) . '|' . $postObj->formatCurrency(trim($tempArray[1]));
                                        else
                                            $minMaxFromFQ = trim($tempArray[0]) . '|' . trim($tempArray[1]);
                                    }
                                }
                                if ($minMaxFromFQ != "") {
                                    $childAttrSelected[] = $allMinMax . '~$~' . $minMaxFromFQ;
                                } else {
                                    $childAttrSelected[] = $allMinMax . '~$~' . $min . '|' . $max;
                                }
                            } else {
                                $childAttrSelected[] = $allMinMax . '~$~' . $allMinMax;
                            }
                        } else {
                            $allMinMax = $min . '|' . $max;
                            $this->minMaxRangeNS->minmax = $allMinMax;
                            $childAttrSelected[] = $allMinMax . '~$~' . $min . '|' . $max;
                        }
                    }
                }
                if (strtolower($facetType) == "range" && strtolower($displayFormat) == "date") {
                    $childAttrCounts = array();
                    $childAttrSelected = array();
                    if (stristr($facetParams, $allFieldsArray[$i]) !== FALSE) {
                        $childAttrCounts[] = ' (' . $rangeCount . ')';
                        $tempArray = explode(':', $dateFields);
                        $childAttrSelected[] = $tempArray[1];
                    } else {
                        $childAttrSelected[] = ",";
                    }
                }
            }
            if (isset($childAttrCounts) && (sizeof($childAttrCounts) > 0) || strtolower($displayFormat) == "date") {

                $facetFieldsObjArray[] = array(
                    'facet_name' => $facetName,
                    'facet_type' => $facetType,
                    'display_format' => $displayFormat,
                    'is_currency' => $isCurrency,
                    'is_emphasized' => $isEmphasized,
                    'range_increment' => $rangeIncrement,
                    'solr_column_name' => $solrColumnName,
                    'facet_heading' => $facetHeading,
                    'parent_count' => $parentCount,
                    'child_attr_counts' => $childAttrCounts,
                    'child_attr_selected' => $childAttrSelected,
                    'visible_item_count_left_nav' => $this->view->visible_item_count_left_nav,
                );
            }
        }

        return $facetFieldsObjArray;
    }

    function getSelectHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/select.html.php';
        return ob_get_clean();
    }

    function getRangeHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/range.html.php';
        return ob_get_clean();
    }

    function getMultiSelectHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/multiselect.html.php';
        return ob_get_clean();
    }

    function getLeftNavHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/leftnav.html.php';
        return ob_get_clean();
    }

    function formatDateFieldsForSolrQuery($dateFields) {
        try {
            $formattedDateFields = "";
            $firstArray = explode(':', $dateFields);
            $secondArray = explode(',', $firstArray[1]);
            $fromDate = $secondArray[0];
            $toDate = $secondArray[1];
            if (strlen($fromDate) == 0)
                $fromDate = date("Y-m-d");
            if (strlen($toDate) == 0)
                $toDate = date("Y-m-d");

            $fromDate = $this->formatDateForSolr($fromDate);
            $toDate = $this->formatDateForSolr($toDate);

            $formattedDateFields = $firstArray[0] . ':' . '[' . $fromDate . ' TO ' . $toDate . ']';

            return $formattedDateFields;
        } catch (Exception $ex) {

            return "";
        }
    }

    function RoundSigDigs($number, $incrementCounter) {
        try {
            $number = ($number / $incrementCounter);
            $number = round($number);
            $number = $number * $incrementCounter;
        } catch (Exception $ex) {
            return $number;
        }
        return $number;
    }

    function formatDateForSolr($date) {
        $date = str_replace('/', '-', $date);
        $dateTime = new DateTime($date);
        $formattedDate = "";
        $formattedDate = $dateTime->format("Y-m-d\TH:i:s\Z");
        return $formattedDate;
    }

}

