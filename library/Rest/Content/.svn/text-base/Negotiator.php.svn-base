<?php
class Rest_Content_Negotiator
{
	/**
	 * @var Zend_Controller_Request_Http
	 */
	protected $_httpRequest;
	/**
	 * @var Zend_Controller_Response_Http
	 */
	protected $_httpResponse;
	/**
	 * @var Rest_Content_Registry
	 */
	protected $_registry;
	/**
	 * An overwrite content type. Will be used before accept
	 * headers are being parsed.
	 * @var string
	 */
	protected $_contentType;
	
	/**
	 * Create a new content negotiator instance with given HTTP request, response
	 * and REST handler instance
	 * @param Zend_Controller_Request_Http $request
	 * @param Zend_Controller_Response_Http $response
	 * @param Rest_Content_Registry $registry
	 */
	public function __construct(Zend_Controller_Request_Http $request, Zend_Controller_Response_Http $response,
		Rest_Content_Registry $registry)
	{
		$this->_httpRequest = $request;
		$this->_httpResponse = $response;
		$this->_registry = $registry;
		$this->_format = null;
	}
	
	/**
	 * Set the response and view format based on the registry format to
	 * content type mapping. This will ignore any accept headers
	 * that might be present.
	 * @param string $format The format to use
	 */
	public function setFormat($format)
	{
		$formats = $this->_registry->getViewFormats();
		if(isset($formats[$format])) {
			$this->setContentType($formats[$format]);
		} else {
			throw new Rest_Exception('Format ' . $format . ' is not supported.', Rest_Exception::HTTP_NOT_ACCEPTABLE);
		}
	}
	
	/**
	 * Overwrite the content type used. Will skip accept header parsing.
	 * @param string $contentType The content type to use
	 */
	public function setContentType($contentType)
	{
		$this->_contentType = $contentType;
	}
	
	/**
	 * Returns the best matching view based on the requests accept headers and
	 * the views registered and sets the response content type accordingly.
	 * @return Zend_View_Interface
	 * @throws Rest_Exception with a 406 (Not Acceptable) error code
	 * if no matching content type has been found. 
	 */
	public function getView()
	{
		if($this->_contentType !== null) {
			$contentType = $this->_contentType;
		} else {
			$contentType = $this->getRegistry()->acceptContentType($this->getRequest());
		}
		$this->getResponse()->setHeader('Content-Type', $contentType, true);
		return $this->getRegistry()->getView($contentType);
	}
	
	/**
	 * @return Zend_Controller_Response_Http
	 */
	public function getResponse()
	{
		return $this->_httpResponse;
	}

	/**
	 * @return Zend_Controller_Request_Http
	 */
	public function getRequest()
	{
		return $this->_httpRequest;
	}
	
	/**
	 * @return Rest_Content_Registry
	 */
	public function getRegistry()
	{
		return $this->_registry;
	}
	
	/**
	 * Returns the data deserialized from the request body.
	 * @return array | null The deserialized data as an array or null
	 * if nothing can be deserialized.
	 * @throws Rest_Exception on deserialization errors
	 */
	public function getData()
	{
		$dataType = $this->getRequest()->getHeader('Content-Type');
		if($dataType !== null) {
			return $this->getRegistry()->deserialize($dataType, $this->getRequest());
		}
		return null;
	}
}