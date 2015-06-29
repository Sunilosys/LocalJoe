<?php

class Application_Service_LjSession
{
    public function execute_service($service_name,$input,$tranaction_flag=true)
    {
    	$service_instance = new $service_name;

        if($tranaction_flag)
        {
            
            $this->execute_with_transaction($service_instance,$input);

        }  else {

            $resultSet = $this->execute_with_no_transaction($service_instance, $input);
            return $resultSet;
        }
      
    }

    private function execute_with_transaction($service_instance,$input)
    {
        $db = $this->getDbConnection();

        $db->beginTransaction();

        try {
        
            $service_instance->execute($input);

            $db->commit();

        } catch (Exception $e) {

        	$db->rollBack();

            throw $e;

        }

    }

    private function execute_with_no_transaction($service_instance, $input)
    {
      
        $db = $this->getDbConnection();       
        $resultObj = $service_instance->execute($input);
        return $resultObj;
    }

    private function getDbConnection()
    {       
        if(Zend_Registry::isRegistered('default_adapter'))
        {
            
            $db =  Zend_Registry::get('default_adapter');           
            Zend_Db_Table_Abstract::setDefaultAdapter($db);

        }  else {
            
            if(!Zend_Registry::isRegistered('dbConfig'))
            	throw new FemException ("Config parameters not available in registry");

            $config = Zend_Registry::get('dbConfig');           
            $db = Zend_Db::factory($config->db);            
            Zend_Db_Table_Abstract::setDefaultAdapter($db);
            Zend_Registry::set('default_adapter',$db);
            
            
        }

        return $db;
    }
}

class FemException extends Exception
{

    public function errorMessage()
    {
        $errorMsg = 'Exception on '.$this->getLine().' in '.$this->getFile()." : ".$this->getMessage();
        return $errorMsg;
    }

}

?>