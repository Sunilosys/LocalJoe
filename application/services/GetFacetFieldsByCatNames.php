<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetFacetFieldsByCatIds
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetFacetFieldsByCatNames {
    public function execute($input) {
        try {

            $catAttrObj = new Application_Model_LjParentCategory();
            
            $count = sizeof(explode(',', $input['categories']));
            $parentCategory = $input['parent_category'];
            $categories = $input['categories'];
            $where = "where pca.is_active = 1 and pca.is_search_facet= 1 and pc.name='" .$parentCategory ."' and c.name in (" . $categories . ")";
            $groupBy = " group by pca.facet_name,pca.facet_type,pca.solr_column_name,f.display_format,pca.is_currency,pca.range_increment,pca.rule having count(*) =" . $count;
            $catAttrObj->sql_stmt = 'select pca.facet_name,pca.facet_type,pca.solr_column_name,f.display_format,pca.is_currency,pca.range_increment,pca.rule, count(*) from parent_category_attribute pca inner join category_attribute ca on pca.parent_category_attribute_id = ca.parent_category_attribute_id inner join format f  on f.format_id = pca.format_id '
                                    . ' inner join category c on c.category_id = ca.category_id inner join parent_category pc on pc.parent_category_id = c.parent_category_id '. "$where" . "$groupBy".' order by ca.display_sequence asc' ;

            $facetFields = $catAttrObj->query();           
            return $facetFields;
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}


