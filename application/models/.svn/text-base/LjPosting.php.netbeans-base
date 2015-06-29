<?php

class Application_Model_LjPosting extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "posting";
    protected $table_pk = "posting_id";
    protected $class_name = 'Application_Model_LjPosting';
    var $posting_id;
    var $posting_status_id;
    var $title;
    var $description;
    var $posting_date;
    var $expiration_date;
    var $date_created;
    var $date_updated;
    var $user_id;
    var $city_id;
    var $category_id;
    var $short_html;
    var $long_html;
    var $phone;

    //////////////////////////
    //Sets Entity info
    function setPosting_id($posting_id) {
        $this->posting_id = $posting_id;
    }

    function setPosting_status_id($posting_status_id) {
        $this->posting_status_id = $posting_status_id;
    }

    function settitle($title) {
        $this->title = $title;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setLong_html($long_html) {
        $this->long_html = $long_html;
    }

    function setShort_html($short_html) {
        $this->short_html = $short_html;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPosting_date($posting_date) {
        $this->posting_date = $posting_date;
    }

    function setExpiration_date($expiration_date) {
        $this->expiration_date = $expiration_date;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    function setDate_updated($date_updated) {
        $this->date_updated = $date_updated;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getPosting_id() {
        return $this->posting_id;
    }

    function getPosting_status_id() {
        return $this->posting_status_id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getPosting_date() {
        return $this->posting_date;
    }

    function getExpiration_date() {
        return $this->expiration_date;
    }

    function getDate_created() {
        return $this->date_created;
    }

    function getDate_updated() {
        return $this->date_updated;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getCity_id() {
        return $this->city_id;
    }

    function getCategory_id() {
        return $this->category_id;
    }

    function getLong_html() {
        return $this->long_html;
    }

    function getShort_html() {
        return $this->short_html;
    }

    function getPhone() {
        return $this->phone;
    }

    function ChangePostingStatusToActiveForNewUser($userId) {
        $currentDate = date("Y-m-d H:i:s");
        $expiryDate = date('Y-m-d H:i:s', strtotime('+7 days'));
        $this->sessionObj = new Application_Service_LjSession();
        $arPostInfo = array(
            'user_id' => $userId,
            'posting_status_id' => Application_Model_LjConstants::$POST_STATUS_ACTIVE_ID,
            'date_updated' => $currentDate,
            'posting_date' => $currentDate,
            'expiration_date' => $expiryDate,
            'is_indexed' => 0
        );
        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdatePostingStatusForNewUser', $arPostInfo, false);
    }

    function Repost($postingId) {
        $repostStatus = false;
        try {
            $currentDate = date("Y-m-d H:i:s");
            $expiryDate = date('Y-m-d H:i:s', strtotime('+7 days'));
            $this->sessionObj = new Application_Service_LjSession();
            $arPostInfo = array(
                'posting_id' => $postingId,
                'posting_status_id' => Application_Model_LjConstants::$POST_STATUS_ACTIVE_ID,
                'date_updated' => $currentDate,
                'posting_date' => $currentDate,
                'expiration_date' => $expiryDate,
                'is_indexed' => 0
            );
            $updateResult = $this->sessionObj->execute_service('Application_Service_UpdatePostStatus', $arPostInfo, false);
            $repostStatus = true;
        } catch (Exception $ex) {
            
        }
        return $repostStatus;
    }

    function FlagPostAsDeleted($postingId) {
        $flagAsDeletedStatus = false;
        try {
            $currentDate = date("Y-m-d H:i:s");
            $this->sessionObj = new Application_Service_LjSession();
            $arPostInfo = array(
                'posting_id' => $postingId,
                'posting_status_id' => Application_Model_LjConstants::$POST_STATUS_DELETED_ID,
                'date_updated' => $currentDate,
                'is_indexed' => 0
            );
            $updateResult = $this->sessionObj->execute_service('Application_Service_UpdatePostStatus', $arPostInfo, false);
            $flagAsDeletedStatus = true;
        } catch (Exception $ex) {
            
        }
        return $flagAsDeletedStatus;
    }

    function hidePostFromTimeline($postingViewId) {
        $hideStatus = false;
        try {
            $currentDate = date("Y-m-d H:i:s");
            $this->sessionObj = new Application_Service_LjSession();
            $arPostInfo = array(
                'posting_view_id' => $postingViewId,
                'is_visible' => 0,
            );
            $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateAction', $arPostInfo, false);
            $hideStatus = true;
        } catch (Exception $ex) {
            
        }
        return $hideStatus;
    }

    function DeletePost($postingId) {
        $deleteStatus = false;
        try {
            $arPostingId = array(
                'posting_id' => $postingId
            );
            $deletePost = $this->sessionObj->execute_service('Application_Service_DeletePost', $arPostingId, false);
            $deleteStatus = true;
        } catch (Exception $ex) {
            
        }
        return $deleteStatus;
    }

    function CreateSingleFieldEmphasizedSection($posting) {
        $currency = new Zend_Currency();
        $currency->setFormat(array('precision' => 0));
        $attrValue = null;
        $dimension = null;

        if (!isset($posting))
            return null;
        foreach ($posting as $key => $value) {
            $attrValue = $value['value'];
            $dimension = $value['dimension'];
        }
        if (!isset($attrValue))
            return null;
        if (stristr($dimension, "%") !== FALSE)
            $emphasizedSection = '<span class="price"><span>' . $attrValue . '</span><span class="superscript-short-html">% Off</span></span>';
        else if (stristr($dimension, "$") !== FALSE)
            $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span><span class="superscript-short-html frequency-short-html">Off</span></span>';
        else {
            if (isset($dimension) && strlen($dimension) > 0) {

                if (stristr($dimension, "per") !== FALSE) {
                    $tempArray = explode("per ", strtolower($dimension));
                    $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span><span class="superscript-short-html">/' . $tempArray[1] . '</span></span>';
                }
                else
                    $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span><span class="superscript-short-html">/' . $dimension . '</span></span>';
            }
            else
                $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span></span>';
        }
        return $emphasizedSection;
    }

    function CreateEmphasizedSection($postings, $postingId) {
        $currency = new Zend_Currency();
        $currency->setFormat(array('precision' => 0));
        $attrValue = null;
        $dimension = null;
        $emphasizedSection = null;
        if (!isset($postings))
            return null;
        foreach ($postings as $key => $value) {
            if ($value['posting_id'] == $postingId) {
                $attrValue = $value['value'];
                $dimension = $value['dimension'];
                break;
            }
        }

        if (!isset($attrValue))
            return null;
        if (strlen(trim($attrValue)) == 0)
            return null;
        if (stristr($dimension, "%") !== FALSE)
            $emphasizedSection = '<span class="price"><span>' . $attrValue . '</span><span class="superscript-short-html">% Off</span></span>';
        else if (stristr($dimension, "$") !== FALSE)
            $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span><span class="superscript-short-html frequency-short-html">Off</span></span>';
        else {
            if (isset($dimension) && strlen($dimension) > 0) {

                if (stristr($dimension, "per") !== FALSE) {
                    $tempArray = explode("per ", strtolower($dimension));
                    $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span><span class="superscript-short-html">/' . $tempArray[1] . '</span></span>';
                }
                else
                    $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span><span class="superscript-short-html">/' . $dimension . '</span></span>';
            }
            else
                $emphasizedSection = '<span class="price"><span>' . $currency->toCurrency($attrValue) . '</span></span>';
        }
        return $emphasizedSection;
    }

    function CreateEmphasizedSectionForLongHtml($emphasizedAttributes) {
        $currency = new Zend_Currency();
        $currency->setFormat(array('precision' => 0));
        $attrValue = null;
        $dimension = null;
        $emphasizedSection = null;
        if (!isset($emphasizedAttributes))
            return null;
        foreach ($emphasizedAttributes as $key => $value) {
            $attrValue = $value['value'];
            $dimension = $value['dimension'];
            if ($emphasizedSection == null) {
                $emphasizedSection = '<ul style="list-style-type:none" id="preview_emphasized_section">';
                if (stristr($dimension, "%") !== FALSE)
                    $emphasizedSection = $emphasizedSection . '<li><span class="price"><span class="number">' . $attrValue . '</span><span class="superscript frequency">% Off</span></span></li>';
                else if (stristr($dimension, "$") !== FALSE)
                    $emphasizedSection = $emphasizedSection . '<li><span class="price"><span class="number">' . $currency->toCurrency($attrValue) . '</span><span class="superscript frequency">Off</span></span></li>';
                else {
                    if (isset($dimension) && strlen($dimension) > 0) {

                        if (stristr($dimension, "per") !== FALSE) {
                            $tempArray = explode("per", strtolower($dimension));
                            $emphasizedSection = $emphasizedSection . '<li><span class="price" style="min-height:60px"><span class="number">' . $currency->toCurrency($attrValue) . '</span><span class="superscript frequency">/' . $tempArray[1] . '</span></span></li>';
                        }
                        else
                            $emphasizedSection = $emphasizedSection . '<li><span class="price" style="min-height:60px"><span class="number">' . $currency->toCurrency($attrValue) . '</span><span class="superscript frequency">/' . $dimension . '</span></span></li>';
                    }
                    else
                        $emphasizedSection = $emphasizedSection . '<li><span class="price"><span class="number">' . $currency->toCurrency($attrValue) . '</span></span></li>';
                }
            }
            else {
                //if (stristr(strtolower($value['name']), "price") !== FALSE)
                $emphasizedSection = $emphasizedSection . $emphasizedSection . '<li><span class="price-small-font">' . $value['name'] . ': <span>' . $currency->toCurrency($attrValue) . '</span></span></li>';
                //else
                //$emphasizedSection = $emphasizedSection . '<li><span class="price-small-font">' . $value['name'] . ': <span>' . //$attrValue . '</span></span></li>';
            }
        }
        if ($emphasizedSection != null)
            $emphasizedSection = $emphasizedSection . '</ul>';
        return $emphasizedSection;
    }

    public function GetUserShortListsToAddPosting($postingId) {
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        $userId = null;
        $shortLists = null;
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $userId = $userInfo['user_id'];
        }
        if (isset($userId)) {
            $this->sessionObj = new Application_Service_LjSession();
            $input = array(
                'user_id' => $userId,
                'posting_id' => $postingId
            );
            $shortLists = $this->sessionObj->execute_service('Application_Service_GetShortlistsToAddPosting', $input, false);
        }
        return $shortLists;
    }

    public function GetUserShortListsToRemovePosting($postingId) {

        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        $userId = null;
        $shortLists = null;
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $userId = $userInfo['user_id'];
        }
        if (isset($userId)) {
            $this->sessionObj = new Application_Service_LjSession();
            $input = array(
                'user_id' => $userId,
                'posting_id' => $postingId
            );
            $shortLists = $this->sessionObj->execute_service('Application_Service_GetShortlistsToRemovePosting', $input, false);
        }
        return $shortLists;
    }

    public function GetPostStatistics($postingIds) {

        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        $userId = null;
        $postingViews = null;
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $userId = $userInfo['user_id'];
        }
        if (isset($userId)) {
            $this->sessionObj = new Application_Service_LjSession();

            $postingViews = $this->sessionObj->execute_service('Application_Service_GetStatistics', $postingIds, false);
        }
        return $postingViews;
    }

    public function CheckIfPostFlaggedAsSpam($postingId) {
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        $userId = null;
        $isSpam = false;
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $userId = $userInfo['user_id'];
            $this->sessionObj = new Application_Service_LjSession();
            $input = array(
                'user_id' => $userId,
                'posting_id' => $postingId
            );
            $isSpam = $this->sessionObj->execute_service('Application_Service_CheckPostSpamFlag', $input, false);
        }
        return $isSpam;
    }

    public function GetSearchPostings($postingIds, $generateS3Images) {
        $this->postInfo = null;
        $this->pageHtml = "";

        $this->sessionObj = new Application_Service_LjSession();
        $uploadHandler = new LjS3UploadHandler();
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingShortHtmlsByIds', $postingIds, false);

        $this->postEmphasizedSectionInfo = null;
        $remove_shortlists = $this->GetUserShortListsToRemovePosting($postingIds);
        $postingIdsArray = explode(',', $postingIds);
        $counter = 0;
        for ($i = 0; $i < sizeof($postingIdsArray); $i++) {
            $value = null;
            $listingClass = "";
            foreach ($this->postInfo as $keyPostInfo => $valuePostInfo) {
                if ($valuePostInfo['posting_id'] == $postingIdsArray[$i])
                    $value = $valuePostInfo;
            }
            if (!isset($value))
                continue;
            $counter++;
            if ($counter % 4 == 0)
                $listingClass = "endRow";
            if ($i % 4 == 0)
                $listingClass = "beginRow";

            $short_html = $value['short_html'];
            if ($short_html != null && strlen($short_html) > 0) {
                $short_html = $uploadHandler->ReplaceS3URLWithCloudfrontURL($value['short_html']); //Retrieve short html from DB
                $short_html = str_replace('[posting_date]', $this->formatDateForShortSnippet($value['posting_date']), $short_html);
            } else {
                $short_html = $this->CreatePostSnippet($value['posting_id'], $generateS3Images);
            }
            //Check whether post is shortlisted

            $is_favorite = false;
            $favorite_list = "";
            if (isset($remove_shortlists) && sizeof($remove_shortlists)) {

                foreach ($remove_shortlists as $keySL => $valueSL) {
                    if ($value['posting_id'] == $valueSL['posting_id'])
                        $favorite_list = $favorite_list . '|' . $valueSL['folder_id'];
                }
            }
            if ($favorite_list != "")
                $is_favorite = true;
            $favorite_list = trim($favorite_list, '|');
            //End
            //Check whether post is marked is as spam
            $is_spam = $this->CheckIfPostFlaggedAsSpam($value['posting_id']);

            //end
            $favoriteClass = 'favorite';
            $spamClass = 'spam';
            if ($is_favorite)
                $favoriteClass = 'favorite selected';
            if ($is_spam)
                $spamClass = 'spam selected';
            $short_html = str_replace('listing-class-placeholder', $listingClass, $short_html);
            $short_html = str_replace('favorite-class-placeholder', $favoriteClass, $short_html);
            $short_html = str_replace('spam-class-placeholder', $spamClass, $short_html);
            $short_html = str_replace('favorite-list-placeholder', $favorite_list, $short_html);
            $this->pageHtml = $this->pageHtml . $short_html;
        }
        return $this->pageHtml;
    }

    public function CreatePostSnippet($postingIds, $generateS3Images) {
        $postInfo = null;
        $this->pageShortHtml = "";
        $uploadHandler = new LjS3UploadHandler();
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');

        $this->sessionObj = new Application_Service_LjSession();

        $postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingsByIds', $postingIds, false);
        $postEmphasizedSectionInfo = null;

        $postingIdsArray = explode(',', $postingIds);
        $counter = 0;
        for ($i = 0; $i < sizeof($postingIdsArray); $i++) {
            $value = null;
            $listingClass = "";
            foreach ($postInfo as $keyPostInfo => $valuePostInfo) {
                if ($valuePostInfo['posting_id'] == $postingIdsArray[$i])
                    $value = $valuePostInfo;
            }
            if (!isset($value))
                continue;
            $counter++;
            if ($counter % 4 == 0)
                $listingClass = "endRow";
            if ($i % 4 == 0)
                $listingClass = "beginRow";

            $short_html = $value['short_html'];
            if ($short_html != null && strlen($short_html) > 0)
                $short_html = $value['short_html']; //Retrieve short html from DB
            else {

                if (!isset($postEmphasizedSectionInfo))
                    $postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);

                //create short html for the posting
                $imageUrl = null;
                //Get posting images
                $postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $value['posting_id'], false);
                if (isset($postImageInfo) && count($postImageInfo) > 0) {
                    foreach ($postImageInfo as $keyImage => $valueImage) {
                        if ($valueImage['is_main_image'] == '1') {
                            if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {
                                if ($generateS3Images)
                                    $imageUrl = $uploadHandler->copyImageFromCL($valueImage['image_url'], $valueImage['image_id'], $value['user_id']);
                                if (!isset($imageUrl))
                                    $imageUrl = $valueImage['image_url'];
                            }
                            else
                                $imageUrl = $uploadHandler->GetS3ImageUrl($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                        }
                    }
                }
                if (!isset($imageUrl))
                    $imageUrl = str_replace('category-name', $value['parent_category_id'], Application_Model_LjConstants::$DEFAULT_IMAGE_URL);



                $value['description'] = str_replace('<!--', '', $value['description']);
                $value['description'] = str_replace('--!>', '', $value['description']);
                $value['description'] = $this->truncateText($value['description'], $postConfig->post_desc_truncate_limit);
                $arPostInfo = array(
                    'posting_id' => $value['posting_id'],
                    'details_url' => '/api/post/' . $value['posting_id'],
                    'title' => strip_tags($value['title']),
                    'description' => $value['description'],
                    'user_id' => $value['user_id'],
                    'category_id' => $value['category_id'],
                    'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . $value['title'],
                    'posting_date' => '[posting_date]',
                    'image_url' => $imageUrl,
                    'address' => $value['address'],
                    'lat' => $value['lat'],
                    'lon' => $value['lon'],
                    'emphasized_section' => $this->CreateEmphasizedSection($postEmphasizedSectionInfo, $value['posting_id'])
                );
                $short_html = $this->getHtmlPostContents($arPostInfo);
                //update short html in DB
                $arShortHtml = array(
                    'posting_id' => $value['posting_id'],
                    'short_html' => $short_html,
                    'is_preprocessed' => 1
                );
                $shortHtmlUpdate = $this->sessionObj->execute_service('Application_Service_UpdateShortHtml', $arShortHtml, false);
                $short_html = str_replace('[posting_date]', $this->formatDateForShortSnippet($value['posting_date']), $short_html);
            }
            $this->pageShortHtml = $this->pageShortHtml . $short_html;
        }

        return $this->pageShortHtml;
    }

    public function GetLastPostForUser() {
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        $userId = null;
        $lastPost = null;
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $userId = $userInfo['user_id'];
        }
        if (isset($userId)) {
            $this->sessionObj = new Application_Service_LjSession();
            $lastPost = $this->sessionObj->execute_service('Application_Service_GetLastPostForUser', $userId, false);
        }
        return $lastPost;
    }

    public function GetRecentlyPostedItems($categoryId, $isParentCategory) {
        $this->pageHtml = "";
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        //No of items to be displayed
        if (isset($postConfig) && isset($postConfig->homePageNoOfItems))
            $noOfItems = $postConfig->homePageNoOfItems;
        else
            $noOfItems = 15; //Default configuration

        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();

        $input = array(
            'categoryId' => $categoryId,
            'isParentCategory' => $isParentCategory,
            'start' => 0,
            'rows' => $noOfItems
        );

        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetRecentlyPostedItems', $input, false);
        $postingIds = "";
        foreach ($this->postInfo as $key => $value) {
            $postingIds = $postingIds . "," . $value['posting_id'];
        }
        $postingIds = trim($postingIds, ',');
        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            $this->postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);
        }
        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            $this->postImageInfo = $this->sessionObj->execute_service('Application_Service_GetRecentPostsImages', $postingIds, false);
        }
        foreach ($this->postInfo as $key => $value) {
            $imageUrl = null;
            if (isset($this->postImageInfo) && count($this->postImageInfo) > 0) {
                foreach ($this->postImageInfo as $keyImage => $valueImage) {
                    if ($valueImage['posting_id'] == $value['posting_id']) {
                        if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {

//                            $imageUrl = $uploadHandler->copyImageFromCL($valueImage['image_url'], $valueImage['image_id'],$value['user_id']);
//                            if (!isset($imageUrl))
                            $imageUrl = $valueImage['image_url'];
                        }
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrlForHomePage($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                    }
                }
            }
            if (!isset($imageUrl)) {
                $parentCategoryInfo = null;
                $categoryInfo = null;
                $parentCategoryName = null;
                $parentCategoryId = null;
                if (Zend_Registry::isRegistered('parent_category_info')) {
                    $parentCategoryInfo = Zend_Registry::get('parent_category_info');
                }
                if (Zend_Registry::isRegistered('category_info')) {
                    $categoryInfo = Zend_Registry::get('category_info');
                }
                foreach ($categoryInfo as $keyCategory => $valueCategory) {
                    if ($valueCategory->getCategory_id() == $value['category_id'])
                        $parentCategoryId = $valueCategory->getParent_category_id();
                }
                if (isset($parentCategoryId)) {
                    foreach ($parentCategoryInfo as $keyParentCategory => $valueParentCategory) {
                        if ($valueParentCategory->getParent_category_id() == $parentCategoryId)
                            $parentCategoryName = $valueParentCategory->getParentCategoryName();
                    }
                }
                if (isset($parentCategoryName))
                    $imageUrl = str_replace('category-name', $parentCategoryId, Application_Model_LjConstants::$DEFAULT_IMAGE_URL);
            }

            $arPostInfo = array(
                'posting_id' => $value['posting_id'],
                'details_url' => '/api/post/' . $value['posting_id'],
                'title' => $value['title'],
                'cover_image_url' => $imageUrl,
                'emphasized_section' => $this->CreateEmphasizedSection($this->postEmphasizedSectionInfo, $value['posting_id'])
            );
            $short_html = $this->getHomePostHtmlContents($arPostInfo);
            $this->pageHtml = $this->pageHtml . $short_html;
        }

        return $this->pageHtml;
    }

    public function GetRecentPostsForAdmin($categoryId, $isParentCategory) {

        $this->pageShortHtml = "";
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        //No of items to be displayed
        if (isset($postConfig) && isset($postConfig->noOfRecentPostsAdmin))
            $noOfItems = $postConfig->noOfRecentPostsAdmin;
        else
            $noOfItems = 20; //Default configuration

        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();

        $input = array(
            'categoryId' => $categoryId,
            'isParentCategory' => $isParentCategory,
            'start' => 0,
            'rows' => $noOfItems
        );

        $postInfo = $this->sessionObj->execute_service('Application_Service_GetRecentlyPostedItems', $input, false);
        $postingIds = "";
        foreach ($postInfo as $key => $value) {
            $postingIds = $postingIds . "," . $value['posting_id'];
        }
        $postingIds = trim($postingIds, ',');

        $postEmphasizedSectionInfo = null;

        $postingIdsArray = explode(',', $postingIds);
        $counter = 0;
        for ($i = 0; $i < sizeof($postingIdsArray); $i++) {
            $value = null;
            $listingClass = "";
            foreach ($postInfo as $keyPostInfo => $valuePostInfo) {
                if ($valuePostInfo['posting_id'] == $postingIdsArray[$i])
                    $value = $valuePostInfo;
            }
            if (!isset($value))
                continue;
            $counter++;
            if ($counter % 4 == 0)
                $listingClass = "endRow";
            if ($i % 4 == 0)
                $listingClass = "beginRow";



            if (!isset($postEmphasizedSectionInfo))
                $postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);

            //create short html for the posting
            $imageUrl = null;
            //Get posting images
            $postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $value['posting_id'], false);
            if (isset($postImageInfo) && count($postImageInfo) > 0) {
                foreach ($postImageInfo as $keyImage => $valueImage) {
                    if ($valueImage['is_main_image'] == '1') {
                        if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {
                            if ($generateS3Images)
                                $imageUrl = $uploadHandler->copyImageFromCL($valueImage['image_url'], $valueImage['image_id'], $value['user_id']);
                            if (!isset($imageUrl))
                                $imageUrl = $valueImage['image_url'];
                        }
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrl($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                    }
                }
            }
            if (!isset($imageUrl))
                $imageUrl = str_replace('category-name', $value['parent_category_id'], Application_Model_LjConstants::$DEFAULT_IMAGE_URL);



            $value['description'] = str_replace('<!--', '', $value['description']);
            $value['description'] = str_replace('--!>', '', $value['description']);
            $value['description'] = $this->truncateText($value['description'], $postConfig->post_desc_truncate_limit);
            $arPostInfo = array(
                'posting_id' => $value['posting_id'],
                'details_url' => '/api/post/' . $value['posting_id'],
                'title' => strip_tags($value['title']),
                'description' => $value['description'],
                'user_id' => $value['user_id'],
                'category_id' => $value['category_id'],
                'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . $value['title'],
                'posting_date' => $this->formatDateForShortSnippet($value['posting_date']),
                'image_url' => $imageUrl,
                'address' => $value['address'],
                'lat' => $value['lat'],
                'lon' => $value['lon'],
                'emphasized_section' => $this->CreateEmphasizedSection($postEmphasizedSectionInfo, $value['posting_id'])
            );
            $short_html = $this->getHtmlRecentPostAdminContents($arPostInfo);

            $short_html = str_replace('[posting_date]', $this->formatDateForShortSnippet($value['posting_date']), $short_html);

            $this->pageShortHtml = $this->pageShortHtml . $short_html;
        }

        return $this->pageShortHtml;
    }

     public function GetSpamPostsForAdmin() {

        $this->pageShortHtml = "";
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        //No of items to be displayed
        if (isset($postConfig) && isset($postConfig->noOfRecentPostsAdmin))
            $noOfItems = $postConfig->noOfRecentPostsAdmin;
        else
            $noOfItems = 20; //Default configuration

        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();

        $input = array(
           
            'start' => 0,
            'rows' => $noOfItems
        );

        $postInfo = $this->sessionObj->execute_service('Application_Service_GetSpamPosts', $input, false);
        $postingIds = "";
        $spamCounters = "";
        foreach ($postInfo as $key => $value) {
            $postingIds = $postingIds . "," . $value['posting_id'];
            $spamCounters = $spamCounters . "," . $value['counter'];
        }
        $postingIds = trim($postingIds, ',');
        $spamCounters = trim($spamCounters, ',');

        $postEmphasizedSectionInfo = null;

        $postingIdsArray = explode(',', $postingIds);
        $spamCountersArray = explode(',', $spamCounters);
        $counter = 0;
        for ($i = 0; $i < sizeof($postingIdsArray); $i++) {
            $value = null;
            $listingClass = "";
            foreach ($postInfo as $keyPostInfo => $valuePostInfo) {
                if ($valuePostInfo['posting_id'] == $postingIdsArray[$i])
                    $value = $valuePostInfo;
            }
            if (!isset($value))
                continue;
            $counter++;
            if ($counter % 4 == 0)
                $listingClass = "endRow";
            if ($i % 4 == 0)
                $listingClass = "beginRow";



            if (!isset($postEmphasizedSectionInfo))
                $postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);

            //create short html for the posting
            $imageUrl = null;
            //Get posting images
            $postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $value['posting_id'], false);
            if (isset($postImageInfo) && count($postImageInfo) > 0) {
                foreach ($postImageInfo as $keyImage => $valueImage) {
                    if ($valueImage['is_main_image'] == '1') {
                        if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {
                            if ($generateS3Images)
                                $imageUrl = $uploadHandler->copyImageFromCL($valueImage['image_url'], $valueImage['image_id'], $value['user_id']);
                            if (!isset($imageUrl))
                                $imageUrl = $valueImage['image_url'];
                        }
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrl($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                    }
                }
            }
            if (!isset($imageUrl))
                $imageUrl = str_replace('category-name', $value['parent_category_id'], Application_Model_LjConstants::$DEFAULT_IMAGE_URL);



            $value['description'] = str_replace('<!--', '', $value['description']);
            $value['description'] = str_replace('--!>', '', $value['description']);
            $value['description'] = $this->truncateText($value['description'], $postConfig->post_desc_truncate_limit);
            $arPostInfo = array(
                'posting_id' => $value['posting_id'],
                'details_url' => '/api/post/' . $value['posting_id'],
                'title' => strip_tags($value['title']),
                'description' => $value['description'],
                'user_id' => $value['user_id'],
                'category_id' => $value['category_id'],
                'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . $value['title'],
                'posting_date' => $this->formatDateForShortSnippet($value['posting_date']),
                'image_url' => $imageUrl,
                'address' => $value['address'],
                'lat' => $value['lat'],
                'lon' => $value['lon'],
                'spam_counter'=>$spamCountersArray[$i],
                'emphasized_section' => $this->CreateEmphasizedSection($postEmphasizedSectionInfo, $value['posting_id'])
            );
            $short_html = $this->getHtmlSpamPostAdminContents($arPostInfo);

            $short_html = str_replace('[posting_date]', $this->formatDateForShortSnippet($value['posting_date']), $short_html);

            $this->pageShortHtml = $this->pageShortHtml . $short_html;
        }

        return $this->pageShortHtml;
    }
    public function CreateProfilePostSnippet($userId, $start, $rows, $statusFilter) {
        $this->postInfo = null;
        $this->pageHtml = "";
        $this->noOfPosts = 10;
        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        $input = array(
            'user_id' => $userId,
            'start' => $start,
            'rows' => $rows,
            'statusFilter' => $statusFilter
        );
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetAllPostingsForUser', $input, false);
        $postingIds = "";
        foreach ($this->postInfo as $key => $value) {
            $postingIds = $postingIds . "," . $value['posting_id'];
        }
        $postingIds = trim($postingIds, ',');
        $this->noOfPosts = 0;
        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            $this->postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);
            $this->noOfPosts = sizeof($this->postInfo);
        }

        foreach ($this->postInfo as $key => $value) {
            //if (strtolower($value['posting_status']) != strtolower(Application_Model_LjConstants::$POST_STATUS_CREATED_STATUS)) {
            $imageUrl = null;
            //Get posting images
            $this->postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $value['posting_id'], false);
            if (isset($this->postImageInfo) && count($this->postImageInfo) > 0) {
                foreach ($this->postImageInfo as $keyImage => $valueImage) {
                    if ($valueImage['is_main_image'] == '1') {
                        if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {
                            $imageUrl = $valueImage['image_url'];
                        }
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrl($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                    }
                }
            }
            if (!isset($imageUrl))
                $imageUrl = str_replace('category-name', $value['parent_category_id'], Application_Model_LjConstants::$DEFAULT_IMAGE_URL);


            $expiresIn = "";
            if (strtolower($value['posting_status']) == strtolower(Application_Model_LjConstants::$POST_STATUS_ACTIVE_STATUS)) {
                $todaysDate = date("Y-m-d");
                $todaysDate = date('Y-m-d', strtotime($todaysDate));
                $expirationDate = date('Y-m-d', strtotime($value['expiration_date']));
                $nodays = (strtotime($expirationDate) - strtotime($todaysDate)) / (60 * 60 * 24);
                $expiresIn = "Expires in " . $nodays . " days";
            }
            $value['description'] = str_replace('<!--', '', $value['description']);
            $value['description'] = str_replace('--!>', '', $value['description']);
            $value['description'] = $this->truncateText($value['description'], $postConfig->post_desc_truncate_limit);

            $arPostInfo = array(
                'posting_id' => $value['posting_id'],
                'details_url' => '/api/post/' . $value['posting_id'],
                'title' => strip_tags($value['title']),
                'description' => $value['description'],
                'user_id' => $value['user_id'],
                'category_id' => $value['category_id'],
                'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . $value['title'],
                'posting_date' => $this->formatDateForShortSnippet($value['posting_date']),
                'image_url' => $imageUrl,
                'address' => $value['address'],
                'lat' => $value['lat'],
                'lon' => $value['lon'],
                'posting_status_id' => $value['posting_status_id'],
                'posting_status' => $value['posting_status'],
                'expiresIn' => $expiresIn,
                'emphasized_section' => $this->CreateEmphasizedSection($this->postEmphasizedSectionInfo, $value['posting_id'])
            );
            $short_html = $this->getProfilePostHtmlContents($arPostInfo);
            $this->pageHtml = $this->pageHtml . $short_html;
            //}
        }
        $this->pageHtml = $this->pageHtml . '<PostNoFound>' . $this->noOfPosts;
        return $this->pageHtml;
    }

    public function CreatePostResponseSnippet($userId, $start, $rows, $statusFilter) {
        $this->postInfo = null;
        $this->pageHtml = "";
        $this->noOfPosts = 10;
        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        $input = array(
            'user_id' => $userId,
            'start' => $start,
            'rows' => $rows,
            'statusFilter' => $statusFilter
        );
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostsWithResponse', $input, false);
        $postingIds = "";
        foreach ($this->postInfo as $key => $value) {
            $postingIds = $postingIds . "," . $value['posting_id'];
        }
        $postingIds = trim($postingIds, ',');
        $this->noOfPosts = 0;
        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            $this->postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);
            $this->noOfPosts = sizeof($this->postInfo);
        }

        foreach ($this->postInfo as $key => $value) {
            //if (strtolower($value['posting_status']) != strtolower(Application_Model_LjConstants::$POST_STATUS_CREATED_STATUS)) {
            $imageUrl = null;
            //Get posting images
            $this->postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $value['posting_id'], false);
            if (isset($this->postImageInfo) && count($this->postImageInfo) > 0) {
                foreach ($this->postImageInfo as $keyImage => $valueImage) {
                    if ($valueImage['is_main_image'] == '1') {
                        if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {
                            $imageUrl = $valueImage['image_url'];
                        }
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrl($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                    }
                }
            }
            if (!isset($imageUrl))
                $imageUrl = str_replace('category-name', $value['parent_category_id'], Application_Model_LjConstants::$DEFAULT_IMAGE_URL);


            $expiresIn = "";
            if (strtolower($value['posting_status']) == strtolower(Application_Model_LjConstants::$POST_STATUS_ACTIVE_STATUS)) {
                $todaysDate = date("Y-m-d");
                $todaysDate = date('Y-m-d', strtotime($todaysDate));
                $expirationDate = date('Y-m-d', strtotime($value['expiration_date']));
                $nodays = (strtotime($expirationDate) - strtotime($todaysDate)) / (60 * 60 * 24);
                $expiresIn = "Expires in " . $nodays . " days";
            }
            $value['description'] = str_replace('<!--', '', $value['description']);
            $value['description'] = str_replace('--!>', '', $value['description']);
            $value['description'] = $this->truncateText($value['description'], $postConfig->post_desc_truncate_limit);

            $arPostInfo = array(
                'posting_id' => $value['posting_id'],
                'details_url' => '/api/post/' . $value['posting_id'],
                'title' => strip_tags($value['title']),
                'description' => $value['description'],
                'user_id' => $value['user_id'],
                'category_id' => $value['category_id'],
                'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . $value['title'],
                'posting_date' => $this->formatDateForShortSnippet($value['posting_date']),
                'image_url' => $imageUrl,
                'address' => $value['address'],
                'lat' => $value['lat'],
                'lon' => $value['lon'],
                'subject' => $value['subject'],
                'message' => $value['message'],
                'response_date' => $this->formatDateForShortSnippet($value['response_date']),
                'posting_status_id' => $value['posting_status_id'],
                'posting_status' => $value['posting_status'],
                'expiresIn' => $expiresIn,
                'emphasized_section' => $this->CreateEmphasizedSection($this->postEmphasizedSectionInfo, $value['posting_id'])
            );
            $short_html = $this->getPostResponseHtmlContents($arPostInfo);
            $this->pageHtml = $this->pageHtml . $short_html;
            //}
        }
        $this->pageHtml = $this->pageHtml . '<PostNoFound>' . $this->noOfPosts;
        return $this->pageHtml;
    }

    public function CreatePostActivitySnippet($userId, $start, $rows, $statusFilter) {
        $this->postInfo = null;
        $this->pageHtml = "";
        $this->noOfPosts = 10;
        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        $input = array(
            'user_id' => $userId,
            'start' => $start,
            'rows' => $rows,
            'statusFilter' => $statusFilter
        );
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetUserActivities', $input, false);
        $postingIds = "";
        foreach ($this->postInfo as $key => $value) {
            $postingIds = $postingIds . "," . $value['posting_id'];
        }
        $postingIds = trim($postingIds, ',');
        $this->noOfPosts = 0;
        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            $this->postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingIds, false);
            $this->noOfPosts = sizeof($this->postInfo);
        }

        foreach ($this->postInfo as $key => $value) {
            //if (strtolower($value['posting_status']) != strtolower(Application_Model_LjConstants::$POST_STATUS_CREATED_STATUS)) {
            $imageUrl = null;
            //Get posting images
            $this->postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $value['posting_id'], false);
            if (isset($this->postImageInfo) && count($this->postImageInfo) > 0) {
                foreach ($this->postImageInfo as $keyImage => $valueImage) {
                    if ($valueImage['is_main_image'] == '1') {
                        if (isset($valueImage['image_url']) && strlen($valueImage['image_url']) > 0) {
                            $imageUrl = $valueImage['image_url'];
                        }
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrl($value['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $valueImage['image_file'], $valueImage['image_id']);
                    }
                }
            }
            if (!isset($imageUrl))
                $imageUrl = str_replace('category-name', $value['parent_category_id'], Application_Model_LjConstants::$DEFAULT_IMAGE_URL);


            $expiresIn = "";
            if (strtolower($value['posting_status']) == strtolower(Application_Model_LjConstants::$POST_STATUS_ACTIVE_STATUS)) {
                $todaysDate = date("Y-m-d");
                $todaysDate = date('Y-m-d', strtotime($todaysDate));
                $expirationDate = date('Y-m-d', strtotime($value['expiration_date']));
                $nodays = (strtotime($expirationDate) - strtotime($todaysDate)) / (60 * 60 * 24);
                $expiresIn = "Expires in " . $nodays . " days";
            }
            $value['description'] = str_replace('<!--', '', $value['description']);
            $value['description'] = str_replace('--!>', '', $value['description']);
            $value['description'] = $this->truncateText($value['description'], $postConfig->post_desc_truncate_limit);

            $arPostInfo = array(
                'posting_view_id' => $value['posting_view_id'],
                'posting_id' => $value['posting_id'],
                'details_url' => '/api/post/' . $value['posting_id'],
                'title' => strip_tags($value['title']),
                'description' => $value['description'],
                'user_id' => $value['user_id'],
                'category_id' => $value['category_id'],
                'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $value['posting_id']) . '&text=' . $value['title'],
                'posting_date' => $this->formatDateForShortSnippet($value['posting_date']),
                'image_url' => $imageUrl,
                'address' => $value['address'],
                'lat' => $value['lat'],
                'lon' => $value['lon'],
                'posting_status_id' => $value['posting_status_id'],
                'action_id' => $value['action_id'],
                'action_date' => $this->formatDateForShortSnippet($value['action_date']),
                'posting_status' => $value['posting_status'],
                'expiresIn' => $expiresIn,
                'emphasized_section' => $this->CreateEmphasizedSection($this->postEmphasizedSectionInfo, $value['posting_id'])
            );
            $short_html = $this->getUserActivityHtmlContents($arPostInfo);
            $this->pageHtml = $this->pageHtml . $short_html;
            //}
        }
        $this->pageHtml = $this->pageHtml . '<PostNoFound>' . $this->noOfPosts;
        return $this->pageHtml;
    }

    public function GetFbSharePostInfo($postingId) {
        $this->postInfo = null;

        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingsByIds', $postingId, false);
        $this->postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $postingId, false);
        $arPostInfo = null;
        if (isset($this->postInfo)) {

            $imageUrl = null;
            //Get posting images
            $this->postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $postingId, false);

            $cover_image_url = "";
            if (isset($this->postImageInfo) && count($this->postImageInfo) > 0) {
                foreach ($this->postImageInfo as $key => $value) {

                    if ($value['is_main_image'] == '1') {
                        if (isset($value['image_url']) && strlen($value['image_url']) > 0)
                            $imageUrl = $value['image_url'];
                        else
                            $imageUrl = $uploadHandler->GetS3ImageUrl($this->postInfo[0]['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $value['image_file'], $value['image_id']);
                        $cover_image_url = $imageUrl;
                    }
                }
            }
            $this->postInfo[0]['description'] = str_replace('<!--', '', $this->postInfo[0]['description']);
            $this->postInfo[0]['description'] = str_replace('--!>', '', $this->postInfo[0]['description']);
            $arPostInfo = array(
                'posting_id' => $this->postInfo[0]['posting_id'],
                'title' => $this->postInfo[0]['title'],
                'description' => $this->postInfo[0]['description'],
                'cover_image_url' => $cover_image_url,
                'emphasized_section' => $this->CreateSingleFieldEmphasizedSection($this->postEmphasizedSectionInfo)
            );
        }

        return $arPostInfo;
    }

    public function ConvertPostInfoAsArray($postInfo) {
        $this->postInfo = $postInfo;
        $imageUrl = null;
        $uploadHandler = new LjS3UploadHandler();
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        $this->sessionObj = new Application_Service_LjSession();
        $this->postEmphasizedSectionInfo = $this->sessionObj->execute_service('Application_Service_GetEmphasizedAttributes', $this->postInfo[0]['posting_id'], false);
        $this->postAttrInfo = $this->sessionObj->execute_service('Application_Service_GetPostAttribute', $this->postInfo[0]['posting_id'], false);
        $this->postTags = $this->sessionObj->execute_service('Application_Service_GetPostTags', $this->postInfo[0]['posting_id'], false);

        $this->postImageInfo = $this->sessionObj->execute_service('Application_Service_GetPostingImages', $this->postInfo[0]['posting_id'], false);
        $postImagesArray = array();
        $cover_image_url = "";
        if (isset($this->postImageInfo) && count($this->postImageInfo) > 0) {
            foreach ($this->postImageInfo as $key => $value) {
                if (isset($value['image_url']) && strlen($value['image_url']) > 0)
                    $imageUrl = $value['image_url'];
                else
                    $imageUrl = $uploadHandler->GetS3ImageUrl($this->postInfo[0]['user_id'], Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $value['image_file'], $value['image_id']);

                if ($value['is_main_image'] == '1')
                    $cover_image_url = $imageUrl;
                $postImagesArray[] = array('is_main_image' => $value['is_main_image'], 'image_url' => $imageUrl, 'image_title' => $value['image_title']);
            }
        }


        $this->postInfo[0]['description'] = str_replace('<!--', '', $this->postInfo[0]['description']);
        $this->postInfo[0]['description'] = str_replace('--!>', '', $this->postInfo[0]['description']);
        $staticMapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=' . $this->postInfo[0]['lat'] . ',' . $this->postInfo[0]['lon'] .
                '&amp;zoom=12&amp;size=290x125&amp;maptype=roadmap&amp;markers=color:red%7C' . $this->postInfo[0]['lat'] . ',' . $this->postInfo[0]['lon'] . '&amp;sensor=false';

        $tags = "";
        foreach ($this->postTags as $key => $value) {
            $tags = $tags . ',' . $value['tag_name'];
        }
        $tags = trim($tags, ',');
        //Check whether post is shortlisted
        $remove_shortlists = $this->GetUserShortListsToRemovePosting($this->postInfo[0]['posting_id']);
        $is_favorite = false;
        if (isset($remove_shortlists) && sizeof($remove_shortlists))
            $is_favorite = true;
        //End
        //Check whether post is marked is as spam
        $is_spam = $this->CheckIfPostFlaggedAsSpam($this->postInfo[0]['posting_id']);
        //end
        $arPostInfo = array(
            'posting_id' => $this->postInfo[0]['posting_id'],
            'title' => strip_tags($this->postInfo[0]['title']),
            'description' => $this->postInfo[0]['description'],
            'user_id' => $this->postInfo[0]['user_id'],
            'category_id' => $this->postInfo[0]['category_id'],
            'parent_category_id' => $this->postInfo[0]['parent_category_id'],
            'posting_date' => $this->formatDateForShortSnippet($this->postInfo[0]['posting_date']),
            'address' => $this->postInfo[0]['address'],
            'category_name' => $this->postInfo[0]['category_name'],
            'parent_category_name' => $this->postInfo[0]['parent_category_name'],
            'static_map_url' => $staticMapUrl,
            'cover_image_url' => $cover_image_url,
            'twitter_share_link' => 'https://twitter.com/share?url=' . urlencode($postConfig->post_share_url . $this->postInfo[0]['posting_id']) . '&text=' . $this->postInfo[0]['title'],
            'lat' => $this->postInfo[0]['lat'],
            'lon' => $this->postInfo[0]['lon'],
            'zip' => $this->postInfo[0]['zip'],
            'city' => $this->postInfo[0]['city'],
            'email' => $this->postInfo[0]['email'],
            'phone' => $this->postInfo[0]['phone'],
            'post_anonymously' => $this->postInfo[0]['post_anonymously'],
            'tags' => $tags,
            'poster_name' => $this->postInfo[0]['first_name'] . ' ' . $this->postInfo[0]['last_name'],
            'enable_sms' => $this->postInfo[0]['enable_sms'],
            'post_images_array' => $postImagesArray,
            'emphasized_section' => $this->CreateEmphasizedSectionForLongHtml($this->postEmphasizedSectionInfo),
            'category_attributes' => $this->postAttrInfo,
            'is_favorite' => $is_favorite,
            'is_spam' => $is_spam,
            'posting_status_id' => $this->postInfo[0]['posting_status_id'],
            'posting_status' => $this->postInfo[0]['posting_status']
        );
        return $arPostInfo;
    }

    public function CreatePostLongHtml($postingId) {
        $this->postInfo = null;
        $this->pageHtml = "";
        $this->sessionObj = new Application_Service_LjSession();
        $this->postInfo = $this->sessionObj->execute_service('Application_Service_GetPostingsByIds', $postingId, false);

        if (isset($this->postInfo) && sizeof($this->postInfo) > 0) {
            $longHtmlDB = $this->postInfo[0]['long_html'];
//            if ($longHtmlDB != null && strlen($longHtmlDB) > 0)
//                $this->pageHtml = $longHtmlDB; //Retrieve short html from DB
//            else {
            //create long html for the posting        
            //Check whether post is shortlisted
            $remove_shortlists = $this->GetUserShortListsToRemovePosting($this->postInfo[0]['posting_id']);
            $is_favorite = false;

            if (isset($remove_shortlists) && sizeof($remove_shortlists)) {
                $is_favorite = true;
            }
            //End
            $arPostInfo = $this->ConvertPostInfoAsArray($this->postInfo);
            $this->pageHtml = $this->getLongHtmlPostContents($arPostInfo);
            //update long html in DB 
            $arLongHtml = array(
                'posting_id' => $this->postInfo[0]['posting_id'],
                'long_html' => $this->pageHtml
            );
            $longHtmlUpdate = $this->sessionObj->execute_service('Application_Service_UpdateLongHtml', $arLongHtml, false);
            //}
            $arShortList = array(
                'add_shortlists' => $this->GetUserShortListsToAddPosting($this->postInfo[0]['posting_id']),
                'is_favorite' => $is_favorite,
                'posting_id' => $this->postInfo[0]['posting_id']
            );
            $addShortlistHtml = $this->getAddShortListContents($arShortList);
            $this->pageHtml = str_replace('[shortlisthtmlplaceholder]', $addShortlistHtml, $this->pageHtml);
        }

        return $this->pageHtml;
    }

  
    function formatDateForPostStats($postingDate) {

        Zend_Date::setOptions(array('format_type' => 'php'));

        $datetimeformat = 'F j, Y';
        $zenddate = new Zend_Date($postingDate, "Y-m-d H:i:s");
        if (Zend_Registry::isRegistered('timezone')) {

            $timezone = Zend_Registry::get('timezone');
        } else {
            $timezone = 'UTC';
        }
        $zenddate->setTimezone($timezone);


        $formattedDate = "";
        $todaysDate = date("Y-m-d");
        $postDateYMD = date_format(date_create($zenddate), "Y-m-d");
        if (strtotime($todaysDate) == strtotime($postDateYMD))
            $formattedDate = "Today";
        else if (strtotime($todaysDate) == strtotime("+1 day", strtotime($postDateYMD)))
            $formattedDate = "Yesterday";
        else
            $formattedDate = $zenddate->toString($datetimeformat);

        return $formattedDate;
    }

    public function truncateText($text, $limit) {
        $truncated = $text;
        if (!isset($limit) || strlen($limit) == 0)
            $limit = 220;
        if (strlen($text) >= $limit) {

            $truncated = substr($text, 0, $limit);
            $truncated = substr($truncated, 0, strripos($truncated, ' ')) . '&hellip;';
        }
        return $truncated;
    }

    public function formatCurrency($number) {
        $currency = new Zend_Currency();
        $currency->setFormat(array('precision' => 0));
        return $currency->toCurrency($number);
    }

    function getHtmlPostContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/short_html.php';
        return ob_get_clean();
    }
    
        function getHtmlRecentPostAdminContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/recent_posts_admin.html.php';
        return ob_get_clean();
    }
    
       function getHtmlSpamPostAdminContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/spam_posts_admin.html.php';
        return ob_get_clean();
    }
    

    function getProfilePostHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/profile_post_short_html.php';
        return ob_get_clean();
    }

    function getPostResponseHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/post_response_short_html.php';
        return ob_get_clean();
    }

    function getUserActivityHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/post_activity_short_html.php';
        return ob_get_clean();
    }

    function getHomePostHtmlContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/home_post_short_html.php';
        return ob_get_clean();
    }

    function getLongHtmlPostContents(array $vars) {
        extract($vars);
        ob_start();
        include 'Templates/long_html.php';
        return ob_get_clean();
    }

    function getAddShortListContents(array $vars) {
        extract($vars);
        ob_start();
        include 'Templates/add_remove_shortlist_html.php';
        return ob_get_clean();
    }

    protected function getFullUrl() {
        return
                (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') .
                (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
                (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                        (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
                        $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
                substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

}

//End class
?>
