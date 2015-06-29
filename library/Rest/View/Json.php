<?php
/**
 * A Zend view for rendering JSON.
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_View_Json extends Rest_View_Data
{	
	public function render($name)
	{
		return Zend_Json::encode($this->_data);
	}
}