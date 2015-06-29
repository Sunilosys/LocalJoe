<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetSavedSearches
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetSavedSearches {

    public function execute($input) {
        try {

            $savedSearchObj = new Application_Model_LjSavedSearch();
            if (isset($input) && $input != '')
                $savedSearchObj->where_clause = "user_id='" . $input . "'";
            $savedSearchObj->order_by = "order by search_name";
            $savedSearches = $savedSearchObj->select();
            $savedSearchesArray = null;
            if (isset($savedSearches)) {

                foreach ($savedSearches as $key => $value) {

                    $savedSearchesArray[] = array(
                        "user_id" => $value->user_id,
                        "search_id" => $value->search_id,
                        "search_name" => $value->search_name,
                        "search_terms" => urldecode($value->search_terms)
                    );
                }
            }

            return $savedSearchesArray;
        } catch (Exception $e) {

            throw $e;
        }
    }

}

