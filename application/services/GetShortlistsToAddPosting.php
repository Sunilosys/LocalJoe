<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetShortlistsToAddPosting
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetShortlistsToAddPosting {

    public function execute($input) {
        try {

            $shortlistObj = new Application_Model_LjFolder();
            $shortlistObj->where_clause = "user_id='" . $input['user_id'] . "'";
            $shortlistObj->order_by = "order by folder_name";
            $userShortlists = $shortlistObj->select();
            $shortlistArray = null;

            $shortlistObj->sql_stmt = 'select distinct folder_id,folder_name from folder where user_id = ' . $input['user_id'] . ' and folder_id IN ' .
                    ' (select f.folder_id from folder f inner join folder_posting fp on f.folder_id=fp.folder_id ' .
                    '  where fp.posting_id = ' . $input['posting_id'] . ' and user_id = ' . $input['user_id'] . ' ) ';

            $postShortlists = $shortlistObj->query();

            if (isset($userShortlists)) {

                foreach ($userShortlists as $key => $value) {
                    $isAdded = false;
                    if (isset($postShortlists)) {
                        foreach ($postShortlists as $key2 => $value2) {
                            if ($value2['folder_id'] == $value->folder_id) {
                                $isAdded = true;
                                break;
                            }
                        }
                    }
                    $shortlistArray[] = array(
                        "user_id" => $input['user_id'],
                        "folder_id" => $value->folder_id,
                        "folder_name" => $value->folder_name,
                        "is_added" => $isAdded
                    );
                }
            }

            return $shortlistArray;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
