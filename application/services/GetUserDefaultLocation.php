<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetUserDefaultLocation
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetUserDefaultLocation {
    public function execute($input) {
        try {

            $addressObj = new Application_Model_LjAddress();          
          
            $where = "where user_id = '" .$input. "'" ;
            $addressObj->sql_stmt = 'select a.address,a.city,a.zip,a.lat,a.lon,a.phone from address a inner join posting p on a.posting_id = p.posting_id  ' . 
                                    "$where" .' order by p.posting_id desc LIMIT 1' ;

            $address = $addressObj->query();           
            return $address;
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}


