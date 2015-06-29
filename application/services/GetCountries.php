<?php

class Application_Service_GetCountries
{
	public function execute($input)
	{
		try {
			
			$countryObj = new Application_Model_LjCountry();
			if(isset($input) && $input!='')
			$countryObj->where_clause="country_id='".$input."'";
			$countries = $countryObj->select();
			return $countries;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

