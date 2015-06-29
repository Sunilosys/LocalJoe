<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRecentlyPostedItems
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetRecentLogins {

    public function execute($input) {


        try {

            $userObj = new Application_Model_LjUserInfo();
            $where = "";
      

            $limit = "LIMIT " . $input['start'] . ',' . $input['rows'];
            $userObj->sql_stmt = 'select u.user_id,u.first_name,u.last_name,u.email, u.last_login_date,u.last_login_ip,a.authentication_method from user_info u inner join authentication_method a on u.authentication_method_id = a.authentication_method_id  order by last_login_date desc ' . $limit;
            $users = $userObj->query();

            return $users;
        } catch (Exception $e) {

            throw $e;
        }
    }

}

