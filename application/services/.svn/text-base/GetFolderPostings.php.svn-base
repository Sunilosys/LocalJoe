<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetFolderPostings
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetFolderPostings {

    public function execute($input) {
        try {

            $folderPostObj = new Application_Model_LjFolderPosting();
            if (isset($input))
            $where = "where folder_id='" . $input['shortlistId'] . "'";
            if (isset($input) && isset($input['sort']))
            {
            $orderBy = "order by " . str_replace('_dt', '', $input['sort']);   
            }
            $folderPostingList = "";
            $folderPostObj->sql_stmt = 'select fp.folder_id,fp.posting_id,fp.folder_posting_id from folder_posting fp inner join posting p on ' .
                                       ' fp.posting_id = p.posting_id '
                                        . "$where" . ' ' . "$orderBy" ;

            $folderPostings = $folderPostObj->query(); 
            if (isset($folderPostings)) {

                foreach ($folderPostings as $key => $value) {
                    $folderPostingList = $folderPostingList . ',' . $value['posting_id'];
                }
            }
            return trim($folderPostingList, ',');
        } catch (Exception $e) {

            throw $e;
        }
    }

}
