<?php
/**
 * Class that deserializes simple XML strings into a PHP array.
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_Deserialize_Xml implements Rest_Deserialize_Interface
{
	protected $_attributeIndicator;
	
	/**
	 * Create a new XML deserializer with an attribute indicator.
	 * The attribute indicator will be used as a prefix for attributes.
	 * <element attr="foo" /> will then translate into
	 * array('element' => array('@attr' => 'foo')).
	 * @param string $attrindicator Default is @
	 */
	public function __construct($attrindicator = '@')
	{
		$this->_attributeIndicator = $attrindicator;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Rest_Deserialize::deserialize()
	 */
	public function deserialize($data)
	{
		$body = $data;
		if($data instanceof Zend_Controller_Request_Http) {
			$body = $data->getRawBody();
		}
		$xml = new SimpleXMLElement($body);
		$result = array();
		$this->_traverse($xml, $result);
		return $result;
	}
	
	/**
	 * Traverse the xml tree
	 * @param SimpleXMLElement $xml
	 * @param array $stack The reference to the current array
	 */
	protected function _traverse(SimpleXMLElement $xml, &$stack)
	{
		$result = array();
		$value = (string)$xml;
		if(count($xml->attributes()) === 0 && count($xml->children()) === 0) {
			$result = $value;
		} else {
			$value != '' && $result[] = $value;
			foreach($xml->attributes() as $name => $val) {
				$result[$this->_attributeIndicator . $name] = (string)$val;
			}
			foreach($xml->children() as $child) {
				$this->_traverse($child, $result);
			}
		}
		if(isset($stack[$xml->getName()])) {
			$stack[$xml->getName()] = array($stack[$xml->getName()], $result);
		} else {
			$stack[$xml->getName()] = $result;
		}
	}
}