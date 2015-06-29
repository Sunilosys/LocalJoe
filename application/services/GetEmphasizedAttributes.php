<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetEmphasizedAttributes
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetEmphasizedAttributes {
    
 public function execute($input) {
        try {

            $emphasizedAttrObj = new Application_Model_LjCategoryAttribute();

            $where = "where pca.rule ='Emphasized' and pa.posting_id in (" . $input . ")";

            $emphasizedAttrObj->sql_stmt = 'select pa.posting_id,pa.value,pa.dimension,pca.name from posting_attribute pa inner join category_attribute ca on pa.category_attribute_id =
                                            ca.category_attribute_id inner join parent_category_attribute pca on pca.parent_category_attribute_id = ca.parent_category_attribute_id ' 
                                            . "$where" ;

            $emphasizedAttrs = $emphasizedAttrObj->query();           
            return $emphasizedAttrs;
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}


