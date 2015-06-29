<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetTagById
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetTagByName {

    public function execute($input) {
        try {

            $tagObj = new Application_Model_LjTag();
            if (isset($input) && $input != '')
                $tagObj->where_clause = "tag_name='" . $input . "'";
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
