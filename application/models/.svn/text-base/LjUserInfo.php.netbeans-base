<?php

class Application_Model_LjUserInfo extends Application_Model_LjBaseModel {

    //Modlular level variables
    protected $table_name = "user_info";
    protected $table_pk = "user_id";
    protected $class_name = 'Application_Model_LjUserInfo';
    var $user_id;
    var $authentication_method_id;
    var $city_id;
    var $user_type_id;
    var $first_name;
    var $last_name;
    var $email;
    var $password;
    var $active_flag;
    var $date_created;
    var $date_updated;
    var $enable_sms;
    var $post_anonymously;
    var $last_login_date;
    var $last_login_ip;

    //////////////////////////
    //Sets Entity info
    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setAuthentication_method_id($authentication_method_id) {
        $this->authentication_method_id = $authentication_method_id;
    }

    function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    function setUserType_id($user_type_id) {
        $this->user_type_id = $user_type_id;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setActive_flag($active_flag) {
        $this->active_flag = $active_flag;
    }

    function setEnable_sms($enable_sms) {
        $this->enable_sms = $enable_sms;
    }

    function setPost_anonymously($post_anonymously) {
        $this->post_anonymously = $post_anonymously;
    }

    function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    function setDate_updated($date_updated) {
        $this->date_updated = $date_updated;
    }

    function setLastLoginDate($last_login_date) {
        $this->last_login_date = $last_login_date;
    }

    function setLastLoginIp($last_login_ip) {
        $this->last_login_ip = $last_login_ip;
    }

    //////////////////////////
    //////////////////////////
    //Returns Loaded Entity info
    function getUser_id() {
        return $this->user_id;
    }

    function getAuthentication_method_id() {
        return $this->authentication_method_id;
    }

    function getCity_id() {
        return $this->city_id;
    }

    function getUserType_id() {
        return $this->user_type_id;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getActive_flag() {
        return $this->active_flag;
    }

    function getEnable_sms() {
        return $this->enable_sms;
    }

    function getPost_anonymously() {
        return $this->post_anonymously;
    }

    function getDate_created() {
        return $this->date_created;
    }

    function getDate_updated() {
        return $this->date_updated;
    }

    function getLastLoginDate() {
        return $this->last_login_date;
    }

    function getLastLoginIp() {
        return $this->last_login_ip;
    }

    function ActivateUser($userId) {
        $arUserInfo = array(
            'user_id' => $userId,
            'active_flag' => 1,
            'date_updated' => date("Y-m-d H:i:s")
        );
        $this->user_info = new Application_Service_LjSession();
        $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);
    }

    function EnableSMSForUser($userId, $enableSMS) {
        $arUserInfo = array(
            'user_id' => $userId,
            'enable_sms' => $enableSMS
        );
        $this->user_info = new Application_Service_LjSession();
        $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);
    }

    function SetPrivacyForUser($userId, $postAnonymously) {
        $arUserInfo = array(
            'user_id' => $userId,
            'post_anonymously' => $postAnonymously
        );
        $this->user_info = new Application_Service_LjSession();
        $userResult = $this->user_info->execute_service('Application_Service_UpdateUser', $arUserInfo, true);
    }

    public function GetRecentLogins() {
        $this->pageHtml = "";
        $postConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'posting');
        //No of items to be displayed
        if (isset($postConfig) && isset($postConfig->noOfRecentLogins))
            $noOfItems = $postConfig->noOfRecentLogins;
        else
            $noOfItems = 100; //Default configuration

        $uploadHandler = new LjS3UploadHandler();
        $this->sessionObj = new Application_Service_LjSession();

        $input = array(
            'start' => 0,
            'rows' => $noOfItems
        );

        $userInfo = $this->sessionObj->execute_service('Application_Service_GetRecentLogins', $input, false);
        $userIds = "";

        foreach ($userInfo as $key => $value) {
            $userIds = $userIds . "," . $value['user_id'];
        }
        $userIds = trim($userIds, ',');
        $userIdsArray = explode(',', $userIds);

        $counter = 0;
        for ($i = 0; $i < sizeof($userIdsArray); $i++) {
            $value = null;
            $listingClass = "";
            foreach ($userInfo as $keyUserInfo => $valueUserInfo) {
                if ($valueUserInfo['user_id'] == $userIdsArray[$i])
                    $value = $valueUserInfo;
            }
            if (!isset($value))
                continue;
            $counter++;
            if ($counter % 4 == 0)
                $listingClass = "endRow";
            if ($i % 4 == 0)
                $listingClass = "beginRow";

            $uploadHandler = new LjS3UploadHandler();
            $ip = "unknown";
            if (isset($value['last_login_ip']))
                $ip = $value['last_login_ip'];
            $arUserInfo = array(
                'user_id' => $value['user_id'],
                'details_url' => '/page=profile&user_id=' . $value['user_id'],
                'first_name' => $value['first_name'],
                'last_name' => $value['last_name'],
                'email' => $value['email'],
                'title' => $value['first_name'] . ' ' . $value['last_name'] . ' (' . $value['email'] . ')' . ' logged in using ' . $value['authentication_method'] . ' credentials. IP - ' . $ip,
                'authentication_method' => $value['authentication_method'],
                'profile_pic_url' => $uploadHandler->GetS3ProfilePicUrl($value['user_id']),
                'last_login_date' => $this->formatDateForShortSnippet($value['last_login_date']),
                'last_login_ip' => $value['last_login_ip']
            );

            $short_html = $this->getHtmlRecentLoginAdminContents($arUserInfo);

            $this->pageHtml = $this->pageHtml . $short_html;
        }

        return $this->pageHtml;
    }

    function getHtmlRecentLoginAdminContents(array $vars) {
        extract($vars);

        ob_start();
        include 'Templates/recent_logins_admin.html.php';
        return ob_get_clean();
    }

}

//End class
?>
