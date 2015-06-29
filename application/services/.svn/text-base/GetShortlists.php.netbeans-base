<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetShortlists
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetShortlists {

    public function execute($input) {
        try {

            $shortlistObj = new Application_Model_LjFolder();
            $folderPostingObj = new Application_Model_LjFolderPosting();
            if (isset($input) && $input != '')
                $shortlistObj->where_clause = "user_id='" . $input . "'";
            $shortlistObj->order_by = "order by folder_name";
            $shortlists = $shortlistObj->select();
            $shortlistArray = null;
            if (isset($shortlists)) {

                foreach ($shortlists as $key => $value) {


                    $folderPostingObj->where_clause = "folder_id='" . $value->folder_id . "'";
                    $folderPostingObj->order_by = "order by posting_id desc";
                    $folderPostings = $shortlistObj->select();
                    $shortlistArray[] = array(
                        "user_id" => $value->user_id,
                        "folder_id" => $value->folder_id,
                        "folder_name" => $value->folder_name,
                        "folder_postings" => $folderPostings
                    );
                }
            }

            return $shortlistArray;
        } catch (Exception $e) {

            throw $e;
        }
    }

}

