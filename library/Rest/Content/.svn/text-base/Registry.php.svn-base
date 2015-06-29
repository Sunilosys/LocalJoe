<?php
class Rest_Content_Registry
{
	protected $_views;
	protected $_deserializers;
	protected $_acceptParser;
	protected $_viewFormats;
	
	/**
	 * Add a new view to this handler
	 * @param string $content_type The type of the content that view produces
	 * @param Zend_View_Interface $view The view instance
	 * @param string $format A format shortname e.g. html for text/html
	 */
	public function addView($contentType, Zend_View_Interface $view, $format = null)
	{
		// TODO probably remove this and leave it to the configuration
		if($contentType == 'text/html' && $view instanceof Zend_View && $view->doctype()->isXhtml()) {
			$contentType = 'application/xhtml+xml';
		}

		$this->_views[$contentType] = $view;
		$this->_acceptParser = new Rest_Accept_Header($this->getViewTypes());
		if($format !== null) {
			$this->_viewFormats[$format] = $contentType;
		}
	}
	
	/**
	 * Return a view for a given content type
	 * @param string $contentType The content type requeste
	 * @return Zend_View_Interface
	 */
	public function getView($contentType)
	{
		if(isset($this->_views[$contentType])) {
			return $this->_views[$contentType];
		}
		return null;
	}
	
	/**
	 * Add a deserializer to this handler
	 * @param string $contentType The content type this deserializer can parse
	 * @param Rest_Deserialize_Interface $deserializer The deserializer instance
	 */
	public function addDeserializer($contentType, Rest_Deserialize_Interface $deserializer)
	{
		$this->_deserializers[$contentType] = $deserializer;
	}
	
	/**
	 * Deserialize a given string in the given format.
	 * @param string $contentType The content type to use
	 * @param string $data The data to deserialize
	 * @return array|null
	 */
	public function deserialize($contentType, $data)
	{
		// TODO allow extensions for content types
		$token = new Rest_Accept_Token($contentType);
		$contentType = $token->getMimeType();
		if(!isset($this->_deserializers[$contentType])) {
			throw new Rest_Exception('Parsing of ' . $contentType . ' is not supported', Rest_Exception::HTTP_BAD_REQUEST);
		}
		return $this->_deserializers[$contentType]->deserialize($data);		
	}
	
	/**
	 * Returns the mime types of the registered view
	 * @return array
	 */
	public function getViewTypes()
	{
		return array_keys($this->_views);
	}
	
	/**
	 * Returns the content types of all registered deserializers
	 * @return array
	 */
	public function getDeserializerTypes()
	{
		return array_keys($this->_deserializers);
	}

	/**
	 * Returns a mapping of format shortnames (e.g. extensions like
	 * html, pdf etc.) to content types.
	 * @return array
	 */
	public function getViewFormats()
	{
		return $this->_viewFormats;
	}
	
	/**
	 * Returns the content type of a registered view, that
	 * matches a requests accept header best.
	 * @param Zend_Controller_Request_Http $request
	 * @throws Rest_Exception with a 406 (Not Acceptable) error code
	 * if no matching content type has been found. 
	 */
	public function acceptContentType($accept)
	{
		if($accept instanceof Zend_Controller_Request_Http) {
			$accept = ($accept->getHeader("Accept") !== null) ? $accept->getHeader("Accept") : '*/*';
		}
		$header = new Rest_Accept_Header($this->getViewTypes());
		$contentType = $header->acceptBest($accept);
		if($contentType !== false) {
			return $contentType;
		} else {
			throw new Rest_Exception('Cannot send any of ' . $accept , Rest_Exception::HTTP_NOT_ACCEPTABLE);
		}
	}
}