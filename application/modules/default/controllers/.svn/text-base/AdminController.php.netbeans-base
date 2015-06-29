<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author sunil_salunkhe
 */
class AdminController extends Lj_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction() {
        $this->_helper->layout->disableLayout();
        $this->sessionObj = new Application_Service_LjSession();
        $importLogs = $this->sessionObj->execute_service('Application_Service_GetRecentImportLogs', null, false);
        $this->view->importLogs = $importLogs;
        $this->view->validUser = 0;

        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            if ($userInfo['user_id'] != 0) {

                $this->sessionObj = new Application_Service_LjSession();
                $userInfoObj = $this->sessionObj->execute_service('Application_Service_GetUser', $userInfo['user_id'], false);

                if (isset($userInfoObj)) {
                    if ($userInfoObj->user_type_id == 1)
                        $this->view->validUser = 1;
                }
            }
        }
    }

    public function importAction() {
        $this->_helper->layout->disableLayout();
        $userId = 0;
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            if ($userInfo['user_id'] != 0) {
                $userId = $userInfo['user_id'];
            }
        }
        $this->sessionObj = new Application_Service_LjSession();

        if ($userId != 0) {

            $input = array(
                'user_id' => $userId,
                'date_imported' => date("Y-m-d H:i:s")
            );
            $importId = $this->sessionObj->execute_service('Application_Service_CreateImportLog', $input, false);

            $fh = fopen(APPLICATION_PATH . '/../data/logs/import.log', 'w');
            fclose($fh);
            $log = Zend_Registry::get('importlog');
            try {
                $tmp = $_FILES['importFile']['tmp_name'];

                $xml = new XMLReader();
                $xml->open($tmp);
                $tempArray = $this->xml2assoc($xml);
                $xml->close();



                $log->info('Import process started.');
                foreach ($tempArray as $key => $value) {
                    $tempArray1 = $value['value'];
                    foreach ($tempArray1 as $key1 => $value1) {
                        if ($value1['tag'] == 'parent-categories') {
                            $tempArray2 = $value1['value'];
                            foreach ($tempArray2 as $key2 => $value2) {


                                $tempArray3 = $value2['value'];
                                if ($value2['attributes']['action'] == 'update') {
                                    $input = array();
                                    foreach ($tempArray3 as $key3 => $value3) {
                                        $input[$value3['tag']] = $value3['value'];
                                    }

                                    $log->info('Updated ' . $value2['tag']);

                                    $text = "";
                                    foreach ($input as $key => $value) {
                                        $text .= $key . " : " . $value . ";";
                                    }

                                    $log->info($text);
                                    if ($value2['tag'] == 'parent-category')
                                        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateParentCategory', $input, false);
                                    else if ($value2['tag'] == 'format')
                                        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateFormat', $input, false);
                                    else if ($value2['tag'] == 'parent-category-attribute')
                                        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateParentCategoryAttribute', $input, false);
                                    else if ($value2['tag'] == 'category')
                                        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateCategory', $input, false);
                                    else if ($value2['tag'] == 'category-attribute')
                                        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateCategoryAttribute', $input, false);
                                    else if ($value2['tag'] == 'category-attribute-valid-value')
                                        $updateResult = $this->sessionObj->execute_service('Application_Service_UpdateCategoryAttributeValidValue', $input, false);
                                } else if ($value2['attributes']['action'] == 'add') {
                                    $input = array();
                                    foreach ($tempArray3 as $key3 => $value3) {
                                        $input[$value3['tag']] = $value3['value'];
                                    }
                                    $log->info('Added ' . $value2['tag']);

                                    $text = "";
                                    foreach ($input as $key => $value) {
                                        $text .= $key . " : " . $value . ";";
                                    }

                                    $log->info($text);
                                    if ($value2['tag'] == 'parent-category')
                                        $addResult = $this->sessionObj->execute_service('Application_Service_AddParentCategory', $input, false);
                                    else if ($value2['tag'] == 'format')
                                        $addResult = $this->sessionObj->execute_service('Application_Service_AddFormat', $input, false);
                                    else if ($value2['tag'] == 'parent-category-attribute')
                                        $addResult = $this->sessionObj->execute_service('Application_Service_AddParentCategoryAttribute', $input, false);
                                    else if ($value2['tag'] == 'category')
                                        $addResult = $this->sessionObj->execute_service('Application_Service_AddCategory', $input, false);
                                    else if ($value2['tag'] == 'category-attribute')
                                        $addResult = $this->sessionObj->execute_service('Application_Service_AddCategoryAttribute', $input, false);
                                    else if ($value2['tag'] == 'category-attribute-valid-value')
                                        $addResult = $this->sessionObj->execute_service('Application_Service_AddCategoryAttributeValidValue', $input, false);
                                }
                            }
                        }
                    }
                }

                $log->info('Import process ended.');
                $upload_handler = new LjS3UploadHandler();
                $upload_handler->handle_import_log_upload(APPLICATION_PATH . '/../data/logs/import.log', $importId);
                $input = array(
                    'import_id' => $importId,
                    'is_completed' => '1'
                );
                $update = $this->sessionObj->execute_service('Application_Service_UpdateImportLog', $input, false);

                echo "success";
            } catch (Exception $ex) {

                if (isset($log))
                    $log->info($ex->getTrace());
                echo 'Unexpected error occurred while importing the categories.';
                $input = array(
                    'import_id' => $importId,
                    'is_completed' => '0',
                    'error' => $ex->getTrace()
                );
                $update = $this->sessionObj->execute_service('Application_Service_UpdateImportLog', $input, false);
            }
        }
        else {
            echo "login_required";
        }
        exit;
    }

    public function downloadAction() {
        $this->_helper->layout->disableLayout();
        if (isset($_GET['importId'])) {
            $upload_handler = new LjS3UploadHandler();
            $importLogUrl = $upload_handler->GetAmazonS3Url() . '/' . $_GET['importId'] . '.log';
            header('Content-type: "text/xml"; charset="utf8"');
            header('Content-disposition: attachment; filename="' . $_GET['importId'] . '.log"');
            readfile($importLogUrl);
        }
    }

  

    public function exportAction() {
        $this->_helper->layout->disableLayout();

        //$xml = $this->sqlToXml($result, "parent-categories", "parent_category");
        $localJoe = array();
        $localJoe['@attributes'] = array(
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:noNamespaceSchemaLocation' => 'http://www.example.com/schmema.xsd',
            'lastUpdated' => date('c')  // dynamic values
        );

        $parentCategoryObj = new Application_Model_LjParentCategory();

        $parentCategoryObj->sql_stmt = 'select * from parent_category';
        $result = $parentCategoryObj->query();


        $localJoe['parent-categories'] = array();

        $localJoe['parent-categories']['parent-category'] = array();

        foreach ($result as $key => $value) {
            $value['@attributes'] = array(
                'action' => 'nochange'
            );
            $localJoe['parent-categories']['parent-category'][] = $value;
        }

        $formatObj = new Application_Model_LjFormat();

        $formatObj->sql_stmt = 'select * from format';
        $result = $formatObj->query();


        $localJoe['formats'] = array();

        $localJoe['formats']['format'] = array();

        foreach ($result as $key => $value) {
            $value['@attributes'] = array(
                'action' => 'nochange'
            );
            $localJoe['formats']['format'][] = $value;
        }

        $parentCategoryAttrObj = new Application_Model_LjParentCategoryAttribute();

        $parentCategoryAttrObj->sql_stmt = 'select * from parent_category_attribute';
        $result = $parentCategoryAttrObj->query();


        $localJoe['parent-category-attributes'] = array();

        $localJoe['parent-category-attributes']['parent-category-attribute'] = array();

        foreach ($result as $key => $value) {
            $value['@attributes'] = array(
                'action' => 'nochange'
            );
            $localJoe['parent-category-attributes']['parent-category-attribute'][] = $value;
        }

        $CategoryAttrObj = new Application_Model_LjCategoryAttribute();

        $CategoryAttrObj->sql_stmt = 'select * from category_attribute';
        $result = $CategoryAttrObj->query();


        $localJoe['category-attributes'] = array();

        $localJoe['category-attributes']['category-attribute'] = array();

        foreach ($result as $key => $value) {
            $value['@attributes'] = array(
                'action' => 'nochange'
            );
            $localJoe['category-attributes']['category-attribute'][] = $value;
        }

        $CategoryAttrValidValueObj = new Application_Model_LjCategoryAttrValues();

        $CategoryAttrValidValueObj->sql_stmt = 'select * from category_attribute_valid_value';
        $result = $CategoryAttrValidValueObj->query();


        $localJoe['category-attribute-valid-values'] = array();

        $localJoe['category-attribute-valid-values']['category-attribute-valid-value'] = array();

        foreach ($result as $key => $value) {
            $value['@attributes'] = array(
                'action' => 'nochange'
            );
            $localJoe['category-attribute-valid-values']['category-attribute-valid-value'][] = $value;
        }
        $xml = Array2XML::createXML('localjoe', $localJoe);
        header('Content-type: "text/xml"; charset="utf8"');
        header('Content-disposition: attachment; filename="localjoe_categories.xml"');
        echo $xml->saveXML();
    }

    public function xml2assoc($xml) {
        $tree = null;
        while ($xml->read())
            switch ($xml->nodeType) {
                case XMLReader::END_ELEMENT: return $tree;
                case XMLReader::ELEMENT:
                    $node = array('tag' => $xml->name, 'value' => $xml->isEmptyElement ? '' : $this->xml2assoc($xml));
                    if ($xml->hasAttributes)
                        while ($xml->moveToNextAttribute())
                            $node['attributes'][$xml->name] = $xml->value;
                    $tree[] = $node;
                    break;
                case XMLReader::TEXT:
                case XMLReader::CDATA:
                    $tree .= $xml->value;
            }
        return $tree;
    }

}

?>
