<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class PHPMailerService {

    /**
     * Create a new class instance.
     */
    public function __construct() {
        //
    }

    public static function sendEmail($to, $subject, $body, $from = null) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {

            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com'; //smtp.gmail.com if its gmail | smtp.hostinger.com
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //tls if its gmail
            $mail->Port = 465; // 587 if its gmail | 465 if hostinger
            $mail->Username = 'admin@plcode.in';
            $mail->Password = '#Parallel@Code22';
            $mail->Subject = $subject;
            $mail->setFrom('admin@plcode.in', 'Parallel Code');
            $mail->isHTML(true);
            $mail->addAddress($to); // Recipient email            
            $mail->Body = $body;

            //$mail->addAddress('venkateshkmca@gmail.com');
            //$mail->addAddress('parallelcode2018@gmail.com');
            if ($mail->send()) {
                return ['success' => true, 'message' => 'Email sent successfully!'];
            } else {
                return false;
            }
            $mail->smtpClose();
        } catch (Exception $e) {
            return ['success' => false, 'message' => $mail->ErrorInfo];
        }
    }

}
