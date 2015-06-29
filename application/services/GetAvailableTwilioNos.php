<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetAvailableTwilioNos
 *
 * @author ssalunkhe
 */
class Application_Service_GetAvailableTwilioNos {
    
 public function execute($input) {
        try {

            $twilioPhoneNo = new Application_Model_LjTwilioPhoneNo();

           

            $twilioPhoneNo->sql_stmt = "select tp.twilio_phone_id,tp.twilio_phone_no from twilio_phone_no tp where tp.twilio_phone_id not in ".
                                       "(select su.twilio_phone_id from sms_usage su where su.is_active=1 and su.to_phone !='". $input['to_phone']."' and  su.from_phone ='". $input['from_phone']."') ";

            $twilioNos = $twilioPhoneNo->query();   
             $twilioNoArray = null;
            if (isset($twilioNos)) {

                foreach ($twilioNos as $key => $value) {
                    $twilioNoArray[] = array(
                        
                        "twilio_phone_id" => $value['twilio_phone_id'],
                        "twilio_phone_no" => $value['twilio_phone_no'],
                         
                    );
                }
            }

            return $twilioNoArray;
          
        } 
        catch (Exception $e) {

            throw $e;
        }
 }
}
