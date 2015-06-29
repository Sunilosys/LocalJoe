<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRecentImportLogs
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetRecentImportLogs {

    public function execute($input) {
        try {

            $obj = new Application_Model_LjImportCategory();
            $where = "where is_completed='1'";
            $obj->sql_stmt = 'select import_id,u.first_name,u.last_name,date_imported from import_category i inner join user_info u on u.user_id = i.user_id  ' . $where . ' order by import_id desc limit 0,20';

            $imports = $obj->query();
            return $imports;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
