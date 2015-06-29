<?php
/**
 * Class that represents a single HTTP Accept header token.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_Accept_Token
{
	const WILDCARD = '*';

	/**
	 * Function to sort tokens by quality, starting with the highest quality.
	 * If the qualities are the same, sort by precedence.
	 * @param Rest_Accept_Token $first The first token to compare
	 * @param Rest_Accept_Token $second The second token to compare
	 */
	public static function sortByQuality($first, $second)
	{
		$result = strcmp(number_format($second->getQuality(), 2), number_format($first->getQuality(), 2));
		if($result == 0) {
			$result = self::sortByPrecedence($first, $second);
		}
		return $result;
	}
	
	/**
	 * Function to sort Tokens by precedence, starting with the highest precedence.
	 * @param Rest_Accept_Token $first The first token to compare
	 * @param Rest_Accept_Token $second The second token to compare
	 */
	public static function sortByPrecedence($first, $second)
	{
		if($first->getPrecedence() == $second->getPrecedence()) {
			return 0;
		} 
		return ($first->getPrecedence() > $second->getPrecedence()) ? -1 : 1;
	}
	
	protected $_quality = 1.0;
	protected $_extensions = array();
	protected $_type = self::WILDCARD;
	protected $_subtype = self::WILDCARD;
	
	/**
	 * Create a new accept header token.
	 * @param string $token The token to parse
	 */
	public function __construct($token)
	{
		$this->_parse($token);
	}
	
	/**
	 * Parses a token string into instance variables
	 * @param string $token The single accept header token to use
	 */
	protected function _parse($token)
	{
		$token = strtolower(str_replace(' ', '', $token));
		$tokenList = explode(";", $token);
		
		$typestring = array_shift($tokenList);
		$typearray = explode('/', $typestring);
		if(count($typearray) != 2) {
			throw new Rest_Exception($typestring . ' is not a valid accept header token', Rest_Exception::HTTP_BAD_REQUEST);
		}
		list($this->_type, $this->_subtype) = $typearray;
		if($this->_type == self::WILDCARD && $this->_subtype != self::WILDCARD) {
			throw new Rest_Exception($this->_type . '/' . $this->_subtype . 
			 ' is not a valid miime type', Rest_Exception::HTTP_BAD_REQUEST);
		}
		foreach($tokenList as $current)
		{
			$vals = explode('=', $current);
			if(count($vals) != 2) {
				throw new Rest_Exception('Bad accept header extension parameters ' . $current, Rest_Exception::HTTP_BAD_REQUEST);
			}
			list($key, $value) = $vals;
			if($key == 'q') {
				$this->_quality = floatval($value);
			} else {
				$this->_extensions[$key] = $value;
			}
		}
	}
	
	/**
	 * Returns the precedence (specificy) of this token. Default precedence
	 * is 0 and will be incremented by 1 if
	 * - The main type is not *
	 * - The subtype is not *
	 * - For every extension parameter
	 * @return integer
	 */
	public function getPrecedence()
	{
		$precedence = 0;
		if($this->_type != self::WILDCARD)
		{
			$precedence++;
			if($this->_subtype != self::WILDCARD) $precedence++;
		}
		$precedence += count($this->_extensions);
		return $precedence;
	}
	
	public function isWildcard()
	{
		return $this->getType() == self::WILDCARD && $this->getSubType() == self::WILDCARD;
	}
	
	/**
	 * Returns whether this token accepts a given mime type.
	 * @param string $mimeType The mime type to check
	 */
	public function accepts($typeToken)
	{
		if($typeToken instanceof Rest_Accept_Token) {
			if($this->isWildcard() || $typeToken->isWildcard())
				return true;
			if($this->_type == $typeToken->getType()) {
				if($this->getSubType() == self::WILDCARD || $this->getSubType() == $typeToken->getSubType())
				{
					foreach($this->getExtensions() as $name => $value) {
						if($typeToken->getExtensionParam($name) != $value)
							return false;
					}
					return true;
				}
			}
		} else {
			return $this->accepts(new Rest_Accept_Token($typeToken));
		}
		return false;	
	}
	
	/**
	 * Returns all extensions in this token.
	 * @return array
	 */
	public function getExtensions()
	{
		return $this->_extensions;
	}
		
	/**
	 * Returns an extension parameter given in this
	 * token or false.
	 * @param string $name Name of the parameter
	 * @return string The parameter or false
	 */
	public function getExtensionParam($name)
	{
		if(!isset($this->_extensions[$name])) {
			return false;
		}
		return $this->_extensions[$name];
	}
	
	public function getMimeType()
	{
		return $this->getType() . '/' . $this->getSubType();
	}
	
	/**
	 * Returns the quality set for this token.
	 * HTTP quality is between 0.0 and 1.0, default is 1.0.
	 * @return float
	 */
	public function getQuality()
	{
		return floatval($this->_quality);
	}
	
	/**
	 * Returns the main type.
	 * @return string
	 */
	public function getType()
	{
		return $this->_type;
	}
	
	/**
	 * Returns the accept tokens sub type
	 * @return string
	 */
	public function getSubType()
	{
		return $this->_subtype;
	}
	
	/**
	 * Return a string representation of this token
	 * @return string
	 */
	public function __toString()
	{
		$paramstr = ($this->_quality != 1.0) ? ';q=' . $this->_quality : '';
		foreach($this->_extensions as $key => $val) {
			$paramstr .= ';' . $key . '=' . $val;
		}
		return $this->_type . '/' . $this->_subtype . $paramstr;
	}
}