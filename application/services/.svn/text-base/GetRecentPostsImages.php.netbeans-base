<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRecentPostsImages
 *
 * @author ssalunkhe
 */
class Application_Service_GetRecentPostsImages {
    
 public function execute($input) {
    
        try {

            $postingImageObj = new Application_Model_LjPostingImage();
            $where = "where pi.is_main_image = 1 and pi.posting_id in (" . $input . ")";
            $postingImageObj->sql_stmt = 'select i.image_id,user_id,image_file,pi.posting_id,pi.is_main_image,image_title,width,height,image_size,image_url,i.date_created from image i inner join posting_image pi on i.image_id = pi.image_id ' . "$where" . " order by pi.date_created desc";

            $postingImages = $postingImageObj->query();
            return $postingImages;
        } catch (Exception $e) {

            throw $e;
        }
        
 }
}
