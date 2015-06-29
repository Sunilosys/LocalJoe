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
class Application_Service_GetRecentlyPostedItems {

    public function execute($input) {


        try {

            $postingObj = new Application_Model_LjPosting();
            $where = "";
            if ($input['categoryId'] != "0") {
                if ($input['isParentCategory'] == "true")
                    $where = "where ps.posting_status_id = 2 and p.category_id in (select category_id from category where parent_category_id ='" + $input['category_id'] + "')";
                else
                    $where = "where ps.posting_status_id = 2 and p.category_id ='" + $input['categoryId'] + "'";
            }
            else {
                $where = "where ps.posting_status_id = 2";
            }

            $limit = "LIMIT " . $input['start'] . ',' . $input['rows'];
            $postingObj->sql_stmt = 'select distinct p.posting_id,ps.posting_status_id,ps.posting_status,p.title,p.description,p.posting_date,p.expiration_date,p.date_created, ' .
                    ' p.date_updated,p.user_id,p.category_id ' .
                    ' from posting p inner join posting_status ps on ps.posting_status_id = p.posting_status_id '
                    . "$where" . ' order by p.posting_date desc ' . "$limit";
            $postings = $postingObj->query();

            return $postings;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
