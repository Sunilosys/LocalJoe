<?php

class Application_Service_GetUser {

    public function execute($input) {
        try {

            $userInfoObj = new Application_Model_LjUserInfo();
            if (isset($input) && $input != '')
                $userInfoObj->where_clause = "user_id='" . $input . "'";
            $userInfo = $userInfoObj->select();
            if (isset($userInfo) && sizeof($userInfo) == 1)
                return $userInfo[0];
            else
                return $userInfo;
        } catch (Exception $e) {

            throw $e;
        }
    }

}