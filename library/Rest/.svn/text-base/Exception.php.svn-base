<?php
/**
 * Class for REST Exceptions, including constants and descriptions for HTTP error codes.
 * @author daff
 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
 */
class Rest_Exception extends Exception
{
	/**
	 * The request could not be understood by the server due to malformed syntax.
	 * The client SHOULD NOT repeat the request without modifications.
	 * @var integer
	 */
	const HTTP_BAD_REQUEST = 400;

	/**
	 * The request requires user authentication. The response MUST include a WWW-Authenticate header field 
	 * (section 14.47) containing a challenge applicable to the requested resource.
	 * The client MAY repeat the request with a suitable Authorization header field (section 14.8). 
	 * If the request already included Authorization credentials, then the 401 response indicates 
	 * that authorization has been refused for those credentials. 
	 * If the 401 response contains the same challenge as the prior response, 
	 * and the user agent has already attempted authentication at least once, 
	 * then the user SHOULD be presented the entity that was given in the response, 
	 * since that entity might include relevant diagnostic information. 
	 * HTTP access authentication is explained in "HTTP Authentication: Basic and Digest Access Authentication" [43].
	 * @var integer
	 */
	const HTTP_UNAUTHORIZED = 401;

	/**
	 * The server understood the request, but is refusing to fulfill it.
	 * Authorization will not help and the request SHOULD NOT be repeated.
	 * If the request method was not HEAD and the server wishes to make public why the request has not been fulfilled, 
	 * it SHOULD describe the reason for the refusal in the entity.
	 * If the server does not wish to make this information available to the client,
	 * the status code 404 (Not Found) can be used instead. 
	 * @var integer
	 */
	const HTTP_FORBIDDEN = 403;
	
	/**
	 * The server has not found anything matching the Request-URI.
	 * No indication is given of whether the condition is temporary or permanent.
	 * The 410 (Gone) status code SHOULD be used if the server knows,
	 * through some internally configurable mechanism,
	 * that an old resource is permanently unavailable and has no forwarding address.
	 * This status code is commonly used when the server does not wish to reveal exactly
	 * why the request has been refused, or when no other response is applicable. 
	 * @var integer
	 */
	const HTTP_NOT_FOUND = 404;	
	
	/**
	 * The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.
	 * The response MUST include an Allow header containing a list of valid methods for the requested resource. 
	 * @var integer
	 */
	const HTTP_METHOD_NOT_ALLOWED = 405;
	
	/**
	 * The resource identified by the request is only capable of generating response entities which have content 
	 * characteristics not acceptable according to the accept headers sent in the request.
	 * Unless it was a HEAD request, the response SHOULD include an entity containing a list of 
	 * available entity characteristics and location(s) from which the user or user agent can choose the one most appropriate.
	 * The entity format is specified by the media type given in the Content-Type header field.
	 * Depending upon the format and the capabilities of the user agent,
	 * selection of the most appropriate choice MAY be performed automatically.
	 * However, this specification does not define any standard for such automatic selection. 
	 * @var integer
	 */
	const HTTP_NOT_ACCEPTABLE = 406;
	
	/** 
	 * This code is similar to 401 (Unauthorized), but indicates that the client must first authenticate itself with the proxy.
	 * The proxy MUST return a Proxy-Authenticate header field (section 14.33) containing a challenge applicable
	 * to the proxy for the requested resource. The client MAY repeat the request with a suitable Proxy-Authorization header
	 * field (section 14.34). HTTP access authentication is explained in "HTTP Authentication: Basic and Digest Access Authentication" [43]. 
	 * @var integer
	 */
	const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
	
	/**
	 * The client did not produce a request within the time that the server was prepared to wait.
	 * The client MAY repeat the request without modifications at any later time. 
	 * @var integer
	 */
	const HTTP_REQUEST_TIMEOUT = 408;
	
	/**
	 * The request could not be completed due to a conflict with the current state of the resource.
	 * This code is only allowed in situations where it is expected that the user might be able to resolve the conflict and resubmit the request.
	 * The response body SHOULD include enough information for the user to recognize the source of the conflict.
	 * Ideally, the response entity would include enough information for the user or user agent to fix the problem;
	 * however, that might not be possible and is not required.
	 * Conflicts are most likely to occur in response to a PUT request.
	 * For example, if versioning were being used and the entity being PUT included changes 
	 * to a resource which conflict with those made by an earlier (third-party) request, 
	 * the server might use the 409 response to indicate that it can't complete the request.
	 * In this case, the response entity would likely contain a list of the differences between the two versions in a format defined 
	 * by the response Content-Type. 
	 * @var integer
	 */
	const HTTP_CONFLICT = 409;
	
	const HTTP_INTERNAL_SERVER_ERROR = 500;
	
	protected $_resource;
	protected $_params;

	/**
	 * Create a new REST exception.
	 * @param string $message The exception message
	 * @param integer $code The error code, usually one of the HTTP errors, defaults to
	 * HTTP_INTERNAL_SERVER_ERROR (500)
	 * @param array $params Optional parameters
	 * @param Rest_Resource $resource
	 */
	public function __construct($message, $code = self::HTTP_INTERNAL_SERVER_ERROR, $params = null, Rest_Resource $resource = null)
	{
		parent::__construct($message, $code);
		$this->_resource = $resource;
		$this->_params = $params;
	}

	/**
	 * Returns the resource that caused the exception or null if not set.
	 * @return Rest_Resource | null
	 */
	public function getResource()
	{
		return $this->_resource;
	}

	public function getParams()
	{
		return $this->_params;
	}
}