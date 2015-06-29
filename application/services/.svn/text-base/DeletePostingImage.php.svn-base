<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Service_DeletePostingImage {

    public function execute($input) {
        try {
            $res = 0;
            $postImageObj = new Application_Model_LjPostingImage();
            if (isset($input['posting_id']))
                $res = $postImageObj->deleteArr($input);
            else if (isset($input['image_id']))
                $res = $postImageObj->deleteArr($input);
            return $res;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

