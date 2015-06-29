<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostingShortHtmlsByIds
 *
 * @author ssalunkhe
 */
class Application_Service_GetPostingShortHtmlsByIds {
     public function execute($input) {


        try {

            $postingObj = new Application_Model_LjPosting();

            $where = "where posting_id in (" . $input . ")";

            $postingObj->sql_stmt = 'select posting_id,short_html from posting '. "$where" ;
                                    
            
            
            $postings = $postingObj->query(); 
            
            return $postings;
        } catch (Exception $e) {

            throw $e;
        }
    }
}


