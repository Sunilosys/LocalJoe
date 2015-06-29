<?php
/**
 * Deserializer used to deserialize JSON strings.
 * Data parameter passed can be a Zend_Controller_Request_Http
 * object or a plain string.
 * 
 * @author David Luecke (daff@neyeon.de)
 *
 */
class Rest_Deserialize_Json implements Rest_Deserialize_Interface
{
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
		return Zend_Json_Decoder::decode($body);
	}
}