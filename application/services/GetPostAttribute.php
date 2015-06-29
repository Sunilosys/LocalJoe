<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostAttribute
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetPostAttribute {

    public function execute($input) {
        try {

            $postAttrObj = new Application_Model_LjPosting();
            if (isset($input) && $input != '')
                $where = "where pa.posting_id='" . $input . "'";
            $postAttrObj->sql_stmt = 'SELECT pa.category_attribute_id,pca.name,pa.value,pa.dimension from posting_attribute pa inner join category_attribute ca on ' .
                    ' pa.category_attribute_id = ca.category_attribute_id  inner join parent_category_attribute pca on pca.parent_category_attribute_id = ca.parent_category_attribute_id   '
                    . "$where" . " order by ca.display_sequence asc";

            $postAttrs = $postAttrObj->query();
            return $postAttrs;
        } catch (Exception $e) {

            throw $e;
        }
    }

}