<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostingsByIds
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetPostingsByIds {
     public function execute($input) {


        try {

            $postingObj = new Application_Model_LjPosting();

            $where = "where p.posting_id in (" . $input . ")";

            $postingObj->sql_stmt = 'select p.posting_id,p.posting_status_id,ps.posting_status,p.post_anonymously,p.title,p.description,posting_date,p.expiration_date,p.date_created,p.date_updated,p.user_id,p.category_id,pc.parent_category_id,c.name as category_name,pc.name as parent_category_name, '.
                                    ' short_html,long_html,a.lat,a.lon,a.zip,a.city,a.address,a.phone,ui.email,ui.first_name,ui.last_name,ui.enable_sms' . 
                                    ' from posting p left join address a on a.posting_id = p.posting_id inner join user_info ui on ui.user_id = p.user_id inner join category c '.
                                    ' on p.category_id = c.category_id inner join parent_category pc on pc.parent_category_id = c.parent_category_id inner join posting_status ps on ps.posting_status_id=p.posting_status_id '
                                    . "$where" ;

            $postings = $postingObj->query();          
            return $postings;
        } catch (Exception $e) {

            throw $e;
        }
    }
}


