<?php

class Application_Service_GetStates
{
	public function execute($input)
	{
		try {
			
			$stateObj = new Application_Model_LjState();
			if(isset($input) && $input!='')
			$stateObj->where_clause="country_id='".$input."'";
			$states = $stateObj->select();
			return $states;
			
		} catch (Exception $e) {
			
			throw $e;
		}
	}
}			

