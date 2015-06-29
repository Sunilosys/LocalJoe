<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetStatistics
 *
 * @author ssalunkhe
 */
class Application_Service_GetStatistics {
     public function execute($input) {


        try {

            $postingViewObj = new Application_Model_LjPostingView();

            $where = "where posting_id in (" . $input . ")";
            $groupBy = " group by a.action";
           
            $postingViewObj->sql_stmt = "select a.action,count(*) as count " .
                                        "from posting_view pv inner join action a on pv.action_id = a.action_id ". "$where" . "$groupBy"  ;
                                    

            $postingViews = $postingViewObj->query(); 
             $postingViewsArray = null;
            if (isset($postingViews)) {

                foreach ($postingViews as $key => $value) {
                    $postingViewsArray[] = array(
                       
                        "action" => $value['action'],
                        
                        "count" => $value['count']
                         
                    );
                }
            }

            return $postingViewsArray;
            
        } catch (Exception $e) {

            throw $e;
        }
    }
}
