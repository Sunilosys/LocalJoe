<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CheckPostSpamFlagByUser
 *
 * @author sunil_salunkhe
 */
class Application_Service_CheckPostSpamFlag {

    public function execute($input) {
        try {

            $postSpamObj = new Application_Model_LjPostingView();
            if (isset($input)) {
                $postSpamObj->where_clause = "action_id = " . Application_Model_LjConstants::$POST_ACTION_SPAM_ID . " and posting_id=" . $input['posting_id'] . " and user_id =" . $input['user_id'] ;
                $postSpam = $postSpamObj->select();
                if (isset($postSpam) && sizeof($postSpam) > 0)
                    return true;
                else
                    return false;
            }
            else {
                return false;
            }
        } catch (Exception $e) {

            throw $e;
        }
    }

}