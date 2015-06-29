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
class Application_Service_GetShortlistsToRemovePosting {

    public function execute($input) {
        try {

            $shortlistObj = new Application_Model_LjFolder();

//            $shortlistObj->sql_stmt = 'select distinct folder_id,folder_name from folder where user_id = ' . $input['user_id'] . ' and folder_id IN ' .
//                    ' (select f.folder_id from folder f inner join folder_posting fp on f.folder_id=fp.folder_id ' .
//                    '  where fp.posting_id = ' . $input['posting_id'] . ' and user_id = ' . $input['user_id'] . ' ) ';

            $shortlistObj->sql_stmt = 'select distinct f.folder_id,f.folder_name,fp.posting_id from folder f inner join folder_posting fp '.
                                       ' on f.folder_id = fp.folder_id where fp.posting_id in ('.  $input['posting_id']  .') and user_id =' . $input['user_id'];
            
            $shortlists = $shortlistObj->query();
            $shortlistArray = null;
            if (isset($shortlists)) {

                foreach ($shortlists as $key => $value) {
                    $shortlistArray[] = array(
                        "user_id" => $input['user_id'],
                        "folder_id" => $value['folder_id'],
                        "folder_name" => $value['folder_name'],
                         "posting_id" => $value['posting_id'],
                    );
                }
            }

            return $shortlistArray;
        } catch (Exception $e) {

            throw $e;
        }
    }

}
