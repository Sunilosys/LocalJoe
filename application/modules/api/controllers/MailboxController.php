<?php
/**
 * Regular controller
 **/
require_once 'Upload/LjUploadHandler.php';
require_once 'Upload/LjS3UploadHandler.php';
require_once 'Mail/Email_reader.php';
class Api_MailboxController extends Zend_Controller_Action
{
     public function indexAction() {
        $this->_helper->layout->disableLayout();
        $email_reader = new Email_reader();


        // this method is run on a cronjob and should process all emails in the inbox
        while (1) {
            // get an email
            $email = $email_reader->get();

            // if there are no emails, jump out
            if (count($email) <= 0) {
                break;
            }

            $attachments = array();
            // check for attachments
            if (isset($email['structure']->parts) && count($email['structure']->parts)) {
                // loop through all attachments

                for ($i = 0; $i < count($email['structure']->parts); $i++) {
                    // set up an empty attachment
                    $attachments[$i] = array(
                        'is_attachment' => FALSE,
                        'filename' => '',
                        'name' => '',
                        'attachment' => ''
                    );

                    // if this attachment has idfparameters, then proceed
                    if ($email['structure']->parts[$i]->ifdparameters) {
                        foreach ($email['structure']->parts[$i]->dparameters as $object) {
                            // if this attachment is a file, mark the attachment and filename
                            if (strtolower($object->attribute) == 'filename') {
                                $attachments[$i]['is_attachment'] = TRUE;
                                $attachments[$i]['filename'] = $object->value;
                            }
                        }
                    }

                    // if this attachment has ifparameters, then proceed as above
                    if ($email['structure']->parts[$i]->ifparameters) {
                        foreach ($email['structure']->parts[$i]->parameters as $object) {
                            if (strtolower($object->attribute) == 'name') {
                                $attachments[$i]['is_attachment'] = TRUE;
                                $attachments[$i]['name'] = $object->value;
                            }
                        }
                    }


                    // if we found a valid attachment for this 'part' of the email, process the attachment
                    if ($attachments[$i]['is_attachment']) {
                        // get the content of the attachment
                        $attachments[$i]['attachment'] = imap_fetchbody($email_reader->conn, $email['index'], $i + 1);

                        // check if this is base64 encoding
                        if ($email['structure']->parts[$i]->encoding == 3) { // 3 = BASE64
                            $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                        }
                        // otherwise, check if this is "quoted-printable" format
                        elseif ($email['structure']->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                            $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                        }
                    }
                }
            }
            // get content from the email that I want to store
            $addr = $email['header']->from[0]->mailbox . "@" . $email['header']->from[0]->host;
            $sender = $email['header']->from[0]->mailbox;
            $text = (!empty($email['header']->subject) ? $email['header']->subject : '');
            $this->sessionObj = new Application_Service_LjSession();
            $userInfoObj = $this->sessionObj->execute_service('Application_Service_GetUserByEmail', $addr, false);
            $userId = null;
            if (isset($userInfoObj)) {

                $userId = $userInfoObj->user_id;
            }

            $upload_handler = new LjS3UploadHandler();
            $currentDate = date("Y-m-d H:i:s");
            // for My Slow Low, check if I found an image attachment
            $found_img = FALSE;
            if (isset($userId)) {
                foreach ($attachments as $a) {
                    if ($a['is_attachment'] == 1) {
                        // get information on the file
                        $finfo = pathinfo($a['filename']);

                        // check if the file is a jpg, png, or gif
                        if (preg_match('/(jpg|gif|png)/i', $finfo['extension'], $n)) {
                            $found_img = TRUE;
                            // process the image (save, resize, crop, etc.)
                            $fname = $a['filename'];
                            $arImageInfo = array(
                                'user_id' => $userId,
                                'image_title' => $fname,
                                'image_file' => $fname,
                                'date_created' => $currentDate
                            );
                            $last_insert_image_id = $this->sessionObj->execute_service('Application_Service_CreateImage', $arImageInfo, false);

                            $arImageTypeInfo = array(
                                'image_id' => $last_insert_image_id,
                                'image_type_id' => 1,
                                'image_size' => 0,
                                'image_file' => $fname,
                                'date_created' => $currentDate
                            );
                            $imageTypeResult = $this->sessionObj->execute_service('Application_Service_CreateImageCopy', $arImageTypeInfo, false);

                            $upload_handler->copyImageFromMailbox($last_insert_image_id, $a['attachment'], $finfo['extension'], $userId);
                            break;
                        }
                    }
                }
            }

            // if there was no image, move the email to the Rejected folder on the server
            if (!$found_img) {
                $email_reader->move($email['index'], 'Rejected');
                continue;
            }

            // move the email to Processed folder on the server
            $email_reader->move($email['index'], 'Processed');


            // don't slam the server
            sleep(1);
        }

        // close the connection to the IMAP server
        $email_reader->close();
        exit;
    }
    
    
}
