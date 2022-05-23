<?php
print PHP_EOL . '<!--  BEGIN include mail-message -->' . PHP_EOL;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//use PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//
// This function mails the text passed in to the people specified 
// it requires the person sending it to and a message 
// CONSTRAINTS:
//      $to must not be empty
//      $to must be an email format
//      $cc must be an email format if its not empty
//      $bcc must be an email format if its not empty
//      $from must not be empty
//      $subject must not be empty
//      $message must not be empty
//      $message must have a minium number of characters
//      $message must be a minuim lenght (just count the characters and spaces
//      
//      $from should be cleand of invalid html before being sent here but needs 
//            to allow < and >
//      $message should be cleand of invalid html before being sent here as you 
//            may want to allow html characters
//
// function returns a boolean value
function sendMail($to, $cc, $bcc, $from, $subject, $message, $advisName, $billMessage, $refEmail, $refMessage, $refName) {
    $MIN_MESSAGE_LENGTH = 10;
    
    $blnMail = false;

    $to = filter_var($to, FILTER_SANITIZE_EMAIL);
    $cc = filter_var($cc, FILTER_SANITIZE_EMAIL);
    $bcc = filter_var($bcc, FILTER_SANITIZE_EMAIL);
    $subject = htmlentities($subject,ENT_QUOTES,"UTF-8");
     
    // just checking to make sure the values passed in are reasonable
    if(empty($to)) return false;
    if(!filter_var($to, FILTER_VALIDATE_EMAIL)) return false;
    if($to == "youremail@uvm.edu") return false;
    if($cc!="") if(!filter_var($cc, FILTER_VALIDATE_EMAIL)) return false;
    if($bcc!="") if(!filter_var($bcc, FILTER_VALIDATE_EMAIL)) return false;
    if(empty($from)) return false;
    if(empty($subject)) return false;
    if(empty($message)) return false;
    //if (strlen($message)<$MIN_MESSAGE_LENGTH) return false;
    
    // /* message */
    // $messageTop  = '<html><head><title>' . $subject . '</title></head><body>';
    // $mailMessage = $messageTop . $message;
    // $headers  = "MIME-Version: 1.0\r\n";
    // $headers .= "Content-type: text/html; charset=utf-8\r\n";
    // $headers .= "From: " . $from . "\r\n";
    // if ($cc!="") $headers .= "CC: " . $cc . "\r\n";
    // if ($bcc!="") $headers .= "Bcc: " . $bcc . "\r\n";
    // /* this line actually sends the email */
    // //$blnMail = mail($to, $subject, $mailMessage, $headers);

    // Load Composer's autoloader
    require 'vendor/autoload.php';
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Enable verbose debug output SMTP::DEBUG_SERVER
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.dreamhost.com';                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'noreply@vtsrc.com';                    //SMTP username
        $mail->Password   = 'Laquerre1';                            //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        // MAIL ADVISOR EMAIL /////////////////////////////////////////////////////////////////////////////
        // This stops error sending multiple emails
        $mail->clearAllRecipients();
        $mail->clearAddresses();
        //Set who the message is to be sent from
        $mail->setFrom($from, 'VT State Referee Committee');

        //Set who the message is to be sent to
        $mail->addAddress($to, $advisName);
        if ($cc != "") {
            $mail->addCC($cc);
        }
        if ($bcc != "") {
            $mail->addBCC($bcc);
        }

        //Set the subject line
        $mail->Subject = $subject;

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->isHTML(true);
        $mail->Body = $message;
        $mail->AltBody = 'Referee Advisor Report Submitted Successfully.';

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $blnMail = false;
        } else {
            $blnMail = true;
        }

        // MAIL BILLS EMAIL /////////////////////////////////////////////////////////////////////////////
        // This stops error sending multiple emails
        $mail->clearAllRecipients();
        $mail->clearAddresses();
        //Set who the message is to be sent from
        $mail->setFrom($from, 'VT State Referee Committee');

        //Set who the message is to be sent to
        $mail->addAddress('stretchvt@gmail.com', 'Bill Edwards');
        $mail->addCC('jace.laquerre@gmail.com', 'Jace Laquerre');
        if ($cc != "") {
            $mail->addCC($cc);
        }
        if ($bcc != "") {
            $mail->addBCC($bcc);
        }

        //Set the subject line
        $mail->Subject = 'New Advisor Report Submitted';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->isHTML(true);
        $mail->Body = $billMessage;
        $mail->AltBody = 'New Referee Advisor Report Added.';

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $blnMail = false;
        } else {
            $blnMail = true;
        }

        // MAIL REFEREE EMAIL /////////////////////////////////////////////////////////////////////////////
        // This stops error sending multiple emails
        $mail->clearAllRecipients();
        $mail->clearAddresses();
        //Set who the message is to be sent from
        $mail->setFrom($from, 'VT State Referee Committee');

        //Set an alternative reply-to address
        $mail->addReplyTo($to, $advisName);

        //Set who the message is to be sent to
        $mail->addAddress($refEmail, $refName);
        if ($cc != "") {
            $mail->addCC($cc);
        }
        if ($bcc != "") {
            $mail->addBCC($bcc);
        }

        //Set the subject line
        $mail->Subject = 'New Advisor Report Available';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->isHTML(true);
        $mail->Body = $refMessage;
        $mail->AltBody = 'Advisor Report not able to load for your specific email server, contact sljj@comcast.net to get it.';

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $blnMail = false;
        } else {
            $blnMail = true;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    return $blnMail;
}
print PHP_EOL . '<!--  END include mail-message -->' . PHP_EOL;
?>
