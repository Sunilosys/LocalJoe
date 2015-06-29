<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TagController
 *
 * @author sunil_salunkhe
 */
class TagController extends Lj_Controller_Action {
   public function searchAction()
   {
        $name_startsWith = strtolower($_GET["name_startsWith"]);
        if (!$name_startsWith) return;
        $this->tagObj = new Application_Service_LjSession();
        $tagInfo = $this->tagObj->execute_service('Application_Service_GetTags', null, false);
        $tagArray = array();
        
        foreach ($tagInfo as $key=>$value) {
	if (strpos(strtolower($value->tag_name), $name_startsWith) !== false) {
		$tagArray[] = $value;
	}
        }
        echo json_encode($tagArray);
        exit;

   }
    
}

?>
