<?php

class Application_Service_GetPostingById
{
    public function execute($input) {
        try {

            $postInfoObj = new Application_Model_LjPosting();
            if (isset($input) && $input != '')
                $postInfoObj->where_clause = "posting_id='" . $input . "'";
            $postInfo = $postInfoObj->select();
            if (isset($postInfo) && sizeof($postInfo) == 1)
                return $postInfo[0];
            else
                return $postInfo;
        } catch (Exception $e) {

            throw $e;
        }
    }
}
