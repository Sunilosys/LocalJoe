<?php
/**
 * Class for parsing HTTP request headers.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_Accept_Header
{
	protected $_availableTypes;
	
	/**
	 * Create a new accept header parser with a given list of available types.
	 * @param array|string $types A list of available mime types
	 */
	public function __construct($types = array())
	{
		if(!is_array($types)) {
			$types = (array)$types;
		}
		$this->_availableTypes = $types;
	}
	
	/**
	 * Returns the availabel Mime types.
	 * @return array A list of mime types given to this instance
	 */
	public function getMimeTypes()
	{
		return $this->_availableTypes;
	}
	
	/**
	 * Return the best matching type or false if none found.
	 * @param string $header The request header
	 * @return string|false The best matching Mime type or false if none matches
	 */
	public function acceptBest($header)
	{
		$result = $this->accept($header);
		if(count($result) === 0) {
			return false;
		}
		return $result[0];
	}
	
	/**
	 * Returns a list of accepted types based on the given accept header and
	 * the available types, sorted by quality and precedence.
	 * @param string $header The request header
	 */
	public function accept($header)
	{
		if($header instanceof Zend_Controller_Request_Http) {
			$header = $header->getRawBody();
		}
		$tokens = $this->parseHeader($header);
		$accepted = $this->_getAcceptedTokens($tokens);
		$wildcardsOnly = true;
		foreach($accepted as $type => $token) {
			if(!$token->isWildcard()) {
				$wildcardsOnly = false;
			}
		}
		if($wildcardsOnly && isset($accepted['text/html'])) {
			return array('text/html');
		}
		return array_keys($accepted);
	}
	
	/**
	 * Find all tokens that match one of availableTypes sorted by accept quality, starting with the highest.
	 * @param array $tokens The list of tokens, usually ordered by precedence
	 */
	protected function _getAcceptedTokens($tokens)
	{
		$result = array();
		foreach($this->_availableTypes as $type) {
			foreach($tokens as $token) {
				if($token->accepts($type)) {
					$result[$type] = $token;
					// Only adds the token with highest precedence
					break;
				}
			}
		}
		uasort($result, array('Rest_Accept_Token', 'sortByQuality'));
		return $result;
	}
	
	/**
	 * Parses a given accept header into a list of accept tokens sorted by precedence,
	 * starting with the highest.
	 * @param string $header The clean accept header
	 */
	public function parseHeader($header)
	{
		$result = array();
		$header = strtolower(str_replace(' ', '', $header));
		$tokenStrings = explode(',', $header);
		foreach($tokenStrings as $tokenString) {
			$token = new Rest_Accept_Token($tokenString);
			$result[] = $token;
		}
		usort($result, array('Rest_Accept_Token', 'sortByPrecedence'));
		return $result;
	}
}