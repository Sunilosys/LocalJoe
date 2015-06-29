<?php
/**
 * A Zend view rendering simple XML output.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_View_Xml extends Rest_View_Data
{
	/**
	 * The main function for converting to an XML document.
	 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
	 *
	 * @param array $data
	 * @param string $rootNodeName - what you want the root node to be - defaultsto data.
	 * @param SimpleXMLElement $xml - should only be used recursively
	 * @return string XML
	 * @see http://snipplr.com/view.php?codeview&id=3491
	 */
	protected function _toXml($data, $rootNodeName = 'data', $xml=null)
	{
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}
		
		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}
		
		foreach($data as $key => $value)
		{
			if (is_numeric($key))
			{
				$key = "unknownNode_". (string) $key;
			}
			
			$key = preg_replace('/[^a-z]/i', '', $key);
			
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				$this->_toXml($value, $rootNodeName, $node);
			}
			else 
			{
				$value = htmlentities($value);
				$xml->addChild($key,$value);
			}
			
		}
		return $xml->asXML();
	}
		
	public function render($name)
	{
		return $this->_toXml($this->_data);
	}
}