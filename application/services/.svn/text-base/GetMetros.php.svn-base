<?php

class Application_Service_GetMetros
{
	public function execute($input)
	{
		try {
			
			$metroObj = new Application_Model_LjCity();
			if(isset($input) && $input!='')
			$metroObj->where_clause="region_id='".$input."'" ;
			$metros = $metroObj->select();
			return $metros;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

