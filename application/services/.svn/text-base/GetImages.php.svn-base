<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetImages
 *
 * @author sunil_salunkhe
 */
class Application_Service_GetImages {

    public function execute($input) {
        try {

            $imageObj = new Application_Model_LjImage();

            if (isset($input) && $input != '')
                $where = "where i.user_id='" . $input . "'";
            $imageObj->sql_stmt = "select i.image_id,i.image_file,i.image_title,i.image_size,i.width as 'org_img_width',i.height as 'org_img_height', " .
                    " ic.image_type_id,ic.image_size as 'image_type_size', ic.width as 'image_type_width',ic.height as 'image_type_height' from image i inner join image_copy ic on i.image_id = ic.image_id " . "$where" . " order by i.image_id desc";
            $images = $imageObj->query();
            return $images;
        } catch (Exception $e) {

            throw $e;
        }
    }

}