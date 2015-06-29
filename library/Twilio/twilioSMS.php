<?php

/* Send an SMS using Twilio. You can run this file 3 different ways:
 *
 * - Save it as sendnotifications.php and at the command line, run 
 *        php sendnotifications.php
 *
 * - Upload it to a web host and load mywebhost.com/sendnotifications.php 
 *   in a web browser.
 * - Download a local server like WAMP, MAMP or XAMPP. Point the web root 
 *   directory to the folder containing this file, and load 
 *   localhost:8888/sendnotifications.php in a web browser.
 */

// Step 1: Download the Twilio-PHP library from twilio.com/docs/libraries, 
// and move it into the folder containing this file.
require "Services/Twilio.php";

class twilioSMS {

    function __construct($options = null) {
        // Step 2: set our AccountSid and AuthToken from www.twilio.com/user/account

        $twilioConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'twilio');
        if (isset($twilioConfig)) {
            $this->AccountSid = $twilioConfig->twilio_account_id;
            $this->AuthToken = $twilioConfig->twilio_auth_token;
            $this->CountryCode = $twilioConfig->twilio_country_code;
        }
    }

    public function SendSMS($fromPhone, $toName, $toPhone, $body, $type) {

      
        if (isset($this->AccountSid)) {
            // Step 3: instantiate a new Twilio Rest Client
            $client = new Services_Twilio($this->AccountSid, $this->AuthToken);

            $body = str_replace('<br/>', ' ', $body);
            $body = str_replace('<p>', ' ', $body);
            $body = str_replace('</p>', ' ', $body);
           
            $twilioNo = null;
            $twilioPhoneId = null;
            $fromPhone = str_replace(' ', '', $fromPhone);
            $fromPhone = str_replace('-', '', $fromPhone);
            $fromPhone =  $this->CountryCode . $fromPhone;
            
            $toPhone = str_replace(' ', '', $toPhone);
            $toPhone = str_replace('-', '', $toPhone);
            $toPhone =  $this->CountryCode . $toPhone;
            // Step 4: make an array of people we know, to send them a message. 
            // Feel free to change/add your own phone number and name here.

            if ($type == "Send SMS") {
                if (isset($toPhone)) {
                   

                    $this->sessionObj = new Application_Service_LjSession();

                    $input = array(
                        'from_phone' => $fromPhone,
                        'to_phone' => $toPhone,
                    );
                    $twilioAvailableNos = $this->sessionObj->execute_service('Application_Service_GetAvailableTwilioNos', $input, false);
                    if (isset($twilioAvailableNos) && sizeof($twilioAvailableNos) > 0) {
                        $twilioNo = $twilioAvailableNos[0]['twilio_phone_no'];
                        $twilioPhoneId = $twilioAvailableNos[0]['twilio_phone_id'];
                    }
                }
                
            } else if ($type == "Send Response") {
                $twilioNo = $toPhone;

                $this->sessionObj = new Application_Service_LjSession();

                $input = array(
                    'from_phone' => $fromPhone,
                    'to_phone' => $toPhone,
                );
                $senderInfo = $this->sessionObj->execute_service('Application_Service_GetSenderInfo', $input, false);
                if (isset($senderInfo) && sizeof($senderInfo) > 0) {
                    $toPhone = $senderInfo[0]['sender_phone'];
                    $twilioPhoneId = $senderInfo[0]['twilio_phone_id'];
                    
                }
            }
            // Step 5: Loop over all our friends. $number is a phone number above, and 
            // $name is the name next to it
            if (isset($twilioNo)) {
                if (isset($toPhone)) {

                    $sms = $client->account->sms_messages->create(
                            // Step 6: Change the 'From' number below to be a valid Twilio number 
                            // that you've purchased, or the (deprecated) Sandbox number
                            $twilioNo,
                            // the number we are sending to - Any phone number
                            $toPhone,
                            // the sms body
                            $body
                    );



                    $input = array(
                        'from_phone' => $fromPhone,
                        'to_phone' => $toPhone,
                        'sms' => $body,
                        'twilio_phone_id' => $twilioPhoneId,
                        'is_active' => 1,
                        'date_sent' => date("Y-m-d H:i:s")
                    );
                    $result = $this->sessionObj->execute_service('Application_Service_SaveSmsUsage', $input, false);
                    // Display a confirmation message on the screen
                    return "success";
                }
            }
            return "No Phone Line Available";
        }
    }

}

