<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetPostingImages
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetPostingImages {

    public function execute($input) {
        try {

            $postingImageObj = new Application_Model_LjCategoryAttribute();
            $where = "where pi.posting_id='" . $input . "'";
            $postingImageObj->sql_stmt = 'select i.image_id,user_id,image_file,pi.is_main_image,image_title,width,height,image_size,image_url,i.date_created from image i inner join posting_image pi on i.image_id = pi.image_id ' . "$where" . " order by pi.date_created desc";

            $postingImages = $postingImageObj->query();
            return $postingImages;
        } catch (Exception $e) {

            throw $e;
        }
    }

}