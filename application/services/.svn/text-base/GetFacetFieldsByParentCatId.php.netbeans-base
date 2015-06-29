<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetFacetFieldsByParentCatId
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetFacetFieldsByParentCatId {
   public function execute($input) {
        try {

            $catAttrObj = new Application_Model_LjParentCategory();

            $where = "where pca.is_active = 1 and pca.is_search_facet= 1 and pca.parent_category_id ='" . $input . "'";

            $catAttrObj->sql_stmt = 'select distinct pca.facet_name,pca.facet_type,pca.solr_column_name,f.display_format,pca.is_currency,pca.range_increment from parent_category_attribute pca inner join category_attribute ca on pca.parent_category_attribute_id = ca.parent_category_attribute_id inner join format f  on f.format_id = pca.format_id '
                                    . "$where" .' order by ca.display_sequence asc' ;

            $facetFields = $catAttrObj->query();           
            return $facetFields;
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}


