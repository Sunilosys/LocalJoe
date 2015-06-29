<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetFacetFieldsByCatId
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetFacetFieldsByCatId {
    
 public function execute($input) {
        try {

            $catAttrObj = new Application_Model_LjParentCategory();

            $where = "where pca.is_active = 1 and pca.is_search_facet= 1 and ca.category_id ='" . $input . "'";

            $catAttrObj->sql_stmt = 'select pca.facet_name,pca.facet_type,pca.solr_column_name from parent_category_attribute pca inner join category_attribute ca on pca.parent_category_attribute_id =
                                            ca.parent_category_attribute_id '. "$where" . ' order by ca.display_sequence asc' ;

            $facetFields = $catAttrObj->query();           
            return $facetFields;
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}
