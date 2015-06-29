<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDefaultModuleAutoloader() {
        $this->_resourceLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => 'Application',
                    'basePath' => APPLICATION_PATH,
                ));

        $this->_resourceLoader->addResourceTypes(array(
            'modelResource' => array(
                'path' => 'models/',
                'namespace' => 'Model',
            ),
            'service' => array(
                'path' => 'services/',
                'namespace' => 'Service',
            ),
        ));
    }

    public function _initRest() {
        $frontController = Zend_Controller_Front::getInstance();

        // add the REST route for the API module only
        $restRoute = new Zend_Rest_Route($frontController, array(), array('api'));
        $frontController->getRouter()->addRoute('rest', $restRoute);
    }

    protected function _initConfig() {

        $dbConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', APPLICATION_ENV);
        Zend_Registry::set('dbConfig', $dbConfig);
        $db = Zend_Db::factory($dbConfig->db);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);

        //This is in your bootstrap, note you can also use Zend_Config in the constructor
        $config = array(
            'name' => 'session', //table name as per Zend_Db_Table
            'primary' => 'id', //the sessionID given by php
            'modifiedColumn' => 'modified', //time the session should expire
            'dataColumn' => 'data', //serialized data
            'lifetimeColumn' => 'lifetime'      //end of life for a specific record
        );
        Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($config));
        Zend_Session::start();
        Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts');
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->doctype('HTML5');

        $translate = new Zend_Translate(array(
                    'adapter' => 'gettext',
                    'content' => APPLICATION_PATH . '/languages/fr.mo',
                    'locale' => 'fr'
                ));
        $translate->addTranslation(array(
            'adapter' => 'gettext',
            'content' => APPLICATION_PATH . '/languages/en.mo',
            'locale' => 'en'
        ));

        if (isset($dbConfig->locale))
            $locale = new Zend_Locale($dbConfig->locale);
        else
            $locale = new Zend_Locale();
        if ($translate->isAvailable($locale)) {
            $translate->setLocale($locale);
            //$view->locale = $locale->toString();
        } else {
            $translate->setLocale('en_US');
            //$view->locale = 'en';
        }
        Zend_Registry::set('Zend_Locale', $locale);

        $view->locale = $locale;
        $currency = new Zend_Currency($locale);
        $view->currencySymbol = $currency->getSymbol();
        $view->translate = $translate;
        $dateformat = $dbConfig->dateformat;
        $datetimeformat = $dbConfig->datetimeformat;
        $view->dateformat = $dateformat;
        $view->phoneformat = $dbConfig->phoneformat;
        $view->country = $dbConfig->country;
        $view->latitude = $dbConfig->latitude;
        $view->longitude = $dbConfig->longitude;
        $timezone = $dbConfig->timezone;
        $view->partition = $dbConfig->partition;
        $view->blog_url = $dbConfig->blog_url;
        $view->facebook_app_id = $dbConfig->facebook_app_id;

        //Set Parent Categories and Categories in registry
        $this->ParentCategoryService = new Application_Service_LjSession();
        $parentCategoryInfo = $this->ParentCategoryService->execute_service('Application_Service_GetParentCategories', null, false);

        Zend_Registry::set('parent_category_info', $parentCategoryInfo);
        $this->CategoryService = new Application_Service_LjSession();
        $categoryInfo = $this->CategoryService->execute_service('Application_Service_GetCategories', null, false);

        Zend_Registry::set('category_info', $categoryInfo);
        Zend_Registry::set('timezone', $timezone);
        Zend_Registry::set('dateformat', $dateformat);
        Zend_Registry::set('datetimeformat', $datetimeformat);

        //End
    }

    /**
     * Setup the logging
     */
    protected function _initLogging() {
        $logger = new Zend_Log();

        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/application.log');

        $logger->addWriter($writer);

        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);

        $options = $this->getOption('resources');


        $logOptions = $options['log'];

        $logFilename = $logOptions['stream']['writerParams']['stream'];
       
        $logOptions['stream']['writerParams']['stream'] = $logFilename;

        $importlogger = Zend_Log::factory($logOptions);
        Zend_Registry::set('importlog', $importlogger);

        
    }

}