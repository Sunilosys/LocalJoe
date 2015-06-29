<?php
/**
 * A generic Zend View base class that holds it's content in
 * an array.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
abstract class Rest_View_Data implements Zend_View_Interface
{
	protected $_data;
	
	public function __construct()
	{
		$this->_data = array();
	}
	
	public function getEngine()
	{
		return $this;
	}
	
	public function setScriptPath($path)
	{
		
	}
	
	public function getScriptPaths()
	{
		return array();
	}
	
	public function setBasePath($path, $classPrefix = 'Zend_View')
	{
		
	}
	
	public function addBasePath($path, $classPrefix = 'Zend_View')
	{
		
	}
	
	public function __get($key)
	{
		return $this->_data[$key];
	}
	
	public function __set($key, $val)
	{
		$this->_data[$key] = $val;
	}
	
	public function __isset($key)
	{
		return isset($this->_data[$key]);
	}
	
	public function __unset($key)
	{
		unset($this->_data[$key]);
	}
	
	public function assign($spec, $value = null)
	{
		if(is_callable(array($spec, 'toArray'))) {
			$this->assign($spec->toArray());
		} elseif(is_array($spec)) {
			$this->_data = array_merge($this->_data, $spec);
		} elseif(is_string($spec))
		{
			$this->_data[$spec] = $value;
		}
	}
	
	public function clearVars()
	{
		$this->_data = array();
	}
}