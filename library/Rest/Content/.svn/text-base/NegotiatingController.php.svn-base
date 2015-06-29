<?php
/**
 * A controller implementation that support content negotiating using
 * a Rest_Content_Registry.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_Content_NegotiatingController extends Zend_Controller_Action
{
	/**
	 * The rest content registry 
	 * @var Rest_Content_Registry
	 */
	protected $_contentRegistry;
	
	/** 
	 * The content negotiator instance
	 * @var Rest_Content_Negotiator
	 */
	protected $_negotiator;
	
	/**
	 * Creates a new content negotiating controller. Initializes the Rest_Content_Registry
	 * from the initialized resource or from the static factory method.
	 * @see Rest_Resource 
	 * @param Zend_Controller_Request_Abstract $request
	 * @param Zend_Controller_Response_Abstract $response
	 * @param array $invokeArgs
	 */
	public function __construct(Zend_Controller_Request_Abstract $request,
		Zend_Controller_Response_Abstract $response,
		array $invokeArgs = array())
	{
		$this->_contentRegistry = $this->_getRegistry();
		$this->_negotiator = new Rest_Content_Negotiator(
			$request, $response, $this->getContentRegistry());
		parent::__construct($request, $response, $invokeArgs);
	}
	
	/**
	 * Initialize the content registry
	 * @return Rest_Content_Registry
	 */
	private function _getRegistry()
	{
		$bootstrap = $this->getFrontController()->getParam('bootstrap');
		$registry = null;
		if($bootstrap !== null) {
    		$registry = $bootstrap->getResource('rest');
		}
		return ($registry instanceof Rest_Content_Registry) ? $registry : Application_Resource_Rest::getRegistry();		
	}
	
	/**
	 * Returns the current REST content registry for this controller.
	 * @return Rest_Content_Registry
	 */
	public function getContentRegistry()
	{
		return $this->_contentRegistry;
	}
	
	/**
	 * Returns the controllers content negotiator instance.
	 * @return Rest_Content_Negotiator
	 */
	public function getContentNegotiator()
	{
		return $this->_negotiator;
	}
	
	/**
	 * Returns the data deserialized from the requests body.
	 * @return array|null
	 */
	public function getData()
	{
		return $this->getContentNegotiator()->getData();
	}
	
	public function preDispatch()
	{
		$this->view = $this->initView();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Controller_Action::initView()
	 */
	public function initView()
	{
		$format = $this->_getParam('format');
		if($format !== null) {
			$this->getContentNegotiator()->setFormat($format);
		}
		$view = $this->getContentNegotiator()->getView();
		if($this->_helper->hasHelper('viewRenderer')) {
			$this->_helper->viewRenderer->setView($view);
		}
		return $view;
	}
}