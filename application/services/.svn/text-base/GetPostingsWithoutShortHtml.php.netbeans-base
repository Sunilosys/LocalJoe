<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostingsWithoutShortHtml
 *
 * @author ssalunkhe
 */
class Application_Service_GetPostingsWithoutShortHtml {

    public function execute($input) {


        try {

            $postingObj = new Application_Model_LjPosting();

            $where = "where ps.posting_status_id = 2 and p.is_preprocessed = 0";


            $limit = "LIMIT " . $input['start'] . ',' . $input['rows'];
            $postingObj->sql_stmt = 'select distinct p.posting_id' .
                    ' from posting p inner join posting_status ps on ps.posting_status_id = p.posting_status_id '
                    . "$where" . ' order by p.posting_id desc ' . "$limit";
            $postings = $postingObj->query();

            return $postings;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
