<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetSenderInfo
 *
 * @author ssalunkhe
 */
class Application_Service_GetSenderInfo {
    
 public function execute($input) {
        try {

            $senderInfo = new Application_Model_LjSmsUsage();

           

            $senderInfo->sql_stmt = "select distinct su.from_phone,su.twilio_phone_id from sms_usage su inner join twilio_phone_no tp on tp.twilio_phone_id =  ".
                                    " su.twilio_phone_id where su.is_active=1 and tp.twilio_phone_no ='".$input['to_phone'] ."' and su.to_phone='". $input['from_phone'] ."'" ;
            
            $sender = $senderInfo->query();   
             $senderArray = null;
            if (isset($sender)) {

                foreach ($sender as $key => $value) {
                    $senderArray[] = array(
                        
                        "sender_phone" => $value['from_phone'],
                        "twilio_phone_id" => $value['twilio_phone_id'],
                         
                    );
                }
            }

            return $senderArray;
          
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}
