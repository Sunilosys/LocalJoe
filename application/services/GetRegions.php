<?php

class Application_Service_GetRegions
{
	public function execute($input)
	{
		try {
			
			$regionObj = new Application_Model_LjCity();
			if(isset($input) && $input!='')
			$regionObj->where_clause="region_id='".$input."'" ;
			$regions = $regionObj->select();
			return $regions;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

