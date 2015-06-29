<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostsWithResponse
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetPostsWithResponse {
     public function execute($input) {


        try {

            $postingObj = new Application_Model_LjPosting();
            $where = "";
            if ($input['statusFilter'] == "all")
            $where = "where pr.user_id ='" . $input['user_id'] .  "' and ps.posting_status_id in (1,2,3,4)";    
            else
              $where = "where pr.user_id ='" . $input['user_id'] . "' and ps.posting_status = '" . $input['statusFilter']. "'";    
            $limit = "LIMIT " . $input['start'] . ',' . $input['rows'];
            $postingObj->sql_stmt = 'select distinct p.posting_id,ps.posting_status_id,ps.posting_status,title,p.description,p.posting_date,p.expiration_date,p.date_created, ' .
                                    ' p.date_updated,p.user_id,p.category_id,c.name as category_name,pc.name as parent_category_name, '.
                                    ' short_html,long_html,a.lat,a.lon,a.city,a.address,a.phone,ui.email,ui.first_name,ui.last_name,pr.subject,pr.message,pr.date_created as response_date ' . 
                                    ' from posting p left join address a on a.posting_id = p.posting_id inner join user_info ui on ui.user_id = p.user_id inner join category c '.
                                    ' on p.category_id = c.category_id inner join parent_category pc on pc.parent_category_id = c.parent_category_id '.
                                    ' inner join posting_status ps on ps.posting_status_id = p.posting_status_id inner join posting_response pr on pr.posting_id = p.posting_id '
                                    . "$where" . ' order by pr.date_created desc ' . "$limit" ;

            $postings = $postingObj->query(); 
            //print_r($postings);exit;
            
            return $postings;
        } catch (Exception $e) {

            throw $e;
        }
    }
}