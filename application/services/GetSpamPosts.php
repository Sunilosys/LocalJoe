<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetSpamPosts
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetSpamPosts {

    public function execute($input) {


        try {

            $postingObj = new Application_Model_LjPosting();
            $where = "";
            $postingObj->sql_stmt = 'select p.posting_id,p.title,p.description,p.posting_date,p.expiration_date,p.date_created, '.
                                    ' p.date_updated,p.user_id,p.category_id ,a.lat,a.lon,a.address,count(*) counter ' .
                                    ' from posting p inner join posting_view pv on pv.posting_id = p.posting_id and p.posting_status_id = 2 ' . 
                                    ' and pv.action_id=3 inner join address a on a.posting_id = pv.posting_id '.
                                    ' group by posting_id order by counter desc ';

            $postings = $postingObj->query();

            return $postings;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
