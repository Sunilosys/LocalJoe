<?php
class Rest_Controller extends Rest_Content_NegotiatingController
{
	protected $_resource;
	
	/**
	 * Creates a new REST controller. A Rest controller basically decorates
	 * calls to a Rest_Resource.
	 * If this controller implements the Rest_Resource interface
	 * it will automatically decorate itself.
	 * @see Rest_Resource 
	 * @param Zend_Controller_Request_Abstract $request
	 * @param Zend_Controller_Response_Abstract $response
	 * @param array $invokeArgs
	 */
	public function __construct(Zend_Controller_Request_Abstract $request,
		Zend_Controller_Response_Abstract $response,
		array $invokeArgs = array())
	{
		if($this instanceof Rest_Resource) {
			$this->setResource($this);
		}
		parent::__construct($request, $response, $invokeArgs);
	}
	
	/**
	 * Set the resource this controller decorates.
	 * @param Rest_Resource $resource
	 */
	public function setResource($resource)
	{
		$this->_resource = $resource;
	}
	
	/**
	 * Returns the resource this controller decorates.
	 * @return Rest_Resource
	 */
	public function getResource()
	{
		return $this->_resource;
	}
	
	/**
	 * Wrap the result if any has been returned
	 * @param string $result
	 */
	private function _assignResult($result)
	{
		if(isset($result) && $result !== null) {
			$this->view->assign($result);
		}
	}
	
	/**
	 * Check the request method and throw a bad request exception if it is not as expected.
	 * @param string $expected The expected request method
	 * @throws Rest_Exception
	 */
	private function _checkRequestMethod($expected = 'get')
	{
		$request = $this->getRequest();
		if($request instanceof Zend_Controller_Request_Http) {
			if($expected != strtolower($request->getMethod()))
				throw new Rest_Exception('Request method must be of type ' . strtoupper($expected), Rest_Exception::HTTP_BAD_REQUEST);
		}
	}
	
	/* (non-PHPdoc)
	 * @see Zend_Rest_Controller::indexAction()
	 */
	public function indexAction()
	{
		$this->_checkRequestMethod('get');
		$this->_assignResult($this->getResource()->index($this->_getAllParams()));
	}

	/* (non-PHPdoc)
	 * @see Zend_Rest_Controller::getAction()
	 */
	public function getAction()
	{
		$this->_checkRequestMethod('get');
		$this->_assignResult($this->getResource()->get($this->_getParam('id'), $this->_getAllParams()));
	}

	/* (non-PHPdoc)
	 * @see Zend_Rest_Controller::postAction()
	 */
	public function postAction()
	{
		$this->_checkRequestMethod('post');
		$this->_assignResult($this->getResource()->post($this->getData(), $this->_getAllParams()));
	}

	/* (non-PHPdoc)
	 * @see Zend_Rest_Controller::putAction()
	 */
	public function putAction()
	{
		$this->_checkRequestMethod('put');
		$this->_assignResult($this->getResource()->put($this->getData(), $this->_getParam('id'), $this->_getAllParams()));
	}

	/* (non-PHPdoc)
	 * @see Zend_Rest_Controller::deleteAction()
	 */
	public function deleteAction()
	{
		$this->_checkRequestMethod('delete');
		$this->_assignResult($this->getResource()->delete($this->_getParam("id"), $this->_getAllParams()));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Controller_Action::_getAllParams()
	 */
	protected function _getAllParams()
	{
		$result = parent::_getAllParams();
		if(isset($result['id'])) {
			unset($result['id']);
		}
		return $result;
	}
	
	/**
	 * Assembles a URI for this REST controller with the given
	 * arguments. If none are given, the current parameters
	 * will be used.
	 * @param unknown_type $args
	 */
	public function getUri($args = null)
	{
		$params = ($args === null) ? $this->_getAllParams() : $args;
		$router = $this->getFrontController()->getRouter();	 
		return $router->assemble($params);
	}
}