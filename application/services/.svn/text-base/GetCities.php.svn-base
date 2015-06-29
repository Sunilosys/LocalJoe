<?php

class Application_Service_GetCities
{
	public function execute($input)
	{
		try {
			
			$cityObj = new Application_Model_LjCity();
//			if(isset($input) && $input!='')
//			$cityObj->where_clause="state_id='".$input."' || " . "region_id='".$input."'" ;
			$cities = $cityObj->select();
			return $cities;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

