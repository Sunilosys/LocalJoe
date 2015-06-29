<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetLastPostForUser
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetLastPostForUser {
    public function execute($input) {
        try {

            $postInfoObj = new Application_Model_LjPosting();             
            $where = "where user_id='" . $input . "'";
            $postInfoObj->sql_stmt = 'select * from posting ' . "$where" . " order by posting_date desc LIMIT 1";
            $lastPost = $postInfoObj->query();
            return $lastPost;
        } catch (Exception $e) {

            throw $e;
        }
    }
}

?>
