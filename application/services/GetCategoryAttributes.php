<?php

class Application_Service_GetCategoryAttributes {

    public function execute($input) {


        try {

            $categoryAttrKeyObj = new Application_Model_LjCategoryAttribute();

            $where = "where pca.is_active=1 and ca.category_id='" . $input . "'";

            $categoryAttrKeyObj->sql_stmt = 'select distinct ca.category_attribute_id,f.display_format,pca.name,ca.display_sequence,pca.sorttype,pca.rule,pca.is_currency,pca.help_text,pca.is_required,"" as value from category_attribute ca inner join parent_category_attribute pca on pca.parent_category_attribute_id = ca.parent_category_attribute_id
                                                           inner join format f on f.format_id = pca.format_id  ' . "$where" . " order by ca.display_sequence asc";

            $categoryAttrKeyArray = $categoryAttrKeyObj->query();

            $categoryAttributeObj = new Application_Model_LjCategoryAttribute();

            $where = "where cav.is_active=1 and ca.category_id='" . $input . "'";

            $categoryAttributeObj->sql_stmt = 'select ca.category_attribute_id,category_id,ca.display_sequence,cav.is_active,cav.value,cav.is_other from category_attribute ca
                                                           inner join category_attribute_valid_value cav on cav.parent_category_attribute_id = ca.parent_category_attribute_id ' . "$where" . " order by ca.display_sequence asc,cav.display_sequence";

            $categoryAttributesArray = $categoryAttributeObj->query();
            $delimiter = "~$~";
            $emphasized_category_ids = "";
            $categoryAttrModArray = array();
            $validValuesArray = array();
            foreach ($categoryAttrKeyArray as $key => $value) {
                unset($validValuesArray);
                $validValuesArray = array();
                foreach ($categoryAttributesArray as $key2 => $value2) {
                    if ($value['category_attribute_id'] == $value2['category_attribute_id']) {
                        $validValuesArray[] = $value2['value'];
                    }
                }
                if (isset($value['sortType']) && strtolower($value['sortType']) == 'asc') {
                    asort($validValuesArray);
                } else if (isset($value['sortType']) && strtolower($value['sortType']) == 'desc') {
                    arsort($validValuesArray);
                }
                for ($i = 0; $i < count($validValuesArray); $i++) {
                    if ($value['value'] == "")
                        $value['value'] = $validValuesArray[$i];
                    else
                        $value['value'] = $value['value'] . $delimiter . $validValuesArray[$i];
                }
               
                $categoryAttrModArray[] = $value;
            }
          
            return $categoryAttrModArray;
        } catch (Exception $e) {

            throw $e;
        }
    }

}

