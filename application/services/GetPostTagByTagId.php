<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostTagByName
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetPostTagByTagId {

    public function execute($input) {
        try {

            $tagObj = new Application_Model_LjPostingTag();
            if (isset($input))
                $tagObj->where_clause = "tag_id='" . $input['tag_id'] . "' and posting_id='" . $input['posting_id'] . "'";
            $tag = $tagObj->select();
            if (isset($tag) && sizeof($tag) == 1)
                return $tag[0];
            else
                return $tag;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
