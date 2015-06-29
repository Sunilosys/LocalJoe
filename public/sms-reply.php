<?php
require_once '../library/Twilio/twilioSMS.php';
$dbConfig = parse_ini_file('../application/configs/config.ini', 'production');
$connection = null;
$twilioConfig = parse_ini_file('../application/configs/config.ini', 'twilio');
$AccountSid = null;
$AuthToken = null;
if (isset($twilioConfig)) {
    $AccountSid = "ACd913df1bfe6c1224f6b1f8dc0cb61b6c";
    $AuthToken = "d9a4410e668aed3c4e603a3a2f47278d";
}
if (isset($AccountSid)) {
    // Step 3: instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);

   
    $twilioNo = null;
    $twilioPhoneId = null;
    // Step 4: make an array of people we know, to send them a message. 
    // Feel free to change/add your own phone number and name here.


    $twilioNo = $_REQUEST['To'];
    $fromPhone = $_REQUEST['From'];
    $message = $_REQUEST['Body'];
    $toPhone = null;
    $input = array(
        'from_phone' => $fromPhone,
        'twilio_phone_no' => $twilioNo,
    );

    if (isset($dbConfig)) {
        try {
            $connection = mysql_connect($dbConfig['production']['db.params.host'], $dbConfig['production']['db.params.username'], $dbConfig['production']['db.params.password']) or die(mysql_error());
            mysql_select_db($dbConfig['production']['db.params.dbname']) or die(mysql_error());
           
            
            $sqlQuerySenderInfo = "select  distinct su.from_phone,su.twilio_phone_id from sms_usage su inner join twilio_phone_no tp on tp.twilio_phone_id =  " .
                    " su.twilio_phone_id where su.is_active=1 and tp.twilio_phone_no ='" . $input['twilio_phone_no'] . "' and su.to_phone='" . $input['from_phone'] . "' order by date_sent desc LIMIT 0,1";
            $result = mysql_query($sqlQuerySenderInfo)
                    or die(mysql_error());
            $noOfRecords = mysql_num_rows($result);
            if ($result && isset($noOfRecords) && $noOfRecords > 0) {
                while ($row = mysql_fetch_assoc($result)) {

                    $toPhone = $row['from_phone'];
                    $twilioPhoneId = $row['twilio_phone_id'];
                    
                   
                }
            }
        
            if (isset($twilioNo)) {
                if (isset($toPhone)) {

                    $sms = $client->account->sms_messages->create(
                            // Step 6: Change the 'From' number below to be a valid Twilio number 
                            // that you've purchased, or the (deprecated) Sandbox number
                            $twilioNo,
                            // the number we are sending to - Any phone number
                            $toPhone,
                            // the sms body
                            $message
                    );



                    $input = array(
                        'from_phone' => $fromPhone,
                        'to_phone' => $toPhone,
                        'sms' => $message,
                        'twilio_phone_id' => $twilioPhoneId,
                        'is_active' => 1,
                        'date_sent' => date("Y-m-d H:i:s")
                    );
                    $insert = "INSERT INTO sms_usage (from_phone, to_phone,sms,twilio_phone_id,is_active,date_sent)

 			VALUES ('" . $input['from_phone'] . "', '" . $input['to_phone'] . "','" . $input['sms'] . "','" . $input['twilio_phone_id'] . "','" . $input['is_active'] . "','" . $input['date_sent'] . "')";
                    $result = mysql_query($insert)
                            or die(mysql_error());
                }
            }
        } catch (Exception $ex) {
            mysql_close($connection);
        }
    }
}
?>
