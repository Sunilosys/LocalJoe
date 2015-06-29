<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeletePost
 *
 * @author sunil_salunkhe
 */
class Application_Service_DeletePost
{
	public function execute($input)
	{
		try {
	
                        //Delete Posting Attribute
			$PostAttrObj=new Application_Model_LjPostingAttribute();                      
			$PostAttrDelete=$PostAttrObj->deleteArr($input);
                        //Delete Post Tags
                        $PostTagObj=new Application_Model_LjPostingTag();                      
			$PostAttrDelete=$PostTagObj->deleteArr($input);
                        //Delete Post Images
			$PostImageObj=new Application_Model_LjPostingImage();                      
			$PostImageDelete=$PostImageObj->deleteArr($input);
                        //Delete Post Address
                        $PostAddressObj=new Application_Model_LjAddress();                      
			$PostAddrDelete=$PostAddressObj->deleteArr($input);
                        //Delete Post
                        $PostObj=new Application_Model_LjPosting();                      
			$PostObjDelete=$PostObj->deleteArr($input);
                        
		} catch (Exception $e) {
			throw $e;
		}
	}
}
