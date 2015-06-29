<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostTags
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetPostTags {

    public function execute($input) {
        try {

            $tagObj = new Application_Model_LjTag();
            if (isset($input) && $input != '')
                $where = "where posting_id='" . $input . "'";
            $tagObj->sql_stmt = 'select t.tag_name from posting_tag pt inner join tag t on t.tag_id=pt.tag_id '
                    . "$where";

            $tags = $tagObj->query();
            return $tags;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
