<?php

class Application_Resource_Rest extends Zend_Application_Resource_ResourceAbstract {

    const DEFAULT_VIEW = 'default';

    /**
     * Return a new registry instance.
     * @param array $config The configuration to overwrite the defaults with
     * @return Rest_Content_Registry
     */
    public static function getRegistry($config = array()) {
        $resource = new Application_Resource_Rest($config);
        return $resource->init();
    }   

    /**
     * The content registry default configuration
     * @var array
     */
    protected $_options = array(
        'deserialize' => array(
            'xml' => array(
                'class' => 'Rest_Deserialize_Xml',
                'content_type' => array('application/xml', 'text/xml')
            ),
            'json' => array(
                'class' => 'Rest_Deserialize_Json',
                'content_type' => 'application/json'
            ),
            'form' => array(
                'class' => 'Rest_Deserialize_Form',
                'content_type' => 'application/x-www-form-urlencoded'
            )
        ),
        'view' => array(
//            'xml' => array(
//                'class' => 'Rest_View_Xml',
//                'content_type' => array('application/xml', 'text/xml')
//            ),
//            'json' => array(
//                'class' => 'Rest_View_Json',
//                'content_type' => 'application/json'
//            ),
            'html' => array(
                'class' => self::DEFAULT_VIEW,
                'content_type' => 'text/html'
            )
        // 'pdf' => array(
        //	'class' => 'View_Pdf',
        //	'content_type' => 'application/pdf'
        // )
        )
    );

    /**
     * @var Rest_Content_Registry
     */
    protected $_registry;

    /*
     * TODO getting the default view is quite painful because
     * the framework has at least three different locations where
     * views could be initialized (view resource, view renderer,
     * controller instance) all in different parts of the request
     * lifecycle.
     */

    /**
     * Returns the the default view, either from the view application
     * resource or the viewRenderer or null if nothing was found.
     * @return Zend_View_Interface | null
     */
    private function _getDefaultView() {
        if ($this->getBootstrap() !== null) {
            try {
                $bootstrap = $this->getBootstrap()->bootstrap('frontController')->bootstrap('view');
                $view = $bootstrap->getResource('view');
                if ($view instanceof Zend_View_Interface) {
                    return $view;
                }
            } catch (Zend_Application_Bootstrap_Exception $e) {
                return $this->_getFromViewRenderer();
            } // finally *sigh*
        }
        return $this->_getFromViewRenderer();
    }

    /**
     * Return the view from the view renderer.
     * @return Zend_View_Interface | null
     */
    private function _getFromViewRenderer() {
        try {
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
            $viewRenderer->init();
            $view = $viewRenderer->view;            
        } catch (Zend_Controller_Action_Exception $e) {
            $view = null;
        }
        return $view;
    }

    /**
     * (non-PHPdoc)
     * @see Zend_Application_Resource_Resource::init()
     * @return Rest_Content_Registry
     */
    public function init() {
        $options = $this->getOptions();
        $this->_registry = new Rest_Content_Registry();
        $this->_initViews($options['view']);
        $this->_initDeserializers($options['deserialize']);
        return $this->_registry;
    }

    protected function _initViews($config) {
        foreach ($config as $format => $options) {
            if ($options != false) {
                $params = isset($options['params']) ? $options['params'] : array();
                $cls = $options['class'];
                if ($cls == self::DEFAULT_VIEW) {
                    $instance = $this->_getDefaultView();
                } else {
                    $instance = new $cls($params);
                }
                if ($instance !== null) {
                    $types = (array) $options['content_type'];
                    foreach ($types as $contentType) {
                        $this->_registry->addView($contentType, $instance, $format);
                    }
                }
            }
        }
    }

    protected function _initDeserializers($config) {
        foreach ($config as $format => $options) {
            if ($options != false) {
                $params = isset($options['params']) ? $options['params'] : array();
                $cls = $options['class'];
                $instance = new $cls($params);
                $types = (array) $options['content_type'];
                foreach ($types as $contentType) {
                    $this->_registry->addDeserializer($contentType, $instance);
                }
            }
        }
    }

}