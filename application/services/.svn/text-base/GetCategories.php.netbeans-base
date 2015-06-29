<?php

class Application_Service_GetCategories {

    public function execute($input) {
        try {

            $categoryObj = new Application_Model_LjCategory();
            if (isset($input) && $input != '')
                $categoryObj->where_clause = "is_active = 1 and category_id='" . $input . "'";
            else
                $categoryObj->where_clause = "is_active = 1";
            $categories = $categoryObj->select();
            return $categories;
        } catch (Exception $e) {

            throw $e;
        }
    }

}

